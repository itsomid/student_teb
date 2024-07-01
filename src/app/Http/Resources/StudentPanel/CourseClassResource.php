<?php

namespace App\Http\Resources\StudentPanel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseClassResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "product_id" => $this->product->id,
            "name" => $this->product->name,
            "course_id" => $this->course->id,
            "parent_id" => null,
            "holding_date" => $this->holding_date,
            "status" => $this->status,
            "sort_num" => $this->sort_num,
            "is_free" => $this->is_free,
            "offline_link_woza" => $this->offline_link_woza,
            "offline_link_vod" => $this->offline_link_vod,
            "emergency_link" => $this->emergency_link,
        ];

    }
}
