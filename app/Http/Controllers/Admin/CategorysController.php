<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category as category;
use App\Http\Requests\admin\CategoryRequest;

class CategorysController extends Controller
{
    //
    private  $field  =  ["_token" , "_method"];
    public function __construct()
    {
    }
    /**
     * 分类列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $categorys  = category::getTreeCategory();
        return view('admin.category.index',compact('categorys'));
    }

    /**
     * 添加分类页面
     * @return mixed
     */
    public function create()
    {
        $treer  = category::getTreeCategory();
        return view('admin.category.create',compact('treer'));
    }
    /**
     * 添加分类
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CategoryRequest $request){
        $data = $request->all();
        unset($data['_token']);
        $data['created_at'] = date('Y-m-d H:i:s',time());
        $data['updated_at'] = date('Y-m-d H:i:s',time());
        if(category::insert($data)){
            flash('分类添加生成')->success()->important();
            return redirect()->route('categorys.index');
        }else{
            flash('分类添加失败')->error()->important();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $treer  = category::getTreeCategory();
        $catagory  = category::find($id);
        return view('admin.category.edit',compact('catagory','treer'));
    }

    /**
     * @param CategoryRequest $request
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function update(CategoryRequest $request,$id){
        $category = category::find($id);
        $map = $request->except(['parent_id','path','code','updated_at']);
        if (empty($map)) {
            return  flash('无数据更新')->error()->important();
        }
        foreach ($map as $k => $v) {
            if(in_array($k,$this->field)){
                unset($map[$k]);
                continue;
            }
            $category->$k = $v;
        }
       if($category->save()){
           flash('分类更新成功')->success()->important();
           return redirect()->route('categorys.index');
       }else{
           return  flash('分类更新失败')->error()->important();
       }
    }

    /**
     * 删除分类及子类
     * @param $id
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function destroy($id){
        try{
           $delete = \DB::table('categorys')->where('id',$id)->orWhere('parent_id',$id)->delete();
           if($delete){
               flash('分类删除成功')->success()->important();
               return redirect()->route('categorys.index');
           }else{
               return  flash('分类删除失败')->error()->important();
           }
        }catch (\Exception $e){
            return  flash($e->getMessage())->error()->important();
        }
    }
}
