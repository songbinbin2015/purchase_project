<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //  echo route('purchases.index');exit;
        return view('admin.indexs.index');
    }

    public function main()
    {
        return view('admin.indexs.main');
    }
}
