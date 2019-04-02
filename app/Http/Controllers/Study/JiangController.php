<?php

namespace App\Http\Controllers\Study;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JiangController extends Controller
{
    //
    public function jiang()
    {
    	return view('study.jiang.index');
    }

    public function doJIang(Request $request)
    {
    	$phone = $request->input('phone');

    	$user_id = $request->input('user_id');

    	$start = date("Y-m-d 10:00:00",time());

    	$end = date("Y-m-d 23:00:00",time());

    	$return = [
    		'code' => 2000,
    		'msg'  => '抽奖成功'
    	];

    	return json_encode($return);

    	if(empty($phone)){
    		$return = [
    			'code' => 4001,
    			'msg'  => '手机号不能为空',
    		];

    		return json_encode($return);
    	}

    	$user = Db::table('study_lottery_recode')->where('phone',$phone)->first();

    	if(empty($user)){
    		$return = [
    			'code' => 4002,
    			'msg'  => "用户信息不存在"
    		];

    		return json_encode($return);
    	}

    	$recodes = Db::table('study_lottery_recode')->where('user_id',$user_id)->where('created_at',date('Y-m-d'))->conut();

    	if($recodes >=3){
    		$return = [
    			'code' => 4003,
    			'msg'  => '今日抽奖次数已用完，请明日再来'
    		];

    		return json_encode($return);
    	}

    	if(time() > strtotime($end) || time() < strtotime($start)){
    		$return = [
    			'code' => 4004,
    			'msg'  => '请在规定时间前来抽奖'
    		]; 

    		return json_encode($return);
    	}

    	$lottery = Db::table('study_lottery')->get()->toArray();

    	$lotterys = $precents = [];

    	foreach ($lottery as $key => $value) {
    		$lotterys[$value->id] = [
    			'lottery_name' =>$value->lottery_name
    		];

    		$pretents[$value->id] = $value->pretents;
    	}

    	$preSum = array_sum($pretents);

    	$result = '';

    	foreach ($precents as $k => $v) {
    		
    		$preCurrent = mt_rand(1, $preSum);
    		
    		if($v > $preCurrent){
    			$result = $k;
    			break;
    		}else{
    			$preSum = $preSum - $v;
    		}
    	}

    	$data = [
    		'user_id' => $user_id,
    		'lottery_id' => $lottery_id,
    		'created_at' => date('Y-m-d')
    	];

    	DB::table('study_lottery_record')->insert($data);

    	$return['msg'] = $lotterys[$result]['lottery_name'];
    	
    	return json_encode($return);
    }
}
