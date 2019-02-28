<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paste extends Model
{

    protected $table = 'paste';
    protected $primaryKey = 'code';
    public $incrementing = false;
    public $timestamps = false;


    public function getAccount(){
        return $this->belongsTo('App\\Paste','username');
    }

    public function listComment()
    {
        return $this->hasMany('App\\Comment', 'code')->orderBy('id','desc');
    }
}
