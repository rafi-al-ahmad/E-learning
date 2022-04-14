<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Permission extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'code',
        'group',
    ];
}
