<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebateRecentView extends Model
{
    protected $table = 'debate_recent_views';

    protected $fillable = [
        'user_id',
        'debate_id',
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
