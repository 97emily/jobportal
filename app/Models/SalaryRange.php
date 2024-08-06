<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class SalaryRange extends Model implements HasMedia, Searchable
{
    use HasFactory, InteractsWithMedia;

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'minimum',
        'maximum',
    ];

    protected $orderable = [
        'id',
        'minimum',
        'maximum',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
    
    public function jobs()
    {
        return $this->hasMany(JobListing::class);
    }
    // For quick search
    public function getSearchResult(): SearchResult
    {
        $url = route('categories.show', $this->id);

        return new \Spatie\Searchable\SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}
