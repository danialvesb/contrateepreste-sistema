<?php

namespace App\Models;

use App\Models\Service\Category;
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
        return $this->belongsTo(Category::class);
    }

}
