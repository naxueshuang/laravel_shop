<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class HomeController extends Controller
{
    //后台首页
    public function home()
    {
    	//redis缓存数据
    	$key = "admin_home_data";

    	$redis = new \Redis();

    	$redis->connect('127.0.0.1',6379);

    	$data = $redis->get($key);

    	if(!$data){//redis的数据如果为空
    		//今天日期
	    	$today = date("Y-m-d");

	    	//明天日期
	    	$tomorrow = date("Y-m-d",strtotime('+1 days'));

	    	//一周前
	    	$lastWeek = date("Y-m-d",strtotime('-5 days'));

	    	/*##########[会员统计总数]##########*/
	    	//会员总数
	    	$assign['member_nums'] = \DB::table('jy_user')->count('id');

	    	//今日会员注册总量
	    	$assign['today_register_nums'] = \DB::table('jy_user')
	    										->where('created_at','>=',$lastWeek)
	    										->where('created_at','<',$tomorrow)
	    										->count('id');

	    	//近一周会员注册量
	    	$assign['last_week_register'] = \DB::table('jy_user')
	    										->where('created_at','>=',$lastWeek)
	    										->where('created_at','<',$today)
	    										->count('id');
	    	// dd($assign);

	    	//近一周会员注册走势图
	  		$member_data = \DB::table('jy_user')
	  						->select(\DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d') as date,count(id) as nums"))
							->where('created_at','>=',$lastWeek)
							->where('created_at','<',$tomorrow)
							->groupBy(\DB::raw("DATE_FORMAT(created_at,'%Y-%m-%d')"))
							->get();
			// dd($member_data);
			$dates = $register = '';

			foreach ($member_data as $key => $value) {
				$dates .= "'".$value->date."',";
				$register .= $value->nums.",";
			}

			$assign['register_date'] = substr($dates,0,-1);

			$assign['register_nums'] = substr($register,0,-1);

	  		/*##########[会员统计总数]##########*/



	  		/*##########[订单统计总数]##########*/
	  		//订单总数
	  		$assign['order_nums'] = \DB::table('jy_order')->count('id');

	  		//今日订单总量
	    	$assign['today_order_nums'] = \DB::table('jy_order')
	    										->where('created_at','>=',$lastWeek)
	    										->where('created_at','<',$tomorrow)
	    										->count('id');

	    	//近一周订单量
	    	$assign['last_week_order'] = \DB::table('jy_order')
	    										->where('created_at','>=',$today)
	    										->where('created_at','<',$tomorrow)
	    										->count('id');
	  		/*##########[订单统计总数]##########*/



	  		/*##########[商品统计总数]##########*/
	  		//商品总数
	  		$assign['goods_nums'] = \DB::table('jy_goods')->count('id');

	  		//今日商品总量
	    	$assign['today_goods_nums'] = \DB::table('jy_goods')
	    										->where('created_at','>=',$lastWeek)
	    										->where('created_at','<',$tomorrow)
	    										->count('id');

	    	//近一周商品量
	    	$assign['last_goods_order'] = \DB::table('jy_goods')
	    										->where('created_at','>=',$today)
	    										->where('created_at','<',$tomorrow)
	    										->count('id');
	  		/*##########[商品统计总数]##########*/

	  		//设置redis缓存
	  	 	$redis->setex($key,180,json_encode($assign));

	    }else{

	    	// echo "redis缓存数据";exit;
	    	$assign = json_decode($data,true);

	    	// dd($assign);
	    }
    	return view('admin.home.home',$assign);
    }


}
