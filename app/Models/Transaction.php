<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = ['momo_transaction_id', 'amount', 'user_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
