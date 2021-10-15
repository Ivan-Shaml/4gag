@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center">
    <form action="/" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="form-group">
            <label for="title" class="col-sm-2 col-form-label">Title</label>
            <div class="col-sm-15">
                <input type="text" class="form-control" id="title" name="title" placeholder="Hot Title...">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-15">
                <label for="image">Drop your meme here <i>(Supported image formats are: <code>jpg,png,jpeg,gif</code>)</i></label>
                <input type="file" class="form-control-file" id="image" name="image" accept="image/png, image/jpeg, image/gif">
            </div>
        </div>

        <button type="submit" class="btn btn-success m-3"><i class="fas fa-plus"></i> Add</button>
    </form>
</div>

    @if (count($errors) > 0)
        <div class="d-flex justify-content-center">
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-danger list-unstyled">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection
