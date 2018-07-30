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
  <link href="/Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
  <link href="/Public/Front/js/plugins/layui/css/layui.css" rel="stylesheet">
  <script type="text/javascript" src="/Public/js/jquery-1.10.2.min.js"></script>
  <script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/Public/js/bootstrap-datepicker.js"></script>
  <script type="text/javascript" src="/Public/js/floatDiv.js"></script>
  <script type="text/javascript" src="/Public/Admin/js/user.js"></script>
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-sm-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>邀请码管理</h5>
        </div>
        <div class="ibox-content">
          <blockquote class="layui-elem-quote">
            <form class="form-inline" role="form" action="" method="get" autocomplete="off" id="selectedform">
              <div class="form-group">
                <input type="text" class="form-control" style="width: 120px;" id="invitecodesearch" name="invitecodesearch" placeholder="邀请码" value="<?php echo ($_GET['invitecodesearch']); ?>">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" style="width: 120px;" id="fbusernamesearch" name="fbusernamesearch" placeholder="发布者用户名" style="width:150px;" value="<?php echo ($_GET['fbusernamesearch']); ?>">
              </div>
              <div class="form-group">
                <input type="text" class="form-control" style="width: 120px;" id="syusernamesearch" name="syusernamesearch" placeholder="使用者用户名" style="width:150px;" value="<?php echo ($_GET['syusernamesearch']); ?>">
              </div>
              <div class="form-group">
                <select class="form-control" id="regtypesearch" name="regtypesearch">
                  <option value="">注册类型</option>
                  <option value="4">普通商户</option>
                  <option value="5">普通代理商</option>
                </select>
                <script type="text/javascript">
                    $("#regtypesearch").val('<?php echo ($_GET['regtypesearch']); ?>');
                </script>
              </div>
              <div class="form-group">
                <select class="form-control" id="ztsearch" name="ztsearch">
                  <option value="">所有状态</option>
                  <option value="1">未使用</option>
                  <option value="2">已使用</option>
                  <option value="0">禁用</option>
                </select>
                <script type="text/javascript">
                    $("#ztsearch").val('<?php echo ($_GET['ztsearch']); ?>');
                </script>
              </div>
              <button type="submit" class="layui-btn layui-btn-small"> <span class="glyphicon glyphicon-search"></span> 搜索 </button>
              <button type="button" class="layui-btn layui-btn-small" onClick="javascript:location.reload();"><span class="glyphicon glyphicon-refresh"></span> 刷新数据 </button>
              <button type="button" class="layui-btn layui-btn-small" id="yqmsz"><span class="glyphicon glyphicon-wrench"></span> 设 置 </button>
              <button type="button" class="layui-btn layui-btn-danger layui-btn-small" id="yqmtj" ajaxurl="<?php echo U("createinvite");?>"><span class="glyphicon glyphicon-plus"></span> 添加邀请码 </button>
            </form>
          </blockquote>

          <div class="table-responsive" style="margin:0px auto; margin-top:10px;">
            <table class="table table-bordered table-hover table-condensed table-responsive">
              <thead>
              <tr>
                <th>邀请码</th>
                <th>注册地址</th>
                <th>发布者</th>
                <th>使用者</th>
                <th>生成时间</th>
                <th>过期时间</th>
                <th>使用时间</th>
                <th>注册类型</th>
                <th>状态</th>
                <th>删除</th>
              </tr>
              </thead>
              <tbody>
              <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                  <td class="success"><?php echo ($vo["invitecode"]); ?></td>
                  <td style="text-align:center;"><a href="#" onClick="javascript:window.open('http://<?php echo C("DOMAIN"); echo U("Home/Index/reg","invitecode=".$vo["invitecode"]);?>');">注册地址</a></td>
                  <td class="active"><?php echo (getusername($vo["fmusernameid"])); ?></td>
                  <td class="active"><?php echo (getusername($vo["syusernameid"])); ?></td>
                  <td class="active"><?php echo date('Y-m-d',$vo["fbdatetime"]);?></td>
                  <td class="active"><?php echo date("Y-m-d",$vo["yxdatetime"]);?></td>
                  <td class="active"><?php echo ($vo["sydatetime"]? date('Y-m-d',$vo["sydatetime"]):"-"); ?></td>
                  <td class="info">
                    <?php switch($vo["regtype"]): case "4": ?>普通商户<?php break;?>
                      <?php case "5": ?>普通代理商<?php break; endswitch;?>
                  </td>
                  <td class="danger">
                    <?php echo (getinviteconfigzt($vo['id'])); ?>
                  </td>
                  <td class="active" style="text-align:center;">
                    <?php if($vo["inviteconfigzt"] < 2): ?><a href="javascript:delinvitecode('<?php echo ($vo["id"]); ?>')"><span class="glyphicon glyphicon-trash"></span></a>
                      <?php else: ?>
                      -<?php endif; ?>
                  </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
              <tr>
                <td colspan="11"><div class="pagex"><?php echo ($_page); ?> </div></td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div></div>
  </div>
