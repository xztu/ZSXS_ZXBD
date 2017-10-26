<?php 
/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170905
 * 
 *
 */

$code = $_SESSION["phone"].date("YmdHis");

$sql = "SELECT * FROM fdyxx WHERE lxdh = '".$_SESSION["phone"]."'";
$rs = $db->query($sql);
$uinfo = $rs->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>二维码丨在线报到丨忻州师范学院</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/app.css">
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="../js/jquery.qrcode.js"></script>
<script type="text/javascript" src="../js/qrcode.js"></script>
<body>

<div class="login-container">
	<h1>忻州师范学院</h1>
	
	<div class="connect">
		<p style="left: 0%;">在线报到系统&nbsp;|&nbsp;二维码</p>
	</div>
	<div style="height:30px"></div>
	<h3 id="qrcodeTitleInfo1"><?php print $_SESSION["xi"]."&nbsp;".$_SESSION["xm"]?></h3>
	<div style="height:15px"></div>
	<h3 id="qrcodeTitleInfo2"><?php print "您已经引导报到&nbsp;".$uinfo["bdrs"]."&nbsp;人"?></h3>
	<div style="height:15px"></div>
	<h3 id="qrcodeTitle">以下二维码 30 秒后更新</h3>
	<div style="height:15px"></div>
	<div id="qrcodeCanvas"></div>
	<div style="height:15px"></div>
	<h3 id="qrcodeInfo">您的学生扫描以上二维码即可完成报到</h3>
	<div style="height:5px"></div>
	<h3 id="qrcodeInfo">请您保持网络畅通</h3>
	<div style="height:15px"></div>
	<div>
		<button type="button" id="logout" class="button-gl">&gt; 退出登录 &lt;</button>
	</div>
	<div id="end" style="height:30px"></div>
	<div class="footer">
		<div class="footer-zsxs">
			<image src="../images/logo-icon-w.png"></image>
			<p>掌上忻师</p>
		</div>
		<div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
		<div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div>
	</div>
</div>
</body>
<script>
	$('#qrcodeCanvas').qrcode({
		text	: <?php print "'http://m.xztc.edu.cn/2017bd/index.php?hash=".$code."'";?>
	});	
	$(function(){
		$("#logout").click (function () {
			$.post("../logout.php",{},function(data){$("#end").html(data);});
		})
		var t; 
		t = 30;
		setInterval(function(){
			t = t-1;
			$('#qrcodeTitle').html("以下二维码&nbsp;"+t+"&nbsp;秒后更新");
			if (t<=0) 
			{ 
				document.location.reload(); 
			} 
		},1000);
	}); 
</script>
</html>
