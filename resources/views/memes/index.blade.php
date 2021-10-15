@extends('layouts.app')

@section('content')

    @foreach($memes as $meme)
    <div class="d-flex justify-content-center">
        <div class="card">
            <div class="card-header h3">{{ $meme->title }}</div>
            <img class="card-img-top img-fluid" src="{{ asset('images/' . $meme->image_path) }}" />
            <div class="card-footer">
                <span class="text-success font-weight-bolder">{{ $meme->up_votes_count }}</span> <a href="upvote/{{$meme->id}}" class="btn btn-success"><i class="fas fa-arrow-up"></i></a>
                <a href="downvote/{{$meme->id}}" class="btn btn-danger"><i class="fas fa-arrow-down"></i></a>  <span class="text-danger font-weight-bolder">{{ $meme->down_votes_count }}</span>
                <span class="m-lg-5"><a href="comments/{{ $meme->id }}">14 Comments</a></span>
                <span class="float-right">Uploaded by <b>{{ $meme->user->name }}</b> at <b>{{ $meme->created_at }}</b></span>
            </div>
        </div>
    </div>
    @endforeach
@endsection
