<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = 'product';
    public function review()
    {
        return $this->hasMany('App\review_product', 'id_product', 'id');
    }
    public function category_product(){
        return $this->belongsTo('App\category_product', 'id_category', 'id');
    }
}
