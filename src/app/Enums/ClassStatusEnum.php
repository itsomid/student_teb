<?php

namespace App\Enums;

enum ClassStatusEnum: string
{
    case Upcoming = 'upcoming';    //1
    case Ongoing = 'ongoing';      //2
    case Postponed = 'postponed';  //8
    case Ended = 'ended';          //3
}
