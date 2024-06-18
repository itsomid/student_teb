<?php

namespace App\Http\Resources\StudentPanel;

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
        return [
            'id' => $this->id,
            'name' => (string)$this->section_name,
            'courses' => $this->items->map(function ($item) {
                return [
                    'id'=>$item->product->id,
                    'name' => $item->product->name,
                    'image' => $item->product->img_filename,
                    'start_date' => $item->product->course->start_date,
                    'holding_days' => $item->product->course->holding_days(),
                    'start_time' => $item->product->course->start_time(),
                    'finish_time' => $item->product->course->end_time(),
                ];
            }),
        ];
    }
}
