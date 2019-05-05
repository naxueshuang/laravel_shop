<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

	//echo "hello Laravel";exit;
    return view('welcome');
});

//学习类的路由组
Route::prefix('study')->group(function(){

/**********************************************【红包】************************************/
    //红包首页路由
    Route::get('bonus/index','Study\BonusController@index');

    //红包添加路由
    Route::post('bonus/add','Study\BonusController@addBonus');

    //红包列表
    Route::get('bonus/list','Study\BonusController@getList');


    Route::get('bonus/record/list','Study\BonusController@getBonusRecord');


    Route::any('get/bonus', 'Study\BonusController@getBonus'); //获取红包的路由

/**********************************************【红包】************************************/



/************************************[足球竞猜]************************************/
    
    //足球竞猜添加页面
    Route::get('guess/add','Study\GuessController@add');

    //足球竞猜列表页面
    Route::post('guess/doAdd','Study\GuessController@doAdd');

    //足球竞猜列表页面
    Route::get('guess/list','Study\GuessController@list');

    //足球竞猜列表页面
    Route::get('guess/guess','Study\GuessController@guess');


    Route::post('guess/result','Study\GuessController@checkResult');


    Route::post('guess/doGuess','Study\GuessController@doGuess');

/************************************[足球竞猜]************************************/

/************************************[抽奖]************************************/
    //抽奖页面
    Route::get('lottery/index','Study\LotteryController@lottery');

    //执行抽奖
    Route::any('lottery/do','Study\LotteryController@doLottery');


    Route::get('jiang/index','Study\JiangController@jiang');


});




//登陆页面
Route::get('/admin/login','Admin\LoginController@index');

//执行登陆
Route::post('/admin/doLogin','Admin\LoginController@doLogin');

//用户退出
Route::get('/admin/logout','Admin\LoginController@logout');

//忘记密码的页面
Route::get('/admin/forget/password','Admin\LoginController@forget');

//执行发送邮件
Route::post('/admin/forget/sendEmail','Admin\LoginController@sendEmail');

//重置密码页面
Route::get('/admin/forget/reset','Admin\LoginController@reset');

//执行重置密码
Route::post('/admin/reset/password/save','Admin\LoginController@save');


Route::get('403',function(){
    return view('403');
});

