<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение бронирования</title>
</head>
<body>
    <h1>Здравствуйте, <?php echo e($guestName); ?>!</h1>
    <p>Ваше бронирование подтверждено.</p>
    <p><strong>Номер:</strong> <?php echo e($roomId); ?></p>
    <p><strong>Период:</strong> с <?php echo e($startDate); ?> по <?php echo e($endDate); ?></p>
    <p>Спасибо, что выбрали наш отель!</p>
</body>
</html>
<?php /**PATH C:\Users\Wulf.png\hotel_booking\resources\views/emails/booking_confirmation.blade.php ENDPATH**/ ?>