<?php

namespace Database\Factories;

use App\Enums\ProductTypeEnum;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = $this->generateFakeProduct();
        return [
            'user_id' => 1,
            'name' => $product['name'],
            'description' => fake()->sentence(),
            'original_price' => $price = fake()->numberBetween(10000, 9000000),
            'off_price' => Arr::random([null, fake()->numberBetween($price - 1000, $price)]),
            'sort_num' =>rand(1, 11),
            'img_filename' => $product['image'],
            'is_purchasable' => fake()->boolean,
            'has_installment' => fake()->boolean,
            'show_in_list' => true,
            'options' => [
                'holding_days1' => Arr::random([0, 1, 2, 3, 4, 5, 6, 7]),
                'holding_hours1' => [fake()->time('H:i'), fake()->time('H:i')],
                'holding_days2' => Arr::random([0, 1, 2, 3, 4, 5, 6, 7]),
                'holding_hours2' => [fake()->time('H:i'), fake()->time('H:i')],
                'holding_days3' => Arr::random([0, 1, 2, 3, 4, 5, 6, 7]),
                'holding_hours3' => [fake()->time('H:i'), fake()->time('H:i')],
            ]
        ];
    }


    private function generateFakeProduct(): array
    {
        $fakeProducts = [
            ['name' => 'کلاس آنلاین همایش 60 درصد کنکور حسابان استاد آریان حیدری', 'image' => '1681676556599.jpg'],
            ['name' => 'کلاس آنلاین همایش 60 درصد کنکور فیزیک استاد مهدی براتی', 'image' => '1681676169687.jpg'],
            ['name' => 'کلاس آنلاین همایش 60 درصد کنکور فیزیک استاد محمد نوکنده', 'image' => '1681676128917.jpg'],
            ['name' => 'کلاس آنلاین همایش 60 درصد کنکور ریاضی انسانی استاد آریان حیدری', 'image' => '1681676745278.jpg'],
            ['name' => 'کلاس آنلاین همایش 60 درصد کنکور فلسفه و منطق استاد علی فروغی نیا', 'image' => '1681677364762.jpg'],
            ['name' => 'کلاس آنلاین همایش 60 درصد کنکور جامعه شناسی استاد حمید اثباتی', 'image' => '1681679260291.jpg'],
            ['name' => 'کلاس آنلاین همایش 60 درصد کنکور روان شناسی استاد پویا بهشتی', 'image' => '1681734964702.jpg'],
            ['name' => 'کلاس آنلاین همایش جمع بندی ویژه سال نهم', 'image' => '1684688159726.png'],
            ['name' => 'کلاس آنلاین همایش جمع بندی ویژه سال ششم', 'image' => '1684688135650.png'],
            ['name' => 'کلاس آنلاین نکته و تست کنکور1402 ریاضی تجربی استاد آریان حیدری', 'image' => '1674328240150.png'],
           ['name' =>  'کلاس آنلاین زبانینو ترم اول زبان عمومی سطح Elementary استاد نسترن سلطانی', 'image' => '1672658793415.jpg'],
            ['name' => 'کلاس آنلاین هوش و خلاقیت سال پنجم استاد حمیدرضا زیارتی 1402', 'image' => '1655895115973.png'],
        ];

        $product = Arr::random($fakeProducts);
        $product['name'] .= ' ' . fake()->numberBetween(1395, 1410);

        return $product;
    }

    public function subscriable(): Factory
    {
        return $this->state(function(array $attributes){
            return [
              'expiration_duration' => Arr::random([10, 30, 40, 60])
            ];
        });
    }

    public function course(): Factory
    {
        return $this->state(function(array $attributes){
            return [
                'product_type_id' => 1
            ];
        });
    }
    public function class(): Factory
    {
        return $this->state(function(array $attributes){
            return [
                'product_type_id' => ProductTypeEnum::CLASSES
            ];
        });
    }

    public function package(): Factory
    {
        return $this->state(function(array $attributes){
            return [
                'product_type_id' => ProductTypeEnum::CUSTOM_PACKAGE
            ];
        });
    }

    public function classname(): Factory
    {
        return $this->state(function(array $attributes){
            return [
                'name' =>   Arr::random(['جلسه ' , 'کلاس ' , 'سمینار ']).
                    Arr::random([' تدریس ' , ' بررسی ' , 'حل نمونه سوال از ']).
                    Arr::random([' مباحث ' , 'بخشهای ']).
                    Arr::random(['آزمون های قلمچی جدید ' , 'خیلی خیلی مهم ', 'کاربردی  ' , 'اضافه شده ', 'مهم امتحانی '])
            ];
        });
    }
}
