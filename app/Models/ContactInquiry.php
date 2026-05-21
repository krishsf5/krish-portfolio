<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactInquiry extends Model
{
    public const STATUS_UNREAD = 'unread';

    public const STATUS_READ = 'read';

    public const STATUS_ARCHIVED = 'archived';

    protected $fillable = [
        'name',
        'email',
        'message',
        'status',
        'ip_hash',
        'user_agent',
        'read_at',
        'archived_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'archived_at' => 'datetime',
    ];

    public function markRead(): void
    {
        $this->update([
            'status' => self::STATUS_READ,
            'read_at' => $this->read_at ?? now(),
        ]);
    }

    public function markUnread(): void
    {
        $this->update([
            'status' => self::STATUS_UNREAD,
            'read_at' => null,
        ]);
    }

    public function archive(): void
    {
        $this->update([
            'status' => self::STATUS_ARCHIVED,
            'archived_at' => $this->archived_at ?? now(),
        ]);
    }
}
