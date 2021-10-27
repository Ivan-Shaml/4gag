<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReplies extends Model
{
    use HasFactory;

    protected $table='comment_replies';
    protected $primaryKey = 'id';
    protected $fillable = ['parent_comment', 'child_comment'];
    public $timestamps = false;

    public function comment() {
        return $this->belongsTo(Comment::class);
    }

}
