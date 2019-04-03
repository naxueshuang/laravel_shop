<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\AdPosition;

class AdPositionController extends Controller
{
    //广告位列表
    public function list()
    {
    	$position = new AdPosition();

    	$assign['position'] = $position->getList();

    	// dd($assign);

    	return view('admin.position.list',$assign);
    }

    //添加页面
    public function add()
    {
    	return view('admin.position.add');
    }

    //保存星系
    public function store(Request $request)
    {
    	$params = $request->all();

    	$params = $this->delToken($params);

    	$position = new AdPosition();

    	$res = $this->storeData($position,$params);

    	if(!$res){

    		return redirect()->back()->with('msg','广告位添加失败');
    	}

    	return redirect('/admin/position/list');


    }

    public function edit($id)
    {
    	// $params = $request->all();

    	$position = new AdPosition();

    	$assign['info'] = $this->getDataInfo($position,$id);

    	return view('admin.position.edit',$assign);
    }

    public function doEdit(Request $request)
    {
    	$params = $request->all();

    	$params = $this->delToken($params);

    	$position = AdPosition::find($params['id']);

    	$res = $this->storeData($position,$params);

    	if(!$res){
    		return redirect()->back()->with('msg','广告位修改失败');
    	}

    	return redirect('/admin/position/list');
    }

    public function del($id)
    {
    	$position = new AdPosition();

    	$this->delData($position,$id);

    	return redirect('/admin/position/list');
    }
}
