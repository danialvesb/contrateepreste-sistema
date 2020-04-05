<?php

namespace App\Models\User;

use App\Models\File;
use App\Models\Service\Offer;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Solicitation extends Model
{

    public function user()
    {
        //Um para muitos (inverso)
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        //Um para muitos (inverso)
        return $this->belongsTo(Offer::class);
    }

    public function files() {
        return $this->belongsToMany(File::class);
    }
}
