<?php

namespace App\Http\Controllers;

use App\KeyWords;
use App\Paste;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PasteController extends Controller
{

    public function Pastes()
    {
        $listPaste = Paste::paginate(30);
        return view('paste', ['pastes' => $listPaste, 'title' => 'List paste']);
    }

    public function Search(Request $request)
    {
        $key = $request->key;
        $listPaste = Paste::where('title', 'like', '%' . $key . '%')->orWhere('slug', 'like', '%' . $key . '%')->paginate(20);

        $kOld = KeyWords::where('keyword', $key)->first();
        if ($kOld == null) {
            $k = new KeyWords();
            $k->keyword = $key;
            $k->solan = 1;
            $k->save();
        } else {
            //cap nhat
            $soLanCu = $kOld->solan;
            KeyWords::where('keyword', $key)->update(['solan' => $soLanCu + 1]);
        }

        return view('paste', ['pastes' => $listPaste, 'title' => 'Result for search with key: '.$key]);
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

        $ipInfo = file_get_contents('http://ip-api.com/json/' . get_client_ip());
        $ipInfo = json_decode($ipInfo);
        $timezone = $ipInfo->timezone;
        date_default_timezone_set($timezone);
        $time = date('h:i:s d-m-Y');
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

function addView($paste)
{
    $oldview = $paste->views;
    Paste::where('code', $paste->code)->update([
        'views' => $oldview + 1
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
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = '1.55.199.209';
    return $ipaddress;
}