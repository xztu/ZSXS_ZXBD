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

$sql = "SELECT sum(bdrs) as bdrs FROM fdyxx";
$rs = $db->query($sql);
$uinfo1 = $rs->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) as bd FROM tdd WHERE nf = '2017' AND kslx = '对口升学' AND sfbd = '1'";
$rs = $db->query($sql);
$ninfo1 = $rs->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) as wbd FROM tdd WHERE nf = '2017' AND kslx = '对口升学' AND sfbd = '0'";
$rs = $db->query($sql);
$ninfo12 = $rs->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) as bd FROM tdd WHERE nf = '2017' AND kslx = '普通高考' AND sfbd = '1'";
$rs = $db->query($sql);
$ninfo2 = $rs->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) as wbd FROM tdd WHERE nf = '2017' AND kslx = '普通高考' AND sfbd = '0'";
$rs = $db->query($sql);
$ninfo22 = $rs->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) as bd FROM tdd WHERE nf = '2017' AND kslx = '专升本' AND sfbd = '1'";
$rs = $db->query($sql);
$ninfo3 = $rs->fetch(PDO::FETCH_ASSOC);

$sql = "SELECT count(*) as wbd FROM tdd WHERE nf = '2017' AND kslx = '专升本' AND sfbd = '0'";
$rs = $db->query($sql);
$ninfo32 = $rs->fetch(PDO::FETCH_ASSOC);

$kslx = '普通高考';
$sql = "SELECT DISTINCT(zymc) FROM `tdd` WHERE `kslx` = '".$kslx."'";
$rs = $db->query($sql);
$zymcRes = $rs->fetchall(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>报到情况丨在线报到丨忻州师范学院</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/app.css">
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
<body>

<div class="login-container">
	<h1>忻州师范学院</h1>
	
	<div class="connect">
		<p style="left: 0%;">在线报到系统&nbsp;|&nbsp;报到情况</p>
	</div>
	<div style="height:30px"></div>
	<h3 id="qrcodeTitleInfo1"><?php print $_SESSION["xi"]."&nbsp;".$_SESSION["xm"]?></h3>
	<div style="height:15px"></div>
	<h3 id="qrcodeTitle">以下数据&nbsp;0&nbsp;秒后更新</h3>
	<div style="height:30px"></div>
	<h3 id="qrcodeTitleInfo2"><?php print "您已经引导报到&nbsp;".$uinfo["bdrs"]."&nbsp;人"?></h3>
	<div style="height:15px"></div>
	<h3 id="qrcodeTitleInfo3"><?php print "全体辅导员已引导报到&nbsp;".$uinfo1["bdrs"]."&nbsp;人"?></h3>
	<div style="height:30px"></div>
	<div>对口升学</div>
	<div style="height:10px"></div>
	<div id="num1"><?php print "已报到：".$ninfo1["bd"]."人&nbsp;&nbsp;未报到：".$ninfo12["wbd"]."人";?></div>
	<div style="height:10px"></div>
	<a style="color:white;" href="index.php?kslx=1">点击查看分专业报到情况</a>
	<div style="height:20px"></div>
	<a>普通高考</a>
	<div style="height:10px"></div>
	<div id="num2"><?php print "已报到：".$ninfo2["bd"]."人&nbsp;&nbsp;未报到：".$ninfo22["wbd"]."人";?></div>
	<div style="height:10px"></div>
	<a style="color:white;" href="index.php?kslx=2">点击查看分专业报到情况</a>
	<div style="height:20px"></div>
	<a>专&nbsp;升&nbsp;本</a>
	<div style="height:10px"></div>
	<div id="num3"><?php print "已报到：".$ninfo3["bd"]."人&nbsp;&nbsp;未报到：".$ninfo32["wbd"]."人";?></div>
	<div style="height:10px"></div>
	<a style="color:white;" href="index.php?kslx=3">点击查看分专业报到情况</a>
	<div style="height:30px"></div>
	<h3 id="qrcodeInfo">请您保持网络畅通</h3>
	<div style="height:30px"></div>
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
	$(function(){
		$("#logout").click (function () {
			$.post("../logout.php",{},function(data){$("#end").html(data);});
		})
		var t; 
		t = 30;
		setInterval(function(){
			t = t-1;
			$('#qrcodeTitle').html("以下数据&nbsp;"+t+"&nbsp;秒后更新");
			if (t<=0) 
			{ 
				document.location.reload(); 
			} 
		},1000);
	}); 
</script>
</html>
