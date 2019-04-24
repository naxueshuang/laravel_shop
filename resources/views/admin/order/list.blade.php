@extends('common.admin_base')

@section('title','管理后台订单列表')


<!--页面顶部信息-->
@section('pageHeader')
    <div class="pageheader">
        <h2><i class="fa fa-home"></i> 订单列表 <span>Subtitle goes here...</span></h2>
    </div>
@endsection

@section('content')

    <div class="row" id="goods_list">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-primary  mb30">
                    <thead>
                    <tr>
                        <th>订单号</th>
                        <th>下单时间</th>
                        <th>收货人信息</th>
                        <th>支付金额</th>
                        <th>已支付的金额</th>
                        <th>使用红包金额</th>
                        <th>支付时间</th>
                        <th>订单状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(!empty($order_list))
                        @foreach($order_list as $order)
                            <tr>
                                <td>{{$order->order_sn}}</td>
                                <td>{{$order->created_at}}</td>
                                <td>{{$order->consignee}}</td>
                                <td>{{$order->pay_price}}</td>
                                <td>{{$order->paid_price}}</td>
                                <td>{{$order->bonus_price}}</td>
                                <td>{{$order->pay_time}}</td>
                                <td>
                                    @if($order->order_status == 1)
                                        未确认
                                    @elseif($order->order_status == 2)
                                        已确认
                                    @elseif($order->order_status == 3)
                                        取消
                                    @else
                                        退货
                                    @endif
                                    &nbsp;
                                    @if($order->shipping_status == 1)
                                        待发货
                                    @elseif($order->shipping_status == 2)
                                        已发货
                                    @elseif($order->shipping_status == 3)
                                        未发货
                                    @else
                                        退货
                                    @endif
                                    &nbsp;
                                    @if($order->pay_status == 1)
                                        未支付
                                    @elseif($order->pay_status == 2)
                                        已支付
                                    @else
                                        支付成功
                                    @endif

                                </td>
                                <td>
                                    <a class="btn btn-sm btn-success" href="/admin/order/detail/{{$order->id}}">详情</a>
                                    <!-- <a class="btn btn-sm btn-danger" href="/admin/order/del">删除</a> -->
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                {{$order_list->links()}}
            </div><!-- table-responsive -->
        </div>
    </div>
    <script src="/js/vue.js"></script>
    <script type="text/javascript">
        var goods_list = new Vue({
            el: "#goods_list",
            delimiters: ['{','}'],
            data: {
                goods_list: [],
            },
            //构造函数
            created:function(){

            },
            methods: {
                //商品列表
                getGoodsList: function(){
                    var that = this;

                    $.ajax({
                        url: "/goods/get/data",
                        type: "post",
                        data: {_token: $("input[name=_token"]).val()},
                        dataType:"json",
                        success: function(res){

                        }
                    })
                },
                //修改商品属性
                changeAttr: function(id,key,val){
                    var that = this;

                    $.ajax({
                        url: "/goods/change/attr",
                        type: "post",
                        data: {_token: $("input[name=_token"]).val()},
                        dataType:"json",
                        success: function(res){

                        }
                    })
                },
                //执行删除的操作
                goodsDel:function(id){
                    var that = this;

                    $.ajax({
                        url: "/goods/del/"+id,
                        type: "post",
                        data: {_token: $("input[name=_token"]).val()},
                        dataType:"json",
                        success: function(res){

                        }
                    })
                }
            }
        })
    </script>
@endsection