<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id', 'type', 'title', 'message', 'data', 'read_at'
    ];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    // Scope untuk notifikasi unread
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    // Scope untuk notifikasi user tertentu
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Mark as read
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }
}
