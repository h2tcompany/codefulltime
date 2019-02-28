@extends('templates')
@section('content')
    <div class="col-sm-9">
        @foreach($pastes as $paste)
            <h1><a href="/{{$paste->code}}">{{$paste->title}}</a></h1>
            <p>{{$paste->username}} | {{$paste->time}} | {{$paste->views}}</p>
            <hr>
        @endforeach
    </div>

@endsection