<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'room_id',
        'text',
        'choices',
        'correct_index',
        'order_num',
    ];

    protected $casts = [
        'choices' => 'array',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}

