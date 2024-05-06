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


}
