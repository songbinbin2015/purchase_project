<?php

use Illuminate\Database\Seeder;

class AddColumPurchase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
       if(!DB::table('rules')->where(['name'=>'采购列表','route'=>'purchases.index'])->count()){
            DB::table('rules')->insert(
                [
                    'name'=>'采购列表',
                    'route'=>'purchases.index',
                    'parent_id'=>'1',
                    'is_hidden'=>'0',
                    'sort'=>'255',
                    'status'=>'1',
                    'created_at'=>date('Y-m-d H:i:s',time()),
                    'updated_at'=>date('Y-m-d H:i:s',time()),
                ]
            );
        }
        if(!DB::table('rules')->where(['name'=>'产品分类','route'=>'categorys.index'])->count()){
            DB::table('rules')->insert(
                [
                    'name'=>'产品分类',
                    'route'=>'categorys.index',
                    'parent_id'=>'1',
                    'is_hidden'=>'0',
                    'sort'=>'255',
                    'status'=>'1',
                    'created_at'=>date('Y-m-d H:i:s',time()),
                    'updated_at'=>date('Y-m-d H:i:s',time()),
                ]
            );
        }

    }
}
