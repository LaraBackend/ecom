<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class Customer extends Model
{
    protected $guarded = ['_token'];

    protected $primaryKey = 'customers_id';

	
 public function parent()
 {
  return $this->belongsTo(Customer::class, 'parent_id');
}



public function children()
{
  return $this->hasMany(Customer::class, 'parent_id');
  
}
	
	

}
