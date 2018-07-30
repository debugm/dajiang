
<?php
$amt = floatval($_GET['amt']) * 100;
$amt1 = floatval($_GET['amt']);
$oid = $_GET['oid'];
$nurl = $_GET['nurl'];
	

?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>支付收银台</title>
		<meta name="description" content="">
		<meta name="keywords" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge">
		<meta name="renderer" content="webkit">
		<link href="Public/Pay/img/favicon.png" rel="icon" type="image/png">

		<!-- Styles -->
		<link href="Public/Pay/css/style.css" rel="stylesheet">
	<meta name="__hash__" content="3c08a9058a44259dd233bba788256b47_0ec6991247f941508644c386398ddc99" /></head>
	<body id="paybox">
		
		<div id="paynav" class="shadown">
			<div class="content">
				<div class="logo">
					<img src="Public/Pay/img/paylogo.png">
				</div>
			</div>
		</div>
		
		<div class="content orderInfo shadown">
			
			<div class="info">
				<span>订单编号：&nbsp;<span class="pay_orderid"><?php echo $oid;?></span></span>
			</div>
			
			<div class="priceinfo">
				<div class="price"><small>应付金额￥</small><span class="pay_price"><?php echo $amt1;?></span></div>
			</div>
			
			<div class="clear"></div>
		</div>
		
		<div class="content payway shadown">
			<h1>请选择支付方式</h1>
			<ul id="wayUl">
				<li data-pay-bankcode=01020000><img src="Uploads/bankimg/ICBC.gif" alt="工商银行2"></li><li data-pay-bankcode=03080000><img src="Uploads/bankimg/CMB.gif" alt="招商银行2"></li><li data-pay-bankcode=01030000><img src="Uploads/bankimg/5414c87492ad8.gif" alt="农业银行2"></li><li data-pay-bankcode=01050000><img src="Uploads/bankimg/CCB.gif" alt="建设银行2"></li><li data-pay-bankcode=03010000><img src="Uploads/bankimg/BOCOM.gif" alt="交通银行2"></li><li data-pay-bankcode=05010000><img src="Uploads/bankimg/CIB.gif" alt="兴业银行2"></li><li data-pay-bankcode=03050000><img src="Uploads/bankimg/CMBC.gif" alt="民生银行2"></li><li data-pay-bankcode=03030000><img src="Uploads/bankimg/CEB.gif" alt="光大银行2"></li><li data-pay-bankcode=01040000><img src="Uploads/bankimg/BOC.gif" alt="中国银行2"></li><li data-pay-bankcode=03060000><img src="Uploads/bankimg/GDB.gif" alt="广发银行2"></li><li data-pay-bankcode=03100000><img src="Uploads/bankimg/SPDB.gif" alt="上海浦东发展银行2"></li><li data-pay-bankcode=04105840><img src="Uploads/bankimg/5414c0929a632.gif" alt="平安银行2"></li>
				<div class="clear"></div>
			</ul>
			
			<div class="bottomBox">
				<div class="peice"><small>支付￥</small><span class="pay_price"><?php echo $amt1;?></span></div>
				<div class="btnBox"><a class="btn payBtn">去付款</a></div>
			</div><!--bottomBox-->
			
		</div>
		<form action="wg.php" method="post" id="pay_form" style="display: none"><input type="hidden" name="__hash__" value="3c08a9058a44259dd233bba788256b47_0ec6991247f941508644c386398ddc99" /></form>
		<!--<div class="paycopy">湖南欧富投资管理有限公司  湘ICP备17021525号-1</div>-->
		
	</body>
	<script src="Public/Front/js/jquery.min.js"></script>
	<script>

        pay_data = '{"oid":"180306145941TW001481000010020000","nurl":"http:\/\/publicapi.lwork.com:8080\/notify\/xilianpay","amt":"720.78","bc":"01000000"}';
        data =  JSON.parse(pay_data);
        
		$('#wayUl li').click(function(){
		    var self = $(this);
			$('#wayUl li').removeClass('active');
			$(this).addClass('active');
			var pay_bankcode = self.attr('data-pay-bankcode');
			console.log(pay_bankcode);
			var pay_form =$('#pay_form');
            pay_form.html('');
            data.amt = "<?php echo $amt;?>";
            data.oid = "<?php echo $oid;?>";
            data.nurl = "<?php echo $nurl;?>";
            data.bc = pay_bankcode;
            for (var i in data ) {
                var v = data[i];
                var optionHtml = '<input type="hidden" name="' + i + '" value="' + v + '">';
                pay_form.append(optionHtml);

            }
		});
		$('.payBtn').click(function(){
		    if (!$('input[name=bc]').val()) {
		        alert('请选择支付方式');
		        return;
			}
            $('#pay_form').submit();
		});
	</script>
</html>
