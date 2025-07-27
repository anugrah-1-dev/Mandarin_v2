<?php

namespace App\Helpers;

class FeatureHelper
{
    public static function getFeatureIcon($fitur): string
    {
        $fitur = strtolower($fitur);
        return str_contains($fitur, 'kamar') ? '🛏️' : (str_contains($fitur, 'wifi') ? '📶' : (str_contains($fitur, 'makan') ? '🍽️' : (str_contains($fitur, 'laundry') ? '🧺' : (str_contains($fitur, 'ac') ? '❄️' : (str_contains($fitur, 'parkir') ? '🅿️' : '✅')))));
    }
}
