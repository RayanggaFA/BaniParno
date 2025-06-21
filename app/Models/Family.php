<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch', 
        'description',
        'color',
        'generation'
    ];

    protected $attributes = [
        'color' => '#3B82F6',
        'generation' => 1
    ];

    // Relationships
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

    // Accessor untuk jumlah anggota
    public function getMembersCountAttribute()
    {
        return $this->members()->count();
    }

    // Scopes
    public function scopeByBranch($query, $branch)
    {
        return $query->where('branch', 'like', '%' . $branch . '%');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('branch', 'like', '%' . $search . '%');
    }
}