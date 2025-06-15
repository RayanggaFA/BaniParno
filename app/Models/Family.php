<?php
// app/Models/Family.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch',
        'generation',
        'description',
        'color',
    ];

    public function members()
    {
        return $this->hasMany(Member::class);
    }

    public function activemembers()
    {
        return $this->hasMany(Member::class)->where('status', 'active');
    }
}