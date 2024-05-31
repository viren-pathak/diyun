<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Debate extends Model
{
    use HasFactory;

    protected $table = 'debate';

    protected $fillable = [
        'user_id',
        'parent_id',
        'root_id',
        'title',
        'slug',
        'side',
        'thesis',
        'tags',
        'backgroundinfo',
        'image',
        'archived',
        'isDebatePublic',
        'isSingleThesis',
        'voting_allowed',
        'total_votes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(DebateComment::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function userVoted()
    {
        // Check if the authenticated user has voted for this debate
        return $this->votes()->where('user_id', auth()->id())->exists();
    }
}
