<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Meme extends Model
{
    use HasFactory;

    protected $table='memes';
    protected $primaryKey = 'id';
    protected $fillable = ['image_path', 'title', 'up_votes_count', 'down_votes_count', 'user_id', 'comments_count'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }
}
