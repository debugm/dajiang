<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="renderer" content="webkit">
<title><?php echo ($sitename); ?></title>
<link rel="shortcut icon" href="favicon.ico">
<link href="<?php echo ($siteurl); ?>Public/Front/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/font-awesome.min.css?v=4.4.0" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/animate.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
</head>
<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
  <!--左侧导航开始-->
  <nav class="navbar-default navbar-static-side" role="navigation">
  <div class="nav-close"><i class="fa fa-times-circle"></i> </div>
  <div class="sidebar-collapse">
    <ul class="nav" id="side-menu">
      <li class="nav-header">
        <div class="dropdown profile-element"> <span>ID:<?php echo (session('shid')); ?></span><a data-toggle="dropdown" class="dropdown-toggle" href="#"> <span class="clear"> <span class="block m-t-xs"><strong class="font-bold"><?php echo (session('username')); ?></strong></span> <span class="text-muted text-xs block">
          <?php if($rzstatus == 0): ?><span>未认证</span>
          <?php else: ?>
          <span>认证用户</span><?php endif; ?>
          <b class="caret"></b></span> </span> </a>
          <ul class="dropdown-menu animated fadeInRight m-t-xs">
            <li><a class="J_menuItem" href="<?php echo U("Account/loginpassword");?>">修改密码</a> </li>
            <li class="divider"></li>
            <li><a href="<?php echo U("Index/quit");?>">安全退出</a> </li>
          </ul>
        </div>
        <div class="logo-element">展开 </div>
      </li>
      <li> <a href="#"> <i class="fa fa-home"></i> <span class="nav-label">主页</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
          <li> <a class="J_menuItem" href="<?php echo U("Index/gonggao");?>">通知公告</a> </li>
        </ul>
      </li>
      <li> <a href="#"> <i class="fa fa fa-user"></i> <span class="nav-label">账户管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
   <li><a href="<?php echo U("Account/zqtongdao");?>" class="J_menuItem"><strong>直清通道统计</strong></a> </li>
   <li><a href="<?php echo U("Account/basicinfo");?>" class="J_menuItem"><strong>基本信息</strong></a> </li>
   <li><a href="<?php echo U("Account/bankcard");?>" class="J_menuItem"><strong>银行卡</strong></a> </li>
   <li><a href="<?php echo U("Account/verifyinfo");?>" class="J_menuItem"><strong>认证信息</strong></a> </li>
   <li><a href="<?php echo U("Account/loginpassword");?>" class="J_menuItem"><strong>登录密码</strong></a> </li>
   <li><a href="<?php echo U("Account/paypassword");?>" class="J_menuItem"><strong>支付密码</strong></a> </li>
  <li> <a href="<?php echo U("Account/loginrecord");?>" class="J_menuItem"><strong>登录记录</strong></a> </li>
  <li> <a href="<?php echo U("Account/zjbdjl");?>" class="J_menuItem"><strong>资金变动记录</strong></a> </li>
        </ul>
      </li>
	   <li> <a href="#"> <i class="fa fa-money"></i> <span class="nav-label">流量管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
