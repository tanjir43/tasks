<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'slug',
        'media_id',
        'views',
        'status',
        'published_at',
        'created_by',
        'updated_by',
        'deleted_by'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now());
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
