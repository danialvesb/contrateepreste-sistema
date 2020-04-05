<?php

namespace App\Models;

use App\Models\Service\Category;
use App\Models\Service\Offer;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Service extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
    ];

    public function category() {
        return $this->belongsToMany(Category::class);
    }

    //um pra muitos
    public function solicitations()
    {
        return $this->hasMany(Offer::class);
    }

    public function save($service, $categories)
    {
        $service->save();
        $service->category()->attach($categories);
    }

}
