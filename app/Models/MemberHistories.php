<?php
// app/Models/MemberHistory.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'field_changed',
        'old_value',
        'new_value',
        'changed_by',
        'reason',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}