<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo ($sitename); ?>  - 注册</title>
<link href="<?php echo ($siteurl); ?>Public/Front/css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/font-awesome.css?v=4.4.0" rel="stylesheet">
<link rel="stylesheet" src="<?php echo ($siteurl); ?>Public/Front/bootstrapvalidator/css/bootstrapValidator.min.css">
<link href="<?php echo ($siteurl); ?>Public/Front/css/animate.css" rel="stylesheet">
<link href="<?php echo ($siteurl); ?>Public/Front/css/style.css?v=4.1.0" rel="stylesheet">
</head>
<body>
<div class="middle-box text-center loginscreen  animated fadeInDown">
  <div id="regdiv">
    <div>
      <h1 class="logo-name">Reg</h1>
    </div>
    <h3>注册成为会员</h3>
	<form role="form" id="Formreg" method="post" action="<?php echo U("Index/register");?>" autocomplete="off">
    <input type="hidden" id="tj" value="0">
      <div class="form-group">
        <input type="text" class="form-control" id="username" name="username" placeholder="请输入用户名" >
      </div>
      <div class="form-group">
        <input type="password" class="form-control" id="password" name="password" placeholder="请输入登录密码" >
          <div class="progress password-progress">
              <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0;"></div>
          </div>
      </div>
	   <div class="form-group">
        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="请再次输入登录密码" >
      </div>
	  <div class="form-group">
        <input type="email"  class="form-control" id="email" name="email" placeholder="请输入您的Email地址" >
      </div>
	    <div class="form-group">
        <input type="text" class="form-control" id="invitecode" name="invitecode" placeholder="必须有邀请码才能注册" value="<?php echo ($_GET['invitecode']); ?>">
      </div>
        <div class="form-group">
                <div id="messages"></div>
        </div>
        <button type="submit" class="btn btn-primary block full-width m-b">注 册</button>
      <p class="text-muted text-center">  <a href="<?php echo U('Index/index');?>">已有账号？点击登录</a> </p>
    </form>
  </div>
</div>
<!-- 全局js -->
<script src="<?php echo ($siteurl); ?>Public/Front/js/jquery.min.js?v=2.1.4"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/bootstrap.min.js?v=3.3.6"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/bootstrapvalidator/js/bootstrapValidator.min.js"></script>
<script src="<?php echo ($siteulr); ?>Public/Front/js/plugins/zxcvbn/4.4.2/zxcvbn.js"></script>
<script src="<?php echo ($siteurl); ?>Public/Front/js/plugins/layer/layer.min.js"></script>
<style>
    .password-progress {
        margin-top: 10px;
        margin-bottom: 0;
    }
