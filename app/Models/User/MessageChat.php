<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class MessageChat extends Model
{
    protected $fillable = [
        'text', 'solicitation_id'
    ];

    public function solicitation()
    {
        //Um para muitos (inverso)
        return $this->belongsTo(Solicitation::class);
    }
}
