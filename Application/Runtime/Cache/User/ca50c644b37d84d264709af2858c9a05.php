<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title></title>
<link href="/Public/Front/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="/Public/Front/css/font-awesome.css?v=4.4.0" rel="stylesheet">
<link href="/Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
<link href="/Public/css/datepicker.css" rel="stylesheet">
  <script src="/Public/js/jquery.js" /></script>
  <script src="/Public/js/bootstrap.min.js" /></script>
  <script src="//cdn.bootcss.com/holder/2.9.4/holder.min.js" /></script>
  <script src="/Public//User/js/js.js" /></script>
<script type="text/javascript">
$(document).ready(function(e) {
    $(".uploadfile").each(function(index, element) {
        if($(this).attr("src") != "/Uploads/verifyinfo/"){
			$(this).attr("data-src","");
			$(this).parent("a").attr("href", $(this).attr("src")).attr("target","_blank");
		}
    });
});
</script>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-sm-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>申请认证</h5>
        </div>
        <div class="ibox-content">
<?php if($uploadsfzzm != '' and $uploadsfzbm != '' and $uploadscsfz != '' and $uploadyhkzm != '' and $uploadyhkbm != '' and $uploadyyzz != '' and $status == 0): ?><ol class="breadcrumb">
    <li class="active" style="text-align:center;">
      <input type="button" class="btn btn-warning" value="申请认证" onclick="javascript:window.location.href='<?php echo U("Account/verifyinfosqsh");?>
      '" /></li>
  </ol>
  <?php else: ?>
  <?php if($status ==0): ?><ol class="breadcrumb">
      <li class="active" style="text-align:center; color:#F00; font-weight:bold;"> 上传完三个图片后才能申请认证！ </li>
    </ol><?php endif; endif; ?>

<div class="content col-sm-4 col-md-4 col-xs-12">
  <form action="<?php echo U("Account/upload");?>" enctype="multipart/form-data" method="post" >
    <div class="row">
      <div class="col-sm-6 col-md-4" style="width:100%;">
        <div class="thumbnail">
          <div class="caption" style="text-align:center; font-size:18px; color:#003;">
            <p>身份证正面</p>
          </div>
          <a href="#"><img data-src="holder.js/300x200?text=还没上传资料" src="/Uploads/verifyinfo/<?php echo ($uploadsfzzm); ?>" class="uploadfile"></a>
          <div class="caption">
            <?php if($status == 0): ?><input type="hidden" name="fieldsname" value="uploadsfzzm">
              <label for="uploadsfzzm">上传身份证正面图片</label>
              <input type="file" id="uploadsfzzm" name="uploadsfzzm" style="width:100%;">
              <br>
              <input type="submit" class="btn btn-primary" value="上 传" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <?php if($uploadsfzzm != ''): ?><input type="button" class="btn btn-primary" value="删除图片" onclick="javascript:window.location.href='<?php echo U("Account/verifyinfodel","filename=uploadsfzzm");?>
                '" /><?php endif; ?>
              <p class="help-block" style="color:#F00;">可上传图片类型(jpg, gif, png, bmp),图片大小 2M 以内</p>
              <?php else: ?>
              <br>
              <br>
              <?php if($status == 2): ?><span style="color:#F60; font-weight:bold;">正在等待审核中......</span>
                <?php else: ?>
                <img src="./Public/User/images/rzyh.gif" style="width:230px; height:120px;"><?php endif; endif; ?>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="content col-sm-4 col-md-4 col-xs-12">
  <form action="<?php echo U("Account/upload");?>
    " enctype="multipart/form-data" method="post" >
    <div class="row">
      <div class="col-sm-6 col-md-4" style="width:100%;">
        <div class="thumbnail">
          <div class="caption" style="text-align:center; font-size:18px; color:#003;">
            <p>身份证反面</p>
          </div>
          <a href="#"><img data-src="holder.js/300x200?text=还没上传资料"  src="/Uploads/verifyinfo/<?php echo ($uploadsfzbm); ?>" class="uploadfile"></a>
          <div class="caption">
            <?php if($status == 0): ?><input type="hidden" name="fieldsname" value="uploadsfzbm">
              <label for="uploadsfzbm">上传身份证反面图片</label>
              <input type="file" id="uploadsfzbm" name="uploadsfzbm" style="width:100%;">
              <br>
              <input type="submit" class="btn btn-primary" value="上 传" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <?php if($uploadsfzbm != ''): ?><input type="button" class="btn btn-primary" value="删除图片" onclick="javascript:window.location.href='<?php echo U("Account/verifyinfodel","filename=uploadsfzbm");?>
                '" /><?php endif; ?>
              <p class="help-block" style="color:#F00;">可上传图片类型(jpg, gif, png, bmp),图片大小 2M 以内</p>
              <?php else: ?>
              <br>
              <br>
              <?php if($status == 2): ?><span style="color:#F60; font-weight:bold;">正在等待审核中......</span>
                <?php else: ?>
                <img src="./Public/User/images/rzyh.gif" style="width:230px; height:120px;"><?php endif; endif; ?>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>


<div class="content col-sm-4 col-md-4 col-xs-12">
  <form action="<?php echo U("Account/upload");?>
    " enctype="multipart/form-data" method="post" >
    <div class="row">
      <div class="col-sm-4 col-md-4" style="width:100%;">
        <div class="thumbnail">
          <div class="caption" style="text-align:center; font-size:18px; color:#003;">
            <p>营业执照</p>
          </div>
          <a href="#"><img data-src="holder.js/300x200?text=还没上传资料"  src="/Uploads/verifyinfo/<?php echo ($uploadyyzz); ?>" class="uploadfile"></a>
          <div class="caption">
            <?php if($status == 0): ?><input type="hidden" name="fieldsname" value="uploadyyzz">
              <label for="uploadyyzz">上传营业执照图片</label>
              <input type="file" id="uploadyyzz" name="uploadyyzz" style="width:100%;">
              <br>
              <input type="submit" class="btn btn-primary" value="上 传" />
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <?php if($uploadyyzz != ''): ?><input type="button" class="btn btn-primary" value="删除图片" onclick="javascript:window.location.href='<?php echo U("Account/verifyinfodel","filename=uploadyhkzm");?>
                '" /><?php endif; ?>
              <p class="help-block" style="color:#F00;">可上传图片类型(jpg, gif, png, bmp),图片大小 2M 以内</p>
              <?php else: ?>
              <br>
              <br>
              <?php if($status == 2): ?><span style="color:#F60; font-weight:bold;">正在等待审核中......</span>
                <?php else: ?>
                <img src="./Public/User/images/rzyh.gif" style="width:230px; height:120px;"><?php endif; endif; ?>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>




<div style="clear:left"></div>
</div>
<!--ibox-->
</div>
</div>
</div>
</div>
<?php echo tongji(0);?>
</body>
</html>