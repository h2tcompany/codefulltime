<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KeyWords extends Model
{
    protected $table = 'KeyWords';
    protected $primaryKey = 'KeyWord';
    public $incrementing = false;
    public $timestamps = false;
}
