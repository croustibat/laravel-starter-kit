<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialPost extends Model
{
    /** @use HasFactory<\Database\Factories\SocialPostFactory> */
    use HasFactory;

    protected $fillable = [
        'platform',
        'status',
        'post_id',
        'published_at',
        'error_message',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
        ];
    }

    public function digest(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Digest::class);
    }
}
