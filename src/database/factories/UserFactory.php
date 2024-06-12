<?php

namespace Database\Factories;

use App\Data\FamiliarityWays;
use App\Data\FieldOfStudy;
use App\Data\Grades;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gender = Arr::random(['male', 'female', null]);
        return [
            'name' => ($gender == 'male' ? $this->getRandomMaleFirstName() : $this->getRandomFemaleFirstName()) . ' ' . $this->getRandomLastName(),
            'name_english' => Arr::random([fake()->name(), null]),
            'mobile' => generatePhone(),
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'gender' => $gender,
            'grade' => Arr::random(array_keys(Grades::get())),
            'field_of_study' => Arr::random(array_keys(FieldOfStudy::get())),
            'familiarity_way' => Arr::random(array_keys(FamiliarityWays::get())),
            'credit' => 0,
            'verified_by_supporter' => false,
            'verified' => true,
            'referral_id' => null,
            'sale_support_id' => null,
            'sales_description' => null,
            'description' => null,
            'products_ids_purchased' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];

    }

    public function withCustomSaleSupport($supporter_mobile)
    {

        return $this->afterCreating(function (User $user) use ($supporter_mobile) {
            $supporter = Admin::where('mobile', $supporter_mobile)->first();
            $user->sale_support_id = $supporter->id;
            $user->save();
        });

    }

    public function unverifiedWithIncompleteRegistration(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'name' => null,
                'grade' => null,
                'field_of_study' => null,
                'verified' => false,
            ];
        });
    }

    public function unverified(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'verified' => false,
            ];
        });
    }

    private function getRandomMaleFirstName(): string
    {
        $maleNames = ['رضا', 'سجاد', 'شایان', 'دانیال', 'افشین', 'فربد', 'مصطفی', 'مهرداد', 'حامد', 'سپهر', 'محمد', 'علی', 'محمد رضا', 'حسین', 'فرید', 'امیر', 'علیرضا'];
        return Arr::random($maleNames);
    }

    private function getRandomFemaleFirstName(): string
    {
        $femaleNames = ['یاسمین', 'مینا', 'درسا', 'فاطمه', 'مهدیه', 'الهه', 'سارا', 'نگار', 'نگین', 'راحله', 'سمانه', 'شیما', 'مهسا', 'هدیه', 'هلما', 'حمیرا'];
        return Arr::random($femaleNames);
    }

    private function getRandomLastName(): string
    {
        $lastNames = ['رضاپور', 'ابراهیمی', 'مرادی', 'میبدی', 'طاهری', 'موسوی', 'پناهی', 'آذری', 'قاضیان', 'شمسی', 'فلاح', 'محمدی', 'ترکاشوند', 'فتحیان', 'تبریزی', 'خراسانی', 'گودرزی', 'شریفی', 'شهبازی', 'حاتمی', 'نعمتی', 'کاظم زاده', 'علیپور', 'رضایی', 'کریمی', 'رحمانی', 'تاجیک', 'حیدری', 'خسروی', 'جهانی'];
        return Arr::random($lastNames);
    }

}
