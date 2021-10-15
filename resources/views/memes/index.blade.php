@extends('layouts.app')

@section('content')

    @foreach($memes as $meme)
    <div class="d-flex justify-content-center">
        <div class="card">
            <div class="card-header display-4">{{ $meme->title }}</div>
            <img class="card-img-top img-fluid" src="{{ asset($meme->image_path) }}" />
            <div class="card-body">
                <p>
                    It is a long established fact that a reader will be distracted by the readable content of a page
                    when looking at its layout. The point of using
                </p>
            </div>
            <div class="card-footer">
                <span class="text-success">{{ $meme->up_votes_count }}</span> <a href="" class="btn btn-success"><i class="fas fa-arrow-up"></i></a>
                <a href="" class="btn btn-danger"><i class="fas fa-arrow-down"></i></a>  <span class="text-danger">{{ $meme->down_votes_count }}</span>
                <span class="float-right">Uploaded by <b>username</b> at <b>{{ $meme->created_at }}</b></span>
            </div>
        </div>
    </div>
    @endforeach
@endsection
