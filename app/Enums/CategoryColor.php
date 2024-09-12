<?php

namespace App\Enums;

enum CategoryColor: string

{
	case YELLOW = '#FFFF00';
    case BLUE = '#0000FF';
    case WHITE = '#FFFFFF';
    case GRAY = '#808080';
    case ORANGE = '#FFA500';
    case BROWN = '#A52A2A';
    case BLACK = '#000000';
    case PINK = '#FFC0CB';
    case PURPLE = '#800080';
    case GREEN = '#008000';
    case RED = '#FF0000';


	public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