<!--          <li> <a class="J_menuItem" href='<?php echo U("Skgl/chongzhi");?>'>流量充值</a> </li>-->
          <li> <a class="J_menuItem" href='<?php echo U("Skgl/llrecord");?>'>充值列表</a> </li>
	<!--	     <li>  <a href="javascript:alert('正在开发完善中...');"  style="display:none;"><strong>收款二维码</strong></a> </li>-->
        </ul>
      </li>
	        <li> <a href="#"> <i class="fa fa fa-check"></i> <span class="nav-label">结算管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
  <li>  <a href="<?php echo U("Tikuan/sqjs");?>" class="J_menuItem"><strong>申请结算</strong></a>     </li>
   <!--<li> <a href="<?php echo U("Tikuan/wtjs");?>" class="J_menuItem"><strong>委托结算</strong></a>     </li>-->
   <li> <a href="<?php echo U("Tikuan/tklist");?>" class="J_menuItem"><strong>结算记录</strong></a>     </li>
   <!--<li>  <a href="<?php echo U("Tikuan/wttklist");?>" class="J_menuItem"><strong>委托结算记录</strong></a>     </li>-->
        </ul>
      </li>
	  
	    <li> <a href="#"> <i class="fa fa fa-sellsy"></i> <span class="nav-label">交易管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
  <li>  <a href="<?php echo U("Dealmanages/dealrecord");?>" class="J_menuItem"><strong>交易记录</strong></a>     </li>
  <li>  <a href="<?php echo U("Dealmanages/wxrecord");?>" class="J_menuItem"><strong>微信交易查询</strong></a>     </li>
 
        </ul>
      </li>
	  
	     <li> <a href="#"> <i class="fa fa fa-bank"></i> <span class="nav-label">通道管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
  
  <li>   <a href="<?php echo U("Tongdao/wdtongdao");?>" class="J_menuItem"><strong>接口默认通道</strong></a>  </li>
   <li>  <a href="<?php echo U("Tongdao/tksxf");?>" class="J_menuItem"><strong>提款手续费</strong></a>  </li>
        </ul>
      </li>
	  
	  
	   <?php if(($_COOKIE['usertype']) == "5"): ?><li> <a href="#"> <i class="fa fa fa-gears"></i> <span class="nav-label">代理管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
  
  <li>  <a href="<?php echo U("Daili/invitecode");?>" class="J_menuItem"><strong>注册邀请码</strong></a> </li>
   <li>  <a href="<?php echo U("Daili/usercontrol");?>" class="J_menuItem"><strong>下级商户管理</strong></a> </li>
   <li>  <a href="<?php echo U("Daili/tcjl");?>" class="J_menuItem"> <strong>提成记录</strong></a> </li>
        </ul>
      </li><?php endif; ?>
	  
	  
    </ul>
  </div>
</nav>

  <!--左侧导航结束-->
  <!--右侧部分开始-->
  <div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="row border-bottom">
      <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
          <form role="search" class="navbar-form-custom" method="post" action="#">
            <div class="form-group">
              <input type="text" placeholder="请输入您需要查找的内容 …" class="form-control" name="top-search" id="top-search">
            </div>
          </form>
        </div>
        <ul class="nav navbar-top-links navbar-right">
      
          <li class="hidden-xs"> <i class="fa fa-user"></i> <?php echo (session('username')); ?> </li>
          <li class="dropdown hidden-xs"> <a  href="<?php echo U("Index/quit");?>" class="right-sidebar-toggle" aria-expanded="false"> <i class="fa fa-logout"></i> 退出 </a> </li>
        </ul>
      </nav>
    </div>
    <div class="row content-tabs">
      <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i> </button>
      <nav class="page-tabs J_menuTabs">
        <div class="page-tabs-content"> <a href="javascript:;" class="active J_menuTab" data-id="/User.html">首页</a> </div>
      </nav>
      <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i> </button>
      <div class="btn-group roll-nav roll-right">
        <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span> </button>
        <ul role="menu" class="dropdown-menu dropdown-menu-right">
          <li class="J_tabShowActive"><a>定位当前选项卡</a> </li>
          <li class="divider"></li>
          <li class="J_tabCloseAll"><a>关闭全部选项卡</a> </li>
          <li class="J_tabCloseOther"><a>关闭其他选项卡</a> </li>
        </ul>
      </div>
      <a href="<?php echo U("Index/quit");?>" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a> </div>
    <div class="row J_mainContent" id="content-main">
      <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="<?php echo U('Index/defaultindex');?>" frameborder="0" data-id="/User.html" seamless></iframe>
    </div>
    <div class="footer">
      <div class="pull-right">&copy; 2014-2017 河南微云网络科技有限公司 版权所有 </div>
    </div>
  </div>
  <!--右侧部分结束-->
 
</div>
<!-- 全局js -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/jquery.min.js?v=2.1.4"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/bootstrap.min.js?v=3.3.6"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/plugins/layer/layer.min.js"></script>
<!-- 自定义js -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/hplus.js?v=4.1.0"></script>
<script type="text/javascript" src="<?php echo ($siteurl); ?>Public/Front/js/contabs.js"></script>
<!-- 第三方插件 -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/plugins/pace/pace.min.js"></script>
<?php echo tongji(0);?>
</body>
</html>