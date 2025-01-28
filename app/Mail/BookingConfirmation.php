<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $guestName;
    public $roomId;
    public $startDate;
    public $endDate;

    public function __construct($guestName, $roomId, $startDate, $endDate)
    {
        $this->guestName = $guestName;
        $this->roomId = $roomId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function build()
    {
        return $this->view('emails.booking_confirmation')
                    ->subject('Подтверждение бронирования')
                    ->with([
                        'guestName' => $this->guestName,
                        'roomId' => $this->roomId,
                        'startDate' => $this->startDate,
                        'endDate' => $this->endDate,
                    ]);
    }
}
