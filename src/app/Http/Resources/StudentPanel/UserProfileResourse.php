<?php

namespace App\Http\Resources\StudentPanel;

use App\Data\Cities;
use App\Data\Province;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResourse extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                        => $this->id,
            'name'                      => $this->name,
            'name_english'              => $this->name_english,
            'credit'                    => $this->balance,
            'mobile'                    => $this->mobile,
            'province'                  => $this->province,
            'city'                      => $this->city,
            'field_of_study'            => $this->field_of_study,
            'grade'                     => $this->grade,
            'block'                     => $this->block,
            'block_reason_image'        => $this->block_reason_image,
            'block_reason_description'  => $this->block_reason_description,
            'gender'                    => $this->gender ?? null,
            'familiarity_way'           => $this->familiarity_way ?? null,
            'profile_img'               => $this->profile_img,
            'supporter_name'            => optional($this->saleSupport)->fullname(),
            'created_at'                => (string) $this->created_at,
            'updated_at'                => (string) $this->updated_at,
        ];
    }
}
