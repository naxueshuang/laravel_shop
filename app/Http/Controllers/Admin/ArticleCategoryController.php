<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\ArticleCategory;

class ArticleCategoryController extends Controller
{
	protected $articleCategory = null;

	public function __construct()
	{
		$this->articleCategory = new ArticleCategory();
	}

    //文章分类列表页面
    public function list()
    {
    	$assign['list'] = $this->articleCategory->getCategoryList();

    	return view('admin.article.category.list',$assign);
    }

    //执行文章分类添加页面
    public function add()
    {
    	return view('admin.article.category.add');
    }

    //执行文章分类添加操作
    public function store(Request $request)
    {
    	$params = $request->all();

    	if(!isset($params['cate_name']) || empty($params['cate_name'])){

    		return redirect()->back()->with('msg','分类名称不能为空');
    	}

    	unset($params['_token']);

    	// dd($params);

    	$res = $this->articleCategory->doAdd($params);

    	// dd($res);

    	if(!$res){
    		return redirect()->back()->with('msg','分类添加失败');
    	}

    	return redirect('/admin/article/category/list');
    }

    //分类编辑页面
    public function edit($id)
    {
    	$assign['info'] = $this->articleCategory->getInfo($id);

    	return view('admin.article.category.edit',$assign);
    }

    //分类编辑执行页面
    public function doEdit(Request $request)
    {
    	$params = $request->all();

    	// dd($params);

    	if(!isset($params['cate_name']) || empty($params['cate_name'])){

    		return redirect()->back()->with('msg','分类名称不能为空');
    	}

    	unset($params['_token']);

    	$res = $this->articleCategory->doUpdate($params,$params['id']);

    	//dd($res);

    	if(!$res){
    		return redirect()->back()->with('msg','分类修改失败');
    	}

    	return redirect('/admin/article/category/list');
    }


    //执行删除操作
    public function del($id)
    {
    	$res = $this->articleCategory->del($id);

    	return redirect('/admin/article/category/list');
    }


}
