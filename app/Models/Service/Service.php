<?php

namespace App\Models;

use App\Models\Service\Category;
use App\Models\Service\Offer;
use Illuminate\Database\Eloquent\Model;


class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
    ];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    //um pra muitos
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

}
