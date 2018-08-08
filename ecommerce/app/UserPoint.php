<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class UserPoint extends Model
{
    protected $guarded = ['_token'];


    public function user() {

        return $this->belongsTo('App\User');

    }


}
