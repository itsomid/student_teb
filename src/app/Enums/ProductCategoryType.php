<?php

namespace App\Enums;

enum ProductCategoryType: string
{
    case COURSE = 'course';
    case GRADE = 'grade';
    case LESSON = 'lesson';
}
