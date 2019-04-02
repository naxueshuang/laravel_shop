<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;

class CategoryController extends Controller
{
    //
    public function getCategory(){
    	$category = new Category();

    	$list = $category->getCategory();

    	$return = [
    		'code' => 2000,
    		'msg' => '获取分类的接口',
    		'data' => $list
    	];
    	return json_encode($return);
    }
}
