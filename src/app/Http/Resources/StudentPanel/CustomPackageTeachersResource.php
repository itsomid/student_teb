<?php

namespace App\Http\Resources\StudentPanel;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomPackageTeachersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

           return $this->items->map(function ($item){
                return [
                    'id'=>$item->product->teacher->id,
                    'name'=>$item->product->teacher->fullname(),
                    'bio' => $item->product->teacher->bio,
                    'images' => [
                        'img_1' => $item->product->teacher->teacherImage('img_1') ?? null,  // Small One
                        'img_2' => $item->product->teacher->teacherImage('img_2') ?? null,  // Somehow Bigger
                        'img_3' => $item->product->teacher->teacherImage('img_3') ?? null,  // IDK
                    ]
                ];
            })->toArray();

    }
}