</div>
<div id="szyqm" style="width:580px; height:600px; display:none;">
  <div class="panel panel-primary">
    <div class="panel-heading">邀请码设置<span class="close" aria-hidden="true" onclick="javascript:$('#szyqm').hide(); $('#yqmsz').button('reset'); $('.pagination').show();">&times;</span></div>
    <div class="panel-body"> 
      <!-------------------------------------------------------------------------->
      <div style="width:100%; margin:0px auto;">
        <form class="form-inline" role="form" id="inviteconfig" ajaxurl="<?php echo U("ajaxinviteconfig");?>">
          <div class="form-group">
            <input type="hidden" id="inviteconfigid">
            <label class="control-label">状态：</label>
          </div>
          <div class="form-group">
            <select class="form-control" id="invitezt">
              <option value="1">正常</option>
              <option value="0">关闭</option>
            </select>
          </div>
          <div style="clear:left;"></div>
          <div class="form-group" style="margin-top:10px; display: none">
            <label>分站管理员指标：</label>
          </div>
          <div class="form-group" style="margin-top:10px;display: none"> 可生成
            <input type="text" class="form-control" id="invitetype2number" style="width:100px;" onkeyup="javascript:clearNoNum(this);">
            个邀请码，
            <select class="form-control" id="invitetype2ff">
              <option value="1">可分配给下级</option>
              <option value="0">不可分配给下级</option>
            </select>
          </div>
          <div style="clear:left;"></div>
          <div class="form-group" style="margin-top:10px;display: none">
            <label class="control-label">独立代理商指标：</label>
          </div>
          <div class="form-group" style="margin-top:10px;display: none"> 可生成
            <input type="text" class="form-control" id="invitetype6number" onkeyup="javascript:clearNoNum(this);">
            个邀请码，
            <select class="form-control" id="invitetype6ff">
              <option value="1">可分配给下级</option>
              <option value="0">不可分配给下级</option>
            </select>
          </div>

          <div style="clear:left;"></div>
          <div class="form-group" style="margin-top:10px;">
            <label class="control-label">普通代理商指标：</label>
          </div>
          <div class="form-group" style="margin:20px 0;"> 可生成
            <input type="text" class="form-control" id="invitetype5number" onkeyup="javascript:clearNoNum(this);">
            个邀请码，
            <select class="form-control" id="invitetype5ff">
              <option value="1">可分配给下级</option>
              <option value="0">不可分配给下级</option>
            </select>
          </div>
        </form>
      </div>
      <div style="clear:left;"></div>
      <div class="form-group" style="margin-top:20px; text-align:center;">
        <button type="button" class="btn btn-primary" data-loading-text="正在处理中..." id="invitebc" ajaxurl="<?php echo U("invitebc");?>"><strong>保 存</strong> </button>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-info" onclick="javascript:$('#szyqm').hide(); $('#yqmsz').button('reset'); $('#yqmtj').button('reset');  $('.pagination').show();"><strong>关 闭</strong> </button>
      </div>
      <!--------------------------------------------------------------------------> 
    </div>
  </div>
</div>
<div id="addyqm" style="width:600px; height:600px; display:none;">  <div class="panel panel-primary">    <div class="panel-heading">添加邀请码<span class="close" aria-hidden="true" onclick="javascript:$('#addyqm').hide(); $('#yqmtj').button('reset'); $('.pagination').show();">&times;</span></div>    <div class="panel-body">       <!-------------------------------------------------------------------------->      <div style="width:100%; margin:0px auto;">        <form class="form-inline" role="form" id="inviteaddtj" ajaxurl="<?php echo U("addinvitecode");?>          ">          <div class="form-group">            <label class="control-label">邀请码：</label>          </div>          <div class="form-group"> <span id="spaninvitecode"></span>            <input type="hidden" id="invitecode">            <button type="button" class="btn btn-warning btn-sm" id="cxsc"><strong>重新生成</strong> </button>          </div>          <div style="clear:left;"></div>          <div class="form-group" style="margin-top:10px;">            <label class="control-label">到期时间：</label>          </div>          <div class="form-group" style="margin-top:10px;">            <div class="input-group input-append date" id="dp5" data-date-format="yyyy-mm-dd" style="width:140px;">              <input class="form-control" type="text"  id="yxdatetime" disabled="disabled" value="<?php echo date('Y-m-d',strtotime('+1 day'));?>">              <span class="add-on input-group-addon" style="cursor:pointer;"><span class="glyphicon glyphicon-calendar"></span></span> </div>          </div>          <div style="clear:left;"></div>          <div class="form-group" style="margin-top:10px;">            <label class="control-label">注册类型：</label>          </div>          <div class="form-group" style="margin-top:10px;">            <select class="form-control" id="regtype">              <option value="4">普通商户</option>              <option value="5">普通代理商</option>            </select>          </div>        </form>      </div>      <div style="clear:left;"></div>      <div class="form-group" style="margin-top:20px; text-align:center;">        <button type="button" class="btn btn-primary" data-loading-text="正在处理中..." id="inviteadd" ajaxurl="<?php echo U("invitebc");?>"><strong>添 加</strong> </button>        &nbsp;&nbsp;&nbsp;&nbsp;        <button type="button" class="btn btn-info" onclick="javascript:$('#addyqm').hide(); $('#yqmtj').button('reset'); $('#yqmsz').button('reset');  $('.pagination').show();"><strong>关 闭</strong> </button>      </div>      <!-------------------------------------------------------------------------->     </div>  </div></div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-describedby="tscontent" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" aria-hidden="true" onclick="javascript:location.reload();">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-volume-up"></span></h4>
      </div>
      <div class="modal-body" id="tscontent" style="color:#000; font-family:'微软雅黑';">
     
      </div>
      <div class="modal-footer">
      <input type="hidden" id="delid" ajaxurl="<?php echo U("delinvitecode");?>">
      <button type="button" class="btn btn-primary" id="okdelbutton" style="display:none;">
        确认删除
        </button>
        <button type="button" class="btn btn-default" onclick="javascript:location.reload();">
        关闭
        </button>
       
      </div>
    </div>
  </div>
</div>
<?php echo tongji(0);?>
</body>
</html>