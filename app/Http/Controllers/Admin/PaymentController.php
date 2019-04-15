<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Payment;


class PaymentController extends Controller
{
    //支付列表
    public function list()
    {
        $payment = new Payment();

        $assign['pay_list'] = $this->getDataList($payment);

    	return view('admin.payment.list',$assign);
    }

    //支付添加页面
    public function add()
    {
    	return view('admin.payment.add');
    }

    public function store(Request $request)
    {
    	$params = $request->all();

    	$params = $this->delToken($params);

        //处理支付方式的配置信息,进行序列化
    	if(!empty($params['pay_config'])){

    		$arr = explode('|', $params['pay_config']);

            foreach ($arr as $key => $value) {
                $arr1 = explode('=>',$value);

                $pay_config[$arr1[0]] = $arr1[1];
            }

            // dd($pay_config);

    		$params['pay_config'] = serialize($arr);
    	}

    	// dd($params);

        $payment = new Payment();

    	$res = $this->storeData($payment,$params);

        if(!$res){

            return redirect()->back()->with('msg','支付方式添加失败');
        }

        return redirect('/admin/payment/list');
    }

    //编辑
    public function edit($id)
    {
        $payment = new Payment();

        $assign['info'] = $this->getDataInfo($payment,$id)->toArray();

        $pay_config = unserialize($assign['info']['pay_config']);

        $string = "";

        foreach ($pay_config as $key => $value) {

             $string = $key."=>".$value."|";
        }

        // dd($string);

        $assign['info']['pay_config'] = substr($string,0,-1);

        return view('admin.payment.edit',$assign);
    }

    //执行编辑
    public function doEdit(Request $request)
    {
        $params = $request->all();

        $params = $this->delToken($params);

        //处理支付方式的配置信息,进行序列化
        if(!empty($params['pay_config'])){

            $arr = explode('|', $params['pay_config']);

            foreach ($arr as $key => $value) {
                $arr1 = explode('=>',$value);

                $pay_config[$arr1[0]] = $arr1[1];
            }

            // dd($pay_config);

            $params['pay_config'] = serialize($arr);
        }

         $payment = Payment::find($params['id']);

        $res = $this->storeData($payment,$params);

        if(!$res){

            return redirect()->back()->with('msg','支付方式修改失败');
        }

        return redirect('/admin/payment/list');
    }

    public function del($id)
    {
        $payment = new Payment();

        $this->delData($payment,$id);

        return redirect('/admin/payment/list');
    }
}
