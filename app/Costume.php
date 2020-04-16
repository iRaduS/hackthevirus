<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Costume extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'costume_name', 'costume_price'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */

    protected $hidden = [
        'created_at', 'updated_at', 'id'
    ];
}