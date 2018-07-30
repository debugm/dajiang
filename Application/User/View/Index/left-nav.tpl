<nav class="navbar-default navbar-static-side" role="navigation">
  <div class="nav-close"><i class="fa fa-times-circle"></i> </div>
  <div class="sidebar-collapse">
    <ul class="nav" id="side-menu">
      <li class="nav-header">
        <div class="dropdown profile-element"> <span>ID:<{$Think.session.shid}></span><a data-toggle="dropdown" class="dropdown-toggle" href="#"> <span class="clear"> <span class="block m-t-xs"><strong class="font-bold"><{$Think.session.username}></strong></span> <span class="text-muted text-xs block">
          <if condition="$rzstatus == 0"> <span>未认证</span>
          <else />
          <span>认证用户</span> </if>
          <b class="caret"></b></span> </span> </a>
          <ul class="dropdown-menu animated fadeInRight m-t-xs">
            <li><a class="J_menuItem" href="<{:U("Account/loginpassword")}>">修改密码</a> </li>
            <li class="divider"></li>
            <li><a href="<{:U("Index/quit")}>">安全退出</a> </li>
          </ul>
        </div>
        <div class="logo-element">展开 </div>
      </li>
      <li> <a href="#"> <i class="fa fa-home"></i> <span class="nav-label">主页</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
          <li> <a class="J_menuItem" href="<{:U("Index/gonggao")}>">通知公告</a> </li>
        </ul>
      </li>
      <li> <a href="#"> <i class="fa fa fa-user"></i> <span class="nav-label">账户管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
   <li><a href="<{:U("Account/zqtongdao")}>" class="J_menuItem"><strong>直清通道统计</strong></a> </li>
   <li><a href="<{:U("Account/basicinfo")}>" class="J_menuItem"><strong>基本信息</strong></a> </li>
   <li><a href="<{:U("Account/bankcard")}>" class="J_menuItem"><strong>银行卡</strong></a> </li>
   <li><a href="<{:U("Account/verifyinfo")}>" class="J_menuItem"><strong>认证信息</strong></a> </li>
   <li><a href="<{:U("Account/loginpassword")}>" class="J_menuItem"><strong>登录密码</strong></a> </li>
   <li><a href="<{:U("Account/paypassword")}>" class="J_menuItem"><strong>支付密码</strong></a> </li>
  <li> <a href="<{:U("Account/loginrecord")}>" class="J_menuItem"><strong>登录记录</strong></a> </li>
  <li> <a href="<{:U("Account/zjbdjl")}>" class="J_menuItem"><strong>资金变动记录</strong></a> </li>
        </ul>
      </li>
	   <li> <a href="#"> <i class="fa fa-money"></i> <span class="nav-label">流量管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
<!--          <li> <a class="J_menuItem" href='<{:U("Skgl/chongzhi")}>'>流量充值</a> </li>-->
          <li> <a class="J_menuItem" href='<{:U("Skgl/llrecord")}>'>充值列表</a> </li>
	<!--	     <li>  <a href="javascript:alert('正在开发完善中...');"  style="display:none;"><strong>收款二维码</strong></a> </li>-->
        </ul>
      </li>
	        <li> <a href="#"> <i class="fa fa fa-check"></i> <span class="nav-label">结算管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
  <li>  <a href="<{:U("Tikuan/sqjs")}>" class="J_menuItem"><strong>申请结算</strong></a>     </li>
   <!--<li> <a href="<{:U("Tikuan/wtjs")}>" class="J_menuItem"><strong>委托结算</strong></a>     </li>-->
   <li> <a href="<{:U("Tikuan/tklist")}>" class="J_menuItem"><strong>结算记录</strong></a>     </li>
   <!--<li>  <a href="<{:U("Tikuan/wttklist")}>" class="J_menuItem"><strong>委托结算记录</strong></a>     </li>-->
        </ul>
      </li>
	  
	    <li> <a href="#"> <i class="fa fa fa-sellsy"></i> <span class="nav-label">交易管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
  <li>  <a href="<{:U("Dealmanages/dealrecord")}>" class="J_menuItem"><strong>交易记录</strong></a>     </li>
  <li>  <a href="<{:U("Dealmanages/wxrecord")}>" class="J_menuItem"><strong>微信交易查询</strong></a>     </li>
 
        </ul>
      </li>
	  
	     <li> <a href="#"> <i class="fa fa fa-bank"></i> <span class="nav-label">通道管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
  
  <li>   <a href="<{:U("Tongdao/wdtongdao")}>" class="J_menuItem"><strong>接口默认通道</strong></a>  </li>
   <li>  <a href="<{:U("Tongdao/tksxf")}>" class="J_menuItem"><strong>提款手续费</strong></a>  </li>
        </ul>
      </li>
	  
	  
	   <eq name="Think.cookie.usertype" value="5">
            <li> <a href="#"> <i class="fa fa fa-gears"></i> <span class="nav-label">代理管理</span> <span class="fa arrow"></span> </a>
        <ul class="nav nav-second-level">
  
  <li>  <a href="<{:U("Daili/invitecode")}>" class="J_menuItem"><strong>注册邀请码</strong></a> </li>
   <li>  <a href="<{:U("Daili/usercontrol")}>" class="J_menuItem"><strong>下级商户管理</strong></a> </li>
   <li>  <a href="<{:U("Daili/tcjl")}>" class="J_menuItem"> <strong>提成记录</strong></a> </li>
        </ul>
      </li>
            </eq>
	  
	  
    </ul>
  </div>
</nav>
