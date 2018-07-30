<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>用户基本信息</title>
<link rel="shortcut icon" href="favicon.ico">
<link href="<?php echo ($siteurl); ?>Public/Front/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/animate.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/style.css" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
  <div class="col-sm-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>用户信息修改</h5>
        <div class="ibox-content">
          <p class="text-danger">谨慎修改用户信息，胡乱填写一律禁封账号处理</p>
        </div>
      </div>
    </div>
  </div>
    <div class="col-sm-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>用户信息</h5>
          <div class="ibox-tools"> <a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a> <a class="close-link"> <i class="fa fa-times"></i> </a> </div>
        </div>
        <div class="ibox-content">
		  <form role="form" id="basicinfoform" class="form-horizontal m-t"  method="post" action="<?php echo U("Account/basicinfoedit");?>">
		    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><input type="hidden" name="id" id="id" value="<?php echo ($vo["id"]); ?>">
            <div class="form-group">
              <label class="col-sm-3 control-label">姓名：</label>
              <div class="col-sm-8">
                <input minlength="2" type="text" class="form-control" id="fullname" name="fullname" value="<?php echo ($vo["fullname"]); ?>" placeholder="请输入你身份证上的姓名，输入后不能修改" required="" aria-required="true">
              </div>
            </div>
			<div class="form-group">
              <label class="col-sm-3 control-label">身份证号码：</label>
              <div class="col-sm-8">
                <input minlength="2" type="text" class="form-control" id="sfznumber" name="sfznumber" value="<?php echo ($vo["sfznumber"]); ?>"  placeholder="输入确认后不能修改" required="" aria-required="true">
              </div>
            </div>
			<div class="form-group">
     <label class="col-sm-3 control-label">性别：</label>
	   <div class="col-sm-8">
      <select class="form-control" id="sex" name="sex" >
          <option <?php if($vo['sex']): ?>selected<?php endif; ?> value="1">男</option>
        <option value="0" <?php if(!$vo['sex']): ?>selected<?php endif; ?>>女</option>
      </select>
	  </div>
    </div>
	 					
	   <div class="form-group">
     <label class="col-sm-3 control-label">生日：</label>
      <div class="col-sm-8">
		<input class="form-control" type="text"  id="birthday" name="birthday"  value="<?php echo date("Y-m-d",strtotime($vo["birthday"]));?>" onclick="layui.laydate({elem: this, festival: true})">
		</div>
    </div>
         	<div class="form-group">
              <label class="col-sm-3 control-label">手机号码：</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="phonenumber" name="phonenumber" value="<?php echo ($vo["phonenumber"]); ?>"  placeholder="手机号">
              </div>
            </div>
			   <div class="form-group">
      <label class="col-sm-3 control-label">QQ号码：</label>
       <div class="col-sm-8">
	    <input type="text"  class="form-control" id="qqnumber" name="qqnumber" value="<?php echo ($vo["qqnumber"]); ?>"  placeholder="qq号码">
		</div>
    </div>
            
			 <div class="form-group">
       <label class="col-sm-3 control-label">联系地址：</label>
      <div class="col-sm-8">
	   <input type="text" class="form-control" id="address" name="address" value="<?php echo ($vo["address"]); ?>"  placeholder="">
	   </div>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
            <div class="form-group">
              <div class="col-sm-4 col-sm-offset-3">
                <button type="button" id="loading-example-btn" data-loading-text="正在处理..." class="btn btn-info" data-target="#myModal" onclick="javascript:basicinfosubmit(this)">确认修改</button>
              </div>
            </div>
          </form>
        </div>
      </div>
   
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-describedby="tscontent">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-volume-up"></span></h4>
      </div>
      <div class="modal-body" id="tscontent" style="color:#000; font-family:'微软雅黑';"> </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"> 关闭 </button>
      </div>
    </div>
  </div>
</div>
<!-- 全局js -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/jquery.min.js?v=2.1.4"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/bootstrap.min.js?v=3.3.6"></script>
<!-- 自定义js -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/content.js?v=1.0.0"></script>
<!-- jQuery Validation plugin javascript-->
<script src="<?php echo ($siteurl); ?>Public/Front/js/plugins/validate/jquery.validate.min.js"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/plugins/validate/messages_zh.min.js"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/demo/form-validate-demo.js"></script>
 <script src="<?php echo ($siteurl); ?>Public/Front/js/plugins/layui/layui.js"></script>
 <script src="<?php echo ($siteurl); ?>Public/Front/js/user.js"></script>
    <script>
        layui.use('laydate', function() {
            var laydate = layui.laydate;
        });
    </script>

<?php echo tongji(0);?>
</body>
</html>