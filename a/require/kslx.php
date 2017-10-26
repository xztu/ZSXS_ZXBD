<?php 
/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170905
 * 
 *
 */

if(!is_numeric($_GET["kslx"])){
    die("非法参数！");
}elseif ($_GET["kslx"] == '1'){
    $kslx = '对口升学';
}elseif ($_GET["kslx"] == '2'){
    $kslx = '普通高考';
}elseif ($_GET["kslx"] == '3'){
    $kslx = '专升本';
}

$sql = "SELECT DISTINCT(zymc) FROM `tdd` WHERE `kslx` = '".$kslx."' AND `nf` = '2017'";
$rs = $db->query($sql);
$zymcRes = $rs->fetchall(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="zh-CN">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>分专业报到情况丨在线报到丨忻州师范学院</title>
<link rel="stylesheet" href="../css/style.css">
<link rel="stylesheet" href="../css/app.css">
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
<body>
<a style="z-index: 9999;position: fixed ! important;top: 0px; left:0px;text-align: center;width: 100%;line-height: 2rem;background: black;color: white;" href="index.php">返回首页</a>
<div class="login-container">
	<h1>忻州师范学院</h1>
	<div class="connect">
		<p style="left: 0%;">在线报到系统&nbsp;|&nbsp;分专业报到情况</p>
	</div>
	<div style="height:30px"></div>
	<h3 id="qrcodeTitleInfo1"><?php print $_SESSION["xi"]."&nbsp;".$_SESSION["xm"]?></h3>
	<div style="height:15px"></div>
	<h3 id="qrcodeTitle">以下数据&nbsp;0&nbsp;秒后更新</h3>
	<div style="height:30px"></div>
	<h3 id="qrcodeTitleInfo3"><?php print $kslx;?></h3>
	<div style="height:5px"></div>
	<h3>分专业报到情况</h3>
	<div style="height:15px"></div>
	<?php
	   foreach ($zymcRes as $zymc) {
	       $sql = "SELECT COUNT(*) AS `num` FROM `tdd` WHERE `nf` = '2017' AND `kslx` = '".$kslx."' AND `zymc` = '".$zymc["zymc"]."' AND `sfbd` = '1'";
	       $rs = $db->query($sql);
	       $bdrs = $rs->fetch(PDO::FETCH_ASSOC);
	       $sql = "SELECT COUNT(*) AS `num` FROM `tdd` WHERE `nf` = '2017' AND `kslx` = '".$kslx."' AND `zymc` = '".$zymc["zymc"]."' AND `sfbd` = '0'";
	       $rs = $db->query($sql);
	       $wbdrs = $rs->fetch(PDO::FETCH_ASSOC);
	       print $zymc["zymc"]."<div style='height:5px'></div>已报到：".$bdrs["num"]."人&nbsp;&nbsp;未报到:".$wbdrs["num"]."人<div style='height:15px'></div>";
	   }
	?>
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
		t = 1800;
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
<?php die("<script>console.log('加载完成.')</script>");?>