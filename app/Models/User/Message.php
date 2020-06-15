<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'text', 'solicitation_id', 'from_user', 'to_user', 'created_at'
    ];

    public function solicitation()
    {
        //Um para muitos (inverso)
        return $this->belongsTo(Solicitation::class);
    }

    public function fromUser()
    {
        return $this->belongsTo('App\User', 'from_user');
    }

    public function toUser()
    {
        return $this->belongsTo('App\User', 'to_user');
    }
}
