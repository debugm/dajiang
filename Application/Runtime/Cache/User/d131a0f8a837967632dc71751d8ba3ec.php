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
    <link href="/Public/Front/js/plugins/layui/css/layui.css" rel="stylesheet">
</head>
<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <form role="form" id="bankcardform" class="form-horizontal" method="post" action="<?php echo U("Account/addbankcard");?>" autocomplete="off">
                <div class="form-group">
                    <label class="col-sm-2 control-label">所属省市</label>
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
                    <label for="bankname" class="col-sm-2 control-label">银行名称</label>
                    <div class="col-md-8">
                        <select class="form-control" id="bankname" name="bankname">
                            <option value="">选择开户行</option>
                            <?php if(is_array($banklist)): $i = 0; $__LIST__ = $banklist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vobank): $mod = ($i % 2 );++$i;?><option <?php if($list['bankname'] == $vobank['bankname']): ?>selected<?php endif; ?> value="<?php echo ($vobank["bankname"]); ?>"><?php echo ($vobank["bankname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="tel" class="col-sm-2 control-label">支行名称</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="bankzhiname" name="bankzhiname" value="<?php echo ($list["bankzhiname"]); ?>" placeholder="请输入支行的名称">
                    </div>
                </div>

                <div class="form-group">
                    <label for="bankfullname" class="col-sm-2 control-label">开户名</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="bankfullname" name="bankfullname" value="<?php echo ($list["bankfullname"]); ?>" placeholder="请输入开户人姓名">
                    </div>
                </div>
                <div class="form-group">
                    <label for="banknumber" class="col-sm-2 control-label">银行卡号</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="banknumber" name="banknumber" value="<?php echo ($list["banknumber"]); ?>" placeholder="请输入银行账号">
                    </div>
                </div>
                <div id="insertbank"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <button type="<?php if($list[disabled]): ?>button<?php else: ?>submit<?php endif; ?>" class="btn btn-primary <?php if($list[disabled]): ?>disabled<?php endif; ?>">提交保存</button>
                </div>
            </form>
            <script src="<?php echo ($siteurl); ?>Public/Front/js/jquery.min.js"></script>
            <script src="<?php echo ($siteurl); ?>Public/Front/js/bootstrap.min.js"></script>
            <script src="<?php echo ($siteurl); ?>Public/Front/js/distpicker.js"></script>
            <script>
                $('[data-toggle="distpicker"]').distpicker({
                    province: "<?php echo ($list["sheng"]); ?>",
                    city: "<?php echo ($list["shi"]); ?>"
                });
            </script>
</body>
</html>