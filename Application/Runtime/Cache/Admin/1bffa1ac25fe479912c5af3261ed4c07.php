<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="renderer" content="webkit">
<title><?php echo C("WEB_TITLE");?></title>
<link rel="shortcut icon" href="favicon.ico">
<link href="/Public/Front/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="/Public/Front/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
<link href="/Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
<link href="/Public/css/jquery.alerts.css" rel="stylesheet">
    <link href="/Public/Front/js/plugins/layui/css/layui.css" rel="stylesheet">
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/js/jquery.alerts.js"></script>
<script type="text/javascript" src="/Public/laydate/laydate.js"></script>
<script type="text/javascript" src="/Public/Admin/js/tklist.js"></script>
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
              <h5>委托提款记录</h5>
          </div>
          <div class="ibox-content">
<div style="margin:0px auto;">
  <form class="form-inline" role="form" action="" method="get" autocomplete="off" id="orderform">
    <div class="form-group">
      <input type="text" class="form-control" style="width:90px;" id="memberid" name="memberid" placeholder="商户号" value="<?php echo ($_GET['memberid']); ?>">
    </div>
    
    <div class="form-group">
      <select class="form-control" id="tongdao" name="tongdao">
        <option value="">全部通道</option>
        <?php if(is_array($tongdaolist)): $i = 0; $__LIST__ = $tongdaolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["zh_payname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
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
      <select class="form-control zy-searchstr" id="T" name="T">
       <option value="">全部类型</option>
        <option value="0">T + 0</option>
        <option value="1">T + 1</option>
      </select>
      <script type="text/javascript">
	   $("#T").val('<?php echo ($_GET['T']); ?>');
	  </script> 
    </div>
    <div class="form-group">
      <select class="form-control zy-searchstr" id="status" name="status">
        <option value="">全部状态</option>
        <option value="0">未处理</option>
        <option value="1">处理中</option>
        <option value="2">已打款</option>
      </select>
      <script type="text/javascript">
	  $("#status").val('<?php echo ($_GET['status']); ?>');
	  </script> 
    </div>
    <div class="form-group">
      <input type="text"  id="tjdate_ks" name="tjdate_ks"  class="form-control laydate-icon" placeholder="申请起始日" onclick="laydate({ele:this,max: laydate.now(+1),istime: false,
      istoday: true,format: 'YYYY-MM-DD'})" style="height: 30px; width:120px;" value="<?php echo ($_GET['tjdate_ks']); ?>">
    </div>
    <div class="form-group">
     <input type="text"  id="tjdate_js" name="tjdate_js"  class="form-control laydate-icon" placeholder="申请截止日" onclick="laydate({ele:this,max: laydate.now(+1),istime: false,
     istoday: true,format: 'YYYY-MM-DD'})" style="height: 30px; width:120px;" value="<?php echo ($_GET['tjdate_js']); ?>">
    </div>
    <div class="form-group">
      <input type="text"  id="cgdate_ks" name="cgdate_ks"  class="form-control laydate-icon" placeholder="打款起始日" onclick="laydate({ele:this,max: laydate.now(+1),istime: false,
      istoday: true,format: 'YYYY-MM-DD'})" style=" height: 30px; width:120px;" value="<?php echo ($_GET['cgdate_ks']); ?>">
    </div>
    <div class="form-group">
     <input type="text"  id="cgdate_js" name="cgdate_js"  class="form-control laydate-icon" placeholder="打款截止日" onclick="laydate({ele:this,max: laydate.now(+1),istime: false,
     istoday: true,format: 'YYYY-MM-DD'})" style=" height: 30px; width:120px;" value="<?php echo ($_GET['cgdate_js']); ?>">
    </div>
      <div class="form-group">
          <button type="submit" class="layui-btn layui-btn-small" id="ptshsearch"> <span class="glyphicon glyphicon-search"></span> 搜索</button>
          <button class="layui-btn layui-btn-danger layui-btn-small" id="export" type="button"><span class="glyphicon glyphicon-export"></span> 导出数据 </button>
      </div>
  </form>
</div>

