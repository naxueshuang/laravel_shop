<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJyShippingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jy_shipping', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shipping_name',20)->default('')->comment('配送方式名称');
            $table->string('shipping_desc',50)->default('')->comment('配送方式描述');
            $table->smallInteger('fee')->default(0)->comment('费用');
            $table->enum('status',[1,2,3])->default('1')->comment('1可用 2不可用');
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
        Schema::dropIfExists('jy_shipping');
    }
}
