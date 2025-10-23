<?php

namespace App\Rules;

use App\Models\Country;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
class PhoneNumberByCountry implements ValidationRule
{
    protected string $countryName = 'Неизвестная';
    protected string $cleanedNumber = '';

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // 1. Очистка и нормализация номера (убираем все, кроме цифр и плюса)
        $normalizedNumber = preg_replace('/[^\d+]/', '', $value);
        if (empty($normalizedNumber)) {
            $fail('Поле номера телефона обязательно.');
            return;
        }

        // 2. Ищем код страны (временно ограничимся поиском по префиксу)
        $phoneCode = null;
        $country = null;

        // Ищем в БД самое длинное совпадение кода страны
        $countries = Country::all(['country_code', 'country_name', 'phone_code', 'regex_pattern'])
            ->sortByDesc(fn ($c) => strlen($c->phone_code));

        foreach ($countries as $c) {
            // Проверяем, начинается ли нормализованный номер с кода страны (например, '7' или '380')
            // Для удобства, убираем возможный '+' в начале номера, так как phone_code его не содержит
            $numberWithoutPlus = ltrim($normalizedNumber, '+');

            if (str_starts_with($numberWithoutPlus, $c->phone_code)) {
                $phoneCode = $c->phone_code;
                $country = $c;
                break;
            }
        }

        if (!$country) {
            $fail('Не удалось определить код страны для указанного номера.');
            return;
        }

        // 3. Валидация с помощью регулярного выражения из БД
        // Регулярное выражение в вашем Seeder-е предполагает, что номер начинается сразу с кода.
        $regex = '/^' . $country->regex_pattern . '$/';

        if (!preg_match($regex, $numberWithoutPlus)) {
            $fail('Номер телефона не соответствует формату страны ' . $country->country_name . '.');
            return;
        }

        // 4. Сохранение данных для успешного ответа
        $this->countryName = $country->country_name;
        $this->cleanedNumber = $numberWithoutPlus;
    }

    /**
     * Возвращает название страны для использования в контроллере.
     */
    public function getCountryName(): string
    {
        return $this->countryName;
    }
}
