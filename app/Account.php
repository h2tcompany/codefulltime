<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'account';
    protected $primaryKey = 'username';
    public $incrementing = false;
    public $timestamps = false;

    public function listPaste()
    {
        return $this->hasMany('App\\Paste', 'username');
    }

}
