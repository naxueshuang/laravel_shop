<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    //
    protected $table = "jy_article_category";

    public $timestamps = false;

    //获取分类列表的数据
    public function getCategoryList()
    {
    	return self::get()->toArray();
    }

    //执行分类添加
    public function doAdd($data)
    {
    	return self::insertGetId($data);
    }

    //获取分类详情
    public function getInfo($id)
    {
    	return self::where('id',$id)->first();
    }

    //执行编辑分类的操作
    public function doUpdate($data,$id)
    {
    	return self::where('id',$id)->update($data);
    }

    //执行删除分类的操作
    public function del($id)
    {
    	return self::where('id',$id)->delete();
    }    
}
