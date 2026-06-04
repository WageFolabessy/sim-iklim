<?php

namespace App\Enums;

enum AnomalyType: string
{
    case Flood = 'flood';
    case Drought = 'drought';
    case StrongWind = 'strong_wind';
    case Other = 'other';
}
