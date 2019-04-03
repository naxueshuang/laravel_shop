<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleContent extends Model
{
    //
    protected $table = "jy_article_content";

    public $timestamps = false;

    public function doAdd($data)
    {
    	return self::insert($data);
    }
    //获取内容详情
    public function getInfo($id)
    {
    	return self::where('id',$id)->first();
    }
    //修改操作
    public function doEdit($data,$id)
    {
    	return self::where('a_id',$id)->update($data);
    }
//删除
    public function delData($aid)
    {
    	return self::where('a_id',$aid)->delete();
    }
}
