<?php

namespace App\Enums;

enum TaskDuration: string
{
	case HALF_HOUR = 'half hour';
    case HOUR = 'hour';
    case TURN = 'turn';

	public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
