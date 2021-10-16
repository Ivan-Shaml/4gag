@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <b class="h5">Dashboard</b>
                    <i class="float-right">Hello,<b> {{ Auth::user()->name }}</b></i>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                        <a href="/create" class="btn btn-success m-3"><i class="fas fa-file-upload"></i>  Upload New Meme</a>
                        <a href="/showmymemes" class="btn btn-primary m-3"><i class="fas fa-eye"></i>  View Your Memes</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
