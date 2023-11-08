<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Taraneem extends Model
{
    use HasFactory;
    protected $table = 'taraneem';

    protected $fillable = [
        'titel',
        'lyrics'
    ];
}
