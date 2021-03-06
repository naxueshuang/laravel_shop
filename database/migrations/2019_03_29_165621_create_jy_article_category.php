<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJyArticleCategory extends Migration
{
    /**
     * Run the migrations.
     * 文章分类表
     * @return void
     */
    public function up()
    {
        Schema::create('jy_article_category', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cate_name',30)->default('')->comment('文章分类名称');
            $table->string('cate_desc',150)->default('')->comment('分类描述');
            $table->integer('cate_order')->default(0)->comment('分类排序');
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
        Schema::dropIfExists('jy_article_category');
    }
}
