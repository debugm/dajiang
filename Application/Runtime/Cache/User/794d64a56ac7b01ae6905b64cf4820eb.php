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
<script src="<?php echo ($siteurl); ?>Public/js/jquery.js" /></script>
<script src="<?php echo ($siteurl); ?>Public/js/bootstrap.min.js" /></script>
<script src="<?php echo ($siteurl); ?>Public/User/js/tongdao.js" /></script>
</head>
 
 <body class="gray-bg">
<div class="wrapper wrapper-content">
  <div class="row animated fadeInRight">
    <div class="col-sm-12">
      <div class="ibox">
   <div class="ibox-content">
 <input type="hidden" id="tksxfajaxurl" value="<?php echo U("Tongdao/tksz");?>">
 <div class="row">
<?php if(is_array($tongdaolist)): $i = 0; $__LIST__ = $tongdaolist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="col-sm-4">
<div class="Payaccessdiv" id="tikuanmoney">
<ul class="list-group">
  <li class="list-group-item text-center">【<span><?php echo ($vo["zh_payname"]); ?></span>】<strong>提款手续费</strong></li>
  <li class="list-group-item" style="text-align:center;">
     <form role="form" id="form<?php echo ($vo["id"]); ?>">
    
    <?php $__FOR_START_1123224668__=0;$__FOR_END_1123224668__=2;for($i=$__FOR_START_1123224668__;$i < $__FOR_END_1123224668__;$i+=1){ ?><div class="tikuandiv">
    <a class="list-group-item" style="font-size:13px;"><strong>T+<sapn style="color:#F00"><?php echo ($i); ?></span></strong>&nbsp;&nbsp;(<span>白天</span>)</a>
    <div class="input-group">
      <div class="input-group-addon"><?php echo huoqutktype();?></div>
      <input class="form-control" type="text" disabled="disabled" style="font-size:15px; font-weight:bold" onkeyup="clearNoNum(this)" id="t<?php echo ($i); ?>b" name="t<?php echo ($i); ?>b">
    </div>
    </div>
    
    <div class="tikuandiv">
    <a class="list-group-item" style="font-size:13px;"><strong>T+<sapn style="color:#F00"><?php echo ($i); ?></span></strong>&nbsp;&nbsp;(<span>晚间</span>)</a>
    <div class="input-group">
      <div class="input-group-addon"><?php echo huoqutktype();?></div>
      <input class="form-control" type="text" disabled="disabled" style="font-size:15px; font-weight:bold"  onkeyup="clearNoNum(this)" id="t<?php echo ($i); ?>w" name="t<?php echo ($i); ?>w">
    </div>
    </div>
    
    <div class="tikuandiv">
    <a class="list-group-item" style="font-size:13px;"><strong>T+<sapn style="color:#F00"><?php echo ($i); ?></span></strong>&nbsp;&nbsp;(<span>节假日</span>)</a>
    <div class="input-group">
      <div class="input-group-addon"><?php echo huoqutktype();?></div>
      <input class="form-control" type="text" disabled="disabled" style="font-size:15px; font-weight:bold"  onkeyup="clearNoNum(this)" id="t<?php echo ($i); ?>j" name="t<?php echo ($i); ?>j">
    </div>
    </div><?php } ?>
   
     </form>
 
  </li>
</ul>
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