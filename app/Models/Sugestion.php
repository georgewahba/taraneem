<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sugestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'titel',
        'lyrics',
    ];

    protected $table = 'suggestions';
}
