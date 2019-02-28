@extends('templates')
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/showdown/1.9.0/showdown.min.js"></script>

    <script>
        $(document).ready(function () {
            var lang = '{{$paste->language}}';
            $('#language option[value="' + lang + '"]').attr('selected', 'selected');
            @if($paste->language == 'markdown')
                var converter = new showdown.Converter();
                let text = '{{$paste->contentpaste}}';
                $('#content').html(converter.makeHtml(text));
            @endif
        });
    </script>

    @php
        $acc = Session::get('acc');
    @endphp

    <div class="col-sm-9">

        @if($acc == null || ($acc != null && $acc->username != $paste->username))
            <h1><b>{{$paste->title}}</b></h1>
            <h3>Author: {{$paste->username}} | Time: {{$paste->time}} | views: {{$paste->views}}</h3>
            <h3>Description: {{$paste->description}}</h3>
            <hr>
            @if($paste->language == 'plain/text' || $paste->language == 'text/html')
                <h3><b>Content</b></h3>
                {!! $paste->contentpaste !!}
                <hr>

            @elseif($paste->language == 'markdown')
                <h3><b>Content</b></h3>
                <div id="content"></div>
                <hr>
            @else
                <textarea id="code" name="code">{{$paste->contentpaste}}</textarea>
            @endif
        @endif
        @if($acc != null && $acc->username == $paste->username)
            <form action="/paste/edit-paste" method="post">
                {{csrf_field()}}
                <input type="text" name="code" value="{{$paste->code}}" style="display: none">
                <h1>Add your title</h1>
                <input class="form-control" type="text" name="title" placeholder="" value="{{$paste->title}}"><br>
                <h3>Description</h3>
                <input class="form-control" type="text" name="description" placeholder=""
                       value="{{$paste->description}}"><br>
                <h3>Code</h3>
                <textarea id="code" name="contentpaste">{{$paste->contentpaste}}</textarea><br>
                <button class="btn btn-primary">Save</button>
        @endif
                <p><b>Select your language</b>:
                    <select class="form-control" onchange="selectLanguage()" name="language" id="language">
                        <option value="plain/text">Text</option>
                        <option value="text/apl">APL</option>
                        <option value="text/x-csrc">C</option>
                        <option value="text/x-c++src">C++</option>
                        <option value="text/x-java">Java</option>
                        <option value="text/x-csharp">C#</option>
                        <option value="text/x-clojure">Clojure</option>
                        <option value="text/x-common-lisp">Common Lisp</option>
                        <option value="text/css">CSS</option>
                        <option value="text/x-scss">SCSS</option>
                        <option value="text/x-less">LESS</option>
                        <option value="text/x-python">Python</option>
                        <option value="text/x-cython">Cython</option>
                        <option value="text/x-d">D</option>
                        <option value="text/x-django">Django</option>
                        <option value="application/xml-dtd">DTD</option>
                        <option value="text/x-erlang">Erlang</option>
                        <option value="text/x-Fortran">Fortran</option>
                        <option value="text/x-ocaml">OCaml</option>
                        <option value="text/x-fsharp">F#</option>
                        <option value="text/x-go">Go</option>
                        <option value="text/x-groovy">Groovy</option>
                        <option value="text/x-haskell">Haskell</option>
                        <option value="application/x-aspx">ASP.NET</option>
                        <option value="application/x-ejs">Embedded Javascript (ejs)</option>
                        <option value="application/x-jsp">JavaServer Pages (jsp)</option>
                        <option value="text/html">HTML</option>
                        <option value="text/x-jade">Jade</option>
                        <option value="text/javascript">Javascript</option>
                        <option value="text/typescript">Typescript</option>
                        <option value="jinja2">Jinja2</option>
                        <option value="text/x-less">Less</option>
                        <option value="text/x-livescript">LiveScript</option>
                        <option value="text/x-lua">Lua</option>
                        <option value="markdown">Markdown</option>
                        <option value="text/x-pascal">Pascal</option>
                        <option value="text/x-perl">Perl</option>
                        <option value="application/x-httpd-php">PHP with html</option>
                        <option value="text/x-php">PHP</option>
                        <option value="text/x-properties">Properties files</option>
                        <option value="text/x-rsrc">R</option>
                        <option value="text/x-rst">reStructuredText</option>
                        <option value="text/x-ruby">Ruby</option>
                        <option value="text/x-sass">SASS</option>
                        <option value="text/x-scala">Scala</option>
                        <option value="text/x-scheme">Scheme</option>
                        <option value="text/x-scss">SCSS</option>
                        <option value="text/x-sh">Shell</option>
                        <option value="text/x-mariadb">SQL</option>
                        <option value="text/x-stex">sTeX</option>
                        <option value="text/x-vb">VB.NET</option>
                        <option value="text/vbscript">VBScript</option>
                        <option value="application/xml">XML</option>
                        <option value="text/x-yaml">YAML</option>
                    </select>
                </p>

                @if($paste->language != 'plain/text' && $paste->language != 'text/html'&& $paste->language != 'markdown')
                <p><b>Select a theme</b>: <select class="form-control" onchange="selectTheme()" id="theme">
                        <option selected>dracula</option>
                        <option>isotope</option>
                        <option>midnight</option>
                        <option>paraiso-dark</option>
                        <option>the-matrix</option>
                        <option>xq-dark</option>
                    </select>
                </p>
                @endif

                <h3><b>Tag</b></h3>
                <input class="form-control" type="text" name="tag" id="tag" placeholder=""
                       value="{{$paste->tag}}">
                <h3><b>Slug</b></h3>
                <input class="form-control" type="text" name="slug" id="slug" placeholder=""
                       value="{{$paste->slug}}">
            </form>

            @if(Session::get('acc')==null)
                <h3><b>Required login to view and add comment</b></h3>
            @endif

            @if(Session::get('acc')!=null)
                <h3 ><b>Latest comment:</b></h3>
                    <br>
                <div style="margin-left: 5%">
                    <p id="down"></p>
                    @foreach($paste->listComment()->get() as $comment)
                        <p><b style="color: red">{{$comment->username}}</b>: {{$comment->comment}}</p>
                        <hr>
                    @endforeach

                    <div class="input-group">
                        <input style="display: none" type="text" value="{{$paste->code}}" id="codepaste">
                        <input aria-describedby="btnAnswerQuestion" type="text" id="my-question"
                               placeholder="Add your comment" class="form-control">
                        <span id="btnAnswerQuestion" style="background-color: green;color: white"
                              class="input-group-addon"><span class="glyphicon glyphicon-send"></span></span>
                        <p id="thongbao" style="color: red"></p>
                    </div>
                </div>
            @endif
    </div>
    <div class="col-sm-3">
        @include('recentpaste')
    </div>


    <script>
        @if($acc == null || ($acc!=null && $acc->username != $paste->username ))
            document.getElementById('slug').readOnly = 'readOnly';
            document.getElementById('tag').readOnly = 'readOnly';
            document.getElementById('language').disabled = true;
            document.getElementById('theme').disabled = true;
        @endif
        $(document).ready(function () {
            $('#btnAnswerQuestion').on('click', function () {
                $.ajax({
                    url: '/comment/add-new',
                    data: {
                        code: $('#codepaste').val(),
                        comment: $('#my-question').val()
                    },
                    success: function (data) {
                        if(data.status === 'ok'){
                            @if($acc!=null)
                            $('#down').append('<p><b style="color: red">{{$acc->username}}</b>: '+$('#my-question').val()+'</p>\n' +
                                '                        <hr>');
                            @endif
                        }
                    }
                });
            });
        });

        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
            lineNumbers: true,
            styleActiveLine: true,
            matchBrackets: true,
            extraKeys: {
                "F11": function (cm) {
                    cm.setOption("fullScreen", !cm.getOption("fullScreen"));
                },
                "Esc": function (cm) {
                    if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
                },
                "Ctrl-Space": "autocomplete",
                "Alt-F": "findPersistent",
                "Ctrl-Q": function (cm) {
                    cm.foldCode(cm.getCursor());
                }
            },
            scrollbarStyle: "simple",
            mode: {name: "{{$paste->language}}", globalVars: true},
            lineWrapping: true,
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
            theme: 'dracula'
        });
        var input = document.getElementById("select");

        function selectTheme() {
            var theme = input.options[input.selectedIndex].textContent;
            editor.setOption("theme", theme);
            location.hash = "#" + theme;

        }

        function selectLanguage() {
            var lang = document.getElementById('language').value;
            console.log(lang);
            editor.setOption('mode', {name: lang, globalVars: true});
        }

        @if($acc == null || ($acc!=null && $acc->username != $paste->username ))
            editor.setOption("readOnly", 'nocursor');
        @endif
        var choice = (location.hash && location.hash.slice(1)) ||
            (document.location.search &&
                decodeURIComponent(document.location.search.slice(1)));
        if (choice) {
            input.value = choice;
            editor.setOption("theme", choice);
        }
        CodeMirror.on(window, "hashchange", function () {
            var theme = location.hash.slice(1);
            if (theme) {
                input.value = theme;
                selectTheme();
            }
        });


    </script>
@endsection