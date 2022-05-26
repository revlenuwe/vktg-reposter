<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups';

    protected $fillable = [
        'group_id','name','custom_name','is_private','group_type'
    ];

    public function channels()
    {
        return $this->belongsToMany(Channel::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
