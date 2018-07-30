<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><{$sitename}></title>
<link rel="shortcut icon" href="favicon.ico">
<link href="<{$siteurl}>Public/Front/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="<{$siteurl}>Public/Front/css/font-awesome.css?v=4.4.0" rel="stylesheet">
<link href="<{$siteurl}>Public/Front/css/animate.css" rel="stylesheet">
<link href="<{$siteurl}>Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
<js href="/Public/js/jquery.js" />
<js href="/Public/js/bootstrap.min.js" />
<css href="/Public/css/bootstrap.min.css" />
<css href="/Public/Home/css/Homecss.css" />
<js href="/Public/Home/js/js.js" />
</head>

<body>
<div id="dldiv" style="background-image:none; width:800px;">
 <div style="width:90%; margin:0px auto; margin-top:60px;">
   <div style="width:80%; margin:0px auto; margin-top:60px;">
 	<span class="glyphicon glyphicon-ok" style="font-size:80px; color:#F60"></span>
    <span style="font-size:40px; color:#0C0;">恭喜您，注册成功！</span>
   </div>
   <hr>
   <div style="width:100%; color:#CCC; font-size:20px; font-family:'微软雅黑'; margin-top:30px;">
   我们已发送了一封验证邮件到 <span style="color:#F6C;"><{$email}></span>, 请注意查收您的邮箱，点击其中的链接激活您的账号！
   </div>
    <div style="width:100%; color:#CCC; font-size:20px; font-family:'微软雅黑'; margin-top:20px;">
   如果您未收到验证邮件，请联系管理员重新发送验证邮件或手动帮您激活账号。
   </div>
    <div style="width:100%; color:#CCC; font-size:20px; font-family:'微软雅黑'; margin-top:20px;">
   管理员联系方式：
 <foreach name="qqlist" item="vo" >
 <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<{$qqlist[$key]}>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<{$qqlist[$key]}>:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>&nbsp;&nbsp;
</foreach>
<span class="glyphicon glyphicon-phone-alt"></span> <{$tel}>
   </div>
   <div style="width:100%; color:#CCC; font-size:20px; font-family:'微软雅黑'; text-align:center; margin-top:30px;">
    <button type="button" class="btn btn-success btn-lg" style="font-family:'微软雅黑'; width:150px; font-size:20px" onclick="javascript:window.location.href='<{:U('Index/index')}>'"><span class="glyphicon glyphicon-hand-right"></span>&nbsp;&nbsp;登 录</button>
  
   </div>
 </div>
 
 
</div>
<{:tongji(0)}>
</body>
</html>
