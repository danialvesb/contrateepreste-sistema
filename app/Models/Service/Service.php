<?php

namespace App\Models;

use App\Models\Service\Category;
use App\Models\Service\Offer;
use Illuminate\Database\Eloquent\Model;



class Service extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'description',
        'file'
    ];

    public function category() {
        return $this->belongsToMany(Category::class);
    }

    //um pra muitos
    public function solicitations()
    {
        return $this->hasMany(Offer::class);
    }
}
