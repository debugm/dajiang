<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<link rel="stylesheet" href="/Public/css/bootstrap.min.css">
<link href="/Public/Admin/css/systembank.css" rel="stylesheet" type="text/css" />
<css href="/Public/css/jquery.alerts.css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>
<js href="/Public/js/jquery.alerts.js" />
<script type="text/javascript" src="/Public/Admin/js/systembank.js"></script>
</head>

<body>
<div style="width:350px; height:auto; margin:0px auto;">
<volist name="list" id="vo">
<!-------------------------------------------------------------------------------->
<form class="form-horizontal" onsubmit="return editcheck();" action="<{:U("Payaccess/systembankeditedit")}>" enctype="multipart/form-data" method="post" >
<input type="hidden" name="id" value="<{$vo.id}>">
  <div class="form-group">
    <label for="bankname" class="col-sm-3 control-label">银行名称：</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="bankname" name="bankname" value="<{$vo.bankname}>" placeholder="请输入银行名称" style="color:#39F; font-weight:bold;">
    </div>
  </div>
  <div class="form-group">
    <label for="bankcode" class="col-sm-3 control-label">银行编码：</label>
    <div class="col-sm-6">
      <input type="text" class="form-control" id="bankcode" name="bankcode" value="<{$vo.bankcode}>" placeholder="请输入银行编码" style="color:#39F; font-weight:bold;">
    </div>
  </div>
  <div class="form-group">
    <label for="bankimages" class="col-sm-3 control-label">银行图标：</label>
     <div class="col-sm-6">
      <img src="/Uploads/bankimg/<{$vo.images}>" style="width:150px; height:33px;">
    </div>
    <div class="col-sm-6" style="margin-top:10px;">
      <input type="file" id="bankimages" name="bankimages">
    </div>
    
  </div>
  <div class="form-group">
       <div class="col-sm-9" style="font-size:12px; color:#F00; text-align:right;">
    图片尺寸：150×33，图片大小：2M以内，图片格式：jpg, gif, png
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-primary">确认修改</button>
    </div>
  </div>
</form>
</volist>
</div>
<{:tongji(0)}>
</body>
</html>
