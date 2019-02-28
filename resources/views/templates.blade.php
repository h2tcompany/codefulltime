<!DOCTYPE html>
<html lang="vi_VN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{$title}}</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    @include('editor')
</head>
<body>

@php
    $acc = Session::get('account');
@endphp
<div class="container">
    <nav class="navbar navbar-inverse">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="/" class="navbar-brand">Codefulltime</a>
        </div>
        <!-- Collection of nav links, forms, and other content for toggling -->
        <div id="navbarCollapse" class="collapse navbar-collapse">


            <ul class="nav navbar-nav">
                <li class="active" id="lienhe"><a href="#"><span class="glyphicon glyphicon-stats"></span> Paste</a></li>
            </ul>

            <div class="navbar-form navbar-left">
                <div class="form-group">
                    <input list="browsers" type="text" autocomplete="off" id="key" class="form-control"
                           value=""
                           placeholder="Anything in website">
                    <datalist id="browsers">
                            <option value="GGG">GGG</option>
                    </datalist>
                </div>
                <button type="submit" id="btnSearch" class="btn btn-default">Search</button>
            </div>

        </div>
    </nav>

    @yield('content')

</div>
</body>
</html>