//管理后台RBAC功能类的路由组
Route::middleware(['admin_auth','permission_auth'])->prefix('admin')->group(function(){

    //管理后台首页
    Route::get('home','Admin\HomeController@home')->name('admin.home');

/*######################################[权限相关]############################################*/
    //权限列表
    Route::get('/permission/list','Admin\PermissionController@list')->name('admin.permission.list');

    //获取权限的数据
    Route::any('/get/permission/list/{fid?}','Admin\PermissionController@getPermissionList')->name('admin.get.permission.list');

    //权限添加
    Route::get('/permission/create','Admin\PermissionController@create')->name('admin.permission.create');

    //执行权限添加
    Route::post('/permission/doCreate','Admin\PermissionController@doCreate')->name('admin.permission.doCreate');

    //删除权限的操作
    Route::get('/permission/del/{id}','Admin\PermissionController@del')->name('admin.permission.del');


    /*#######################################[权限相关]#####################################*/



    /*#######################################[用户相关]############################################*/
    //用户添加页面
    Route::get('/user/add','Admin\AdminUsersController@create')->name('admin.user.add');

    //执行用户添加
    Route::post('/user/store','Admin\AdminUsersController@store')->name('admin.user.store');

    //用户列表页面
    Route::get('/user/list','Admin\AdminUsersController@list')->name('admin.user.list');

    //用户删除操作
    Route::get('/user/del/{id}','Admin\AdminUsersController@delUser')->name('admin.user.del');

    //用户编辑页面
    Route::get('/user/edit/{id}','Admin\AdminUsersController@edit')->name('admin.user.edit');

    //用户执行编辑页面
    Route::post('/user/doEdit','Admin\AdminUsersController@doEdit')->name('admin.user.doEdit');

        /*###################[密码相关]########################*/
    //修改密码的页面
    Route::get('/user/password','Admin\AdminUsersController@password')->name('admin.user.password');

    //执行修改密码
    Route::post('/user/password/save','Admin\AdminUsersController@updatePwd')->name('admin.user.password.save');

        /*###################[密码相关]########################*/

     /*########################################[用户相关]##########################################*/


     /*########################################[角色相关]###########################################*/

     //角色列表
     Route::get('/role/list','Admin\RoleController@list')->name('admin.role.list');

     //角色删除
     Route::get('/role/del/{id}','Admin\RoleController@delRole')->name('admin.role.del');


     //角色添加
     Route::get('/role/create','Admin\RoleController@create')->name('admin.role.create');

     //角色执行添加
     Route::post('/role/store','Admin\RoleController@store')->name('admin.role.store');

     //角色编辑
     Route::get('/role/edit/{id}','Admin\RoleController@edit')->name('admin.role.edit');

     //角色执行编辑
     Route::post('/role/doEdit','Admin\RoleController@doEdit')->name('admin.role.doEdit');

     //角色权限编辑
     Route::get('/role/permission/{id}','Admin\RoleController@rolePermission')->name('admin.role.permission');
     
     //角色权限执行编辑
     Route::post('/role/permission/save','Admin\RoleController@saveRolePermission')->name('admin.role.permission.save');


     /*#############################[角色相关]#############################*/

     /*########################################[商品品牌相关]###########################################*/
     //品牌列表页面
     Route::get('brand/list','Admin\BrandController@list')->name('admin.brand.list');

     //品牌列表页面
     Route::post('brand/data/list','Admin\BrandController@getListData')->name('admin.brand.data.list');

    //品牌添加页面
     Route::get('brand/add','Admin\BrandController@add')->name('admin.brand.add');

     //执行商品品牌添加
     Route::post('brand/doAdd','Admin\BrandController@doAdd')->name('admin.brand.doAdd');

    //商品品牌修改
     Route::get('brand/edit/{id}','Admin\BrandController@edit')->name('admin.brand.edit');

     //执行商品品牌修改
     Route::post('brand/doEdit','Admin\BrandController@doEdit')->name('admin.brand.doEdit');

     //执行商品品牌删除的操作
     Route::get('brand/del/{id}','Admin\BrandController@del')->name('admin.brand.del');

     //修改商品品牌属性的操作
     Route::post('brand/change/attr','Admin\BrandController@changeAttr')->name('admin.brand.change.attr');

     /*########################################s[商品品牌相关]###########################################*/

      /*#############################[商品分类相关]#############################*/

     //商品分类列表页面
     Route::get('category/list', 'Admin\CategoryController@list')->name('admin.category.list');

     //获取商品接口分类的数据
     Route::get('category/get/data/{fid?}','Admin\CategoryController@getListData')->name('admin.category.get.data');

     //商品添加页面
     Route::get('category/add','Admin\CategoryController@add')->name('admin.category.add');

     //商品执行添加操作
     Route::post('category/doAdd','Admin\CategoryController@doAdd')->name('admin.category.doAdd');

     //商品编辑页面
     Route::get('category/edit/{id}','Admin\CategoryController@edit')->name('admin.category.edit');

     //商品执行编辑操作
     Route::post('category/doEdit','Admin\CategoryController@doEdit')->name('admin.category.doEdit');

     //商品执行删除操作
     Route::get('category/del/{id}','Admin\CategoryController@del')->name('admin.category.del');

     /*#############################[商品分类相关]#############################*/

     /*#############################[文章分类相关]#############################*/
     //文章分类列表操作
     Route::get('article/category/list','Admin\ArticleCategoryController@list')->name('admin.article.category.list');

     //文章分类添加
     Route::get('article/category/add','Admin\ArticleCategoryController@add')->name('admin.article.category.add');

     //文章分类执行添加
     Route::post('article/category/store','Admin\ArticleCategoryController@store')->name('admin.article.category.store');

     //文章分类删除操作
     Route::get('article/category/del/{id}','Admin\ArticleCategoryController@del')->name('admin.article.category.del');

     //文章分类编辑
     Route::get('article/category/edit/{id}','Admin\ArticleCategoryController@edit')->name('admin.article.category.edit');

     //文章分类执行编辑
     Route::post('article/category/save','Admin\ArticleCategoryController@doEdit')->name('admin.article.category.save');

     /*#############################[文章分类相关]#############################*/

     /*#############################[文章相关]#############################*/
     //文章列表
     Route::get('article/list','Admin\ArticleController@list')->name('admin.article.article.list');

     //文章添加页面
     Route::get('article/add','Admin\ArticleController@add')->name('admin.article.article.add');

     //文章执行添加
     Route::post('article/store','Admin\ArticleController@store')->name('admin.article.store');

      //文章编辑
     Route::get('article/edit/{id}','Admin\ArticleController@edit')->name('admin.article.edit');

     //文章执行编辑
     Route::post('article/save','Admin\ArticleController@doEdit')->name('admin.article.save');

     //文章分类删除操作
     Route::get('article/del/{id}','Admin\ArticleController@del')->name('admin.article.del');

     /*#############################[文章相关]#############################*/

     /*#############################[广告相关]#############################*/
     //广告位列表
     Route::get('position/list','Admin\AdPositionController@list')->name('admin.position.list');

     //广告位添加页面
     Route::get('position/add','Admin\AdPositionController@add')->name('admin.position.add');

     //广告位执行添加
     Route::post('position/store','Admin\AdPositionController@store')->name('admin.position.store');

      //广告位编辑
     Route::get('position/edit/{id}','Admin\AdPositionController@edit')->name('admin.position.edit');

     //广告位执行编辑
     Route::post('position/save','Admin\AdPositionController@doEdit')->name('admin.position.save');

     //广告位删除操作
     Route::get('position/del/{id}','Admin\AdPositionController@del')->name('admin.position.del');

     /*#############################[广告位相关]#############################*/


     /*#############################[广告列表相关]#############################*/
     //广告列表
     Route::get('ad/list','Admin\AdController@list')->name('admin.ad.list');

     //广告添加页面
     Route::get('ad/add','Admin\AdController@add')->name('admin.ad.add');

     //广告执行添加
     Route::post('ad/store','Admin\AdController@store')->name('admin.ad.store');

      //广告编辑
     Route::get('ad/edit/{id}','Admin\AdController@edit')->name('admin.ad.edit');

     //广告执行编辑
     Route::post('ad/save','Admin\AdController@doEdit')->name('admin.ad.save');

     //广告删除操作
     Route::get('ad/del/{id}','Admin\AdController@del')->name('admin.ad.del');

     /*#############################[广告列表相关]#############################*/


      /*#############################[商品类型相关]#############################*/
     //商品类型列表
     Route::get('goods/type/list','Admin\GoodsTypeController@list')->name('admin.goods.type.list');

     //商品类型添加页面
     Route::get('goods/type/add','Admin\GoodsTypeController@add')->name('admin.goods.type.add');

     //商品类型执行添加
     Route::post('goods/type/store','Admin\GoodsTypeController@store')->name('admin.goods.type.store');

      //商品类型编辑
     Route::get('goods/type/edit/{id}','Admin\GoodsTypeController@edit')->name('admin.goods.type.edit');

     //商品类型执行编辑
     Route::post('goods/type/save','Admin\GoodsTypeController@doEdit')->name('admin.goods.type.save');

     //商品类型告删除操作
     Route::get('goods/type/del/{id}','Admin\GoodsTypeController@del')->name('admin.goods.type.del');

     /*#############################[商品类型相关]#############################*/


     /*#############################[商品属性相关]#############################*/
     //商品属性列表
     Route::get('goods/attr/list/{type_id}','Admin\GoodsAttrController@list')->name('admin.goods.attr.list');

     //商品属性添加页面
     Route::get('goods/attr/add','Admin\GoodsAttrController@add')->name('admin.goods.attr.add');

     //商品属性执行添加
     Route::post('goods/attr/store','Admin\GoodsAttrController@store')->name('admin.goods.attr.store');

      //商品属性编辑
     Route::get('goods/attr/edit/{id}','Admin\GoodsAttrController@edit')->name('admin.goods.attr.edit');

     //商品属性执行编辑
     Route::post('goods/attr/save','Admin\GoodsAttrController@doEdit')->name('admin.goods.attr.save');

     //商品属性告删除操作
     Route::get('goods/attr/del/{id}','Admin\GoodsAttrController@del')->name('admin.goods.attr.del');

     /*#############################[商品属性相关]#############################*/

     /*#############################[商品相关]#############################*/
    //商品列表
     Route::get('goods/list','Admin\GoodsController@list')->name('admin.goods.list');

     //商品属性即点即改
     Route::post('goods/change/attr','Admin\GoodsController@changeAttr')->name('admin.goods.change.attr');

     //商品数据接口数据
     Route::any('goods/data/list','Admin\GoodsController@getGoodsData')->name('admin.goods.data.list');

     //商品添加页面
     Route::get('goods/add','Admin\GoodsController@add')->name('admin.goods.add');

     //商品添加页面
     Route::post('goods/store','Admin\GoodsController@store')->name('admin.goods.store');

     // 商品添加
     Route::get('goods/edit/{id}','Admin\GoodsController@edit')->name('admin.goods.edit');

      //商品添加操作
     Route::post('goods/save','Admin\GoodsController@doEdit')->name('admin.goods.save');

      // 商品删除
     Route::get('goods/del/{id}','Admin\GoodsController@del')->name('admin.goods.del');

      //商品相册的数据
     Route::post('goods/gallery/list/{goods_id}','Admin\GoodsGalleryController@getGallery')->name('admin.goods.gallery.list');
     
     // 商品相册删除
     Route::get('goods/gallery/del/{id}','Admin\GoodsGalleryController@del')->name('admin.goods.gallery.del');
     
     //商品sku和属性页面
     Route::get('goods/sku/edit/{goods_id}','Admin\GoodsSkuController@edit')->name('admin.goods.sku.edit');
      
      //商品添加操作
     Route::post('goods/sku/save','Admin\GoodsSkuController@doEdit')->name('admin.goods.sku.save');
    
     //商品sku属性列表接口
     Route::any('goods/sku/attr/{goods_id}','Admin\GoodsSkuController@getSkuAttr')->name('admin.goods.sku.attr');
     
     //商品属性值
     Route::any('goods/attr/value/{id}','Admin\GoodsSkuController@getAttrValues')->name('admin.goods.attr.value');
     
     Route::any('goods/sku/list/bind/{goods_id}','Admin\GoodsSkuController@getSkuList')->name('admin.goods.sku.list.bind');




     /*#############################[商品相关]#############################*/


     /*#############################[商品系统管理（支付，配送方式方式）相关]#############################*/
     //支付方式列表页面
     Route::get('payment/list','Admin\PaymentController@list')->name('admin.payment.list');

     //支付方式添加页面
     Route::get('payment/add','Admin\PaymentController@add')->name('admin.payment.add');

     //支付方式执行添加
     Route::post('payment/store','Admin\PaymentController@store')->name('admin.payment.store');

     //支付方式修改页面
     Route::get('payment/edit/{id}','Admin\PaymentController@edit')->name('admin.payment.edit');

     //支付方式执行修改
     Route::post('payment/save','Admin\PaymentController@doEdit')->name('admin.payment.save');

     //支付方式删除
      Route::get('payment/del/{id}','Admin\PaymentController@del')->name('admin.payment.del');

      //配送方式列表
      Route::get('shipping/list','Admin\ShippingController@list')->name('admin.shipping.list');

      //配送方式添加.
      Route::get('shipping/add','Admin\ShippingController@add')->name('admin.shipping.add');

      //配送方式执行添加.
      Route::post('shipping/store','Admin\ShippingController@store')->name('admin.shipping.store');

      //配送方式删除.
      Route::get('shipping/del/{id}','Admin\ShippingController@del')->name('admin.shipping.del');

       /*############[地区相关]#############*/
     //列表页面
     Route::get('region/list/{fid?}','Admin\RegionController@list')->name('admin.region.list');

      //添加页面
     Route::get('region/add','Admin\RegionController@add')->name('admin.region.add');

      //执行添加页面
     Route::post('region/store','Admin\RegionController@store')->name('admin.region.store');

     //删除
     Route::get('region/del/{id}','Admin\RegionController@del')->name('admin.region.del');

     /*#############################[商品系统管理（支付，配送方式方式）相关]#############################*/

     /*#############################[会员相关]#############################*/
     //会员列表页面
     Route::get('member/list','Admin\MemberController@list')->name('admin.member.list');

      //会员详情
     Route::get('member/detail/{id}','Admin\MemberController@detail')->name('admin.member.detail');

     /*#############################[会员相关]#############################*/

     
     /*#############################[红包相关]#############################*/
     //列表
    Route::get('bonus/list','Admin\BonusController@list')->name('admin.bonus.list');

     //添加页面
    Route::get('bonus/add','Admin\BonusController@addBonus')->name('admin.bonus.add');

     //红包执行
    Route::post('bonus/store','Admin\BonusController@doAddBonus')->name('admin.bonus.store');

    //编辑页面
    Route::get('bonus/edit/{id}','Admin\BonusController@edit')->name('admin.bonus.edit');

     //红包编辑执行
    Route::post('bonus/save','Admin\BonusController@doEdit')->name('admin.bonus.save');

    //删除
    Route::get('bonus/del/{id}','Admin\BonusController@del')->name('admin.bonus.del');

    //发送红包
    Route::get('bonus/send/{bonus_id}','Admin\BonusController@sendBonus')->name('admin.bonus.send');

    //执行发送红包
    Route::post('bonus/doSend','Admin\BonusController@doSendBonus')->name('admin.bonus.doSend');

    //发送红包
    Route::get('/user/bonus/list','Admin\BonusController@userBonusList')->name('admin.user.bonus.list');


      /*#############################[红包相关]#############################*/

      /*#############################[红批次关]#############################*/
      //列表
      Route::get('batch/list','Admin\BatchController@list')->name('admin.batch.list');

      //添加
      Route::get('batch/add','Admin\BatchController@add')->name('admin.batch.add');

      //执行添加
      Route::post('batch/store','Admin\BatchController@store')->name('admin.batch.store');

       //执行批次
      Route::get('batch/do/{id}','Admin\BatchController@doBatch')->name('admin.batch.do');

      /*#############################[红批相关]#############################*/


      /*#############################[订单相关]#############################*/
      //订单列表页面
      Route::get('order/list','Admin\OrderController@list')->name('admin.order.list');

     //订单详情页面
      Route::get('order/detail/{id}','Admin\OrderController@detail')->name('admin.order.detail');

      /*#############################[订单相关]#############################*/

      
});