<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Ad;
use App\Model\AdPosition;
use App\Tools\ToolsAdmin;
use App\Tools\ToolsOss;

use OSS\OssClient;
use OSS\Core\OssException;
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
        //dd(\Config::get('oss.accessKeyId'));
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

        $oss = new ToolsOss();

       $filePath = $oss->putFile($params['image_url']);

       // dd($filePath);

        ##########################oss文件上传测试##########################
        // $files = $params['image_url'];

        // dd($files);

        // 阿里云主账号AccessKey拥有所有API的访问权限，风险很高。强烈建议您创建并使用RAM账号进行API访问或日常运维，请登录 https://ram.console.aliyun.com 创建RAM账号。
        // $accessKeyId = "LTAI2pSbclgr7QkR";

        // $accessKeySecret = "UL0VExN2JqrrPE5uFCnTOR8WlLSnVC";

        // // Endpoint以杭州为例，其它Region请按实际情况填写。
        // $endpoint = "http://oss-cn-beijing.aliyuncs.com";

        // // 存储空间名称
        // $bucket= "small-cute";

        // // 文件名称
        // $object = "uploads/".date('Y-m-d')."/".date("YmdHis",time()).rand(0,10000).".".$files->extension();

        // // <yourLocalFile>由本地文件路径加文件名包括后缀组成，例如/users/local/myfile.txt
        // $filePath = $files->path();//上传的临时文件

        // try{
        //     $ossClient = new OssClient($accessKeyId, $accessKeySecret, $endpoint);

        //     $ossClient->uploadFile($bucket, $object, $filePath);

        // } catch(OssException $e) {

        //     printf(__FUNCTION__ . ": FAILED\n");

        //     printf($e->getMessage() . "\n");

        //     return;
        // }
        ##########################

        // dd('success');



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
