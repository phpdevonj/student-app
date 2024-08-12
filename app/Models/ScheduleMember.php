<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleMember extends Model {
    use HasFactory;

    protected $table = 'schedule_member';

    protected $fillable = ['schedule_id', 'user_id'];

    public function getSchedule() {
        return $this->hasOne(Schedule::class, 'id', 'schedule_id');
    }

}
