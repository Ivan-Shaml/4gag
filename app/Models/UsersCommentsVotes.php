<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usersCommentsVotes extends Model
{
    use HasFactory;
    protected $table='users_comments_votes';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'comment_id', 'vote_type'];

    public function votes()
    {
        return $this->belongsTo(Comment::class);
    }
}
