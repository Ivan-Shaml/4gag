@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/comment_section.css')}}">
    <div class="d-flex justify-content-center">
        <div class="card">
            <div class="card-header h3">{{ $meme->title }}</div>
            <img class="card-img-top img-fluid" src="{{ asset('images/' . $meme->image_path) }}" />
            <div class="card-footer">
                <span class="text-success font-weight-bolder">{{ $meme->up_votes_count }}</span> <a href="/upvote/{{$meme->id}}" class="btn btn-success"><i class="fas fa-arrow-up"></i></a>
                <a href="/downvote/{{$meme->id}}" class="btn btn-danger"><i class="fas fa-arrow-down"></i></a>  <span class="text-danger font-weight-bolder">{{ $meme->down_votes_count }}</span>
                <span class="float-right">Uploaded by <b>{{ $meme->user->name }}</b> at <b>{{ $meme->created_at }}</b></span>
            </div>
        </div>
    </div>

    <h3 class="text-center mt-5 mb-2">3 Comments</h3>

    <div class="container">
        <div class="row d-flex justify-content-center">
            @foreach($comments as $comment)
           <div class="col-md-8">
                <div class="media g-mb-30 media-comment">
                    <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                        <div class="g-mb-15">
                            <h5 class="h5 g-color-gray-dark-v1 mb-3">Posted by: {{ $comment->user->name }}</h5>
                            <span class="g-color-gray-dark-v4 g-font-size-12">Posted on: {{ $comment->updated_at }}</span>
                        </div>

                        <p class="mt-5">{{ $comment->comment_text }}</p>

                        <ul class="list-inline d-sm-flex my-0">
                            <li class="list-inline-item g-mr-20">
                                <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!">
                                    <i class="fa fa-thumbs-up g-pos-rel g-top-1 g-mr-3"></i>
                                    {{ $comment->up_votes_count }}
                                </a>
                            </li>
                            <li class="list-inline-item g-mr-20">
                                <a class="u-link-v5 g-color-gray-dark-v4 g-color-primary--hover" href="#!">
                                    <i class="fa fa-thumbs-down g-pos-rel g-top-1 g-mr-3"></i>
                                    {{ $comment->down_votes_count }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


@endsection
