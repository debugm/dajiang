<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<link rel="shortcut icon" href="favicon.ico">
<link href="<?php echo ($siteurl); ?>Public/Front/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/font-awesome.css?v=4.4.0" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/animate.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/css/jquery.alerts.css" rel="stylesheet"/>
  <script src="<?php echo ($siteurl); ?>Public/Front/js/jquery.min.js"></script>
</head>
 
<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="row animated fadeInRight">
    <div class="col-sm-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>资金变动记录</h5>
        </div>
        <div class="ibox-content">
  <form class="form-inline" role="form" method="get" autocomplete="off" id="form">
     <div class="form-group">
      <input type="text" style="width:180px;" class="form-control zy-searchstr" id="orderid" name="orderid" placeholder="请输入订单号" value="<?php echo ($_GET['orderid']); ?>">
    </div>
    <div class="form-group">
      <select class="form-control zy-searchstr" id="tongdao" name="tongdao">
        <option value="" style="font-weight:bold;">全部通道</option>
        <?php if(is_array($tongdaolist)): $i = 0; $__LIST__ = $tongdaolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["en_payname"]); ?>"><?php echo ($vo["zh_payname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
      </select>
      <script type="text/javascript">
	  $("#tongdao").val('<?php echo ($_GET['tongdao']); ?>');
	  </script> 
    </div>
   <div class="form-group">
      <select class="form-control zy-searchstr" id="bank" name="bank">
        <option value="">全部类型</option>
        <option value="1">付款</option>
        <option value="3">手动增加</option>
        <option value="4">手动减少</option>
        <option value="6">结算</option>
        <option value="7">冻结</option>
        <option value="8">解冻</option>
        <option value="9">提成</option>
      </select>
      <script type="text/javascript">
	   $("#bank").val('<?php echo ($_GET['bank']); ?>');
	  </script> 
    </div>
   
   	<div class="form-group">
     变动时间：
    </div>
    <div class="form-group">
      <input type="text"  id="tjdate_ks" name="tjdate_ks"  class="form-control laydate-icon zy-searchstr" onclick="laydate()" style="height: 30px; width:120px;" value="<?php echo ($_GET['tjdate_ks']); ?>">
    </div>
    <div class="form-group">
     至
    </div>
    <div class="form-group">
     <input type="text"  id="tjdate_js" name="tjdate_js"  class="form-control laydate-icon zy-searchstr" onclick="laydate()" style="height: 30px; width:120px;" value="<?php echo ($_GET['tjdate_js']); ?>">
    </div>
    <div class="form-group">
    <button type="button" class="btn btn-primary zy-searchbutton" id="ptshsearch"> <span class="glyphicon glyphicon-search"></span> 搜索 </button>
    </div>
    
  </form>

<div class="table-responsive" style="margin-top:10px;">
  <table class="table table-bordered table-hover table-condensed table-responsive">
    <thead>
      <tr class="titlezhong">
        <td><strong>用户名</strong></td>
        <td><strong>类型</strong></td>
        <td><strong>提成用户名</strong></td>
        <td><strong>提成级别</strong></td>
        <td><strong>原金额</strong></td>
        <td><strong>变动金额</strong></td>
        <td><strong>变动后金额</strong></td>
        <td><strong>变动时间</strong></td>
        <td><strong>通道</strong></td>
        <td><strong>订单号</strong></td>
        <td><strong>备注</strong></td>
      </tr>
    </thead>
    <tbody style="background-color: #fff;">
      <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td style="text-align:center; color:#090;">
          <?php echo sjusername($vo["userid"],1);?>
          </td>
          <td style="text-align:center;">
          <?php switch($vo["lx"]): case "1": ?>付款<?php break;?>
                <?php case "3": ?>手动增加<?php break;?>
                <?php case "4": ?>手动减少<?php break;?>
                <?php case "6": ?>结算<?php break;?>
                <?php case "7": ?>冻结<?php break;?>
                <?php case "8": ?>解冻<?php break;?>
                <?php case "9": ?>提成<?php break;?>
                <?php default: ?>未知<?php endswitch;?>
          </td>
          <td style="text-align:center; color:#060">
          <?php echo sjusername($vo["tcuserid"],1);?>
          </td>
          <td style="text-align:center; color:#666"><?php echo ($vo["tcdengji"]); ?>&nbsp;</td>
          <td style="text-align:center; color:#030"><?php echo ($vo["ymoney"]); ?></td>
          <td style="text-align:center;">
          
          <?php if($vo["money"] < 0): ?><span style="color:#F00">
          <?php else: ?>
          <span style="color:#030"><?php endif; ?>
          <?php echo ($vo["money"]); ?>
          </span>
          </td>
          <td style="text-align:center; font-weight:bold; color:#060;"><?php echo ($vo["gmoney"]); ?></td>
          <td style="text-align:center;"><?php echo ($vo["datetime"]); ?></td>
          <td style="text-align:center;"><?php echo huoqutongdaoname($vo["tongdao"]);?></td>
          <td style="text-align:center;"><?php echo ($vo["transid"]); ?></td>
          <td style="text-align:center;">
           <?php if($vo["lx"] == 1 or $vo["lx"] == 9): echo huoquddlx($vo.transid);?>
          <?php else: ?>
          <?php echo ($vo['contentstr']); endif; ?>
          
          </td
        ></tr><?php endforeach; endif; else: echo "" ;endif; ?>
      <tr>
        <td colspan="14" style="text-align:center;"><div class="pagex"> <?php echo ($_page); ?></div></td>
      </tr>
    </tbody>
  </table>
</div>

</div>
</div>
    </div>
</div>
</div>
<!-- 全局js -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/bootstrap.min.js"></script>
<script src="<?php echo ($siteurl); ?>Public/js/jquery.alerts.js"></script>
<script src="<?php echo ($siteurl); ?>Public/laydate/laydate.js"></script>
<script src="<?php echo ($siteurl); ?>Public/Admin/js/dealrecord.js"></script>
<script src="<?php echo ($siteurl); ?>Public/js/zy.js"></script>
<?php echo tongji(0);?>
</body>
</html>