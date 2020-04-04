<?php

namespace App\Models\Service;

use App\Models\File;
use App\Models\Service;
use App\Models\User\Solicitation;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    //um pra muitos
    public function solicitations()
    {
        return $this->hasMany(Solicitation::class);
    }

    public function service()
    {
        //um pra muitos(inverso)
        return $this->hasMany(Service::class);
    }

    public function offer() {
        return $this->belongsToMany(File::class);
    }
}
