@extends('layouts.app')

@section('content')

    @foreach($memes as $meme)
    <div class="mt-5 mb-5 d-flex justify-content-center container">
        <div class="row">
            <div class="col-lg-10 d-flex align-items-stretch">
        <div class="card">
            <div class="card-header h3">{{ $meme->title }}</div>
            <img class="card-img-top" src="{{ asset('images/' . $meme->image_path) }}" />
            <div class="card-footer">
                <span class="text-success font-weight-bolder" id="up_votes_count{{$meme->id}}">{{ $meme->up_votes_count }}</span> <button onclick="upvote({{$meme->id}})" class="btn btn-success"><i class="fas fa-arrow-up"></i></button>
                <button onclick="downvote({{$meme->id}})" class="btn btn-danger"><i class="fas fa-arrow-down"></i></button>  <span class="text-danger font-weight-bolder" id="down_votes_count{{$meme->id}}">{{ $meme->down_votes_count }}</span>
                <span class="m-lg-5"><a href="comments/{{ $meme->id }}">14 Comments</a></span>
                <span class="float-right">Uploaded by <b>{{ $meme->user->name }}</b> at <b>{{ $meme->created_at }}</b></span>
            </div>
        </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection
