<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'schedule_type',
        'related_module',
        'target_id',
        'start_date',
        'due_date',
        'repeat_type',
        'priority',
        'status',
        'assigned_to',
        'reminder_time',
        'notification_method',
        'notes',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
    ];

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