</style>
<script>
    $(document).ready(function() {
        $('form').bootstrapValidator({
            //container: '#messages',
            message: 'This value is not valid',
            feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                username: {
                    message: '用户名验证失败',
                    validators: {
                        notEmpty: {
                            message: '用户名不能为空'
                        },
                        different: {
                            field: 'password',
                            message: '用户名不能和密码相同'
                        },
                        threshold:6,
                        stringLength: {
                            min: 6,
                            max: 20,
                            message: '用户名长度必须在6到20之间'
                        },
                        remote:{
                            url: "<?php echo U('Index/checkuser');?>",
                            message: '用户已存在',
                            delay :  1000,
                            type: 'POST'
                        },
                        regexp: {
                            regexp: /^[a-zA-Z0-9_\.]+$/,
                            message: '用户名由数字字母下划线和.组成'
                        }
                    }
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: '密码不能为空'
                        },
                        identical: {
                            field: 'confirmpassword',
                            message: '两次密码不一致'
                        },
                        different: {
                            field: 'username',
                            message: '不能和用户名相同'
                        },
                        callback: {
                            callback: function(value, validator, $field) {
                                var password = $field.val();
                                if (password == '') {
                                    return true;
                                }

                                var result  = zxcvbn(password),
                                    score   = result.score,
                                    message = result.feedback.warning || '弱密码';

                                // Update the progress bar width and add alert class
                                var $bar = $('#strengthBar');
                                switch (score) {
                                    case 0:
                                        $bar.attr('class', 'progress-bar progress-bar-danger')
                                            .css('width', '1%');
                                        break;
                                    case 1:
                                        $bar.attr('class', 'progress-bar progress-bar-danger')
                                            .css('width', '25%');
                                        break;
                                    case 2:
                                        $bar.attr('class', 'progress-bar progress-bar-danger')
                                            .css('width', '50%');
                                        break;
                                    case 3:
                                        $bar.attr('class', 'progress-bar progress-bar-warning')
                                            .css('width', '75%');
                                        break;
                                    case 4:
                                        $bar.attr('class', 'progress-bar progress-bar-success')
                                            .css('width', '100%');
                                        break;
                                }
                                // We will treat the password as an invalid one if the score is less than 3
                                if (score < 3) {
                                    return {
                                        valid: false,
                                        message: message
                                    }
                                }
                                return true;
                            }
                        }
                    }
                },
                confirmpassword: {
                    message: '确认密码无效',
                    validators: {
                        notEmpty: {
                            message: '确认密码不能为空'
                        },
                        stringLength: {
                            min: 6,
                            max: 30,
                            message: '用户名长度必须在6到30之间'
                        },
                        identical: {
                        field: 'password',
                        message: '两次密码不一致'
                        },
                        different: {
                        field: 'username',
                        message: '不能和用户名相同'
                        }
                    }
                },
                email: {
                    message: '邮件验证失败',
                    validators: {
                        notEmpty: {
                            message: '邮件不能为空'
                        },
                        remote:{
                            url: "<?php echo U('Index/checkemail');?>",
                            message: '用户已存在',
                            delay :  1000,
                            type: 'POST'
                        },
                        regexp:{
                            regexp:/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/,
                            message: '邮件格式有误，请核对'
                        }
                    }
                },
                invitecode: {
                    message: '邀请码验证失败',
                    validators: {
                        notEmpty: {
                            message: '邀请码不能为空'
                        },
                        remote:{
                            url: "<?php echo U('Index/checkinvitecode');?>",
                            message: '邀请码无效',
                            delay :  1000,
                            type: 'POST'
                        },
                    }
                },
            }
        }).on('success.form.bv', function(e) {
            e.preventDefault();
            var $form = $(e.target);
            var bv = $form.data('bootstrapValidator');
            $.post($form.attr('action'), $form.serialize(), function(res) {
                if(res.errorno){
                    layer.msg('注册失败,请重新提交，谢谢！', {
                        time: 20000, //20s后自动关闭
                        btn: ['知道了'],
                        yes:function(){
                            window.location.reload();
                        }
                    });
                }else{
                    var data = res.msg;
                    layer.open({
                        type: 1
                        ,title: false
                        ,closeBtn: false
                        ,area: '300px;'
                        ,shade: 0.8
                        ,id: 'LAY_layuipro' //设定一个id，防止重复弹出
                        ,resize: false
                        ,btn: ['立刻激活', '晚点再说']
                        ,btnAlign: 'c'
                        ,moveType: 1 //拖拽模式，0或者1
                        ,content: '<div style="padding: 50px; line-height: 22px; background-color: #393D49; color: #fff; font-weight: 300;">' +
                        '<h3>恭喜您，注册成功！</h3>' +
                        '<p>我们已发送了一封验证邮件到 <strong>'+data.email+'</strong>, 请注意查收您的邮箱，点击其中的链接激活您的账号！</p>' +
                        '<p>如果您未收到验证邮件，请联系管理员重新发送验证邮件或手动帮您激活账号。</p>' +
                        '<p>管理员联系方式：<p><a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='+data.qq+'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'+data.qq+':51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a></div>'
                        ,success: function(layero){
                            var btn = layero.find('.layui-layer-btn');
                            btn.find('.layui-layer-btn0').attr({href: data.mail,target: '_blank'});
                        }
                    });
                }

            }, 'json');
        });
});
</script>
<?php echo tongji(0);?>
<!--统计代码，可删除-->
</body>
</html>