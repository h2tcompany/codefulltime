@extends('templates')

@section('content')
    <style>
        .CodeMirror {
            border: 1px solid black;
            font-size: 13px
        }
        .cm-header { font-family: arial; }
        .cm-header-1 { font-size: 150%; }
        .cm-header-2 { font-size: 130%; }
        .cm-header-3 { font-size: 120%; }
        .cm-header-4 { font-size: 110%; }
        .cm-header-5 { font-size: 100%; }
        .cm-header-6 { font-size: 90%; }
        .cm-strong { font-size: 140%; }
    </style>


    <div class="col-sm-9">
        <form action="/paste/new-paste" method="post">
            {{csrf_field()}}
            <h1>Add your title</h1>
            <input class="form-control" type="text" name="title" placeholder=""><br>
            <h3>Description</h3>
            <input class="form-control" type="text" name="description" placeholder=""><br>
            <h3>Content</h3>
            <textarea id="code" name="contentpaste"></textarea><br>
            <button class="btn btn-primary">Save</button>

            <p>Select your language:
                <select class="form-control" onchange="selectLanguage()" name="language" id="language">
                    <option value="plain/text">Text</option>
                    <option value="text/apl">APL</option>
                    <option value="text/x-csrc">C</option>
                    <option value="text/x-c++src">C++</option>
                    <option value="text/x-java">Java</option>
                    <option value="text/x-csharp">C#</option>
                    <option value="text/x-clojure">Clojure</option>
                    <option value="text/x-coffeescript">CoffeeScript</option>
                    <option value="text/x-common-lisp">Common Lisp</option>
                    <option value="text/css">CSS</option>
                    <option value="text/x-scss">SCSS</option>
                    <option value="text/x-less">LESS</option>
                    <option value="text/x-python">Python</option>
                    <option value="text/x-cython">Cython</option>
                    <option value="text/x-d">D</option>
                    <option value="text/x-django">Django</option>
                    <option value="application/xml-dtd">DTD</option>
                    <option value="text/x-dylan">Dylan</option>
                    <option value="text/x-erlang">Erlang</option>
                    <option value="text/x-Fortran">Fortran</option>
                    <option value="text/x-ocaml">OCaml</option>
                    <option value="text/x-fsharp">F#</option>
                    <option value="text/x-feature">Gherkin</option>
                    <option value="text/x-go">Go</option>
                    <option value="text/x-groovy">Groovy</option>
                    <option value="text/x-haml">HAML</option>
                    <option value="text/x-haskell">Haskell</option>
                    <option value="application/x-aspx">ASP.NET</option>
                    <option value="application/x-ejs">Embedded Javascript (ejs)</option>
                    <option value="application/x-jsp">JavaServer Pages (jsp)</option>
                    <option value="text/html">HTML</option>
                    <option value="text/x-jade">Jade</option>
                    <option value="text/javascript">Javascript</option>
                    <option value="application/json">JSON</option>
                    <option value="text/typescript">Typescript</option>
                    <option value="application/typescript">Application typescript</option>
                    <option value="jinja2">Jinja2</option>
                    <option value="text/x-julia">Julia</option>
                    <option value="text/x-less">Less</option>
                    <option value="text/x-livescript">LiveScript</option>
                    <option value="text/x-lua">Lua</option>
                    <option value="markdown">Markdown</option>
                    <option value="text/nginx">NGINX</option>
                    <option value="text/x-octave">Octave</option>
                    <option value="text/x-pascal">Pascal</option>
                    <option value="pegjs">PEG.js</option>
                    <option value="text/x-perl">Perl</option>
                    <option value="application/x-httpd-php">PHP with html</option>
                    <option value="text/x-php">PHP</option>
                    <option value="text/x-pig">Pig Latin</option>
                    <option value="text/x-properties">Properties files</option>
                    <option value="text/x-puppet">Puppet</option>
                    <option value="text/x-rsrc">R</option>
                    <option value="text/x-rst">reStructuredText</option>
                    <option value="text/x-ruby">Ruby</option>
                    <option value="text/x-rustsrc">Rust</option>
                    <option value="text/x-sass">SASS</option>
                    <option value="text/x-scala">Scala</option>
                    <option value="text/x-scheme">Scheme</option>
                    <option value="text/x-scss">SCSS</option>
                    <option value="text/x-sh">Shell</option>
                    <option value="application/sieve">Sieve (RFC5228)</option>
                    <option value="text/x-mariadb">SQL</option>
                    <option value="text/x-stex">sTeX</option>
                    <option value="text/x-tcl">Tcl</option>
                    <option value="text/turtle">Turtle</option>
                    <option value="text/x-vb">VB.NET</option>
                    <option value="text/vbscript">VBScript</option>
                    <option value="text/velocity">Velocity</option>
                    <option value="application/xml">XML</option>
                    <option value="text/x-yaml">YAML</option>
                </select>
            </p>
            <p>Select a theme: <select class="form-control" onchange="selectTheme()" id=select>

                    <option selected>dracula</option>
                    <option>isotope</option>
                    <option>midnight</option>
                    <option>paraiso-dark</option>
                    <option>the-matrix</option>
                    <option>xq-dark</option>
                </select>
            </p>
            <h3>Tag</h3>
            <input type="text" class="form-control" name="tag">
            <h3>Slug</h3>
            <input class="form-control" type="text" name="slug"><br>
        </form>
    </div>
    <div class="col-sm-3">
        @include('recentpaste')
    </div>

    <script>
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
            mode: {name: "text/plain", globalVars: true},
            lineWrapping: true,
            foldGutter: true,
            gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
            theme:'dracula'
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