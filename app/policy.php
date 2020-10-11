<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class policy extends Model
{
    protected $table = 'policy';

    public function category_policy(){
        return $this->belongsTo('App\category_policy', 'id_category', 'id');
    }
}
