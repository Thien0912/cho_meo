<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'header_title',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'about_url',
        'contact_url',
        'terms_url',
        'privacy_url',
        'favicon'
    ];
}