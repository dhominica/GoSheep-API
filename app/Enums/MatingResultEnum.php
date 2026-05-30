<?php

namespace App\Enums;

enum MatingResultEnum: string
{
    case PREGNANT = 'pregnant';
    case NOT_PREGNANT = 'not_pregnant';
    case FAILED = 'failed';
    case UNKNOWN = 'unknown';
}
