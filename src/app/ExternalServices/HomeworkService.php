<?php

namespace App\ExternalServices;

use App\ExternalServices\Request\Request;
use App\Models\Setting;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class HomeworkService
{
    private static function getServiceUrl()
    {
        return Setting::ReworkServiceAddress();
    }

    public static function getAllHomeworks($body)
    {
        $response= Request::get(static::getServiceUrl() , $body);

        $response= new Paginator($response->data->data, $response->data->total , $body['limit'], $response->data->page, [
            'path'  => \request()->url(),
            'query' => \request()->query(),
        ]);

        return $response;
    }

    public static function setScore($homework_id, $score)
    {
        return Request::patch(static::getServiceUrl().$homework_id.'/score_set', [
            'score' => $score
        ]);
    }

    public static function deleteHomewrk($homework_id)
    {
        return Request::delete(static::getServiceUrl().$homework_id);
    }
}
