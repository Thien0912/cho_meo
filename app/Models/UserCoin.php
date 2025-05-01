<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCoin extends Model
{
    use HasFactory;

    protected $table = 'user_coins';

    protected $fillable = [
        'user_id',
        'coins_change',
        'reason',
        'created_at',
    ];

    public $timestamps = false;
}
