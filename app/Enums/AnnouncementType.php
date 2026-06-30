<?php

namespace App\Enums;

enum AnnouncementType: string
{
    case TEACHER = 'teacher';
    case STUDENT = 'student';
    case PARENTS = 'parents';
    case STUDENT_AND_PARENTS = 'student_and_parents';
}
