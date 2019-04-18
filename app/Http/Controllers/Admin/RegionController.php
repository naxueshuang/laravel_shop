<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Region;
use App\Tools\ToolsAdmin;

class RegionController extends Controller
{
    //列表页面
    public function list($fid=0)
    {
    	$region = new Region();

    	$assign['region_list'] = $this->getDataList($region, ['p_id'=>$fid]);

    	// dd($assign);

    	return view('admin.region.list',$assign);
    }

    //添加页面
    public function add()
    {
        $region = new Region();

        $regions = $this->getDataList($region);

        $assign['region_list'] = ToolsAdmin::buildTreeString($regions,0,0,'p_id');

        // dd($region);
    	
        return view('admin.region.add',$assign);
    }

    //执行添加
    public function store(Request $request)
    {
    	$params = $request->all();

        // dd($params);

        $params = $this->delToken($params);

        // dd($params);

        //要添加地区的详细信息
        $region = new Region();

        $info = $this->getDataInfo($region,$params['p_id']);

        $params['level'] = $info->level + 1;

        // dd($params['level']);

        $res = $this->storeData($region,$params);

        // dd($res);

        if(!$res){

            return redirect()->back()->with('msg','；地区添加失败');
        }
        
        return redirect('/admin/region/list');
    }

    //删除
    public function del($id)
    {
        $region = new Region();

        $this->delData($region,$id);

        return redirect('/admin/region/list');
    }
}
