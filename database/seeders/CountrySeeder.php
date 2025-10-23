<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $countries = [
            [
                'country_code' => 'RU',
                'country_name' => 'Russia',
                'phone_code' => '7',
                'min_length' => 10,
                'max_length' => 10,
                'regex_pattern' => '^7\d{10}$'
            ],
            [
                'country_code' => 'US',
                'country_name' => 'United States',
                'phone_code' => '1',
                'min_length' => 10,
                'max_length' => 10,
                'regex_pattern' => '^1\d{10}$'
            ],
            [
                'country_code' => 'UA',
                'country_name' => 'Ukraine',
                'phone_code' => '380',
                'min_length' => 9,
                'max_length' => 9,
                'regex_pattern' => '^380\d{9}$'
            ],
            [
                'country_code' => 'KZ',
                'country_name' => 'Kazakhstan',
                'phone_code' => '7',
                'min_length' => 10,
                'max_length' => 10,
                'regex_pattern' => '^7\d{10}$'
            ],
            [
                'country_code' => 'BY',
                'country_name' => 'Belarus',
                'phone_code' => '375',
                'min_length' => 9,
                'max_length' => 9,
                'regex_pattern' => '^375\d{9}$'
            ],
            [
                'country_code' => 'DE',
                'country_name' => 'Germany',
                'phone_code' => '49',
                'min_length' => 10,
                'max_length' => 11,
                'regex_pattern' => '^49\d{10,11}$'
            ],
            [
                'country_code' => 'MD',
                'country_name' => 'Moldova',
                'phone_code' => '373',
                'min_length' => 8,
                'max_length' => 8,
                'regex_pattern' => '^373\d{8}$'
            ]
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}
