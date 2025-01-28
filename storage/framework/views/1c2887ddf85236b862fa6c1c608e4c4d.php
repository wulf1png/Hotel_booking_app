<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Система бронирования</title>
</head>
<body>
    <h1>Система бронирования</h1>
    <a href="/rooms">Просмотреть доступные номера</a><br>
    <a href="/bookings">Просмотреть текущие бронирования</a><br><br>
    <form method="POST" action="/book">
        <?php echo csrf_field(); ?>
        <label>Номер:</label>
        <input type="text" name="room_id" placeholder="Введите номер комнаты">
        <label>Имя гостя:</label>
        <input type="text" name="guest_name" placeholder="Введите имя гостя">
        <button type="submit">Забронировать</button>
    </form>
    <?php if(session('success')): ?>
        <p><?php echo e(session('success')); ?></p>
    <?php elseif(session('error')): ?>
        <p><?php echo e(session('error')); ?></p>
    <?php endif; ?>
</body>
</html>
<?php /**PATH C:\Users\Wulf.png\hotel_booking\resources\views/index.blade.php ENDPATH**/ ?>