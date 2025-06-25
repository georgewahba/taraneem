<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Track extends Model
{
    protected $table = 'tracks';
    protected $fillable = ['title', 'artist', 'file'];


}
