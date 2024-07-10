<?php

namespace Tests\Feature\Cart;

use App\Enums\CouponTypesEnum;
use App\Http\Middleware\JwtAuthenticator;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Product;
use App\Models\User;
use App\Services\StudentAccountService;
use App\ShoppingCart\CartAdaptor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplyCouponTest extends TestCase
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

    public function test_apply_discount_amount_on_course(): void
    {
        $studentAccountService = resolve(StudentAccountService::class);
        $product = Product::factory()->course()->has(Course::factory())->state(['original_price' => 9000000, 'off_price' => null])->create();
        $coupon = Coupon::factory()
            ->state([
                'type' => CouponTypesEnum::SPECIFIED_STUDENTS_COUPON,
                'consumer_ids' => [$this->user->id],
                'product_ids' => [$product->id],
                'discount_amount' => $discountAmount = 10000,
                'discount_percentage' => null,
                'expired_at' => now()->addMonth(),
            ])
            ->create();

        $price = $product->price - $discountAmount;
        $vatPercentage = config('shoppingcart.vat');
        $calculatePrice = ($price * ($vatPercentage +1));

        CartAdaptor::init($this->user->id);
        CartAdaptor::addCourse($product->id);


        $this->postJson(route('cart.apply-coupon'), [
            'coupon_name' => $coupon->coupon
        ])->assertOk();


        $this->get(route('cart.lists'))
            ->assertJson([
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
                    'product_calculated_price' => (int)$calculatePrice,
                    'is_package' => false,
                ]],
                'invoice' => [
                    "vat" => (int)($price * $vatPercentage),
                    "vat_percentage" => (int)($vatPercentage*100),
                    "user_credit" => $studentAccountService->getAccount($this->user->id),
                    "sum_price" => (int)$price,
                    "final_price" => (int)$calculatePrice,
                    "payable_price" => (int)$calculatePrice,
                    "payable_for_bank" => (int)$calculatePrice - $studentAccountService->getAccount($this->user->id),
                ]
            ]);
    }

    public function test_apply_discount_percentage_on_course(): void
    {
        $studentAccountService = resolve(StudentAccountService::class);
        $product = Product::factory()->course()->has(Course::factory())->state(['original_price' => 9000000, 'off_price' => null])->create();
        $coupon = Coupon::factory()
            ->state([
                'type' => CouponTypesEnum::SPECIFIED_STUDENTS_COUPON,
                'consumer_ids' => [$this->user->id],
                'product_ids' => [$product->id],
                'discount_amount' => null,
                'discount_percentage' => $discountPercentage = 10,
                'expired_at' => now()->addMonth(),
            ])
            ->create();

        $price = $product->price - ($product->price * ($discountPercentage / 100));
        $vatPercentage = config('shoppingcart.vat');
        $calculatePrice = ($price * ($vatPercentage +1));

        CartAdaptor::init($this->user->id);
        CartAdaptor::addCourse($product->id);


        $this->postJson(route('cart.apply-coupon'), [
            'coupon_name' => $coupon->coupon
        ])->assertOk();


        $this->get(route('cart.lists'))
            ->assertJson([
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
                    'product_calculated_price' => (int)$calculatePrice,
                    'is_package' => false,
                ]],
                'invoice' => [
                    "vat" => (int)($price * $vatPercentage),
                    "vat_percentage" => (int)($vatPercentage*100),
                    "user_credit" => $studentAccountService->getAccount($this->user->id),
                    "sum_price" => (int)$price,
                    "final_price" => (int)$calculatePrice,
                    "payable_price" => (int)$calculatePrice,
                    "payable_for_bank" => (int)$calculatePrice - $studentAccountService->getAccount($this->user->id),
                ]
            ]);
    }
}
