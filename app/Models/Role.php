<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->guard_name)) {
                $model->guard_name = 'web';
            }
        });
    }
}
