<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение бронирования</title>
</head>
<body>
    <h1>Здравствуйте, {{ $guestName }}!</h1>
    <p>Ваше бронирование подтверждено.</p>
    <p><strong>Номер:</strong> {{ $roomId }}</p>
    <p><strong>Период:</strong> с {{ $startDate }} по {{ $endDate }}</p>
    <p>Спасибо, что выбрали наш отель!</p>
</body>
</html>
