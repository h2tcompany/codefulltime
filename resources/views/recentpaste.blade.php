@php
    $listRecent = \App\Paste::orderby('code','desc')->take(10)->get();
@endphp

<div class="panel panel-default">
    <div class="panel-heading">Activity</div>
    <div class="panel-body">
        <p><a href="/paste/new-paste">Create new paste</a></p>
        <p><a href="/paste/all">All paste</a></p>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">Recent Pastes</div>
    <div class="panel-body">
        @foreach($listRecent as $paste)
            <p><a href="/{{$paste->code}}">{{$paste->title}}</a></p>
        @endforeach
    </div>
</div>