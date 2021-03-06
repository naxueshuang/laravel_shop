<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Article;
use App\Model\ArticleCategory;
use App\Model\ArticleContent;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
	protected $category = null;
	protected $article = null;
	protected $content = null;

	public function __construct()
	{
		$this->category = new ArticleCategory();

		$this->article = new Article();

		$this->content = new ArticleContent();

	}
    //文章列表
    public function list()
    {
    	$assign['list'] = $this->article->getList();
    	// dd($assign);

    	return view('admin.article.article.list',$assign);
    }

    //文章添加
    public function add()
    {
    	$assign['category'] = $this->category->getCategoryList();

    	// dd($assign);

    	return view('admin.article.article.add',$assign);
    }

    //文章添加操作
    public function store(Request $request)
    {
    	// dd(1);
    	$params = $request->all();
    	// dd($params);
    	unset($params['_token']);

    	$content = $params['content'];

    	unset($params['content']);
    	// dd(1);

    	try{
    		DB::beginTransaction();//开始事务

    		//执行文章的添加
    		$id = $this->article->doAdd($params);

    		//执行文章内容的添加
    		$data = [
    			'a_id' => $id,
    			'content' => $content
    		];

    		$this->content->doAdd($data);

    		DB::commit();//提交事务

    	}catch(\Exception $e){

    		DB::rollback();//事务回滚

    		\Log::info('文章添加失败'.$e->getMessage());

    		return redirect()->back()->with('msg',$e->getMessage());

    	}

    	return redirect('/admin/article/list');
    }

    //编辑页面
    public function edit($id)
    {
    	$assign['category'] = $this->category->getCategoryList();

    	$assign['info'] = $this->article->getInfo($id);

    	$assign['content'] = $this->content->getInfo($id);

    	return view('admin.article.article.edit',$assign);
    }

    public function doEdit(Request $request)
    {
    	$params = $request->all();
    	// dd($params);
    	unset($params['_token']);

    	$content = $params['content'];

    	$id = $params['id'];

    	unset($params['content']);
    	unset($params['id']);
    	// dd(1);

    	try{
    		DB::beginTransaction();//开始事务

    		//执行文章的添加
    		$id = $this->article->doEdit($params,$id);

    		//执行文章内容的添加
    		$data = [
    			
    			'content' => $content
    		];

    		$this->content->doEdit($data,$id);

    		\Log::info('修改成功');

    		DB::commit();//提交事务

    	}catch(\Exception $e){

    		DB::rollback();//事务回滚

    		\Log::info('文章修改失败'.$e->getMessage());

    		return redirect()->back()->with('msg',$e->getMessage());

    	}

    	return redirect('/admin/article/list');
    }

    //删除
    public function del($id)
    {
    	//事务的执行
    	try{

    		DB::beginTransaction();//开始事务

    		$this->article->delData($id);

    		$this->content->delData($id);

    		\Log::info('删除成功');

    		DB::commit();//提交事务

    	}catch(\Exception $e){

    		DB::rollback();//事务回滚

    		\Log::info('文章删除失败'.$e->getMessage());

    		// return redirect('/admin/article/list');

    	}

    	return redirect('/admin/article/list');

	}
}
