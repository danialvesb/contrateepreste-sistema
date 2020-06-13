<?php

namespace App\Models\User;

use App\Models\File;
use App\Models\Service\Offer;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Solicitation extends Model
{
    protected $fillable = [
        'status',
        'message',
        'owner_id',
        'offer_id',
    ];

    public function user()
    {
        //Um para muitos (inverso)
        return $this->belongsTo(User::class);
    }

    public function messageChat()
    {
        //muitos pra muitos
        return $this->hasMany(Message::class);
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
