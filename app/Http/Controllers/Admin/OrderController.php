<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderGoods;
use App\Model\Region;
use App\Model\Member;

class OrderController extends Controller
{
    //订单列表
    public function list()
    {	
    	$order = new Order();

    	$assign['order_list'] = $this->getPageList($order);

    	// dd($assign);

    	return view('admin.order.list',$assign);
    }

    //订单详情
    public function detail($id)
    {
    	$order = new Order();

    	$orderGoods = new OrderGoods();

    	$region = new Region();

    	$member = new Member();

    	//订单基本信息
    	$order = $this->getDataInfo($order,$id);

    	// dd($order);

    	//获取收货人的地址信息
    	$country = $this->getDataInfo($region,$order->country);//国家

    	$province = $this->getDataInfo($region,$order->province);//省份

    	$city = $this->getDataInfo($region,$order->city);//市

    	$district = $this->getDataInfo($region,$order->district);//区

    	$assign = [
    		'country' => $country->region_name,
    		'province' => $province->region_name,
    		'city' => $city->region_name,
    		'district' => $district->region_name,

    	];

    	// dd($assign);

    	$assign['order'] = $order;

    	//商品订单信息
    	$assign['order_goods'] = $this->getDataList($orderGoods);

    	//购货人的信息
    	$assign['member'] = $this->getDataInfo($member,$order->user_id);

    	// dd($assign);



    	return view('admin.order.detail',$assign);
    }
}
