<?php

namespace App\Http\Controllers;

use App\Rules\PhoneNumberByCountry;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    public function validateAndLookup(Request $request)
    {
        // Создаем экземпляр кастомного правила
        $phoneRule = new PhoneNumberByCountry();

        // 1. Валидация с помощью кастомного правила
        $validator = validator($request->all(), [
            'phone_number' => ['required', 'string', $phoneRule],
        ]);

        if ($validator->fails()) {
            // 2. Если валидация не прошла
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->first('phone_number')
            ], 422);
        }

        // 3. Валидация прошла, получаем имя страны из правила
        $countryName = $phoneRule->getCountryName();

        // 4. Успешный ответ
        return response()->json([
            'success' => true,
            'message' => 'Номер телефона корректен.',
            'country' => $countryName,
        ]);
    }
}
