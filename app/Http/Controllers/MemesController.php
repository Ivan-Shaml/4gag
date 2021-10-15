<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use Illuminate\Http\Request;

class MemesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $memes = Meme::all();
        return view('memes.index', ['memes' => $memes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upvote($id)
    {
        //
    }

    public function downvote($id)
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Meme  $meme
     * @return \Illuminate\Http\Response
     */
    public function show(Meme $meme)
    {
        //
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
        //
    }
}
