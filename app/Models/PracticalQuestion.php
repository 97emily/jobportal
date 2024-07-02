<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PracticalQuestion extends Model
{
    use HasFactory;

    protected $fillable = ['practical_tests_id', 'question'];

    public function test()
    {
        return $this->belongsTo(PracticalTest::class, 'practical_tests_id');
    }
}
