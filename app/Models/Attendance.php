<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date_check_in',
        'check_in_time',
        'check_out_time',
        'is_overtime',
        'is_late',
    ];

    protected $casts = [
        'date_check_in' => 'datetime',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime',
        'is_overtime' => 'boolean',
        'is_late' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
