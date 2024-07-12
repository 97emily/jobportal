<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticalTest extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'instructions', 'deadline', 'category_id'];

    public function questions()
    {
        return $this->hasMany(PracticalQuestion::class, 'practical_tests_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

