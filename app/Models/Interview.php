<?php

namespace App\Models;

// app/Models/Interview.php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    use HasFactory;

    protected $fillable = [
        'interview_date',
        'interview_time',
        'job_listings_id',
        'location_id',
        'applicant_id',
        'applicant_user_id',
        'title',
        'requirements',
    ];

    // Define relationships with Job and Location models
    public function job()
    {
        return $this->belongsTo(JobListing::class, 'job_listings_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
