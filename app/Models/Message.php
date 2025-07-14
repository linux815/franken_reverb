<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'text',
    ];

    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function scopeBetweenUsers(Builder $query, int $authUserId, int $otherUserId): Builder
    {
        return $query->where(fn($q)
            => $q
            ->where('sender_id', $authUserId)
            ->where('receiver_id', $otherUserId),
        )->orWhere(fn($q)
            => $q
            ->where('sender_id', $otherUserId)
            ->where('receiver_id', $authUserId),
        );
    }
}
