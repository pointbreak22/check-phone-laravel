<!DOCTYPE html>
<html>
<head>
    <title>AJAX Валидация телефона</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<h2>Проверка номера телефона</h2>

<form id="phoneValidationForm">
    @csrf
    <div>
        <label for="phone_number">Номер телефона:</label>
        <input type="text" id="phone_number" name="phone_number" placeholder="+7 999 123-45-67" required>
        <button type="submit">Проверить</button>
    </div>

    <div id="result_message" style="margin-top: 10px; padding: 10px; border-radius: 4px;"></div>
</form>

<script>
    $(document).ready(function() {
        // 1. Настройка AJAX для Laravel
        // Установка токена CSRF для всех POST-запросов
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // 2. Обработка отправки формы
        $('#phoneValidationForm').on('submit', function(e) {
            e.preventDefault(); // Останавливаем стандартную отправку формы

            var formData = $(this).serialize();
            var $resultDiv = $('#result_message');
            $resultDiv.html('').css({'border': 'none', 'background-color': 'transparent'}); // Очищаем предыдущий результат

            $.ajax({
                url: '{{ route('phone.validate') }}', // URL для POST-запроса (указанный в routes/web.php)
                type: 'POST',
                data: formData,
                dataType: 'json',

                // 3. Успешный ответ (HTTP 200)
                success: function(response) {
                    // response: { success: true, message: "...", country: "..." }
                    $resultDiv.css({'border': '1px solid green', 'background-color': '#e6ffe6'});
                    $resultDiv.html(
                        '<p style="color: green; font-weight: bold;">✅ ' + response.message + '</p>' +
                        '<p>Страна: <strong>' + response.country + '</strong></p>'
                    );
                },

                // 4. Ответ с ошибкой (наиболее вероятный - HTTP 422 Unprocessable Entity)
                error: function(xhr) {
                    var response = xhr.responseJSON;
                    var errorMessage = 'Произошла неизвестная ошибка.';

                    if (xhr.status === 422 && response && response.error) {
                        // Ошибка валидации из вашего кастомного правила
                        errorMessage = response.error;
                    } else if (response && response.error) {
                        // Другая серверная ошибка (например, 500)
                        errorMessage = response.error;
                    }

                    $resultDiv.css({'border': '1px solid red', 'background-color': '#ffe6e6'});
                    $resultDiv.html('<p style="color: red;">❌ Ошибка: ' + errorMessage + '</p>');
                }
            });
        });
    });
</script>

</body>
</html>
