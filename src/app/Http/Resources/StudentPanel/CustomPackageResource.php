<?php

namespace App\Http\Resources\StudentPanel;

use App\Enums\ProductCategoryType;
use App\Models\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class CustomPackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'teacher_name' => optional($this->teacher)->fullname(),
            'original_price' => $this->getPrice(),
            "original_price_num" => $this->original_price,
            "off_price" => $this->getOffPrice(),
            "off_price_num" => $this->off_price,
            'sort_num' => $this->sort_num,
            'product_type_id' => $this->product_type_id,
            'img_filename' => $this->getImageUrl(),
            'has_installment' => $this->has_installment,
            'installment_count' => $this->installment_count,
            'start_date' => $this->packages[0]->items[0]->product->course->start_date,
            'random_introduce_video'=>$this->getRandomVideoFromPackageCourses($this->packages),
//            'packages' => $this->customPackageItems,
            'sections' => CustomPackageSectionResource::collection($this->packages),
            'teachers' => CustomPackageTeachersResource::collection($this->packages),
            'is_purchasable' => (int)$this->is_purchasable,
            'show_in_list' => (int)$this->show_in_list,
            'grades' => $this->categories->where('type', ProductCategoryType::GRADE)->pluck('name', 'id'),
            'lessons' => $this->categories->where('type', ProductCategoryType::LESSON)->pluck('name', 'id'),
            'courses' => $this->categories->where('type', ProductCategoryType::COURSE)->pluck('name', 'id'),
            'store_status' => $this->determineStoreStatus(Auth::guard('student')->user())
        ];
    }

    public function getRandomVideoFromPackageCourses($packages)
    {
         $items = $packages->flatMap->items;

        if ($items->isEmpty()) {
            return null;
        }

        $randomItem = $items->random();
        return $this->getAparatToken($randomItem->product->course->introduce_video);
    }
    public function getAparatToken($video)
    {
        if ( str_contains( $video , 'aparat.com')) {
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
}
