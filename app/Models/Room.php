<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'is_booked', 'guest_name', 'guest_email', 'start_date', 'end_date', 'price'];
}
?>
