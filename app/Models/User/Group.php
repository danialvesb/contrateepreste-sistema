<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'name'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_groups');
    }
}
