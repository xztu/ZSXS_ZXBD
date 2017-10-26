<?php
/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170905
 *
 */
 
session_start();

require_once '../public.php';
$pdo = new DataBase;
$db = $pdo->mysqlconn();


//检查是否登录
if(is_numeric($_SESSION["phone"]) && (strlen($_SESSION["phone"] != 11))){
	$isLogin = true;
	$sql = "取出信息";
	//检查是否确认使用须知
	$sql = "SELECT * FROM fdyxx WHERE lxdh = '".$_SESSION["phone"]."'";
	$rs = $db->query($sql);
	$info = $rs->fetch(PDO::FETCH_ASSOC);
	if(empty($info["id"])){
		$isLogin = false;
	} else {
		$isLogin = true;
	}
} else {
	$isLogin = false;
}

//登录
if($_POST["phone"]){
	if(!is_numeric($_POST["phone"]) || strlen($_POST["phone"]) != 11){
		die("<script language=javascript>alert('手机号码输入不正确！');window.location='index.php';</script>");
	} else {
		$sql = "SELECT * FROM fdyxx WHERE lxdh = '".$_POST["phone"]."'";
		$rs = $db->query($sql);
		$uinfo = $rs->fetch(PDO::FETCH_ASSOC);
		
		$sql = "SELECT * FROM yd_verification_code WHERE phone = '".$uinfo["lxdh"]."' ORDER BY id DESC";
		$rs = $db->query($sql);
		$info = $rs->fetch(PDO::FETCH_ASSOC);
		if($info["code"] != $_POST["code"]){
		    die("<script language=javascript>alert('验证码输入不正确，请重新输入！');window.location='index.php';</script>");
		} else {
		    $start = $info["time"];
		    $end = date("Y/m/d H:i:s");
		    $term = $info["term"];
		    $countmin=floor((strtotime($end)-strtotime($start))/60);
		    if($countmin > $term){
		        die("<script language=javascript>alert('验证码超时，请重新获取验证码！');window.location='index.php';</script>");
		    } else {
		        $_SESSION["phone"] = $uinfo["lxdh"];
		        $_SESSION["xi"] = $uinfo["xi"];
		        $_SESSION["xm"] = $uinfo["xm"];
		        $sql = "UPDATE yd_user SET last = '".$end."' WHERE phone = '".$info["phone"]."'";
		        $rs = $db->exec($sql);
		        $sql = "INSERT INTO yd_log (`datetime`, `type`, `user`) VALUES ('".$end."','登录','".$info["phone"]."')";
		        $rs = $db->exec($sql);
		        die("<script language=javascript>alert('登录成功！');window.location='index.php';</script>");
		    }
		}
		
		/*
		if($_POST["password"] != $info["mm"]){
			die("<script language=javascript>alert('手机号码或密码输入不正确！');window.location='index.php';</script>");
		} else {
			$sql = "SELECT * FROM yd_verification_code WHERE phone = '".$info["lxdh"]."' ORDER BY id DESC";
			$rs = $db->query($sql);
			$info = $rs->fetch(PDO::FETCH_ASSOC);
			if($info["code"] != $_POST["code"]){
				die("<script language=javascript>alert('验证码输入不正确，请重新输入！');window.location='index.php';</script>");
			} else {
				$start = $info["time"];
				$end = date("Y/m/d H:i:s");
				$term = $info["term"];
				$countmin=floor((strtotime($end)-strtotime($start))/60);
				if($countmin > $term){
					die("<script language=javascript>alert('验证码超时，请重新获取验证码！');window.location='index.php';</script>");
				} else {
					$_SESSION["phone"] = $info["phone"];
					$sql = "UPDATE yd_user SET last = '".$end."' WHERE phone = '".$info["phone"]."'";
					$rs = $db->exec($sql);
					$sql = "INSERT INTO yd_log (`datetime`, `type`, `user`) VALUES ('".$end."','登录','".$info["phone"]."')";
					$rs = $db->exec($sql);
					die("<script language=javascript>alert('登录成功！');window.location='index.php';</script>");
				}
			}
		}
		*/
	}
}

//载入页面
if($isLogin){/*
	if($isConfirm){
	    $sql = "SELECT * FROM yd_user WHERE phone = '".$_SESSION["phone"]."'";
	    $rs = $db->query($sql);
	    $info = $rs->fetch(PDO::FETCH_ASSOC);
	    if($info["department"] == "招生工作领导组"){
	        require "./require/main_ldz.php";
	    } else {
	        require "./require/main.php";
	    }
	} else {
		require "./require/confirm.php";
	}*/
    require "./require/qrcode.php";
} else {
    require "./require/login.php";
}
?>