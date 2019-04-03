<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	protected $table = "jy_article";

    // public $timestamps = false;

    //获取文章添加数据
    // public function add()
    // {
    // 	return self::get()->toArray();
    // }
	//执行添加操作
    public function doAdd($data)
    {
    	return self::insertGetId($data);
    }

    public function getList()
    {
    	$list = self::select('jy_article.id','jy_article_category.cate_name','title','publish_at','clicks','status')
    		->leftJoin('jy_article_category','jy_article.cate_id','=','jy_article_category.id')
    		->paginate(2);

    	return $list;
    }

    //获取详细信息
    public function getInfo($id)
    {
    	return self::where('id',$id)->first();
    }

    public function doEdit($data,$id)
    {
    	return self::where('id',$id)->update($data);
    }

    public function delData($id)
    {
    	return self::where('id',$id)->delete();
    }
}
