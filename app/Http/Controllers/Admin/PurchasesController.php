<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\purchases;
use App\Models\category;
use App\Http\Requests\Admin\PurchasesRequest;
use App\Handlers\ImageUploadHandler;

class PurchasesController extends Controller
{
    //
    private  $field  =  ["_token" , "_method"];
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $purchases = purchases::select('id','category','name','size','thickness','texture','image','status')->orderBy('id','desc')->with('category')->paginate(2);
        $purchases_array = $purchases->toArray();
        return view('admin.purchase.index',compact('purchases','purchases_array'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){
        $categoryTree = category::getTreeCategory();
        return view('admin.purchase.create',compact('categoryTree'));
    }

    /**
     * 商品保存
     * @param PurchasesRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(purchasesrequest $request){
        $datas = $request->all();
        //上传头像
        if ($request->image) {
            $uploader = new ImageUploadHandler;
            $result = $uploader->save($request->image, 'image');
            if ($result) {
                $datas['image'] = $result['path'];
            }
        }
        $purchasers  = new purchases();
        foreach ($datas as $k=>$val){
            if(in_array($k,$this->field)){
                continue;
            }
            if($k == 'details'){
                $val = htmlspecialchars($val);
            }
            $purchasers->$k = $val;
        }
        if($purchasers->save()){
            flash('产品添加成功')->success()->important();
            return redirect()->route('purchases.index');
        }else{
            flash('产品添加失败')->error()->important();
        }
    }

    public function status($status,$id){

    }
    public function delete($id){

    }
    public function edit($id){
        $purchase = purchases::find($id);
      // dd(htmlspecialchars_decode($purchase->details));
        $categoryTree = category::getTreeCategory();
        return view('admin.purchase.edit',compact('purchase','categoryTree'));
    }
}
