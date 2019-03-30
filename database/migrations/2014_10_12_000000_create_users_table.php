<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->default('')->comment('联系人名称');
            $table->string('company_name')->default('')->comment('单位名称');
            $table->string('mobile')->unique()->comment('联系人手机号');
            $table->string('company_tel')->default('')->comment('单位电话');
            $table->string('company_addr')->default('')->comment('单位地址');
            $table->enum('auth',[0,1])->default(0)->comment('是否认证');
            $table->string('email')->default('')->comment('供应商邮箱');
            $table->string('password')->default('')->comment('登录密码');
            $table->rememberToken()->default('')->comment('是否记住密码');
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
        Schema::dropIfExists('users');
    }
}
