<?php

namespace App\Http\Resources\StudentPanel;

use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomPackageSectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // Get the CartItem instance if it exists
        $cartItem = CartItem::where('user_id', \Auth::guard('student')->id())
            ->where('product_id', $this->product_id)
            ->with('packages')
            ->first();

        // Extract package items if the CartItem exists
        $packages_items = $cartItem ? $cartItem->packages->pluck('product_id')->toArray() : [];

        //TODO: add Teacher Resource
        return [
            'id' => $this->id, //custom_packages_id
            'name' => (string)$this->section_name,
            'courses' => $this->items->map(function ($item)  use($packages_items) {

                return [
                    'id'=>$item->id, //section_id
                    'name' => $item->product->name,
                    'image' => $item->product->getImageUrl(),
                    'product_id'=>$item->product->id,
                    'teacher_id'=>$item->product->teacher->id,
                    'teacher_name'=>$item->product->teacher->fullname(),
                    'teacher_img'=>[
                        'img_1' => isset(optional($item->product->teacher)->teacher_img_files['img_1']) ? optional($item->product->teacher)->teacher_img_files['img_1'] : null,  // Small One
                        'img_2' => isset(optional($item->product->teacher)->teacher_img_files['img_2']) ? optional($item->product->teacher)->teacher_img_files['img_2'] : null,  // Somehow Bigger
                        'img_3' => isset(optional($item->product->teacher)->teacher_img_files['img_3']) ? optional($item->product->teacher)->teacher_img_files['img_3'] : null,  // IDK
                    ],
                    'start_date' => $item->product->course->start_date,
                    'holding_days' => $item->product->course->holding_days(),
                    'start_time' => $item->product->course->start_time(),
                    'finish_time' => $item->product->course->end_time(),
                    'is_selected'=> in_array($item->product->id,$packages_items)
                ];
            }),
        ];
    }
}
