<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class AdminCollection extends ResourceCollection
{
    public function toArray(Request $request)
    {

        $output = $this->collection->map(function ($user){
            return [
                'id'         => $user->id,
                'name'       => $user->id .'#'. ' | '. $user->fullname() . ' | ' . $user->mobile,
            ];
        });


        return  $output;
    }
}
