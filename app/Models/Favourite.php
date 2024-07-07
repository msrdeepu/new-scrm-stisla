<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    function user()
    {
        return $this->belongsTo(User::class, 'favourite_id', 'id');
    }
}
