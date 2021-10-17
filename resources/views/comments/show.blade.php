@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/comment_section.css')}}">
    <div class="mt-5 d-flex justify-content-center container alert alert-success w-50 text-center position-sticky" role="alert" id="alert_box1" style="display: none !important;">
        Your comment has been posted successfully.
    </div>
    <div class="d-flex justify-content-center" id="meme_id_{{$meme->id}}">
        <div class="card">
            <div class="card-header h3">{{ $meme->title }}</div>
            <img class="card-img-top img-fluid" name="meme" id="{{ $meme->id }}" src="{{ asset('images/' . $meme->image_path) }}" />
            <div class="card-footer">
                <span class="text-success font-weight-bolder" id="up_votes_count{{$meme->id}}">{{ $meme->up_votes_count }}</span> <button onclick="upvote({{ $meme->id }})" class="btn btn-success"><i class="fas fa-arrow-up"></i></button>
                <button onclick="downvote({{ $meme->id }})" class="btn btn-danger"><i class="fas fa-arrow-down"></i></button>  <span class="text-danger font-weight-bolder" id="down_votes_count{{$meme->id}}">{{ $meme->down_votes_count }}</span>
                @if($isAdmin)
                    <button class="btn btn-danger float-right ml-3" onclick="deletePopup({{ $meme->id }}, 'Meme')"> <i class="fas fa-trash-alt"></i> </button>
                @endif
                <span class="float-right">Uploaded by <a href="/sumemes/{{$meme->user->id}}"> <b>{{ $meme->user->name }}</b></a> at <b>{{ $meme->created_at }}</b></span>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="mt-5 alert alert-success w-50 text-center" role="alert" id="alert_box" style="display: none !important;">
                Your comment has been posted successfully.
            </div>
           <div class="col-md-8">
                <div class="media g-mb-30 media-comment">
                    <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                        <div class="g-mb-15">
                            <h5 class="h5 g-color-gray-dark-v1 mb-3">Write a comment</h5>
                        </div>
                        @csrf
                        <textarea class="form-control shadow-none textarea" name="comment_text" id="comment_box" rows="5" style="resize: none;"></textarea>
                        <div class="mt-3 text-right">
                            <button class="btn btn-primary btn-sm shadow-none" type="button" onclick="postComment()"><i class="fas fa-comment"></i>  Comment</button>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>

    <h3 class="text-center mt-5 mb-2" id="comments_total_count">{{count($comments)}} Comments</h3>

    <div class="container">
        <div class="row d-flex justify-content-center" id="comment_section">
            @foreach($comments as $comment)
           <div class="col-md-8" id="comment_id_{{$comment->id}}">
                <div class="media g-mb-30 media-comment">
                    <div class="media-body u-shadow-v18 g-bg-secondary g-pa-30">
                        <div class="g-mb-15">
                            @if($isAdmin)
                                <button onclick="deletePopup({{$comment->id}}, 'Comment')" class="btn btn-danger float-right"> <i class="fas fa-trash-alt"></i> </button>
                            @endif
                            <h5 class="h5 g-color-gray-dark-v1 mb-3">Posted by {{ $comment->user->name }}</h5>
                            <span class="g-color-gray-dark-v4 g-font-size-12">Posted on {{ $comment->updated_at }}</span>
                        </div>

                        <p class="mt-5">{{ $comment->comment_text }}</p>

                        <ul class="list-inline d-sm-flex my-0">
                            <li class="list-inline-item g-mr-20">
                                <span id="comment_up_votes_count{{$comment->id}}" class="text-success font-weight-bolder">{{ $comment->up_votes_count }}</span>
                                <button class="btn btn-sm btn-success" onclick="commentUpvote({{$comment->id}})">
                                    <i class="fa fa-arrow-up g-pos-rel g-top-1 g-mr-3"></i>
                                </button>
                            </li>
                            <li class="list-inline-item g-mr-20">
                                <button class="btn btn-sm btn-danger" onclick="commentDownvote({{$comment->id}})">
                                    <i class="fa fa-arrow-down g-pos-rel g-top-1 g-mr-3"></i>
                                </button>
                                <span id="comment_down_votes_count{{$comment->id}}" class="text-danger font-weight-bolder">{{ $comment->down_votes_count }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>


@endsection
