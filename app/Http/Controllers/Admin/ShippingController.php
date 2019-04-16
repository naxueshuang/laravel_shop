<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Shipping;

class ShippingController extends Controller
{
    //配送列表页面
    public function list()
    {
    	$shipping = new Shipping();

    	$assign['shipping_list'] = $this->getDataList($shipping);

    	// dd($assign);

    	return view('admin.shipping.list',$assign);
    }

    //配送添加页面
    public function add()
    {
    	return view('admin.shipping.add');
    }

    //配送执行添加
    public function store(Request $request)
    {
    	$params = $request->all();

    	$params = $this->delToken($params);

    	// dd($params);

    	$shipping = new Shipping();

    	$res = $this->storeData($shipping,$params);

    	// dd($res);

    	if(!$res){

    		return redirect()->back()->with('msg','配送方式添加失败');
    	}

    	return redirect('/admin/shipping/list');
    }

    //删除
    public function del($id)
    {
    	$shipping = new Shipping();

    	$this->delData($shipping,$id);

    	return redirect('/admin/shipping/list');
    }
}
