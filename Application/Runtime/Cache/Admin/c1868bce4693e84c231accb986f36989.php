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

<link href="/Public/css/jquery.alerts.css" rel="stylesheet">
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/js/jquery.alerts.js" /></script>
<script type="text/javascript" src="/Public/Admin/js/js.js"></script>
<script type="text/javascript" src="/Public/Admin/js/systembank.js"></script>
</head>
 <body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>系统升级</h5>
            </div>
            <div class="ibox-content">
                    <form class="form-horizontal" onsubmit="return check();" action="<?php echo U("Payaccess/systembankadd");?>" enctype="multipart/form-data" method="post" >
                        <div class="form-group">
                            <label for="bankname" class="col-sm-3 control-label">银行名称：</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="bankname" name="bankname" placeholder="请输入银行名称">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bankcode" class="col-sm-3 control-label">银行编码：</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="bankcode" name="bankcode" placeholder="请输入银行编码">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bankimages" class="col-sm-3 control-label">银行图标：</label>
                            <div class="col-sm-6">
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
                                <button type="submit" class="btn btn-primary">添加银行</button>
                            </div>
                        </div>
                    </form>
                <table class="table table-bordered table-condensed">
                    <thead>
                    <th>银行名称</th>
                    <th>银行编码</th>
                    <th>银行LOGO</th>
                    <th>操作</th>
                    </thead>
                    <?php if(is_array($listbank)): $i = 0; $__LIST__ = $listbank;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$bank): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($bank["bankname"]); ?></td>
                        <td><?php echo ($bank["bankcode"]); ?></td>
                        <td><img src="/Uploads/bankimg/<?php echo ($bank["images"]); ?>" style="width: 80px;height: 32px; padding: 0;margin: 0;"></td>
                        <td><a href="javascript:edit('<?php echo ($bank["id"]); ?>');">编辑</a> <a href="javascript:del('<?php echo U("Payaccess/systembankdel");?>','<?php echo ($bank["id"]); ?>')">删除</a></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </table>

            </div>
        </div>
    </div>
</div>
</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-describedby="tscontent" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close modalgb" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">
        	<b>编辑银行信息</b>
        </h4>
      </div>
      <div class="modal-body" id="tscontent" style="color:#000; font-family:'微软雅黑';">
  <!--------------------------------------------------------------------------------------------------->
  <!-- Nav tabs -->


<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" style="height:400px;">
     <iframe id="iframesystembank" editurl="<?php echo U("Payaccess/systembankedit");?>" style="width:100%; height:400px; border:0px;" src=""></iframe>
  </div>
</div>
  <!--------------------------------------------------------------------------------------------------->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default modalgb" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>
<?php echo tongji(0);?>
</body>
</html>