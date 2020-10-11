<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class category_policy extends Model
{
    protected $table = 'category_policy';
    public $timestamps = false;

    public function policy(){
        return $this->hasMany('App\policy','id_category','id');
    }
}
