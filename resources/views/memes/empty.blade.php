@extends('layouts.app')

@section('content')
    @if(!empty($title))
        <h3 class="h3 text-center">{{$title}}</h3>
    @endif

<div class="mt-5 mb-5 d-flex justify-content-center container">
    <div class="row">
        <div class="col-lg-10 d-flex align-items-stretch">
            <div class="card">
                <div class="card-header h2 text-muted text-center">Seems empty...</div>
                <img class="card-img-top" src="{{asset('pics/empty.gif')}}" />
                <div class="card-footer">
                    You can upload memes from <a href="/home">Your profile</a>.
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
