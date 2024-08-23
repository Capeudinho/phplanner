<?php

namespace App\Enums;

enum GoalStatus: string
{
	case SUCCEEDED = 'succeeded';
    case PARTIALLY_SUCCEEDED = 'partially succeeded';
    case FAILED = 'failed';

	public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
