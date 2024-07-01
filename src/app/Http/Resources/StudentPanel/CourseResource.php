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
            "teacher_name" => optional($this->teacher)->fullname(),
            "original_price" => $this->getPrice(),
            "off_price" => $this->off_price,
            "sort_num" => $this->sort_num,
            "product_type_id" => $this->product_type_id,
            "img_filename" => $this->getImageUrl(),
            "has_installment" => $this->has_installment,
            "is_purchasable" => (int)$this->is_purchasable,
            "show_in_list" => (int)$this->show_in_list,
            'holding_days' => $this->course->holding_days(),
            'start_time' => $this->course->start_time(),
            'finish_time' => $this->course->end_time(),
            'start_date' => $this->course->start_date,
            'course_id' => $this->course->id,
            'classes'=> CourseClassResource::collection($this->course->classes),
            "grades" => $this->categories->where('type', ProductCategoryType::GRADE)->pluck('id'),
            "lessons" => $this->categories->where('type', ProductCategoryType::LESSON)->pluck('id'),
            "courses" => $this->categories->where('type', ProductCategoryType::COURSE)->pluck('id'),
            "store_status" => $storeStatus
        ];
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
}
