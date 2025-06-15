<?php
// app/Models/SocialLink.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'platform',
        'url',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function getIconAttribute()
    {
        $icons = [
            'facebook' => 'fab-facebook-f',
            'twitter' => 'fab-twitter',
            'instagram' => 'fab-instagram',
            'linkedin' => 'fab-linkedin-in',
            'tiktok' => 'fab-tiktok',
            'youtube' => 'fab-youtube',
        ];

        return $icons[$this->platform] ?? 'fas-link';
    }
}

