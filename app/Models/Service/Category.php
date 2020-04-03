<?php

namespace App\Models\Service;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['id', 'title'];

    public function service() {
        return $this->belongsToMany(Service::class);
    }

}
