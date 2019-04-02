<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Novel;

class NovelController extends Controller
{
    //
	//小说书单接口
    public function bookList(Request $request){
    	$novel = new Novel();
    	$list = $novel->getList()->toArray();
    	// dd($list);
    	$return = [
    		'code' => 2000,
    		'msg' => '获取书单成功',
    		'data' => [
    			'page' => $list['current_page'],//当前页
    			'total_page' => $list['last_page'],//总页数
    			'list' =>$list['data']
    		]
    	];
    	return json_encode($return);
    }
}