<div class="table-responsive" style="margin:0px auto; margin-top:10px;">
  <table class="table table-bordered table-hover table-condensed table-responsive">
    <thead>
      <tr class="titlezhong">
        <th style="width:48px;"><strong><input type="checkbox" id="checkAll"></strong></th>
        <th>类型</th>
        <th>通道</th>
        <th>商户编号</th>
        <th>结算金额</th>
        <th>手续费</th>
        <th>到账金额</th>
        <th>银行名称</th>
        <th>支行名称</th>
        <th>银行卡号/开户名</th>
        <th>开户省</th>
        <th>开户市</th>
        <th>申请时间</th>
        <th>处理时间</th>
        <th>状态</th>
        <th>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td style="text-align:center; color:#090;">
          	<input type="checkbox" name="subBox" value="<?php echo ($vo["id"]); ?>">
          </td>
          <td style="text-align: center; vertical-align: middle; font-weight:bold;">T+<?php echo ($vo["t"]); ?></td>
          <td style="text-align: center; ">
          <?php echo huoqutongdaoname($vo["payapiid"]);?>
          </td>
          <td style="text-align:center;"><?php echo ($vo["userid"]+10000); ?></td>
          <td style="text-align:center; color:#060"><?php echo ($vo["tkmoney"]); ?> 元</td>
          <td style="text-align:center; color:#666"><?php echo ($vo["sxfmoney"]); ?> 元</td>
          <td style="text-align:center; color:#C00"><?php echo ($vo["money"]); ?> 元</td>
          <td style="text-align:center;"><?php echo ($vo["bankname"]); ?></td>
          <td style="text-align:center;"><?php echo ($vo["bankzhiname"]); ?></td>
          <td style="text-align:center;"><?php echo ($vo["banknumber"]); ?> <br> <?php echo ($vo["bankfullname"]); ?></td>
          <td style="text-align:center;"><?php echo ($vo["sheng"]); ?></td>
          <td style="text-align:center; "><?php echo ($vo["shi"]); ?></td>
          <td style="text-align:center;"><?php echo ($vo["sqdatetime"]); ?></td>
          <td style="text-align:center;"><?php echo ($vo["cldatetime"]); ?></td>
          <td style="text-align:center;">
          <?php switch($vo["status"]): case "0": ?><span style="color:#F00;">未处理</span><?php break;?>
            <?php case "1": ?><span style="color:#06F;">处理中</span><?php break;?>
            <?php case "2": ?><span style="color:#060;">已打款</span><?php break;?>
            <?php default: endswitch;?>
          </td>
          <td style="text-align:center;">
          <div class="btn-group pull-right">
  <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown">
    操作 <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">
   <?php switch($vo["status"]): case "0": ?><li><a href="javascript:editstatus(<?php echo ($vo["id"]); ?>,1,'<?php echo U("Tikuan/Editstatuswt");?>');">变更为处理中</a></li>
                <li class="divider"></li>
                <li><a href="javascript:editstatus(<?php echo ($vo["id"]); ?>,2,'<?php echo U("Tikuan/Editstatuswt");?>');">变更为已处理</a></li>
                <li class="divider"></li>
                <li style="display:none;"><a href="javascript:editstatus('<?php echo ($vo["orderid"]); ?>')">取消结算</a></li>
                <li class="divider" style="display:none;"></li><?php break;?>
            <?php case "1": ?><li><a href="javascript:editstatus(<?php echo ($vo["id"]); ?>,0,'<?php echo U("Tikuan/Editstatuswt");?>');">变更为未处理</a></li>
                <li class="divider"></li>
                <li><a href="javascript:editstatus(<?php echo ($vo["id"]); ?>,2,'<?php echo U("Tikuan/Editstatuswt");?>');">变更为已处理</a></li>
                <li class="divider"></li>
                <li style="display:none;"><a href="javascript:editstatus('<?php echo ($vo["orderid"]); ?>')">取消结算</a></li>
                <li class="divider" style="display:none;"></li><?php break;?>
            <?php case "2": ?>已打款状态不能修改<?php break;?>
            <?php default: endswitch;?>
    
     
  </ul>
</div>
          </td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      <tr>
        <td colspan="18" style="text-align:center;"><div class="pagex"> <?php echo ($_page); ?></div></td>
      </tr>
    </tbody>
  </table>
</div>
</div>
</div></div>
</div>
</div>

<script>
$('#export').on('click',function(){
    $('#orderform').attr('action',"<?php echo U('Admin/Tikuan/exportweituo');?>");
    $('#orderform').submit();
});
</script>
<?php echo tongji(0);?>
</body>
</html>