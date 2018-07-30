<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<link rel="shortcut icon" href="favicon.ico">
<link href="<?php echo ($siteurl); ?>Public/Front/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/animate.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/style.css" rel="stylesheet">
    <link href="/Public/Front/js/plugins/layui/css/layui.css" rel="stylesheet">
 <link href="<?php echo ($siteurl); ?>Public/css/jquery.alerts.css" rel="stylesheet">
 <script src="<?php echo ($siteurl); ?>Public/js/jquery.js"></script>
<script src="<?php echo ($siteurl); ?>Public/js/bootstrap.min.js"></script>
 <script src="<?php echo ($siteurl); ?>Public/js/jquery.alerts.js"></script>
<script src="<?php echo ($siteurl); ?>Public/laydate/laydate.js"></script>
<script src="<?php echo ($siteurl); ?>Public/js/zy.js"></script>
    <style>
        .form-inline .form-group { margin-bottom: 5px;}
        .laydate-icon, .laydate-icon-default, .laydate-icon-danlan, .laydate-icon-dahong, .laydate-icon-molv {padding-right:0px;}
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {padding:4px 2px;}
    </style>
</head>
 <body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="row animated fadeInRight">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>交易记录</h5>
            </div>
            <div class="ibox-content">
                <div class="margin-top:10px;">
 <form class="form-inline" role="form" method="get" autocomplete="off">
     <div class="form-group">
      <input type="text" style="width:150px;" class="form-control zy-searchstr" id="orderid" name="orderid" placeholder="请输入订单号" value="<?php echo ($_GET['orderid']); ?>">
    </div>
    <div class="form-group">
      <select class="form-control zy-searchstr" id="tongdao" name="tongdao">
        <option value="">全部通道</option>
        <?php if(is_array($tongdaolist)): $i = 0; $__LIST__ = $tongdaolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["en_payname"]); ?>"><?php echo ($vo["zh_payname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
      </select>
      <script type="text/javascript">
	  $("#tongdao").val('<?php echo ($_GET['tongdao']); ?>');
	  </script>
    </div>
    <div class="form-group">
      <select class="form-control zy-searchstr" id="bank" name="bank">
        <option value="">全部银行</option>
        <?php if(is_array($banklist)): $i = 0; $__LIST__ = $banklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["bankname"]); ?>"><?php echo ($vo["bankname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
      </select>
      <script type="text/javascript">
	   $("#bank").val('<?php echo ($_GET['bank']); ?>');
	  </script>
    </div>
    <div class="form-group">
      <select class="form-control zy-searchstr" id="status" name="status">
        <option value="">全部状态</option>
        <option value="0">未处理</option>
        <option value="1">成功，未返回</option>
        <option value="2">成功，已返回</option>
      </select>
      <script type="text/javascript">
	  $("#status").val('<?php echo ($_GET['status']); ?>');
	  </script>
    </div>
    <div class="form-group">
      <select class="form-control zy-searchstr" id="ddlx" name="ddlx">
        <option value="">所有订单类型</option>
        <option value="0">收款订单</option>
        <option value="1">充值订单</option>
      </select>
      <script type="text/javascript">
	  $("#ddlx").val('<?php echo ($_GET['ddlx']); ?>');
	  </script>
    </div>

    <div class="form-group">
      <input type="text"  id="tjdate_ks" name="tjdate_ks" placeholder="提交起始日"  class="form-control laydate-icon zy-searchstr" onclick="laydate()" style="height: 30px; width:120px;" value="<?php echo ($_GET['tjdate_ks']); ?>">
    </div>
    <div class="form-group">
     <input type="text"  id="tjdate_js" name="tjdate_js" placeholder="提交截止日"  class="form-control laydate-icon zy-searchstr" onclick="laydate()" style="height: 30px; width:120px;" value="<?php echo ($_GET['tjdate_js']); ?>">
    </div>
    <div class="form-group">
      <input type="text"  id="cgdate_ks" name="cgdate_ks" placeholder="成功起始日" class="form-control laydate-icon zy-searchstr" onclick="laydate()" style="height: 30px; width:120px;" value="<?php echo ($_GET['cgdate_ks']); ?>">
    </div>
    <div class="form-group">
     <input type="text"  id="cgdate_js" name="cgdate_js" placeholder="成功截止日" class="form-control laydate-icon zy-searchstr" onclick="laydate()" style="height: 30px; width:120px;" value="<?php echo ($_GET['cgdate_js']); ?>">
    </div>
      <div class="form-group">
        <button type="submit" class="layui-btn layui-btn-small"> <span class="glyphicon glyphicon-search"></span>搜索</button>
      </div>
  </form>
