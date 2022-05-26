<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $table = 'channels';

    protected $fillable = [
        'name','channel_id','channel_username'
    ];

    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }
}
