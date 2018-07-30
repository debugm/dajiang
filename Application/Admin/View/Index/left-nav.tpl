<nav class="navbar-default navbar-static-side" role="navigation">
  <div class="nav-close"><i class="fa fa-times-circle"></i> </div>
  <div class="sidebar-collapse">
    <ul class="nav" id="side-menu">
      <li class="nav-header">
        <div class="dropdown profile-element"> 
		
		  <a data-toggle="dropdown" class="dropdown-toggle" href="#"> <span class="clear"> <span class="block m-t-xs"><strong class="font-bold"><{$Think.session.admin_username}></strong></span>  </a>
        
            <span style="color:#F30">	<switch name="Think.session.admin_usertype">
				    <case value="0">总管理员</case>
				</switch></span> 
				<p><a href="#" data-toggle="modal" data-target="#myModal">改密</a>
				</p>
          
          
        </div>
        <div class="logo-element">MENU </div>
      </li>
	   <li> <a href="<{:C('HOUTAINAME')}>.html"> <i class="fa fa-home"></i> <span class="nav-label">管理首页</span>  </a></li>
      <li> <a href="#"> <i class="fa fa-asterisk"></i> <span class="nav-label">系统设置</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
		    <li> <a href="<{:U("System/jbsz")}>" class="J_menuItem">基本设置</a></li>
            <li> <a href="<{:U("System/emailsz")}>" class="J_menuItem">邮箱设置</a></li>
			<li> <a href="<{:U("Update/update")}>" class="J_menuItem">系统升级</a></li>
        </ul>
      </li>
	  <li> <a href="#"> <i class="fa fa-book"></i> <span class="nav-label">内容管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
		   <li><a href="<{:U("Content/articleclassadd")}>" class="J_menuItem">添加栏目</a></li>
		   <li><a href="<{:U("Content/articleclasslist")}>" class="J_menuItem">栏目管理</a></li>
		   <li><a href="<{:U("Content/articleadd")}>" class="J_menuItem">添加文章</a></li>
		   <li><a href="<{:U("Content/articlelist")}>" class="J_menuItem">文章管理</a></li>
        </ul>
      </li>
      <li> <a href="#"> <i class="fa fa-user"></i> <span class="nav-label">用户管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
		   <li><a href="<{:U("User/usercontrol")}>" class="J_menuItem"><{:L("ADMIN_YHGL_PUTONGSHANGHU")}></a></li>
		   <li><a href="<{:U("User/useraccountupload")}>" class="J_menuItem">用户通道账户上传</a></li>
		   <li><a href="<{:U("User/subiduploadview")}>" class="J_menuItem">子商户信息上传</a></li>
		   <li><a href="<{:U("User/userskuploadview")}>" class="J_menuItem">商户收款信息上传</a></li>
		   <li><a href="<{:U("User/invitecode")}>" class="J_menuItem"><{:L("ADMIN_YHGL_YAOQINGMAGUANLI")}></a></li>
		   <li><a href="<{:U("User/llrecharge")}>" class="J_menuItem">流量充值</a></li>
		   <li><a href="<{:U("User/setwallet")}>" class="J_menuItem">流量设置</a></li>
		   <li><a href="<{:U("User/subidcontrol")}>" class="J_menuItem">子商户管理</a></li>
        </ul>
      </li>
      <li> <a href="#"> <i class="fa fa-bank"></i> <span class="nav-label">网关通道</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
	  <li><a href="<{:U("Payaccess/managepayaccess")}>" class="J_menuItem">通道管理</a></li>
      <li><a href="<{:U("Payaccess/systembank")}>" class="J_menuItem">银行设置</a></li>
        </ul>
      </li>
	    <li> <a href="#"> <i class="fa fa fa-sellsy"></i> <span class="nav-label">交易管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
			<li><a href="<{:U("Dealmanages/dealrecord")}>" class="J_menuItem">交易记录</a> </li>
			<!--<li><a href="<{:U("Dealmanages/wxord")}>" class="J_menuItem">微信个人码交易统计</a> </li>
			<li><a href="<{:U("Dealmanages/wxdiaodan")}>" class="J_menuItem">微信个人码掉单统计</a> </li>-->
			<li><a href="<{:U("User/usertji")}>" class="J_menuItem">交易查询</a> </li>
			<li><a href="<{:U("User/tongdaotj")}>" class="J_menuItem">用户统计</a> </li>
			<!--
			<li><a href="<{:U("User/cglcx")}>" class="J_menuItem">子商户成功率查询</a> </li>
			<li><a href="<{:U("User/fstj")}>" class="J_menuItem">子商户分时成功率查询</a> </li>
			<li><a href="<{:U("User/daytj")}>" class="J_menuItem">每日商户成功率统计查询</a> </li>-->
			<!--<li><a href="<{:U("User/delxe")}>" class="J_menuItem">清空限额</a> </li>-->
		   <!--<li> <a href="<{:U("Dealmanages/zjbdjl")}>" class="J_menuItem">资金变动记录</a> </li>-->
 
        </ul>
      </li>
	      <li> <a href="#"> <i class="fa fa fa-cubes"></i> <span class="nav-label">提款设置</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
			  <li> <a href="<{:U("Tikuan/tikuansz")}>" class="J_menuItem">提款设置</a> </li>
			    <li><a href="<{:U("Tikuan/tikuanlist")}>" class="J_menuItem">提款记录</a> </li>
			   <li> <a href="<{:U("Tikuan/wttikuanlist")}>" class="J_menuItem">委托提款记录</a> </li>
 
        </ul>
      </li>
 
	  
	  
    </ul>
  </div>
</nav>
