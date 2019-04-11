<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\purchases;
use App\Models\category;
use App\Http\Requests\Admin\PurchasesRequest;
use App\Handlers\ImageUploadHandler;
use Excel;

class PurchasesController extends Controller
{
    //
    private  $field  =  ["_token" , "_method"];
    private $msg=['产品下架成功','产品上架成功','产品修改为其他'];

    private $purImport = [
        "产品名称" => "name",
        "产品尺寸" => "size",
        "产品厚度" => "thickness",
        "产品材质" => "texture",
        "产品类别" => "category",
        "产品状态" => "status",
    ];


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        $purchases = purchases::select('id','category','name','size','thickness','texture','image','status')->orderBy('id','desc')->with('category')->paginate(30);
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
        $datas['image'] = $this->getImg($request->image);
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

    /**
     * @param $status
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function status($status,$id){
        $purMdl = $this->getPurModel($id);
        if($purMdl->update(['status'=>$status])){
            flash( $this->msg[$status])->success()->important();
            return redirect()->route('purchases.index');
        }else{
            flash('产品状态修改失败')->error()->important();
        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id){
        if(purchases::destroy([$id])){
            flash()->success('产品刪除成功')->important();
            return redirect()->route('purchases.index');
        }else{
            flash('产品刪除失败')->error()->important();
        }
    }
    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id){
        $purchase = purchases::find($id);
        $categoryTree = category::getTreeCategory();
        return view('admin.purchase.edit',compact('purchase','categoryTree'));
    }

    /**
     * 产品编辑
     * @param PurchasesRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(purchasesrequest $request,$id){
        $datas = $request->all();
        $purchases = $this->getPurModel($id);
        //上传头像
        if(isset($request->image)){
            $datas['image'] = $this->getImg($request->image);
        }
        foreach ($datas as $k=>$val){
            if(in_array($k,$this->field)){
                unset($datas[$k]);
                continue;
            }
        }
        if($purchases->update($datas)){
            flash('产品编辑成功')->success()->important();
            return redirect()->route('purchases.index');
        }else{
            flash('产品编辑失败')->error()->important();
        }
    }

    /**
     * @param $path
     * @return string
     */
    private function getImg($path){
        $image = '';
        if ($path) {
            $uploader = new ImageUploadHandler;
            $result = $uploader->save($path, 'image');
            if ($result) {
               $image = $result['path'];
            }
        }
        return $image;
    }

    /**
     * @param $id
     * @return mixed
     */
    private function getPurModel($id){
        return purchases::find($id);
    }

    /**
     * 导入execl页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function import(){
        return view('admin.purchase.import');

    }

    /**
     * 上传导入execl
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function upload(Request $request){
        $file = $request->file('execl');
        if($file->isValid()){
            $ext=$file->getClientOriginalExtension();
            $OriginalName = $file->getClientOriginalName();
            $newFile=md5($OriginalName).".".$ext;
            $directory = 'storage/exports/'.date('Ymd',time()).'/';
            if(!is_dir($directory)){
                mkdir($directory);
            }
            $filename = $directory.$newFile;
            if(!file_exists($filename)){
                $file->move($directory,$newFile);
            }else{
                flash('excel已经上传过!')->error()->important();
            }
            $content =file_get_contents($filename);
            $fileType = mb_detect_encoding($content , array('UTF-8','GBK','LATIN1','BIG5'));//获取当前文本编码格式

            Excel::load($filename, function($reader) {
                $data = $reader->all()->toArray();
                $insert_date = [];
                $date_time = date('Y-m-d H:i:s',time());
             //   dd($data);
                foreach ($data as $key=>$value){
                    if(empty($value)){
                        continue;
                    }
                    foreach ($value as $k=>$v){
                        foreach ($v as $v_k=>$v_v){
                            if(isset($this->purImport[$v_k])){
                              if($this->purImport[$v_k] == 'status'){
                                  switch ($v_v){
                                      case '上架':
                                          $v_v = '1';
                                          break;
                                      case '下架':
                                          $v_v = '0';
                                          break;
                                      case '其他':
                                          $v_v = '2';
                                          break;
                                      default:
                                          $v_v = '1';
                                  }
                              }
                              $insert_date[$this->purImport[$v_k]] = $v_v;
                            }else{
                                continue;
                            }
                        }
                        $insert_date['details'] = '';
                        $insert_date['created_at'] = $date_time;
                        $insert_date['updated_at'] = $date_time;
                        \DB::table('purchases')->insert($insert_date);
                    }
                }
            },$fileType);
            flash('excel上传成功')->success()->important();
            return redirect()->route('purchases.index');
        }else{
            flash('上传失败')->error()->important();
        }
    }

    public function show(){
        $new_array = [
          [
              'id'=>788,
              'name'=>'test2',
              'po'=>'51 ',
              'uplise'=>'ss1',
              'time'=>'ssd'
          ],
            [
                'id'=>788,
                'name'=>'test3',
                'po'=>'52 ',
                'uplise'=>'ss2   ',
                'time'=>'ssd'
            ],
            [
                'id'=>788,
                'name'=>'test4',
                'po'=>'53     ',
                'uplise'=>'ss3 ',
                'time'=>'ssd'
            ], [
                'id'=>788,
                'name'=>'test5',
                'po'=>'54 ',
                'uplise'=>'ss4   ',
                'time'=>'ssd'
            ]
        ];
        foreach($new_array as $key=>$val){
            $new_array[$key]['po'] = trim($val['po']);
            $new_array[$key]['uplise'] = trim($val['uplise']);
            if(trim($val['po'] == '') && trim($val['uplise'] == '')){
                unset($new_array[$key]);
            }
        }
        dd($new_array);
    }
}
