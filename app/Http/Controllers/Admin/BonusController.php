<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Bonus;
use App\Model\Member;
use App\Model\UserBonus;

class BonusController extends Controller
{
    //红包列表
    public function list()
    {	
    	$bonus = new Bonus();

    	$assign['bonus_list'] = $this->getDataList($bonus);

    	// dd($assign);

    	return view('admin.bonus.list',$assign);
    }

    //红包添加页面
    public function addBonus()
    {
    	return view('admin.bonus.add');
    }

    //执行红包添加
    public function doAddBonus(Request $request)
    {
    	$params = $request->all();

    	$params = $this->delToken($params);

    	$bonus = new Bonus();

    	$res = $this->storeData($bonus,$params);

    	if(!$res){

    		return redirect()->back()->with('msg','添加红包失败');
    	}

    	return redirect('admin/bonus/list');
    } 

    //编辑页面
    public function edit($id)
    {
    	$bonus = new Bonus();

    	$assign['bonus'] = $this->getDataInfo($bonus,$id);

    	// dd($assign);

    	return view('admin.bonus.edit',$assign);
    }

    //执行红包编辑
    public function doEdit(Request $request)
    {
    	$params = $request->all();

    	// dd($params);

    	$params = $this->delToken($params);

    	// dd($params);

    	$bonus = Bonus::find($params['id']);



    	$res = $this->storeData($bonus,$params);

    	// dd($res);

    	if(!$res){

    		return redirect()->back()->with('msg','编辑红包失败');
    	}

    	return redirect('admin/bonus/list');
    }

    //删除
    public function del($id)
    {
    	$bonus = new Bonus();

    	$this->delData($bonus,$id);

    	return redirect('admin/bonus/list');
    }

   //发送红包
    public function sendBonus($bonusId)
    {
    	$bonus = new Bonus();

    	$assign['bonus_info'] = $this->getDataInfo($bonus,$bonusId);
    	
    	// dd($info);

    	return view('admin.bonus.send',$assign);
    }

    //执行发送红包
    public function doSendBonus(Request $request)
    {
    	$params = $request->all();

    	$params = $this->delToken($params);

    	//查询用户信息
    	$user = new Member();

    	$userInfo = $this->getDataInfo($user,$params['phone'],'phone');

    	if(empty($userInfo)){

    		return redirect()->back()->with('msg','用户不存在，红包发送失败');
    	}

    	// dd($userInfo);
    	//用户红包的数据
    	$userBonusData = [
    		'user_id' => $userInfo->id,
    		'bonus_id' => $params['bonus_id'],
    		'start_time' => date('Y-m-d H:i:s'),
    		'end_time'   => date('Y-m-d H:i:s',strtotime("+".$params["expires"]."days")),
    	];

    	$userBonus = new UserBonus();

    	$res = $this->storeData($userBonus,$userBonusData);

    	if(!$res){

    		return redirect()->back()->with('msg','红包发送失败');
    	}

    	return redirect('/admin/user/bonus/list');
    }

    public function userBonusList()
    {
    	$userBonus = new UserBonus();

    	$assign['user_bonus'] = $userBonus->getSendBonus();

    	// dd($assign);

    	return view('admin.bonus.userBonus',$assign);
    }
}
