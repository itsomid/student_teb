<?php

namespace App\Http\Resources\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CourseSearchCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(fn(Product $courseProduct) => [
            'product_id' => $courseProduct->id,
            'name' => $courseProduct->name,
            'children' => $courseProduct->children->map(fn(Product $classProduct) => [
                'product_id' => $classProduct->id,
                'name' =>  $classProduct->name,
            ])
        ])->toArray();
    }
}
