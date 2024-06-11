<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class Register
{
    public function add($name, $mobile, $grade, $field_of_study,$reagent_code)
    {
        $response = Http::retry(2, 100)
            ->withHeaders([
                'Accept' => 'application/json',
                'os' => 'web',
                'release' => 2
            ])
            ->post(env('CLASSINO_LEGACY','http://host.docker.internal:8000').'/api/panel/register', [
            'name' => $name,
            'mobile' => $mobile,
            'grade' => $grade,
            'field_of_study' => $field_of_study,
            'reagent_code' => $reagent_code
        ]);

        return json_decode($response->body());
    }
}
