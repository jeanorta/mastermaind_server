<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Play;

class Game extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = ['secret_code'];

}
