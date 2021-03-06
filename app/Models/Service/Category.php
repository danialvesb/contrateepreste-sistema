<?php

namespace App\Models\Service;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title'];

    public function services() {
        return $this->belongsToMany(Service::class);
    }

}
