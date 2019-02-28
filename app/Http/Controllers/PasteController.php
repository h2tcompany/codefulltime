<?php

namespace App\Http\Controllers;

use App\Account;
use App\Paste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PasteController extends Controller
{

    public function Pastes()
    {
        $listPaste = Paste::paginate(30);
        return view('listpaste', ['pastes' => $listPaste, 'title' => 'List paste']);
    }

    public function GetPaste(Request $request)
    {
        $code = $request->code;
        $paste = Paste::where('code', $code)->first();
        addView($paste);
        return view('viewpaste', ['paste' => $paste, 'title' => $paste->title]);
    }

    public function GetPasteA(Request $request)
    {
        $code = $request->code;
        $paste = Paste::where('slug', $code)->first();
        addView($paste);
        return view('viewpaste', ['paste' => $paste, 'title' => $paste->title]);
    }

    public function CreatePastePage()
    {
        return view('createpaste', ['title' => 'Create new paste']);
    }

    public function EditPaste(Request $request)
    {
        $code = $request->code;
        $contentpaste = $request->contentpaste;
        $description = $request->description;
        $title = $request->title;
        $language = $request->language;
        $tag = $request->tag;
        $slug = $request->slug;
        Paste::where('code', $code)->update([
            'contentpaste' => $contentpaste,
            'description' => $description,
            'title' => $title,
            'language' => $language,
            'tag' => $tag,
            'slug' => $slug,
        ]);
        return redirect('/' . $code);
    }

    public function CreatePaste(Request $request)
    {
        $c = round(microtime(true) * 1000);
        $code = substr($c, 5, 4) . rand_string(20);
        $contentpaste = $request->contentpaste;
        $description = $request->description;
        $title = $request->title;
        $language = $request->language;
        $time = date('Y-m-d');
        $username = 'unknow';
        $tag = $request->tag;
        $slug = $request->slug;
        if (Session::get('acc') != null) {
            $username = Session::get('acc')->username;
        }
        $paste = new Paste();
        $paste->code = $code;
        $paste->contentpaste = $contentpaste;
        $paste->description = $description;
        $paste->title = $title;
        $paste->language = $language;
        $paste->time = $time;
        $paste->username = $username;
        $paste->tag = $tag;
        $paste->slug = $slug;
        $paste->views = 0;
        $paste->save();
        return redirect('/' . $code);
    }

}

function addView($paste){
    $oldview = $paste->views;
    Paste::where('code',$paste->code)->update([
       'views'=>$oldview+1
    ]);
}

function rand_string($length)
{
    $str = "";
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $size = strlen($chars);
    for ($i = 0; $i < $length; $i++) {
        $str .= $chars[rand(0, $size - 1)];
    }
    $str = substr(str_shuffle($chars), 0, $length);
    return $str;
}