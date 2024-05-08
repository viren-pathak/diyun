<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag', 
        'tag_image',
        'tag_description'
    ];
    
    public function debates()
    {
        return $this->belongsToMany(Debate::class);
    }
}
