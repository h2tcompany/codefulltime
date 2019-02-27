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
        return view('listpaste', ['pastes' => $listPaste]);
    }

    public function GetPaste(Request $request)
    {
        $code = $request->code;
        $paste = Paste::where('code', $code)->first();
        $acc = Account::where('username', 'unknow')->first();
        Session::put('acc', $acc);
        return view('viewpaste', ['paste' => $paste]);
    }

    public function CreatePastePage()
    {
        return view('createpaste');
    }

    public function EditPaste(Request $request)
    {
        $code = $request->code;
        $contentpaste = $request->contentpaste;
        $description = $request->description;
        $title = $request->title;
        $language = $request->language;
        Paste::where('code', $code)->update([
            'contentpaste' => $contentpaste,
            'description' => $description,
            'title' => $title,
            'language' => $language
        ]);
        return redirect('/paste/' . $code);
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
        $paste->save();
        return redirect('/paste/' . $code);
    }

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