<?php

namespace App\Enums;

enum TaskStatus: string
{
	case FINISHED = 'finished';
    case ONGOING = 'ongoing';
    case DELAYED = 'delayed';

	public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
