<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //
    const
    	USE_ABLE = 1,//可用
    	USE_DISABLE = 2,//不可用
    	ENS = true;
	protected $table = 'jy_brand';

	public $timestamps = false;

    //获取品牌列表数据
    public static function getList($where=[])
	{
		return self::where($where)->get()->toArray();
	}

	//获取品牌详情
	public static function getInfo($id)
	{
		return self::where('id',$id)->first();
	} 

	//添加商品品牌
	public static function create($data)
	{
		return self::insert($data);
	}

	//执行商品品牌修改
	public static function doUpdate($data,$id)
	{
		return self::where('id',$id)->update($data);
	}

	//删除商品品牌
	public static function del($id)
	{
		return self::where('id',$id)->delete();
	}



	
}
