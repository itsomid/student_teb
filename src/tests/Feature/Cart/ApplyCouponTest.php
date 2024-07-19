<?php

namespace Tests\Feature\Cart;

use App\Enums\CouponTypesEnum;
use App\Http\Middleware\JwtAuthenticator;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\CustomPackage;
use App\Models\CustomPackageItem;
use App\Models\Product;
use App\Models\User;
use App\Services\StudentAccountService;
use App\ShoppingCart\CartAdaptor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
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
                    'original_price' => $product->price,
                    'off_price' => $product->off_price,
                    'product_calculated_price' => (int)$calculatePrice,
                    'is_package' => false,
                ]],
                'invoice' => [
                    "vat" => (int)($price * $vatPercentage),
                    "vat_percentage" => (int)($vatPercentage*100),
                    "user_credit" => $studentAccountService->getBalance($this->user->id),
                    "sum_price" => (int)$price,
                    "final_price" => (int)$calculatePrice,
                    "payable_price" => (int)$calculatePrice,
                    "payable_for_bank" => (int)$calculatePrice - $studentAccountService->getBalance($this->user->id),
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
                    'original_price' => $product->price,
                    'off_price' => $product->off_price,
                    'product_calculated_price' => (int)$calculatePrice,
                    'is_package' => false,
                ]],
                'invoice' => [
                    "vat" => (int)($price * $vatPercentage),
                    "vat_percentage" => (int)($vatPercentage*100),
                    "user_credit" => $studentAccountService->getBalance($this->user->id),
                    "sum_price" => (int)$price,
                    "final_price" => (int)$calculatePrice,
                    "payable_price" => (int)$calculatePrice,
                    "payable_for_bank" => (int)$calculatePrice - $studentAccountService->getBalance($this->user->id),
                ]
            ]);
    }

    public function test_add_course_with_installment_method_pay_when_applied_coupon()
    {
        $studentAccountService = resolve(StudentAccountService::class);

        $productCourse = Product::factory()->installment(4, 25)->course()->state(['original_price' => 1000000, 'off_price' => null])->has(Course::factory())->create();
        $productPackage = Product::factory()->installment(4, 25)->package()->state(['original_price' => 2000000, 'off_price' => null])->has(CustomPackage::factory()->has(CustomPackageItem::factory(), 'items'), 'packages')->create();
        $coupon = Coupon::factory()
            ->state([
                'type' => CouponTypesEnum::SPECIFIED_STUDENTS_COUPON,
                'consumer_ids' => [$this->user->id],
                'product_ids' => [$productCourse->id, $productPackage->id],
                'discount_amount' => null,
                'discount_percentage' => $discountPercentage = 10,
                'expired_at' => now()->addMonth(),
            ])
            ->create();

        $packageSelected = [];
        foreach($productPackage->packages as $package){
            array_push($packageSelected, Arr::random($package->items()->pluck('product_id')->toArray()));
        }

        CartAdaptor::init($this->user->id);
        CartAdaptor::changeInstallment(true);
        CartAdaptor::addCourse($productCourse->id);
        CartAdaptor::addPackage($productPackage->id, $packageSelected);


        $this->postJson(route('cart.apply-coupon'), [
            'coupon_name' => $coupon->coupon
        ])->assertOk();

        $installmentCount = 4;
        $installmentRatio = 25 *0.01;

//        $price = $product->price - ($product->price * ($discountPercentage / 100));

        $vatPercentage = config('shoppingcart.vat');
        $price = $productCourse->price + $productPackage->price;

        $priceCourseWithDiscount = $productCourse->price - ($productCourse->price * ($discountPercentage / 100));
        $pricePackageWithDiscount = $productPackage->price - ($productPackage->price * ($discountPercentage / 100));

        $priceCourseWith5 = $priceCourseWithDiscount  * (1.05);
        $pricePackageWith5 = $pricePackageWithDiscount  * (1.05);

        $sumPrice = $priceCourseWith5+$pricePackageWith5;
        $coursePriceCalculated = (int)($priceCourseWith5 * (1+$vatPercentage));
        $packagePriceCalculated = (int)($pricePackageWith5 * (1+$vatPercentage));

        $priceCalculate = $coursePriceCalculated+$packagePriceCalculated;
        $payable_for_bank = $priceCalculate * $installmentRatio;

        $res = $this->getJson(route('cart.lists'));
        $res->assertJson(
            [
                'items' => [
                    [
                        'product_id' => $productCourse->id,
                        'product_name' => $productCourse->name,
                        'product_image' => $productCourse->getImageUrl(),
                        'has_installment' => (int)$productCourse->has_installment,
                        'options' => [
                            'holding_days1' => $productCourse->options['holding_days1'],
                            'holding_hours1' => $productCourse->options['holding_hours1'],
                            'holding_days2' => $productCourse->options['holding_days2'],
                            'holding_hours2' => $productCourse->options['holding_hours2'],
                            'holding_days3' => $productCourse->options['holding_days3'],
                            'holding_hours3' => $productCourse->options['holding_hours3']
                        ],

                        'original_price' => $productCourse->getPrice(),
                        'off_price' => $productCourse->off_price,
                        'product_calculated_price' => $coursePriceCalculated,
                        'is_package' => false,
                    ], [
                        'product_id' => $productPackage->id,
                        'product_name' => $productPackage->name,
                        'product_image' => $productPackage->getImageUrl(),
                        'has_installment' => (int)$productPackage->has_installment,
                        'options' => [
                            'holding_days1' => $productPackage->options['holding_days1'],
                            'holding_hours1' => $productPackage->options['holding_hours1'],
                            'holding_days2' => $productPackage->options['holding_days2'],
                            'holding_hours2' => $productPackage->options['holding_hours2'],
                            'holding_days3' => $productPackage->options['holding_days3'],
                            'holding_hours3' => $productPackage->options['holding_hours3']
                        ],

                        'original_price' => $productPackage->getPrice(),
                        'off_price' => $productPackage->off_price,
                        'product_calculated_price' => $packagePriceCalculated,
                        'is_package' => true,
                    ],
                ],
                'invoice' => [
                    "vat" => (int)($sumPrice * $vatPercentage),
                    "vat_percentage" => (int)($vatPercentage*100),
                    "user_credit" => $studentAccountService->getBalance($this->user->id),
                    "sum_price" => (int)$sumPrice,
                    "final_price" => (int)$priceCalculate,
                    "payable_price" => (int)$payable_for_bank,
                    "payable_for_bank" => (int)$payable_for_bank - $studentAccountService->getBalance($this->user->id),
                ]]);


    }
}
