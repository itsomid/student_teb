<?php

namespace App\Enums;

enum ClassStatusEnum: string
{
    case Upcoming = 'upcoming';
    case Ongoing = 'ongoing';
    case Postponed = 'postponed';
    case Ended = 'ended';
}
