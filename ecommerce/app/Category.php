<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    public function parent()
    {
        return $this->belongsTo(Categories::class, 'parent_id');
    }



    public function children()
    {
        return $this->hasMany(Categories::class, 'parent_id');

    }
}
