<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
	protected $fillable = [
        'user_id', 'provider', 'social_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
