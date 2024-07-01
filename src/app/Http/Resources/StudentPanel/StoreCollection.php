<?php

namespace App\Http\Resources\StudentPanel;

use App\Enums\ProductCategoryType;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

class StoreCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = Auth::guard('student')->user();
        return $this->collection->map( fn ($item) => [
            'id'                =>$item->id,
            "name"              => $item->name,
            "teacher_name"      => optional($item->teacher)->fullname(),
            "original_price"    => $item->getPrice(),
            "off_price"         => $item->off_price,
            "sort_num"          => $item->sort_num,
            "product_type_id"   => $item->product_type_id,
            "img_filename"      => $item->getImageUrl(),
            "is_purchasable"    => (int)$item->is_purchasable,
            "show_in_list"      => (int)$item->show_in_list,
            "course_id"         => optional($item->course)->id,
            'start_date'        => optional($item->course)->start_date,
            "grades"            => $item->categories->where('type', ProductCategoryType::GRADE)->pluck('id'),
            "lessons"           => $item->categories->where('type', ProductCategoryType::LESSON)->pluck('id'),
            "courses"           => $item->categories->where('type', ProductCategoryType::COURSE)->pluck('id'),
            'store_status'      => $this->determineStoreStatus($user,$item)
        ])->toArray();

    }
    protected function determineStoreStatus(?User $user,$item): string
    {

        if (CartItem::where('product_id', $item->id)->where('user_id', $user->id)->exists()) {
            return 'in_cart';
        }

        if ($user->productAccess()->where('product_id', $item->id)->exists()) {
            return 'purchased';
        }

        if (!$item->is_purchasable) {
            return 'not_purchasable';
        }

        if ($item->original_price === 0 && $item->product_type_id === ProductCategoryType::COURSE) {
            return 'free';
        }

        return 'available';
    }
}