</div>
<div class="table-responsive" style="margin:0px auto; margin-top:10px;">
  <table class="table table-bordered table-hover table-condensed table-responsive">
    <thead>
      <tr class="titlezhong">
        <td><strong>订单类型</strong></td>
        <td><strong>订单号</strong></td>
        <td><strong>商户编号</strong></td>
        <td><strong>交易金额</strong></td>
        <td><strong>手续费</strong></td>
        <td><strong>扣除流量</strong></td>
        <td><strong>实际金额</strong></td>
        <td><strong>提交时间</strong></td>
        <td><strong>成功时间</strong></td>
        <td><strong>通道</strong></td>
        <td><strong>银行</strong></td>
        <td><strong>来源地址</strong></td>
        <td><strong>状态</strong></td>
        <td><strong>查看</strong></td>
      </tr>
    </thead>
    <tbody style="background-color:#FFF">
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
         <td style="text-align: center; vertical-align: middle;">
            <?php if($vo["ddlx"] == 1): ?><span style="color:#060">充值</span>
            <?php else: ?>
            收款<?php endif; ?>
          </td>
          <td style="text-align:center; color:#090;"><?php echo ($vo["pay_orderid"]); ?></td>
          <td style="text-align:center;"><?php echo ($vo["pay_memberid"]); ?></td>
          <td style="text-align:center; color:#060"><?php echo ($vo["pay_amount"]); ?></td>
          <td style="text-align:center; color:#666"><?php echo ($vo["pay_poundage"]); ?></td>
          <td style="text-align:center; color:#666"><?php echo ($vo["pay_traffic"]); ?></td>
          <td style="text-align:center; color:#C00"><?php echo ($vo["pay_actualamount"]); ?></td>
          <td style="text-align:center;"><?php echo (date('Y-m-d H:i:s',$vo["pay_applydate"])); ?></td><td style="text-align:center;"><?php if($vo[pay_successdate]): echo (date('Y-m-d H:i:s',$vo["pay_successdate"])); else: ?> ---<?php endif; ?></td>
          <td style="text-align:center;"><?php echo ($vo["pay_zh_tongdao"]); ?></td>
          <td style="text-align:center;"><?php echo ($vo["pay_bankname"]); ?></td>
          <td style="text-align:center;"><a href="<?php echo ($vo["pay_tjurl"]); ?>" target="_blank" title="<?php echo ($vo["pay_tjurl"]); ?>">来源</a></td>
          <td style="text-align:center; color:#369"><?php echo (status($vo['pay_status'])); ?></td>
          <td style="text-align:center;">
          	<div class="btn-group">
  <button class="btn btn-info btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
    操作 <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
     <li><a href="javascript:edit('<?php echo ($vo["id"]); ?>')">详细信息</a></li>
    <li class="divider"></li>
    <?php if($vo["pay_status"] == 0): ?><li><a href="javascript:deldel('<?php echo ($vo["id"]); ?>','<?php echo U("Dealmanages/deldel");?>')">删除</a></li>
    <li class="divider"></li><?php endif; ?>
  </ul>
</div>
     </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      <tr>
        <td colspan="14" style="text-align:center;"><div class="pagex"> <?php echo ($_page); ?></div></td>
      </tr>
    </tbody>
  </table>
</div>
<!-- Modal -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-describedby="tscontent" data-backdrop="static" ajaxurl="<?php echo U("Dealmanages/dealload");?>">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close modalgb" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title"> <span>订单号：</span> <span id="orderidModal" style="color:#060;"></span> </h4>
      </div>
      <div class="modal-body" id="dealcontent" style="color:#000; font-family:'微软雅黑';"> 
        <!--------------------------------------------------------------------------------------------------->
        <table class="table table-condensed">
           <tr style="display:none;">
            <td>订单号：<span style="color:#090;"></span></td>
          </tr>
          <tr>
            <td>交易金额：<span style="color:#060; font-weight:bold;"></span> 元</td>
          </tr>
          <tr>
            <td>手续费：<span style="color:#666; font-weight:bold;"></span> 元</td>
          </tr>
          <tr>
            <td>实际金额：<span style="color:#C00; font-weight:bold;"></span> 元</td>
          </tr>
          <tr>
            <td>提交时间：<span style="color:#F00;"></span></td>
          </tr>
          <tr>
            <td>成功时间：<span style="color:#F00;"></span></td>
          </tr>
           <tr>
            <td>交易通道：<span></span></td>
          </tr>
           <tr>
            <td>交易银行：<span></span></td>
          </tr>
          <tr>
            <td>提交地址：<span></span></td>
          </tr>
          <tr>
            <td>页面通知返回地址：<span></span></td>
          </tr>
           <tr>
            <td>服务器点对点返回地址：<span></span></td>
          </tr>
           <tr>
            <td>状态：<span></span>&nbsp;&nbsp;<span></span></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
        <!---------------------------------------------------------------------------------------------------> 
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default modalgb" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

</div>
</div>
</div>
</div>
</div>
<script src="<?php echo ($siteurl); ?>Public/Front/js/user.js"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/content.js"></script>
<?php echo tongji(0);?>
</body>
</html>