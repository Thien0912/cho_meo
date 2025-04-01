<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenUsage extends Model
{
    use HasFactory;

    protected $fillable = ['tokens_used']; // Đảm bảo cho phép lưu trữ tokens_used
}
