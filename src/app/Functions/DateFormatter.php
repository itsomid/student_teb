<?php

namespace App\Functions;


use Carbon\Carbon;
use Morilog\Jalali\CalendarUtils;

class DateFormatter
{

    public static function format($moment)
    {
        $moment= str_replace('۰', 0, $moment);
        $moment= str_replace('۱', 1, $moment);
        $moment= str_replace('۲', 2, $moment);
        $moment= str_replace('۳', 3, $moment);
        $moment= str_replace('۴', 4, $moment);
        $moment= str_replace('۵', 5, $moment);
        $moment= str_replace('۶', 6, $moment);
        $moment= str_replace('۷', 7, $moment);
        $moment= str_replace('۸', 8, $moment);
        $moment= str_replace('۹', 9, $moment);

        $date= explode( ' ' ,$moment)[0];
        $time= str_contains($moment, ' ')
            ?  explode( ' ' ,$moment)[1] : null;

        $date = explode("/" ,$date);
        $time= $time
            ? explode(":" ,$time)
            : ['00', '00'];

        $date=  CalendarUtils::toGregorian($date[0] , $date[1] , $date[2]);
        $date=  Carbon::create($date[0], $date[1] , $date[2] , $time[0] , $time[1]);

        return (string) $date;
    }

}
