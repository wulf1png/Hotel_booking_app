<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"> <!-- Устанавливает кодировку страницы в UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Адаптирует страницу для мобильных устройств -->
    <title>Бронирование номера</title> <!-- Заголовок страницы -->
    <link rel="stylesheet" href="<?php echo e(asset('css/styles.css')); ?>"> <!-- Подключение CSS-файла -->

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        // --- Логика работы с номерами ---
        const rooms = document.querySelectorAll('.room'); // Находим все элементы с классом "room"
        rooms.forEach(room => {
            room.addEventListener('click', function () { // Добавляем обработчик клика на каждый элемент
                const roomId = this.getAttribute('data-room-id'); // Получаем ID номера из атрибута data-room-id
                document.getElementById('room_id').value = roomId; // Устанавливаем ID номера в поле ввода для бронирования
                document.getElementById('cancel_room_id').value = roomId; // Устанавливаем ID номера в поле для отмены бронирования
            });
        });

        // --- Логика работы с датами ---
        const startDateInput = document.getElementById("start_date"); // Находим поле ввода для даты заезда
        const endDateInput = document.getElementById("end_date"); // Находим поле ввода для даты выезда
        const today = new Date().toISOString().split("T")[0]; // Получаем сегодняшнюю дату в формате "YYYY-MM-DD"

        // Устанавливаем минимальную дату для даты заезда и выезда
        startDateInput.min = today; // Минимальная дата для заезда — сегодня
        endDateInput.min = today; // Минимальная дата для выезда — сегодня

        // Обновляем минимальную дату для выезда при изменении даты заезда
        startDateInput.addEventListener("change", function () {
            const startDate = this.value; // Получаем выбранную дату заезда
            endDateInput.min = startDate; // Устанавливаем минимальную дату для выезда

            if (endDateInput.value && endDateInput.value < startDate) { // Если дата выезда меньше даты заезда
                endDateInput.value = ""; // Очищаем поле выезда
            }
        });

        // Обновляем максимальную дату для заезда при изменении даты выезда
        endDateInput.addEventListener("change", function () {
            const endDate = this.value; // Получаем выбранную дату выезда
            startDateInput.max = endDate; // Устанавливаем максимальную дату для заезда

            if (startDateInput.value && startDateInput.value > endDate) { // Если дата заезда больше даты выезда
                startDateInput.value = ""; // Очищаем поле заезда
            }
        });
    });
</script>

</head>
<body>
<div class="container"> <!-- Контейнер для основного содержимого -->
    <h2>Бронирование номера</h2> <!-- Заголовок страницы -->
    <div class="buttons-container">
    <a href="?action=view_rooms">Просмотреть доступные номера</a> <!-- Ссылка для просмотра доступных номеров -->
    <a href="?action=view_bookings">Просмотреть текущие бронирования</a> <!-- Ссылка для просмотра бронирований -->
    </div>
    <?php if($action === 'view_rooms'): ?> <!-- Если выбран просмотр доступных номеров -->
        <h2>Доступные номера</h2>
        <div class="rooms-container">
        <?php if($rooms->isNotEmpty()): ?> <!-- Если есть доступные номера -->
            <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <!-- Перебираем доступные номера -->
                <div class="room" data-room-id="<?php echo e($room->id); ?>"> <!-- Блок с информацией о номере -->
                    <p><strong>Номер:</strong> <?php echo e($room->id); ?></p> <!-- ID номера -->
                    <p><strong>Описание:</strong> <?php echo e($room->description); ?></p> <!-- Описание номера -->
                    <p><strong>Цена за сутки:</strong> <?php echo e($room->price); ?> руб.</p> <!-- Цена номера -->
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?> <!-- Если нет доступных номеров -->
            <p>Нет доступных номеров.</p>
        
        <?php endif; ?>
    <?php elseif($action === 'book' || $action === 'cancel_booking'): ?> <!-- Если выполняется бронирование или отмена -->
        <p><?php echo e($message); ?></p> <!-- Сообщение об операции -->
    <?php elseif($action === 'view_bookings'): ?> <!-- Если выбран просмотр текущих бронирований -->
        <h2>Текущие бронирования</h2>
        <div class="rooms-container">
        <?php if($bookings->isNotEmpty()): ?> <!-- Если есть текущие бронирования -->
            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <!-- Перебираем бронирования -->
            <div class="booking" data-room-id="<?php echo e($booking->id); ?>"> <!-- Блок с информацией о бронировании -->
                <p><strong>Номер:</strong><br> <?php echo e($booking->id); ?></p> <!-- ID номера -->
                <p><strong>Гость:</strong><br> <?php echo e($booking->guest_name); ?></p> <!-- Имя гостя -->
                <p><strong>Email гостя:</strong><br> <?php echo e($booking->guest_email); ?></p> <!-- Email гостя -->
                <p><strong>Период:</strong><br> <?php echo e($booking->start_date); ?> - <?php echo e($booking->end_date); ?></p> <!-- Период бронирования -->
                <p><strong>Цена за сутки:</strong><br> <?php echo e($booking->price); ?> руб.</p> <!-- Цена бронирования -->
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <form method="POST" action="?action=cancel_booking"> <!-- Форма для отмены бронирования -->
                <?php echo csrf_field(); ?> <!-- CSRF-токен для безопасности -->
                <label>Номер для отмены бронирования:</label>
                <input type="text" id="cancel_room_id" name="room_id" placeholder="Введите номер комнаты для отмены"> <!-- Поле ввода номера для отмены -->
                <button type="submit">Отменить бронирование</button> <!-- Кнопка для отправки формы -->
            </form>
        <?php else: ?> <!-- Если нет текущих бронирований -->
            <p>Нет текущих бронирований.</p>
        <?php endif; ?>
    <?php endif; ?>

    <form method="POST" action="?action=book"> <!-- Форма для бронирования -->
        <?php echo csrf_field(); ?> <!-- CSRF-токен для безопасности -->
        <label>Номер для бронирования:</label>
        <input type="text" id="room_id" name="room_id" placeholder="Введите номер комнаты"> <!-- Поле ввода номера -->

        <label>Имя:</label>
        <input type="text" name="guest_name" placeholder="Введите имя"> <!-- Поле ввода имени -->

        <label>Email:</label>
        <input type="text" name="guest_email" placeholder="Введите email" required> <!-- Поле ввода email -->

        <label>Дата заезда:</label>
        <input type="date" id="start_date" name="start_date" required> <!-- Поле ввода даты заезда -->

        <label>Дата выезда:</label>
        <input type="date" id="end_date" name="end_date" required> <!-- Поле ввода даты выезда -->

        <button type="submit">Забронировать</button> <!-- Кнопка для отправки формы -->
    </form>
</div>
</body>
</html>
<?php /**PATH C:\Users\Wulf.png\hotel_booking\resources\views/hotel_booking.blade.php ENDPATH**/ ?>