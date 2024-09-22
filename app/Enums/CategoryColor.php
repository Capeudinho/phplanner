<?php

namespace App\Enums;

enum CategoryColor: string

{
	case RED = '#FF0000';
	case ORANGE = '#FF8000';
	case YELLOW = '#FFFF00';
	case LIME = '#80FF00';
	case GREEN = '#00FF00';
	case MINT = '#00FF80';
	case CYAN = '#00FFFF';
	case AZURE = '#0080FF';
    case BLUE = '#0000FF';
	case PURPLE = '#8000FF';
	case MAGENTA = '#FF00FF';
	case PINK = '#FF0080';
    case WHITE = '#FFFFFF';
    case GRAY = '#808080';
    case BLACK = '#000000';


	public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
