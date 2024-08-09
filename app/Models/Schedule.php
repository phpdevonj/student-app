<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model {
    use HasFactory;

    protected $table = 'schedule';

    protected $fillable = ['title', 'start_date_time', 'end_date_time'];

}
