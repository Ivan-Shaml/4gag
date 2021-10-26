<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Meme;
use App\Models\User;
use App\Models\UserVotes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

class MemesController extends Controller
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
        $memes = Meme::orderBy('id', 'desc')->get();

        $isAdmin = false;
        if (!is_null(Auth::user()))
            User::where('id', Auth::user()->getAuthIdentifier())->where('role', 'admin')->first() === null ? $isAdmin = false : $isAdmin = true;

        return view('memes.index', ['memes' => $memes, 'isAdmin' => $isAdmin]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|mimes:jpg,png,jpeg,gif|max:5048'
        ]);

        $newImageName = time().'-' . Str::random(10) . '.'.$request->image->extension();

        $request->image->move(public_path('images'), $newImageName);

        Meme::create([
            'title' => $request->input('title'),
            'image_path' => $newImageName,
            'user_id' => auth()->user()->getAuthIdentifier()
        ]);

        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upvote(Request $request, $id)
    {
        $meme = Meme::find($id) ?? json_encode(['status' => 404]);
        $userId = auth()->user();
        if ($userId != null)
            $userId = $userId->getAuthIdentifier();
        else return redirect('/login');

        $result = UserVotes::where('user_id', $userId)->where('meme_id', $meme->id)->first();

        if (empty($result)) {
            UserVotes::create([
                'user_id' => $userId, 'meme_id' => $meme->id, 'vote_type' => true
            ]);
            Meme::where('id', $meme->id)->update(['up_votes_count' => $meme->up_votes_count + 1]);
            $meme->up_votes_count++;
        } elseif (!empty($result) && $result->vote_type == 0) {
            UserVotes::where('id', $result->id)->update(['vote_type' => true]);
            if ($meme->down_votes_count > 0) {
                Meme::where('id', $meme->id)->update(['down_votes_count' => $meme->down_votes_count - 1, 'up_votes_count' => $meme->up_votes_count + 1]);
                $meme->up_votes_count++;
                $meme->down_votes_count--;
            } else {
                Meme::where('id', $meme->id)->update(['up_votes_count' => $meme->up_votes_count + 1]);
                $meme->up_votes_count++;
            }

        }

        return json_encode(['meme_id'=>$meme->id ,'up_votes'=>$meme->up_votes_count, 'down_votes'=>$meme->down_votes_count]);

    }

    public function downvote($id)
    {
        $meme = Meme::find($id) ?? abort(404);
        $userId = auth()->user();
        if ($userId != null)
            $userId = $userId->getAuthIdentifier();
        else return redirect('/login');

        $result = UserVotes::where('user_id', $userId)->where('meme_id', $meme->id)->first();

        if(empty($result)) {
            UserVotes::create([
                'user_id' => $userId, 'meme_id' => $meme->id, 'vote_type' => false
            ]);
            Meme::where('id', $meme->id)->update(['down_votes_count'=>$meme->down_votes_count+1]);
            $meme->down_votes_count++;
        }elseif (!empty($result) && $result->vote_type == 1) {
            UserVotes::where('id', $result->id)->update(['vote_type' => false ]);
            if($meme->up_votes_count > 0) {
                Meme::where('id', $meme->id)->update(['up_votes_count' => $meme->up_votes_count - 1, 'down_votes_count' => $meme->down_votes_count + 1]);
                $meme->up_votes_count--;
                $meme->down_votes_count++;
            } else {
                Meme::where('id', $meme->id)->update(['down_votes_count' => $meme->down_votes_count + 1]);
                $meme->down_votes_count++;
            }
        }

        return json_encode(['meme_id'=>$meme->id ,'up_votes'=>$meme->up_votes_count, 'down_votes'=>$meme->down_votes_count]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('memes.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meme  $meme
     * @return \Illuminate\Http\Response
     */
    public function showmymemes()
    {
        $memes = Meme::where('user_id', Auth::user()->getAuthIdentifier())->get();
        $title = "Showing " . Auth::user()->name . "'s memes.";

        $isAdmin = false;
        if (!is_null(Auth::user()))
            User::where('id', Auth::user()->getAuthIdentifier())->where('role', 'admin')->first() === null ? $isAdmin = false : $isAdmin = true;

        return view ('memes.index', ['memes' => $memes, 'title' => $title, 'isAdmin' => $isAdmin]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Meme  $meme
     * @return \Illuminate\Http\Response
     */
    public function edit(Meme $meme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Meme  $meme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meme $meme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Meme  $meme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meme $meme)
    {
        User::where('id', Auth::user()->getAuthIdentifier())->where('role', 'admin')->first() ?? abort(403);

        $path = realpath('images/' . $meme->image_path);
        file_exists($path) ? [unlink($path), $meme->delete()] : $meme->delete();

        return json_encode(['meme_id'=>$meme->id, 'message'=>"Meme has been deleted"]);
    }

    public function sumemes($id)
    {
      $user = User::find($id) ?? abort(404);
      $memes = Meme::where('user_id', $id)->get();
      $title = "Showing " . $user->name . "'s memes.";

      $isAdmin = false;
      if (!is_null(Auth::user()))
        User::where('id', Auth::user()->getAuthIdentifier())->where('role', 'admin')->first() === null ? $isAdmin = false : $isAdmin = true;

      return view ('memes.index', ['memes' => $memes, 'title' => $title, 'isAdmin' => $isAdmin]);
    }
}
