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
            "offline_token_aparat" => $this->getAparatToken($this->offline_link_aparat),
            "offline_link_woza" => $this->offline_link_woza,
            "offline_link_vod" => $this->offline_link_vod,
            "emergency_link" => $this->emergency_link,
        ];

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

}
