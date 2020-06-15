<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'comment', 'reply', 'solicitation_id', 'rating'
    ];

    public function solicitation()
    {
        //Um para muitos (inverso)
        return $this->belongsTo(Solicitation::class);
    }

}
