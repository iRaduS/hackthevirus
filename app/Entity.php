<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'user_id', 'level', 'exp', 'levelup_at'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $dates = [
        'levelup_at'
    ];

    protected $hidden = [
        'created_at', 'updated_at', 'id', 'user_id'
    ];
}