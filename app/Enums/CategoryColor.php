<?php

namespace App\Enums;

enum CategoryColor: string

{
	case RED = '#CC0000';
	case ORANGE = '#CC6600';
	case YELLOW = '#CCCC00';
	case LIME = '#66CC00';
	case GREEN = '#00CC00';
	case MINT = '#00CC66';
	case CYAN = '#00CCCC';
	case AZURE = '#0066CC';
    case BLUE = '#0000CC';
	case PURPLE = '#6600CC';
	case MAGENTA = '#CC00CC';
	case PINK = '#CC0066';

	public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
