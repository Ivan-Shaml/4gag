<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserVotes extends Model
{
    use HasFactory;

    protected $table='user_votes';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'meme_id', 'vote_type'];

    public function meme() {
        return $this->hasMany(Meme::class);
    }
}
