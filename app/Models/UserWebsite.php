<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserWebsite extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'website_id'
    ];
}
