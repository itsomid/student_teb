<?php

namespace Tests\Feature\Cart;

use App\DTO\StudentAccount\ChargeAccountDTO;
use App\Enums\DepositTypeEnum;
use App\Http\Middleware\JwtAuthenticator;
use App\Models\CartItem;
use App\Models\Course;
use App\Models\Product;
use App\Models\User;
use App\Services\ChargeAccountService;
use App\Services\OrderService;
use App\Services\StudentAccountService;
use App\ShoppingCart\CartAdaptor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->withoutMiddleware([JwtAuthenticator::class]);
        $this->user = User::factory()->create();
        $this->actingAs($this->user, 'student');
    }


    /**
     * A basic feature test example.
     */
    public function test_add_course_on_cart_successfully(): void
    {
        $product = Product::factory()->course()->has(Course::factory())->create();
        $this->postJson(route('cart.add'), [
            'product_id' => $product->id
        ])->assertOk();

        $this->assertDatabaseHas(CartItem::class, ['product_id' => $product->id, 'user_id' => $this->user->id]);
    }

    public function test_add_course_with_installment_method_pay()
    {
        $studentAccountService = resolve(StudentAccountService::class);
        $product = Product::factory()->installment(4, 25)->course()->state(['original_price' => 1000000, 'off_price' => null])->has(Course::factory())->create();
        CartAdaptor::init($this->user->id);
        CartAdaptor::changeInstallment(true);
        CartAdaptor::addCourse($product->id);

        $installmentCount = 4;
        $installmentRatio = 25 *0.01;


        $vatPercentage = config('shoppingcart.vat'); // 10%

        $price = (int) ($product->getInstallmentPrice() * (1 + $vatPercentage));
//dd($price, (int) ($price * $installmentRatio), $installmentRatio);
        $payable_for_bank = (int) ($price * $installmentRatio);
        $finalPrice = $price;




        $res = $this->getJson(route('cart.lists'));
        $res->assertJson([
            'items' => [[
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_image' => $product->getImageUrl(),
                'has_installment' => (int)$product->has_installment,
                'options' => [
                    'holding_days1' => $product->options['holding_days1'],
                    'holding_hours1' => $product->options['holding_hours1'],
                    'holding_days2' => $product->options['holding_days2'],
                    'holding_hours2' => $product->options['holding_hours2'],
                    'holding_days3' => $product->options['holding_days3'],
                    'holding_hours3' => $product->options['holding_hours3']
                ],
                'original_price' => $product->getPrice(),
                'off_price' => $product->off_price,
                'product_calculated_price' => $payable_for_bank,
                'is_package' => false,
            ]],
            'invoice' => [
                "vat" => (int)($product->getInstallmentPrice() * $vatPercentage),
                "vat_percentage" => (int)($vatPercentage*100),
                "user_credit" => $studentAccountService->getAccount($this->user->id),
                "sum_price" => (int)$product->getInstallmentPrice(),
                "final_price" => $finalPrice,
                "payable_price" => $payable_for_bank,
                "payable_for_bank" => $payable_for_bank - $studentAccountService->getAccount($this->user->id),
            ],
            'installments' => [

            ],
        ]);

    }

    public function test_amount_is_valid(): void
    {
        $studentAccountService = resolve(StudentAccountService::class);

        $product = Product::factory()->course()->has(Course::factory())->create();
        CartAdaptor::init($this->user->id);
        CartAdaptor::addCourse($product->id);

        $vatPercentage = config('shoppingcart.vat');
        $price = $product->price;
        $priceCalculate = $price * ($vatPercentage + 1);

        $res = $this->getJson(route('cart.lists'));
        $res->assertJson([
            'items' => [[
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_image' => $product->getImageUrl(),
                'has_installment' => (int)$product->has_installment,
                'options' => [
                    'holding_days1' => $product->options['holding_days1'],
                    'holding_hours1' => $product->options['holding_hours1'],
                    'holding_days2' => $product->options['holding_days2'],
                    'holding_hours2' => $product->options['holding_hours2'],
                    'holding_days3' => $product->options['holding_days3'],
                    'holding_hours3' => $product->options['holding_hours3']
                ],
                'original_price' => $product->getPrice(),
                'off_price' => $product->off_price,
                'product_calculated_price' => (int)$priceCalculate,
                'is_package' => false,
            ]],
            'invoice' => [
                "vat" => (int)($price * $vatPercentage),
                "vat_percentage" => (int)($vatPercentage*100),
                "user_credit" => $studentAccountService->getAccount($this->user->id),
                "sum_price" => (int)$price,
                "final_price" => (int)$priceCalculate,
                "payable_price" => (int)$priceCalculate,
                "payable_for_bank" => (int)$priceCalculate - $studentAccountService->getAccount($this->user->id),
            ]
        ]);
    }

    public function test_send_already_purchased_course()
    {
        $product = Product::factory()->course()->has(Course::factory())->create();

        CartAdaptor::init($this->user->id);
        CartAdaptor::addCourse($product->id);

        $chargeAccount = resolve(ChargeAccountService::class);
        $chargeAccount->charge(
            (new ChargeAccountDTO())
                ->setAmount($product->amount * 2)
                ->setDepositType(DepositTypeEnum::BUY)
                ->setUserId($this->user->id)
        );

        $orderService = resolve(OrderService::class);
        $orderService->buy($this->user->id);

        $res = $this->postJson(route('cart.add'), [
            'product_id' => $product->id
        ]);

        $res->assertUnprocessable()
            ->assertJsonValidationErrors(['product_id']);
    }
}
