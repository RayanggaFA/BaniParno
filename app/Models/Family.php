<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'branch', // Cabang keluarga
        'description',
        // HAPUS 'generation' dari sini
    ];

    // Relationships
    public function members()
    {
        return $this->hasMany(Member::class);
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