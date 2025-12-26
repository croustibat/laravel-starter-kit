<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Digest extends Model
{
    /** @use HasFactory<\Database\Factories\DigestFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'status' => 'string',
        ];
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Item::class)
            ->withPivot('order')
            ->withTimestamps()
            ->orderBy('order');
    }

    public function socialPosts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SocialPost::class);
    }
}
