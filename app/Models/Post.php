<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'group_id','post_id','post_type','text',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
