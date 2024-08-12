<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = 'reports';

    protected $primaryKey = 'report_id';

    protected $fillable = [
        'subject_name',
        'start_date',
        'end_date',
        'improvement_target',
    ];

}
