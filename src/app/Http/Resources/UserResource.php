<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'mobile' => $this->mobile,
            'credit' => $this->balance,
            'support' => $this->getSupportData(),
        ];
    }

    private function getSupportData(): array
    {
        return [
            'name' => optional($this->saleSupport)->fullname(),
            'mobile' => optional($this->saleSupport)->mobile,
            'avatar' => optional($this->saleSupport)->avatar,
            'instagram' => optional($this->saleSupport)->instagram,
            'telegram' => optional($this->saleSupport)->telegram,
            'whatsapp' => optional($this->saleSupport)->whatsapp,
            'gender'=> optional($this->saleSupport)->gender
        ];
    }
}
