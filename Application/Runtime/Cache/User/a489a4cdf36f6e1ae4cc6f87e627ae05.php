<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<link rel="shortcut icon" href="favicon.ico">
<link href="<?php echo ($siteurl); ?>Public/Front/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/font-awesome.css?v=4.4.0" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/animate.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
 <link href="<?php echo ($siteurl); ?>Public/css/jquery.alerts.css" rel="stylesheet">
<script src="<?php echo ($siteurl); ?>Public/js/jquery.js" /></script>
<script src="<?php echo ($siteurl); ?>Public/js/bootstrap.min.js" /></script>
<script src="<?php echo ($siteurl); ?>Public/js/jquery.alerts.js" /></script>
<script src="<?php echo ($siteurl); ?>Public/User/js/tongdao.js" /></script>
</head>

<body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="row animated fadeInRight">
    <div class="col-sm-12">
      <div class="ibox">
   <div class="ibox-content">
 
<input type="hidden" id="defaultpayapi" value="<?php echo ($defaultpayapi); ?>">
<input type="hidden" id="ajaxurl" value="<?php echo U("Tongdao/editwdtongdao");?>">
<div id="tongdaoczsxfcontent">
	<?php if(is_array($tongdaosxf)): $i = 0; $__LIST__ = $tongdaosxf;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="forum-item">
     <div class="row">
	  <div class="col-sm-2">
    <button class="btn btn-primary buttontongdao" id="<?php echo ($vo["en_payname"]); ?>"><?php echo ($vo["zh_payname"]); ?> </button> 
	</div>
	  <div class="col-sm-2 forum-info">
	<span> 费率：<?php echo realityfeilv($vo["id"],$vo["userid"],$vo["feilv"],$vo["defaultpayapiuserid"]);?></span> </div>
	 <div class="col-sm-2 forum-info">
    <span>封顶手续费：<?php echo realityfengding($vo["id"],$vo["userid"],$vo["fengding"],$vo["defaultpayapiuserid"]);?>元 </span>
	</div>
	 </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</div>
</div>
</div>
</div>
</div>
<?php echo tongji(0);?>
</body>
</html>