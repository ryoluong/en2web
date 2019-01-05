<?php

use App\Country;

function getCountryIdsFromRequest(string $str) 
{
    $temp = mb_convert_kana($str, 'as');
    $country_names = preg_split('/[\s,]+/', $temp, -1, PREG_SPLIT_NO_EMPTY);
    $country_ids = [];
    foreach ($country_names as $country_name) {
        $country = Country::firstOrCreate([
            'name' => $country_name,
        ]);
        $country_ids[] = $country->id;
    }
    return $country_ids;
}