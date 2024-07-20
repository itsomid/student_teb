<?php

namespace App\Http\Resources\StudentPanel;

use App\Enums\ProductCategoryType;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $user = Auth::guard('student')->user();
        $storeStatus = $this->determineStoreStatus($user);

        return [
            'id' => $this->id,
            'name' => $this->name,
            "description" => $this->description,
            'introduce_video' => $this->getAparatToken($this->course->introduce_video),
            'teacher' => $this->getTeacherData($this->teacher),
            "original_price" => $this->getPrice(),
            "original_price_num" => $this->original_price,
            "off_price" => $this->getOffPrice(),
            "off_price_num" => $this->off_price,
            "sort_num" => $this->sort_num,
            "product_type_id" => $this->product_type_id,
            "img_filename" => $this->getImageUrl(),
            "has_installment" => $this->has_installment,
            'installment_count' => $this->when($this->has_installment, $this->installment_count),
            'first_installment' => $this->when($this->has_installment, $this->installment_amount ?? $this->calculateDiscountAmount($this->first_installment_ratio)),
            "is_purchasable" => (int)$this->is_purchasable,
            "show_in_list" => (int)$this->show_in_list,
            'holding_days' => $this->course->holding_days(),
            'start_time' => $this->course->start_time(),
            'finish_time' => $this->course->end_time(),
            'start_date' => $this->course->start_date,
            'course_id' => $this->course->id,
            'classes' => CourseClassResource::collection($this->course->classes),
            "grades" => $this->categories->where('type', ProductCategoryType::GRADE)->pluck('name', 'id'),
            "lessons" => $this->categories->where('type', ProductCategoryType::LESSON)->pluck('name', 'id'),
            "courses" => $this->categories->where('type', ProductCategoryType::COURSE)->pluck('name', 'id'),
            "store_status" => $storeStatus
        ];
    }

    public function getTeacherData()
    {
        // Decode the JSON string to an associative array
        $teacherImages = optional($this->teacher)->teacher_img_files;
        return [
            'name' => optional($this->teacher)->fullname(),
            'bio' => optional($this->teacher)->bio,
            'images' => [
                'img_1' => $this->teacher->teacherImage('img_1') ?? null,  // Small One
                'img_2' => $this->teacher->teacherImage('img_2') ?? null,  // Somehow Bigger
                'img_3' => $this->teacher->teacherImage('img_3') ?? null,  // IDK
            ]
        ];
    }

    public function getAparatToken($video)
    {
        if (str_contains($video, 'aparat.com')) {
            // Regular expression to find the code in the src attribute
            $pattern = '/aparat\.com\/embed\/([a-zA-Z0-9]+)/';

            preg_match($pattern, $video, $matches);

            // Check if we have a match and return the code
            if (isset($matches[1])) {
                return $matches[1];
            }
        }

        return null;
    }

    protected function determineStoreStatus(?User $user): string
    {

        if (CartItem::where('product_id', $this->id)->where('user_id', $user->id)->exists()) {
            return 'in_cart';
        }

        if ($user->productAccess()->where('product_id', $this->id)->exists()) {
            return 'purchased';
        }

        if (!$this->is_purchasable) {
            return 'not_purchasable';
        }

        if ($this->original_price === 0 && $this->product_type_id === ProductCategoryType::COURSE) {
            return 'free';
        }

        return 'available';
    }

    public function calculateDiscountAmount($ratio): float|int
    {
        return ($this->original_price * $ratio) / 100;
    }
}
