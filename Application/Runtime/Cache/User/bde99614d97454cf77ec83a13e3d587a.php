<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>用户银行卡信息</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link href="<?php echo ($siteurl); ?>Public/Front/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ($siteurl); ?>Public/Front/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo ($siteurl); ?>Public/Front/css/animate.css" rel="stylesheet">
    <link href="<?php echo ($siteurl); ?>Public/Front/css/style.css" rel="stylesheet">
    <link href="/Public/Front/js/plugins/layui/css/layui.css" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>银行卡信息</h5>
                    <div class="ibox-tools"><a class="collapse-link"> <i class="fa fa-chevron-up"></i> </a> <a
                                class="close-link"> <i class="fa fa-times"></i> </a></div>
                </div>
                <div class="ibox-content">
                    <form role="form" id="bankcardform" class="form-horizontal" method="post" action="<?php echo U("Account/bankcardedit");?>" autocomplete="off">
                        <input type="hidden" name="id" id="id" value="<?php echo ($list["id"]); ?>">
                        <div class="form-group">
                            <blockquote class="layui-elem-quote" style="font-size:12px;">
                                <ul class="list-inline">
                                    <li>上次修改时间：<span class="text-danger"><?php echo ($list["kdatetime"]); ?></span></li>
                                    <li>上次修改IP地址：<span class="text-danger"><?php echo ($list["ip"]); ?></span></li>
                                    <li>上次修改所在地：<span class="text-danger"><?php echo ($list["ipaddress"]); ?></span></li>
                                    <li>可修改开始时间：<span class="text-danger"><?php if($disabled ==0): echo ($list["jdatetime"]); else: ?>已禁止修改<?php endif; ?></span></li>
                                </ul>
                            </blockquote>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-1 control-label">所属省市</label>
                            <div data-toggle="distpicker">
                                <label class="radio-inline" style="padding:0 0 0 15px;margin:0;">
                                    <select class="form-control" style="width: 200px;" id="sheng" name="sheng"></select>
                                </label>
                                <label class="radio-inline" style="padding:0 0 0 10px;margin:0;">
                                    <select class="form-control" style="width: 200px;" id="shi" name="shi"></select>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bankname" class="col-sm-1 control-label">银行名称</label>
                            <div class="col-md-8">
                                <select class="form-control" id="bankname" name="bankname">
                                <option value="">选择开户行</option>
                                <?php if(is_array($banklist)): $i = 0; $__LIST__ = $banklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vobank): $mod = ($i % 2 );++$i;?><option <?php if($list['bankname'] == $vobank['bankname']): ?>selected<?php endif; ?> value="<?php echo ($vobank["bankname"]); ?>"><?php echo ($vobank["bankname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tel" class="col-sm-1 control-label">支行名称</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="bankzhiname" name="bankzhiname" value="<?php echo ($list["bankzhiname"]); ?>" placeholder="请输入支行的名称">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bankfullname" class="col-sm-1 control-label">开户名</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="bankfullname" name="bankfullname" value="<?php echo ($list["bankfullname"]); ?>" placeholder="请输入开户人姓名">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="banknumber" class="col-sm-1 control-label">银行卡号</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" id="banknumber" name="banknumber" value="<?php echo ($list["banknumber"]); ?>" placeholder="请输入银行账号">
                            </div>
                        </div>
                        <div id="insertbank"></div>
                        <div class="form-group">
                            <label class="col-sm-1 control-label"></label>
                            <button type="<?php if($list[disabled]): ?>button<?php else: ?>submit<?php endif; ?>" class="btn btn-primary <?php if($list[disabled]): ?>disabled<?php endif; ?>">提交保存</button>
                            <a data-toggle="modal" href="<?php echo U('Account/addbankcard');?>" data-target="#myModal" class="btn btn-danger">添加银行卡</a>
                            <span class="text-danger">下次解冻时间：<?php echo ($list["jdatetime"]); ?></span>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-describedby="tscontent">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><span class="glyphicon glyphicon-volume-up"></span></h4>
                </div>
                <div class="modal-body" id="tscontent"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default " data-dismiss="modal"> 关闭</button>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo ($siteurl); ?>Public/Front/js/jquery.min.js"></script>
    <script src="<?php echo ($siteurl); ?>Public/Front/js/bootstrap.min.js"></script>
    <script src="<?php echo ($siteurl); ?>Public/Front/js/content.js"></script>
    <script src="<?php echo ($siteurl); ?>Public/Front/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="<?php echo ($siteurl); ?>Public/Front/js/user.js"></script>
    <script src="<?php echo ($siteurl); ?>Public/Front/js/distpicker.js"></script>
    <script>
        $('[data-toggle="distpicker"]').distpicker({
            province: "<?php echo ($list["sheng"]); ?>",
            city: "<?php echo ($list["shi"]); ?>"
        });
    </script>
    <?php echo tongji(0);?>
</body>
</html>