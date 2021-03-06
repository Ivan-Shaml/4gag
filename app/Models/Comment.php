<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table='comments';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'meme_id', 'up_votes_count', 'down_votes_count', 'comment_text', 'is_reply', 'replies_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meme()
    {
        return $this->belongsTo(Meme::class);
    }
    public function commentVotes()
    {
        return $this->hasMany(usersCommentsVotes::class);
    }

    public function commentReplies()
    {
        return $this->hasMany(CommentReplies::class);
    }
}
