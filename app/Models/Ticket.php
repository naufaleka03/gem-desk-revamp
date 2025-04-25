<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'description',
        'user_id',
        'ticket_type',
        'files',
        'status',
        'is_resolved',
        'comments',
        'priority',
        'assignee_id',
    ];

    public function solutions() : HasMany
    {
        return $this->hasMany(Solution::class, 'ticket_id');
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function assignee()
    {
        return $this->belongsTo(User::class, 'assignee_id');
    }
}