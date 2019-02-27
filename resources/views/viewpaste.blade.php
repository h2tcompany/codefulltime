<html lang="en">


<title>{{$paste->title}}</title>
<meta charset="utf-8"/>
@include('editor')
@php
    $acc = Session::get('acc');
@endphp

<!--folding-->


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style>
    .CodeMirror {
        border: 1px solid black;
        font-size: 13px
    }

    .cm-header {
        font-family: arial;
    }

    .cm-header-1 {
        font-size: 150%;
    }

    .cm-header-2 {
        font-size: 130%;
    }

    .cm-header-3 {
        font-size: 120%;
    }

    .cm-header-4 {
        font-size: 110%;
    }

    .cm-header-5 {
        font-size: 100%;
    }

    .cm-header-6 {
        font-size: 90%;
    }

    .cm-strong {
        font-size: 140%;
    }
</style>
<script>
    $(document).ready(function () {
        var lang = '{{$paste->language}}';
        // for (var a of $('#language')[0].options) {
        //     if(a.value === lang){
        //         a.style.selected = true;
        //     }
        // }
        $('#language option[value="'+lang+'"]').attr('selected','selected');
    });
</script>
<body>

<div class="container">

    @if($acc == null || ($acc != null && $acc->username != $paste->username))
        <h1>{{$paste->title}}</h1>
        <h3>{{$paste->description}}</h3>
        <textarea id="code" name="code">{{$paste->contentpaste}}</textarea>
    @endif
    @if($acc != null && $acc->username == $paste->username)
        <form action="/edit-paste" method="post">
            {{csrf_field()}}
            <input type="text" name="code" value="{{$paste->code}}" style="display: none">
            <h1>Add your title</h1>
            <input class="form-control" type="text" name="title" placeholder="" value="{{$paste->title}}"><br>
            <h3>Description</h3>
            <input class="form-control" type="text" name="description" placeholder=""
                   value="{{$paste->description}}"><br>
            <h3>Code</h3>
            <textarea id="code" name="contentpaste">{{$paste->contentpaste}}</textarea>
            <button class="btn btn-default">Save</button>

    @endif
    <p>Select your language:
        <select onchange="selectLanguage()" name="language" id="language">
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
            <option value="text/x-markdown">Markdown</option>
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
    <p>Select a theme: <select onchange="selectTheme()" id=select>

            <option selected>default</option>
            <option>dracula</option>
            <option>isotope</option>
            <option>midnight</option>
            <option>paraiso-dark</option>
            <option>the-matrix</option>
            <option>xq-dark</option>
        </select>
    </p>
        </form>

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
        mode: {name: "text/x-java", globalVars: true},
        lineWrapping: true,
        foldGutter: true,
        gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"]
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
</body>
</html>