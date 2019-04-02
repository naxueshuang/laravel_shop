<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJySystemConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jy_system_config', function (Blueprint $table) {
            $table->increments('id');
            $table->string('syatem_name',20)->default('')->comment('配置描述');
            $table->string('s_key',20)->default('')->comment('配置的key');
            $table->string('s_value',120)->default('')->comment('配置的value');
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
        Schema::dropIfExists('jy_system_config');
    }
}
