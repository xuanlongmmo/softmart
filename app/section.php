<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class section extends Model
{
    protected $table = 'section';
    public $timestamps = false;
    public function section_content()
    {
        return $this->hasMany('App\section_content', 'id_section', 'id');
    }
}
