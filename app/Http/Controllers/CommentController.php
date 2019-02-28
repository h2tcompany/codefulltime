<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CommentController extends Controller
{
    public function add(Request $request)
    {
        $acc = Session::get('acc');
        $id = round(microtime(true) * 1000);
        $code = $request->code;
        $username = $acc->username;
        $comment = $request->comment;

        $c = new Comment();
        $c->id = $id;
        $c->code = $code;
        $c->username = $username;
        $c->comment = $comment;

        $c->save();
        return response()->json([
            'status' => 'ok'
        ]);

    }
}
