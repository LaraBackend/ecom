<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class ProductsPaymentCommssion extends Model
{
    protected $guarded = ['_token'];
    protected $table = 'commission_payment';

    public function user() {

        return $this->belongsTo('App\Customer' , 'user_id');

    }


    public function from_user() {

        return $this->belongsTo('App\Customer' , 'from_user_id');

    }

}
