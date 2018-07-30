<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="renderer" content="webkit">
<title><{:C("WEB_TITLE")}></title>
<link rel="shortcut icon" href="favicon.ico">
<link href="/Public/Front/css/bootstrap.min.css" rel="stylesheet">
<link href="/Public/Front/css/font-awesome.min.css" rel="stylesheet">
<link href="/Public/Front/css/style.css" rel="stylesheet">
<link href="/Public/css/jquery.alerts.css" rel="stylesheet">
  <link href="/Public/Front/js/plugins/layui/css/layui.css" rel="stylesheet">
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/js/jquery.alerts.js"></script>
<script type="text/javascript" src="/Public/laydate/laydate.js"></script>
<script type="text/javascript" src="/Public/Admin/js/dealrecord.js"></script>
<script type="text/javascript" src="/Public/js/zy.js"></script>
  <style>
    .form-inline .form-group { margin-bottom: 5px;}
    .laydate-icon, .laydate-icon-default, .laydate-icon-danlan, .laydate-icon-dahong, .laydate-icon-molv {padding-right:0px;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {padding:4px 2px;}
  </style>
</head>
 <body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
  <div class="col-sm-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>微信个人码订单统计</h5>
      </div>
      <div class="ibox-content">
  <form class="form-inline" role="form" action="" method="get" autocomplete="off" id="orderform">
    <div class="form-group">
      <input type="text" class="form-control zy-searchstr" id="wxname" name="wxname" placeholder="请输入微信号" value="<{$Think.get.wxname}>">
    </div>
    <div class="form-group">
      <input type="text" class="form-control zy-searchstr" id="uid" name="uid" placeholder="请输入用户号" value="">
    </div>
     <div class="form-group">
      <input type="text" class="form-control zy-searchstr" id="orderid" name="orderid" placeholder="请输入订单号" value="<{$Think.get.orderid}>">
    </div>
    <div class="form-group">
      <select class="form-control zy-searchstr" id="status" name="status">
        <option value="">全部状态</option>
        <option value="0">等待支付</option>
        <option value="1">支付成功</option>
        <option value="2">订单超时</option>
      </select>
      <script type="text/javascript">
	  $("#status").val('<{$Think.get.status}>');
	  </script> 
    </div>
    <div class="form-group">
      <input type="text"  id="tjdateks" name="tjdateks"  class="form-control laydate-icon zy-searchstr" style="height: 30px;" onclick="laydate({ele:this,min: laydate.now(-30), max: laydate.now(+1),istime: true,
      istoday: true,format: 'YYYY-MM-DD hh:mm:ss'})" value="<{$Think.get.tjdate_ks}>" placeholder="提交起始日">
     <input type="text"  id="tjdatejs" name="tjdatejs"  class="form-control laydate-icon zy-searchstr" style="height: 30px;" onclick="laydate({ele:this,min: laydate.now(-30), max: laydate.now(+1),istime: true,
     istoday: true,format: 'YYYY-MM-DD hh:mm:ss'})" value="<{$Think.get.tjdate_js}>" placeholder="提交截止日">
    </div>
    <div class="form-group">
      <input type="text"  id="cgdateks" name="cgdateks"  class="form-control laydate-icon zy-searchstr" style="height: 30px;" onclick="laydate({ele:this,min: laydate.now(-30), max: laydate.now(+1),istime: true,
      istoday: true,format: 'YYYY-MM-DD hh:mm:ss'})" value="<{$Think.get.cgdate_ks}>" placeholder="成功起始日">
     <input type="text"  id="cgdatejs" name="cgdatejs"  class="form-control laydate-icon zy-searchstr" onclick="laydate({ele:this,min: laydate.now(-30), max: laydate.now(+1),istime: true,
     istoday: true,format: 'YYYY-MM-DD hh:mm:ss'})" style="height: 30px;" value="<{$Think.get.cgdate_js}>"  placeholder="成功截止日">
    </div>
    <div class="form-group">
      <button type="submit" class="layui-btn layui-btn-small" id="ptshsearch"> <span class="glyphicon glyphicon-search"></span> 搜索 </button>
    </div>
  </form>

    <div class="table-responsive">
  <table class="table table-bordered table-hover table-condensed table-responsive">
    <thead>
      <tr class="titlezhong">
      	<th>&nbsp;</th>
        <th>订单号</th>
        <th>商户编号</th>
        <th>微信号</th>
        <th>交易金额</th>
        <th>提交时间</th>
        <th>成功时间</th>
        <th>状态</th>
      </tr>
    </thead>
    <tbody>
      <volist name="list" id="vo">
        <tr>
          <td style="text-align: center; vertical-align: middle;"><{$key+1}></td>
          <td style="text-align:center; color:#090;"><{$vo.oid}>
          </td>
          <td style="text-align:center;"><{$vo.userid}></td>
          <td style="text-align:center; color:#060"><{$vo.wxname}></td>
          <td style="text-align:center; color:#666"><{$vo.fee}></td>
          <td style="text-align:center;"><{$vo.oidtime|date='Y-m-d H:i:s',###}></td>
          <td style="text-align:center;"><{$vo.paytime|date='Y-m-d H:i:s',###}></td>
          <td style="text-align:center; color:#369"><{$vo['status']|grmstatus=###}></td>
        </tr>
      </volist>
      <tr>
        <td colspan="15" style="text-align:center;"><div class="pagex"> <{$_page}></div></td>
      </tr>
    </tbody>
  </table>
</div>
  </div></div>
</div>
</div>
</div>
<include file="dealrecordlModal" />
<script>
    $('#export').on('click',function(){
        $('#orderform').attr('action',"<{:U('Admin/Dealmanages/exportorder')}>");
        $('#orderform').submit();
    });
</script>
<{:tongji(0)}>
</body>
</html>
