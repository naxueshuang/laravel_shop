<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Ad;
use App\Model\AdPosition;
use App\Tools\ToolsAdmin;

class AdController extends Controller
{
	protected $position = null;

	protected $ad = null;

	public function __construct()
	{
		$this->position = new AdPosition();

		$this->ad = new Ad();
	}
    //
    public function list()
    {
    	$assign['list'] = $this->ad->getAdList();

    	// dd($assign);

    	return view('admin.ad.list',$assign);
    }


    public function add()
    {
    	$assign['position'] = $this->position->getList(); 
    	
    	return view('admin.ad.add',$assign);
    }


    public function store(Request $request)
    {
    	$params = $request->all();

    	// dd($params);
    	if(!isset($params['image_url']) || empty($params['image_url'])){

    		return redirect()->back()->with('msg','亲，先上传图片');
    	}

    	$params['image_url'] = ToolsAdmin::uploadFile($params['image_url']);

    	$params = $this->delToken($params);

    	$ad = new Ad();

    	$res = $this->storeData($ad,$params);

    	if(!$res){

    		return redirect()->back()->with('msg','广告添加失败');
    	}

    	return redirect('/admin/ad/list');
    }


    public function edit($id)
    {
    	$ad = new Ad();

    	$assign['info'] = $this->getDataInfo($ad,$id);

    	$assign['position'] = $this->position->getList();  

    	// dd($assign);

    	return view('/admin/ad/edit',$assign);
    }


    public function doEdit(Request $request)
    {
    	$params = $request->all();

    	if(isset($params['image_url']) && !empty($params['image_url'])){

    		// return redirect()->back()->with('msg','亲，先上传图片');
    		$params['image_url'] = ToolsAdmin::uploadFile($params['image_url']);
    	}

    	$params = $this->delToken($params);

    	$ad = Ad::find($params['id']);

    	$res = $this->storeData($ad,$params);

    	if(!$res){

    		return redirect()->back()->with('msg','广告修改失败');
    	}

    	return redirect('/admin/ad/list');
    }

    public function del($id)
    {
    	$ad = new Ad();

    	$res = $this->delData($ad,$id);

    	return redirect('/admin/ad/list');   
    }
}
