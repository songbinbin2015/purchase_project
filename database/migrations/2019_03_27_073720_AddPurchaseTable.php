<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPurchaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category')->default(0)->comment('产品类别');
            $table->string('name',255)->default('')->comment('产品名称');
            $table->string('size',100)->default('')->comment('产品尺寸');
            $table->string('thickness',20)->default('')->comment('产品厚度');
            $table->string('texture',100)->default('')->comment('产品材质');
            $table->string('image',255)->default('')->comment('产品图片');
            $table->text('details')->comment('产品详情');
            $table->enum('status',[0,1,2])->default(1)->comment('产品状态 0下架,1上架,2其他');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('purchases');
    }
}
