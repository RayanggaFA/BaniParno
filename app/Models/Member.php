<?php
// app/Models/Member.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'birth_place',
        'birth_date',
        'job',
        'address_ktp',
        'domicile_city',
        'domicile_province',
        'current_address',
        'phone',
        'email',
        'photo',
        'family_id',
        'parent_id',
        'generation_id', 
        'gender',
        'status',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    // Relationships
    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function parent()
    {
        return $this->belongsTo(Member::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Member::class, 'parent_id');
    }

    public function socialLinks()
    {
        return $this->hasMany(SocialLink::class);
    }

    public function histories()
    {
        return $this->hasMany(MemberHistory::class);
    }

    public function generation()
    {
        return $this->belongsTo(Generation::class);
    }

    // Accessors
    public function age(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->birth_date ? Carbon::parse($this->birth_date)->age : null,
        );
    }

    public function fullBirthInfo(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->birth_place . ', ' . $this->birth_date->format('d F Y'),
        );
    }

    public function photoUrl(): Attribute
{
    return Attribute::make(
        get: fn () => $this->photo ? asset('storage/' . $this->photo) : asset('images/default-avatar.png'),

    );
}

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByGeneration($query, $generation)
    {
        return $query->whereHas('generation', function ($q) use ($generation) {
            $q->where('name', $generation);
        });
    }

    public function scopeByBranch($query, $branch)
    {
        return $query->whereHas('family', function ($q) use ($branch) {
            $q->where('branch', $branch);
        });
    }

    public function scopeByDomicile($query, $city)
    {
        return $query->where('domicile_city', 'like', '%' . $city . '%');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%');
    }
}