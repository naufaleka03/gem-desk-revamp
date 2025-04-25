<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Solution extends Model
{
    use HasFactory;
    protected $fillable = [
      'ticket_id', 'messages'
    ];
    public function ticket() : BelongsTo{
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
