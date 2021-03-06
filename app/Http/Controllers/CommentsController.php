<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use mysql_xdevapi\Result;
use function PHPUnit\Framework\isNull;
use App\Models\Meme;
use App\Models\UsersCommentsVotes;
use App\Models\CommentReplies;

class CommentsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, bool $isReply=false)
    {
        $request->validate([
            'comment_text' => 'required',
            'meme_id' => 'required|integer'
        ]);

        Meme::find($request->input('meme_id')) ?? abort(404);
        if($isReply) {
            $comment = Comment::create([
                'comment_text' => $request->input('comment_text'),
                'meme_id' => $request->input('meme_id'),
                'user_id' => auth()->user()->getAuthIdentifier(),
                'is_reply' => 1
            ]);
        } else {
            $comment = Comment::create([
                'comment_text' => $request->input('comment_text'),
                'meme_id' => $request->input('meme_id'),
                'user_id' => auth()->user()->getAuthIdentifier(),
            ]);
        }

        Meme::where('id', $request->input('meme_id'))->increment('comments_count', 1);

        return json_encode(['comment_id' => $comment->id, 'comment_text' => htmlspecialchars($comment->comment_text), 'user_name'=>Auth::user()->name, 'posted_at'=>date('Y-m-d h:m:s')]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(?int $id = null)
    {
        $id ?? abort(404);

        $isAdmin = false;
        if (!is_null(Auth::user()))
            User::where('id', Auth::user()->getAuthIdentifier())->where('role', 'admin')->first() === null ? $isAdmin = false : $isAdmin = true;

        $comments = Comment::orderBy('id', 'desc')->where('meme_id', $id)->where('is_reply', 0)->get() ?? abort(404);
        $commentsCount = Comment::orderBy('id', 'desc')->where('meme_id', $id)->count();
        $meme = Meme::find($id) ?? abort(404);
        return view('comments.show',['comments' => $comments, 'meme' => $meme, 'isAdmin' => $isAdmin, 'commentsCount'=>$commentsCount]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        User::where('id', Auth::user()->getAuthIdentifier())->where('role', 'admin')->first() ?? abort(403);

        $comment->delete();
        Meme::where('id', $comment->meme_id)->decrement('comments_count', 1);

        return json_encode(['comment_id'=>$comment->id,'message'=>'Comment has been deleted']);
    }

    public function downvote($id)
    {
        $comment = Comment::find($id) ?? abort(404);
        $userId = auth()->user()->getAuthIdentifier();
        $result = UsersCommentsVotes::where('user_id', $userId)->where('comment_id', $comment->id)->first();

        if(empty($result)) {
            UsersCommentsVotes::create([
                'user_id' => $userId, 'comment_id' => $comment->id, 'vote_type' => false
            ]);
            Comment::where('id', $comment->id)->update(['down_votes_count'=>$comment->down_votes_count+1]);
            $comment->down_votes_count++;
        }elseif (!empty($result) && $result->vote_type == 1) {
            UsersCommentsVotes::where('id', $result->id)->update(['vote_type' => false ]);
            if($comment->up_votes_count > 0) {
                Comment::where('id', $comment->id)->update(['up_votes_count' => $comment->up_votes_count - 1, 'down_votes_count' => $comment->down_votes_count + 1]);
                $comment->up_votes_count--;
                $comment->down_votes_count++;
            } else {
                Comment::where('id', $comment->id)->update(['down_votes_count' => $comment->down_votes_count + 1]);
                $comment->down_votes_count++;
            }
        }

        return json_encode(['comment_id'=>$comment->id ,'up_votes'=>$comment->up_votes_count, 'down_votes'=>$comment->down_votes_count]);
    }

    public function upvote(Request $request, $id)
    {
        $comment = Comment::find($id) ?? json_encode(['status' => 404]);
        $userId = auth()->user()->getAuthIdentifier();
        $result = UsersCommentsVotes::where('user_id', $userId)->where('comment_id', $comment->id)->first();

        if (empty($result)) {
            UsersCommentsVotes::create([
                'user_id' => $userId, 'comment_id' => $comment->id, 'vote_type' => true
            ]);
            Comment::where('id', $comment->id)->update(['up_votes_count' => $comment->up_votes_count + 1]);
            $comment->up_votes_count++;
        } elseif (!empty($result) && $result->vote_type == 0) {
            UsersCommentsVotes::where('id', $result->id)->update(['vote_type' => true]);
            if ($comment->down_votes_count > 0) {
                Comment::where('id', $comment->id)->update(['down_votes_count' => $comment->down_votes_count - 1, 'up_votes_count' => $comment->up_votes_count + 1]);
                $comment->up_votes_count++;
                $comment->down_votes_count--;
            } else {
                Comment::where('id', $comment->id)->update(['up_votes_count' => $comment->up_votes_count + 1]);
                $comment->up_votes_count++;
            }

        }

        return json_encode(['comment_id'=>$comment->id ,'up_votes'=>$comment->up_votes_count, 'down_votes'=>$comment->down_votes_count]);

    }

    public function reply($id, Request $request)
    {
        Comment::where('id', $id)->first() ?? abort(404);

        $result = $this->store($request, true);

        $decoded_result = json_decode($result, true);

        $decoded_result['parent_comment'] = $id;

        CommentReplies::create([
            'parent_comment'=>$id,
            'child_comment'=>$decoded_result['comment_id']
        ]);
        Comment::find($id)->increment('replies_count');

        return json_encode($decoded_result);
    }

    public function showCommentReplies($id)
    {
        Comment::where('id', $id)->first() ?? abort(404);
        $commentReplies = Comment::join('comment_replies', 'comments.id', '=', 'comment_replies.child_comment')
            ->join('users','comments.user_id', '=', 'users.id' )
            ->where('parent_comment', '=', $id)
            ->select('comments.*', 'users.name')
            ->get();

        return json_encode($commentReplies->toArray());
    }
}
