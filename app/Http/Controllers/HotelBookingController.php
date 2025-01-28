<?php

namespace App\Http\Controllers; // Пространство имен для контроллера.

use Illuminate\Http\Request; // Импорт класса для обработки HTTP-запросов.
use App\Models\Room; // Импорт модели Room для взаимодействия с таблицей номеров.
use App\Mail\BookingConfirmation; // Импорт класса для отправки письма с подтверждением бронирования.
use Illuminate\Support\Facades\Mail; // Импорт фасада Mail для отправки электронной почты.
use Carbon\Carbon; // Импорт библиотеки Carbon для работы с датами.

class HotelBookingController extends Controller // Определение контроллера для управления бронированием отеля.
{
    public function index(Request $request) // Основной метод контроллера, который обрабатывает действия пользователя.
    {
        $action = $request->query('action', ''); // Получение параметра `action` из строки запроса (по умолчанию пусто).
        $rooms = []; // Инициализация пустого массива для хранения доступных номеров.
        $bookings = []; // Инициализация пустого массива для хранения бронирований.
        $message = ''; // Инициализация строки для сообщений об ошибках или успехах.

        setlocale(LC_TIME, 'ru_RU.UTF-8'); // Установка локали для работы с датами на русском языке.
        $months = [ // Словарь с названиями месяцев на русском языке.
            1 => 'января', 2 => 'февраля', 3 => 'марта', 4 => 'апреля', 5 => 'мая', 6 => 'июня',
            7 => 'июля', 8 => 'августа', 9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
        ];

        if ($action === 'view_rooms') { // Если действие — просмотр доступных номеров.
            $rooms = Room::where('is_booked', false)->get(); // Получение всех свободных номеров.
        } elseif ($action === 'book') { // Если действие — бронирование номера.
            $roomId = $request->post('room_id'); // Получение ID номера из POST-запроса.
            $guestName = $request->post('guest_name'); // Получение имени гостя из POST-запроса.
            $guestEmail = $request->post('guest_email'); // Получение email гостя из POST-запроса.
            $startDateForDb = $request->post('start_date'); // Получение даты заезда из POST-запроса.
            $endDateForDb = $request->post('end_date'); // Получение даты выезда из POST-запроса.

            $startDate = Carbon::parse($startDateForDb); // Преобразование даты заезда в объект Carbon.
            $endDate = Carbon::parse($endDateForDb); // Преобразование даты выезда в объект Carbon.

            $startDateFormatted = $startDate->day . ' ' . $months[$startDate->month] . ' ' . $startDate->year; // Форматирование даты заезда.
            $endDateFormatted = $endDate->day . ' ' . $months[$endDate->month] . ' ' . $endDate->year; // Форматирование даты выезда.

            if ($roomId && $guestName && $guestEmail && $startDateForDb && $endDateForDb) { // Проверка наличия всех данных.
                $room = Room::where('id', $roomId)->where('is_booked', false)->first(); // Проверка, что номер существует и свободен.
                if ($room) { // Если номер найден.
                    $room->update([ // Обновление данных номера в базе.
                        'is_booked' => true,
                        'guest_name' => $guestName,
                        'guest_email' => $guestEmail,
                        'start_date' => $startDateForDb,
                        'end_date' => $endDateForDb,
                    ]);

                    Mail::to($guestEmail)->send(new BookingConfirmation($guestName, $roomId, $startDateFormatted, $endDateFormatted)); // Отправка письма с подтверждением бронирования.

                    $message = "Номер $roomId успешно забронирован для $guestName с $startDateFormatted по $endDateFormatted!"; // Успешное сообщение.
                } else {
                    $message = "Ошибка: Номер уже забронирован или не существует."; // Ошибка, если номер уже занят или не найден.
                }
            } else {
                $message = "Ошибка: Укажите номер, ваше имя, email и даты."; // Ошибка, если данные неполные.
            }
        } elseif ($action === 'view_bookings') { // Если действие — просмотр бронирований.
            $bookings = Room::where('is_booked', true)->get()->map(function ($booking) use ($months) { // Получение всех забронированных номеров.
                $startDate = Carbon::parse($booking->start_date); // Преобразование даты заезда.
                $endDate = Carbon::parse($booking->end_date); // Преобразование даты выезда.

                $booking->formatted_start_date = $startDate->day . ' ' . $months[$startDate->month] . ' ' . $startDate->year; // Форматирование даты заезда.
                $booking->formatted_end_date = $endDate->day . ' ' . $months[$endDate->month] . ' ' . $endDate->year; // Форматирование даты выезда.

                return $booking; // Возврат объекта бронирования с форматированными датами.
            });
        } elseif ($action === 'cancel_booking') { // Если действие — отмена бронирования.
            $roomId = $request->post('room_id'); // Получение ID номера из POST-запроса.

            if ($roomId) { // Если ID номера указан.
                $room = Room::where('id', $roomId)->where('is_booked', true)->first(); // Проверка, что номер существует и забронирован.
                if ($room) { // Если номер найден.
                    $room->update([ // Обновление данных номера в базе.
                        'is_booked' => false,
                        'guest_name' => null,
                        'guest_email' => null,
                        'start_date' => null,
                        'end_date' => null,
                    ]);
                    $message = "Бронирование номера $roomId успешно отменено."; // Успешное сообщение.
                } else {
                    $message = "Ошибка: Номер не найден или не забронирован."; // Ошибка, если номер не найден или не забронирован.
                }
            } else {
                $message = "Ошибка: Укажите номер для отмены бронирования."; // Ошибка, если ID номера не указан.
            }
        }

        return view('hotel_booking', compact('action', 'rooms', 'bookings', 'message')); // Возврат представления с данными.
    }
}
?>
