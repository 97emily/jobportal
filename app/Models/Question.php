<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['assessment_id', 'question'];

    public function assessment()
    {
        return $this->BelongsTo(Assessment::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
