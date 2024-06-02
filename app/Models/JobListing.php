<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\SearchResult;

class JobListing extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'job_description',
        'status',
        'closing_date',
        'tag_id',
        'category_id',
        'location',
        'salary_min',
        'salary_max',
        'employment_type',
        'experience_level',
        'education_requirements',
        'assessment_test',
        'threshold_score',
    ];

    // Relationships
    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    //

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    // public function categories(): BelongsToMany
    // {
    //     return $this->belongsToMany(Category::class, 'job_category', 'job_id', 'category_id');
    // }

    // public function statusName()
    // {
    //     return ProductStatus::getDescription($this->status);
    // }

    // For quick search
    public function getSearchResult(): SearchResult
    {
        $url = route('jobs.show', $this->id);

        return new \Spatie\Searchable\SearchResult(
            $this->id,
            $this->name,
            $url
        );
    }
}
