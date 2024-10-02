<?php

namespace App\Legacy\Listeners;

use App\Legacy\Listeners\Contract\LegacyContract;
use App\Models\Classes;


class NexusSaveClass implements LegacyContract
{
    public function handle(object $data): void
    {
        $class = Classes::query()->where('id', $data->id)->first();

        $newClass = is_null($class)
            ?  new Classes()
            :  $class;

        $newClass->id                    = $data->id;
        $newClass->product_id            = $data->product_id;
        $newClass->course_id             = $data->course_id;
        $newClass->parent_id             = $data->parent_id;
        $newClass->holding_date          = $data->holding_date;
        $newClass->status                = $data->status;
        $newClass->sort_num              = $data->sort_num;
        $newClass->is_free               = $data->is_free;
        $newClass->offline_link_woza     = $data->offline_link_woza;
        $newClass->offline_link_vod      = $data->offline_link_vod;
        $newClass->emergency_link        = $data->emergency_link;
        $newClass->attached_file_link    = $data->attached_file_link;
        $newClass->studio_description    = $data->studio_description;
        $newClass->qa_is_active          = $data->qa_is_active;
        $newClass->homework_is_active    = $data->homework_is_active;
        $newClass->homework_is_mandatory = $data->homework_is_mandatory;
        $newClass->report_is_mandatory   = $data->report_is_mandatory;
        $newClass->created_at            = $data->created_at;
        $newClass->updated_at            = $data->updated_at;

        $newClass->save();
    }
}
