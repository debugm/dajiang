<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="/Public/css/bootstrap.min.css">
<link href="/Public/<{$Public}>/css/systemcss.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/<{$Public}>/js/js.js"></script>
<script type="text/javascript" src="/Public/<{$Public}>/js/systemjs.js"></script>
</head>
<body>


<ol class="breadcrumb">
  <li class="active">管理后台</li>
  <li class="active">系统设置</li>
  <li class="active">短信设置</li>
</ol>


<div id="SystemContent">
<form role="form" id="form1" method="post" action="<{:U("System/smsszedit")}>">
<volist name="list" id="vo">
<input type="hidden" name="id" id="id" value="<{$vo.id}>">
  <div class="form-group">
    <label for="fetionuser">飞信账号</label>
    <input type="text" style="color:#01a9ef; font-weight:bold;" class="form-control" id="fetionuser" name="fetionuser" value="<{$vo.fetionuser}>" placeholder="例如：13333333333">
  </div>
  <div class="form-group">
    <label for="fetionpass">飞信密码</label>
    <input type="password" style="color:#01a9ef; font-weight:bold;"  class="form-control" id="fetionpass" name="fetionpass" value="<{$vo.fetionpass}>"  placeholder="">
  </div>
  
 </volist>
  <button type="button" id="loading-example-btn" data-loading-text="正在处理..." class="btn btn-primary btn-sm" data-target="#myModal" >确认修改</button>
  <button type="reset" class="btn btn-warning btn-sm" id="reset-btn">重 置</button>
</form>
 <div class="form-group" style="height:30px;"></div>
 <div class="form-group">
    <label for="cs_email">测试接收手机号</label>
    <input type="tel" style="color:#01a9ef; font-weight:bold;"  class="form-control" id="cs_text" name="cs_text" value=""  placeholder="请先将输入的手机号加为飞信好友" url="<{:U("System/csfasms")}>">
  </div>
  <button type="button" id="csfsyj" data-loading-text="正在处理..." class="btn btn-primary btn-sm">测试发送短信</button>
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
      <div class="modal-body" id="tscontent" style="color:#000; font-family:'微软雅黑';">
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">
        关闭
        </button>
       
      </div>
    </div>
  </div>
</div>

</body>
</html>
