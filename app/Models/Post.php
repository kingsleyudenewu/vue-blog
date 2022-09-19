<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterByPublicationDate(Builder $query, string $publicationDate = null)
    {
        return $query->orderBy('created_at', 'desc')
            ->when(!empty($publicationDate), function($query) use ($publicationDate) {
                return $query->orderBy('published_at', $publicationDate);
            });
    }

    public function getPublishedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }
}
