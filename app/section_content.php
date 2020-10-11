<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class section_content extends Model
{
    protected $table = 'section_content';
    public $timestamps = false;
    public function product(){
        return $this->hasOne('App\product','id','id_product');
    }
}
