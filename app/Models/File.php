<?php

namespace App\Models;

use App\Models\Service\Offer;
use App\Models\User\Solicitation;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    public function solicitation() {
        return $this->belongsToMany(Solicitation::class);
    }

    public function offer() {
        return $this->belongsToMany(Offer::class);
    }

}
