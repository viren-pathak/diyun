<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thanks extends Model
{
    use HasFactory;

    protected $fillable = [
        'thanked_by_user_id',
        'thanked_on',
        'thanked_activity_id',
        'thanked_to_user_id',
    ];

    public function debate()
    {
        return $this->belongsTo(Debate::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
