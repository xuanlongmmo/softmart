<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class review_product extends Model
{
    protected $table = 'review_product';
    
    public function users(){
        return $this->hasOne('App\User','id','id_user');
    }

    public function product(){
        return $this->hasOne('App\product','id','id_product');
    }
}
