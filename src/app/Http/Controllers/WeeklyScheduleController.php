<?php

namespace App\Http\Controllers;

use App\Functions\DateFormatter;
use App\Models\Classes;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Morilog\Jalali\CalendarUtils;
use Morilog\Jalali\Jalalian;

class WeeklyScheduleController extends Controller
{
    public function index()
    {
        $current_week= request()->input('week' , 0);

        $firstDayOfTheWeek= Jalalian::now();

        if(!Jalalian::now()->isStartOfWeek())
        {
            $i = 1;
            while ($i < 6) {

                if(Jalalian::now()->subDays($i)->isStartOfWeek())
                {
                    $firstDayOfTheWeek= Jalalian::now()->subDays($i);
                    break;
                }
                $i++;
            }
        }

        $firstDayOfTheWeek=  CalendarUtils::toGregorian(
            $firstDayOfTheWeek->getYear(),
            $firstDayOfTheWeek->getMonth(),
            $firstDayOfTheWeek->getDay()
        );

        $firstDayOfTheWeek=  Carbon::create($firstDayOfTheWeek[0], $firstDayOfTheWeek[1] , $firstDayOfTheWeek[2] , '00' , '00');


        $timeSpanFirstDay= $firstDayOfTheWeek->addDays($current_week ? $current_week * 7 : 0);
        $timeSpanLastDay =  (clone $timeSpanFirstDay)->addDays(7);


        $classes= Classes::query()
            ->whereBetween('holding_date', [$timeSpanFirstDay, $timeSpanLastDay])
            ->orderBy('holding_date', 'ASC')
            ->get();

        $classesByDate = $classes->groupBy(function($item) {
            return Carbon::parse($item->holding_date)->format('Y-m-d');
        });

        // Generate an array of dates for the week
        $datesOfWeek = [];
        for ($date = $timeSpanFirstDay->copy(); $date <= $timeSpanLastDay; $date->addDay()) {
            $datesOfWeek[] = $date->copy();
        }

        $datesOfWeek =array_slice($datesOfWeek,0,count($datesOfWeek)-1);

        return view('dashboard.weekly_schedule.index')->with([
            'current_week'  => $current_week,
            'classesByDate' => $classesByDate,
            'datesOfWeek'   => $datesOfWeek
        ]);
    }
}
