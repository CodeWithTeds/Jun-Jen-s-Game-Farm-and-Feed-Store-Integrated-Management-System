<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'group',
        'order',
        'type',
        'options',
        'label',
        'description',
        'is_system',
        'is_public',
        'validation_rules',
    ];

    protected $casts = [
        'is_system' => 'boolean',
        'is_public' => 'boolean',
        'options' => 'array',
    ];

    // Helper to get value with correct type
    public function getValueAttribute($value)
    {
        if ($this->type === 'boolean') {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
        if ($this->type === 'integer') {
            return (int) $value;
        }
        if ($this->type === 'json') {
            return json_decode($value, true);
        }
        return $value;
    }

    public function setValueAttribute($value)
    {
        if ($this->type === 'json' && is_array($value)) {
            $this->attributes['value'] = json_encode($value);
        } else {
            $this->attributes['value'] = $value;
        }
    }
}
