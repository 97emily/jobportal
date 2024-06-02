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

    protected $fillable = ['title', 'description', 'job_listings_id'];

    public function jobListing()
    {
        return $this->belongsTo(JobListing::class, 'job_listings_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
