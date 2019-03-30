<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Handlers\Tree;

class Category extends Model
{
    //
    protected $table = 'categorys';

    public $timestamps = true;

    /**
     * @return array
     */
    public static function getTreeCategory(){
        $categorys = category::orderBy('id','asc')->get()->toArray();
        $treer = Tree::tree($categorys,'name','id','parent_id');
        return $treer;
    }
}
