<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Service\Category;

class Service extends Model
{
    protected $fillable = [
        'title',
        'category_id',
        'description',
        'file'

    ];

    public function category() {
        return $this->hasOne('Category');
    }

}
