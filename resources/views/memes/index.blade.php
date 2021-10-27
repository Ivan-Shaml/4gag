@extends('layouts.app')

@section('content')
@if(!empty($title))
    <h3 class="h3 text-center">{{$title}}</h3>
@endif

<div class="mt-5 d-flex justify-content-center container alert alert-success w-50 text-center position-sticky" role="alert" id="alert_box1" style="display: none !important;">
    Your comment has been posted successfully.
</div>

   <div id="memes_container">
        @include('memes.post')
   </div>

<div class="ajax-load text-center" style="display: none">
    <img src="{{asset('pics/loading.gif')}}"/>
</div>

<script src="{{asset('js/infinite_scroll.js')}}"></script>

@endsection
