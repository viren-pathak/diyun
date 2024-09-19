<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebateRead extends Model
{
    protected $table = 'debate_reads';

    protected $fillable = [
        'debate_id',
        'user_id',
    ];

    // Relationship with the Debate model
    public function debate()
    {
        return $this->belongsTo(Debate::class);
    }

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
