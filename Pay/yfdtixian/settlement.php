﻿<?php
	/* *
 * 退款调试入口页面
 * 版本：1.0
 * 日期：2015-03-26
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码。
 */
	$time		= time();
	$tradeDate	= date("Ymd",$time);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>支付商户接口范例-结算查询</title>
	<!--
	<link rel="stylesheet" type="text/css" href="styles.css">
	<link href="Styles/mobaopay.css" type="text/css" rel="stylesheet" />
	-->
</head>
<body>
    <table width="50%" border="0" align="center" cellpadding="0" cellspacing="0" style="border: solid 1px #107929">
        <tr>
            <td>
                <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
                    <tr>
                        <td height="30" colspan="2" bgcolor="#6BBE18">
                            <span style="color: #FFFFFF"><a href="index.php">感谢您使用支付平台</a></span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" bgcolor="#CEE7BD">
                            结算查询：
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <form method="post" action="settlementOrd.php">
                            <table>
                                <tr>
									<td align="left" width="30%">
										&nbsp;&nbsp;开始日期
									</td>
									<td align="left">
										&nbsp;&nbsp;<input size="50" type="text" name="startDate" id="startDate" value="<?php echo ($tradeDate -1); ?>" />
									</td>
								</tr>
								<tr>
									<td align="left" width="30%">
										&nbsp;&nbsp;结束日期
									</td>
									<td align="left">
										&nbsp;&nbsp;<input size="50" type="text" name="endDate" id="endDate" value='<?php echo $tradeDate; ?>' />
									</td>
								</tr>
								<tr>
									<td align="left" width="30%">
										&nbsp;&nbsp;起始条数
									</td>
									<td align="left">
										&nbsp;&nbsp;<input size="50" type="text" name="startIndex" id="startIndex" value="10" />
									</td>
								</tr>
								<tr>
									<td align="left" width="30%">
										&nbsp;&nbsp;结束条数
									</td>
									<td align="left">
										&nbsp;&nbsp;<input size="50" type="text" name="endIndex" id="endIndex" value="14" />
									</td>
								</tr>
                                <tr>
                                    <td align="left">
                                        &nbsp;
                                    </td>
                                    <td align="left">
                                        &nbsp;&nbsp;<input type="submit" value="马上提交" />
                                    </td>
                                </tr>
                            </table>
                            </form>
                        </td>
                    </tr>
                    <tr>
                        <td height="5" bgcolor="#6BBE18" colspan="2">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
