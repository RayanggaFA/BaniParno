<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Generation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch',
        'description',
        'color',
        'status'
    ];

    // Atau bisa menggunakan default value untuk generation
    protected $attributes = [
        'generation' => 1, // Default value
        'status' => 'active'
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function activeMembers()
    {
        return $this->hasMany(Member::class)->where('status', 'active');
    }

    public function rootMembers()
    {
        return $this->hasMany(Member::class)->whereNull('parent_id');
    }
}