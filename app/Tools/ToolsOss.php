<?php 
/**
* oss对象储存类
*/
namespace App\Tools;

use OSS\OssClient;
use OSS\Core\OssException;


class ToolsOss
{
	protected $ossClient = null;

	protected $endpoint = null;

	protected $bucket = null;

	public function __construct()
	{
		//获取osss的配置信息
		$config = \Config::get('oss');

		$accessKeyId = $config['accessKeyId'];//访问阿里云access权限的账号id

		// dd($accessKeyId);

		$accessKeySecret = $config['accessKeySecret'];//访问阿里云access权限的账号密码

		$this->endpoint = $config['endpoint'];//权限的节点信息

		$this->bucket = $config['bucket'];//存储空间名称

		try {
			//实例化偶数术客户端对象
			$this->ossClient = new Ossclient($accessKeyId, $accessKeySecret, "http://"."$this->endpoint");

			// dd($res);
			
		} catch (\OssException $e) {
			
			\Log::error('oss对象存储类实例化失败',[$e->getMessage(),$e->getCode()]);
		}
	}

	//oss文件上传的函数
	public function putFile($files)
	{
		//文件上传的目录
		$basePath = 'uploads/'.date("Y-m-d",time());

		// dd($basePath);

		// dd($files);
		//文件名字
		$filename = "/".date("YmdHis",time()).rand(0,10000).".".$files->extension();

		//文件上传的路径
		$object = $basePath.$filename;

		// dd($object);

		try {
			//判断文件是否已经存在
			$exists = $this->ossClient->doesObjectExist($this->bucket,$object);

			// dd($exists);

			if($exists){

				\Log::error('上传的文件已经存在，文位路径是:'.$object);

				return $object;
			}
			//执行文件的上传
			$this->ossClient->uploadFile($this->bucket,$object,$files->path());

			return $object;

		} catch (\OssException $e) {
			
			\Log::error('oss文件上传失败',[$e->getMessage(),$e->getCode()]);

			return;
		}
	}

	//访问文件的路径
	public function getUrl($filePath, $private=false)
	{
		$timeout = 3600;
	// dd($filePath);
		//私有的访问路径
		if($private){

			$signUrl = $this->ossClient->signUrl($this->bucket,$filePath,$timeout);

			return $siangUrl;
		}

		return "http://".$this->bucket.".".$this->endpoint."/".$filePath;
	}
}
 ?>