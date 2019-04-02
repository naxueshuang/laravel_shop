<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJyGoodsAttrTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jy_goods_attr', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cat_id')->default(0)->comment('分类id');
            $table->string('attr_name',20)->default('')->comment('商品属性名称');
            $table->enum('input_type',[1,2])->default('1')->comment('1、手动输入  2、单选');
            $table->string('attr_value',50)->default('')->comment('属性的值');
            $table->enum('status',[1,2])->default('1')->comment('状态 1可用 2不可用');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jy_goods_attr');
    }
}
