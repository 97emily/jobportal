<?php

// app/Models/Assessment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Assessment extends Model
{
    use HasFactory;

    // protected $fillable = ['title', 'description', 'job_listings_id'];

    // public function jobListing()
    // {
    //     return $this->belongsTo(JobListing::class, 'job_listings_id');
    // }

    // public function questions()
    // {
    //     return $this->hasMany(Question::class);
    // }

    protected $fillable = ['title', 'description', 'pass_mark', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
