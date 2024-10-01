<?php

namespace App\Legacy\Listeners;

use App\Legacy\Listeners\Contract\LegacyContract;
use App\Models\Course;

class NexusSaveCourse implements LegacyContract
{

    public function handle(object $data): void
    {
        $course = Course::query()->where('id', $data->id)->first();

        $course = $course != null
            ?  $course
            :  new Course();

        $course->id              = $data->id;
        $course->product_id      = $data->product_id;
        $course->start_date      = $data->start_date;
        $course->about_course    = $data->about_course;
        //$course->introduce_video = null; //There's no such field in legacy
        $course->qa_status       = $data->qa_status;
        $course->created_at      = $data->created_at;
        $course->updated_at      = $data->updated_at;
        $course->deleted_at      = $data->deleted_at;

        $course->save();
    }
}
