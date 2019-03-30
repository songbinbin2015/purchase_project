<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    //
    protected $table='purchases';

    public $timestamps = true;

    public function category(){
       return $this->hasOne('App\Models\Category','id','category');
    }
}
