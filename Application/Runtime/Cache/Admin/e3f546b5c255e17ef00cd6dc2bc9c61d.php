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
<link href="/Public/Front/css/animate.css" rel="stylesheet">
<link href="/Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
<link href="/Public/css/jquery.alerts.css" rel="stylesheet">
  <link href="/Public/Front/js/plugins/layui/css/layui.css" rel="stylesheet">
<script type="text/javascript" src="/Public/js/jquery.js" /></script>
<script type="text/javascript" src="/Public/js/bootstrap.min.js" /></script>
<script type="text/javascript" src="/Public/js/jquery.alerts.js" /></script>
<script type="text/javascript" src="/Public/Front/js/plugins/layui/layui.js" /></script>
<script type="text/javascript" src="/Public/js/tupian.js" /></script>
<script type="text/javascript" src="/Public/Admin/js/usercontrol.js" /></script>
  <script type="text/javascript" src="/Public/laydate/laydate.js" /></script>
<script type="text/javascript" src="/Public/js/zy.js" /></script>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
  <div class="col-sm-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>用户管理</h5>
      </div>
      <div class="ibox-content">
    <blockquote class="layui-elem-quote">
  <form class="form-inline" role="form" action="" method="get" autocomplete="off" id="selectedform">
    <div class="form-group">
      <input type="text" class="form-control" style="width: 130px;" id="usernameidsearch" name="usernameidsearch" placeholder="商户号或用户名" value="<?php echo ($_GET['usernameidsearch']); ?>">
    </div>
    <div class="form-group">通道
      <!--<input type="text" class="form-control" style="width: 130px;" id="td" name="td" placeholder="通道名" value="<?php echo ($_GET['td']); ?>">-->
	<select name='td' id='td' value="<?php echo ($_GET['td']); ?>">
	<option value="1">--</option>
	<?php if(is_array($tdlist)): $i = 0; $__LIST__ = $tdlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["en_payname"]); ?>"><?php echo ($vo["en_payname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
	</select>
    </div>

    <div class="form-group">
	<input type="text" class="form-control" style="width: 130px;" id="sub_mchid" name="sub_mchid" placeholder="子商户号" value="<?php echo ($_GET['sub_mchid']); ?>">
    </div>
    <div class="form-group">
	<input type="text" class="form-control" style="width: 130px;" id="skid" name="skid" placeholder="收款号" value="<?php echo ($_GET['skid']); ?>">

            </div>
    <div class="form-group">
      <input type="text"  id="starttime" name="starttime"  class="form-control laydate-icon zy-searchstr" style="height: 30px;width: 120px;" onclick="laydate({ele:this,max: laydate.now(+1),istoday: true})" value="<?php echo ($_GET['tjdate_ks']); ?>" placeholder="开始日期">
      <input type="text"  id="endtime" name="endtime"  class="form-control laydate-icon zy-searchstr" style="height: 30px;width: 120px;" onclick="laydate({ele:this,max: laydate.now(+1),istoday: true})" value="<?php echo ($_GET['tjdate_js']); ?>" placeholder="结束日期">
    </div>
    <button type="submit" class="layui-btn layui-btn-small"> <span class="glyphicon glyphicon-search"></span> 搜索</button>
    <a href="javascript:;" id="export" class="layui-btn layui-btn-danger layui-btn-small"><span class="glyphicon glyphicon-export"></span> 导出数据</a>
  </form>
    </blockquote>
<blockquote class="layui-elem-quote layui-quote-nm" style="font-size:14px;padding;8px;">成功交易总金额：<span class="label label-info"><?php echo ($money); ?>元</span>  平台流量收入：<span class="label label-info"><?php echo ($traffic); ?>元</span> 总交易笔数：<span class="label label-info"><?php echo ($zsum); ?>笔</span> 成功笔数：<span class="label label-info"><?php echo ($num); ?>笔</span></blockquote>
<div class="table-responsive" style="=margin:0px auto; margin-top:10px;">

  <table class="table table-bordered table-hover table-condensed table-responsive">
    <thead>
      <tr class="titlezhong">
        <td><strong>商户号</strong></td>
	
	<?php if(is_array($tdlist)): $i = 0; $__LIST__ = $tdlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><td><strong><?php echo ($vo["zh_payname"]); ?></strong></td><?php endforeach; endif; else: echo "" ;endif; ?>

      </tr>
    </thead>
    <tbody id="content">
      <?php if(is_array($reslist)): $i = 0; $__LIST__ = $reslist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td style="text-align:center;"><?php echo ($key); ?></td>
	  <?php if(is_array($vo)): $k = 0; $__LIST__ = $vo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($k % 2 );++$k;?><td style="text-align:center;"><?php echo ($vv); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
	
          <td style="text-align:center;">总计</td>
	  
	  <?php if(is_array($tj)): $k = 0; $__LIST__ = $tj;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($k % 2 );++$k;?><td style="text-align:center;"><?php echo ($vv); ?></td><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
      <tr>
        <td colspan="14" style="text-align:center;"><div class="pagex"> <?php echo ($_page); ?></div></td>
      </tr>

  </table>
</div>
      </div>
    </div>
</div>
</div>
</div>
</body>
</html>