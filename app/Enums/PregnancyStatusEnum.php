<?php

namespace App\Enums;

enum PregnancyStatusEnum: string
{
    case ONGOING = 'ongoing';
    case BIRTHED = 'birthed';
    case MISCARRIAGE = 'miscarried';
}
