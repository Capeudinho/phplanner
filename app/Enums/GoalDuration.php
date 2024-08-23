<?php

namespace App\Enums;

enum GoalDuration: string
{
	case WEEK = 'week';
    case MONTH = 'month';
    case YEAR = 'year';

	public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
