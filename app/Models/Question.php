<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Question extends Model
{
    use HasFactory;

    // protected $fillable = ['assessment_id', 'question'];

    // public function assessment()
    // {
    //     return $this->BelongsTo(Assessment::class);
    // }

    // public function answers()
    // {
    //     return $this->hasMany(Answer::class);
    // }

    protected $fillable = ['question', 'allocated_marks', 'allocated_time', 'multiple_choices', 'marking_scheme', 'assessment_id'];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
