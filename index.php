<?php
/** Powerd by RebetaStudio
 *
 *  http://www.rebeta.cn
 *
 * 20170720
 *
 */
 
session_start();

require_once './public.php';
$pdo = new DataBase;
$db = $pdo->mysqlconn();

if($_POST){
    
    if(is_numeric($_POST["hash"]) && is_numeric(substr($_POST["sfzh"],0,17))){
        $sql = "SELECT `sfbd`,`xm`,`bdsx` FROM `tdd` WHERE `sfzh` = '".$_POST["sfzh"]."' AND nf = '2017'";
        $rs = $db->query($sql);
        $info = $rs->fetch(PDO::FETCH_ASSOC);
        if(empty($info["xm"])){
            $error_html = '<!DOCTYPE html><html lang="zh-CN"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>在线报到丨忻州师范学院</title>
        <link rel="stylesheet" href="./css/style.css"><link rel="stylesheet" href="./css/app.css"><body><div class="login-container"><h1>忻州师范学院</h1><div class="connect">
        <p style="left: 0%;">在线报到系统 | 错误</p></div><div style="height:80px"></div><h3 style="font-size: 120%;">身份证输入不正确，请重新扫描二维码！</h3>
        <div style="height:65px"></div><h3 style="font-size: 90%;">微信搜索“&nbsp;掌上忻师&nbsp;”<br><br>即刻体验智慧校园</h3><div style="height:130px"></div><div class="footer"><div class="footer-zsxs">
        <image src="./images/logo-icon-w.png"></image><p>掌上忻师</p></div><div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
        <div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div></div></div></body></html>';
                die($error_html);
        } elseif ($info["sfbd"] == 1){
            $bdsx = $info["bdsx"];
        } else {
            //增加辅导员引导报到人数
            $sql = "SELECT * FROM `fdyxx` WHERE lxdh = '".substr($_POST["hash"],0,11)."'";
            $rs = $db->query($sql);
            $fdyinfo = $rs->fetch(PDO::FETCH_ASSOC);
            $sql = "UPDATE `fdyxx` SET `bdrs` = '".($fdyinfo["bdrs"] + 1)."' WHERE `id` = '".$fdyinfo["id"]."'";
            $status = $db->exec($sql);
            if(!$status){
                $error_html = '<!DOCTYPE html><html lang="zh-CN"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>在线报到丨忻州师范学院</title>
        <link rel="stylesheet" href="./css/style.css"><link rel="stylesheet" href="./css/app.css"><body><div class="login-container"><h1>忻州师范学院</h1><div class="connect">
        <p style="left: 0%;">在线报到系统 | 错误</p></div><div style="height:80px"></div><h3 style="font-size: 120%;">报到失败，请重新扫描二维码！</h3>
        <div style="height:65px"></div><h3 style="font-size: 90%;">微信搜索“&nbsp;掌上忻师&nbsp;”<br><br>即刻体验智慧校园</h3><div style="height:130px"></div><div class="footer"><div class="footer-zsxs">
        <image src="./images/logo-icon-w.png"></image><p>掌上忻师</p></div><div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
        <div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div></div></div></body></html>';
                die($error_html);
            }
            $sql = "SELECT COUNT(*) as bdsx FROM tdd WHERE nf = '2017' AND sfbd = '1'";
            $rs = $db->query($sql);
            $bdinfo = $rs->fetch(PDO::FETCH_ASSOC);
            $bdsx = $bdinfo["bdsx"] + 1;
            $sql = "UPDATE `tdd` SET `sfbd` = '1', `bdsj` = '".date("Y-m-d H:i:s")."', `bdsx` = '".$bdsx."', bdsj_hash = '".$_POST["hash"]."' WHERE `sfzh` = '".$_POST["sfzh"]."'";
            $status = $db->exec($sql);
            if(!$status){
                $error_html = '<!DOCTYPE html><html lang="zh-CN"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>在线报到丨忻州师范学院</title>
        <link rel="stylesheet" href="./css/style.css"><link rel="stylesheet" href="./css/app.css"><body><div class="login-container"><h1>忻州师范学院</h1><div class="connect">
        <p style="left: 0%;">在线报到系统 | 错误</p></div><div style="height:80px"></div><h3 style="font-size: 120%;">报到失败，请重新扫描二维码！</h3>
        <div style="height:65px"></div><h3 style="font-size: 90%;">微信搜索“&nbsp;掌上忻师&nbsp;”<br><br>即刻体验智慧校园</h3><div style="height:130px"></div><div class="footer"><div class="footer-zsxs">
        <image src="./images/logo-icon-w.png"></image><p>掌上忻师</p></div><div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
        <div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div></div></div></body></html>';
                die($error_html);
            }
        }
        $html = '<!DOCTYPE html><html lang="zh-CN"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>在线报到丨忻州师范学院</title>
        <link rel="stylesheet" href="./css/style.css"><link rel="stylesheet" href="./css/app.css"><body><div class="login-container"><h1>忻州师范学院</h1><div class="connect">
        <p style="left: 0%;">在线报到系统 | 报到结果</p></div><div style="height:80px"></div><h3 style="font-size: 120%;">欢迎来到忻州师范学院就读！</h3><div style="height:15px"></div>
        <h3 style="font-size: 120%;">您是第&nbsp;'.$bdsx.'&nbsp;位报到的同学！</h3>
        <div style="height:65px"></div><h3 style="font-size: 90%;">微信搜索“&nbsp;掌上忻师&nbsp;”<br><br>即刻体验智慧校园</h3><div style="height:130px"></div><div class="footer"><div class="footer-zsxs">
        <image src="./images/logo-icon-w.png"></image><p>掌上忻师</p></div><div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
        <div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div></div></div></body></html>';
        die($html);
    } else {
        $error_html = '<!DOCTYPE html><html lang="zh-CN"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>在线报到丨忻州师范学院</title>
        <link rel="stylesheet" href="./css/style.css"><link rel="stylesheet" href="./css/app.css"><body><div class="login-container"><h1>忻州师范学院</h1><div class="connect">
        <p style="left: 0%;">在线报到系统 | 错误</p></div><div style="height:80px"></div><h3 style="font-size: 120%;">参数不正确，请重新扫描二维码！</h3>
        <div style="height:65px"></div><h3 style="font-size: 90%;">微信搜索“&nbsp;掌上忻师&nbsp;”<br><br>即刻体验智慧校园</h3><div style="height:130px"></div><div class="footer"><div class="footer-zsxs">
        <image src="./images/logo-icon-w.png"></image><p>掌上忻师</p></div><div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
        <div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div></div></div></body></html>';
        die($error_html);
    }
    die();
} else {
    $html = '<!DOCTYPE html><html lang="zh-CN"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>在线报到丨忻州师范学院</title>
        <link rel="stylesheet" href="./css/style.css"><link rel="stylesheet" href="./css/app.css"><body><div class="login-container"><h1>忻州师范学院</h1><div class="connect">
        <p style="left: 0%;">在线报到系统</p></div><form action="index.php" method="post" id="loginForm"><div style="display: none;">
        <input type="text" id="hash" name="hash" class="hash" placeholder="HASH" autocomplete="off" value="'.$_GET["hash"].'"></div><div>
        <input type="text" id="sfzh" name="sfzh" class="password" placeholder="身&nbsp;&nbsp;份&nbsp;&nbsp;证&nbsp;&nbsp;号" autocomplete="off">	</div>
        <button id="submit" type="submit">报&nbsp;到</button></form>	<div style="height:30px"></div><div class="footer"><div class="footer-zsxs">
        <image src="./images/logo-icon-w.png"></image><p>掌上忻师</p></div><div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
        <div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div></div></div></body></html>';
    
    if(is_numeric($_GET["hash"]) && (strlen($_GET["hash"]) == 25)){
        //验证二维码是否超出有效期（生成超过1分钟）
        $time = substr($_GET["hash"],11,14);
        if(date("YmdHis") > ($time + 100)){
            $error_html = '<!DOCTYPE html><html lang="zh-CN"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>在线报到丨忻州师范学院</title>
        <link rel="stylesheet" href="./css/style.css"><link rel="stylesheet" href="./css/app.css"><body><div class="login-container"><h1>忻州师范学院</h1><div class="connect">
        <p style="left: 0%;">在线报到系统 | 错误</p></div><div style="height:80px"></div><h3 style="font-size: 120%;">二维码超出有效期，请重新扫描二维码！</h3>
        <div style="height:65px"></div><h3 style="font-size: 90%;">微信搜索“&nbsp;掌上忻师&nbsp;”<br><br>即刻体验智慧校园</h3><div style="height:130px"></div><div class="footer"><div class="footer-zsxs">
        <image src="./images/logo-icon-w.png"></image><p>掌上忻师</p></div><div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
        <div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div></div></div></body></html>';
            die($error_html);
        }
        //验证二维码是否无效（Hash携带的辅导员电话无效）
        $sql = "SELECT * FROM `fdyxx` WHERE lxdh = '".substr($_GET["hash"],0,11)."'";
        $rs = $db->query($sql);
        $info = $rs->fetch(PDO::FETCH_ASSOC);
        if(empty($info["lxdh"])){
            $error_html = '<!DOCTYPE html><html lang="zh-CN"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>在线报到丨忻州师范学院</title>
        <link rel="stylesheet" href="./css/style.css"><link rel="stylesheet" href="./css/app.css"><body><div class="login-container"><h1>忻州师范学院</h1><div class="connect">
        <p style="left: 0%;">在线报到系统 | 错误</p></div><div style="height:80px"></div><h3 style="font-size: 120%;">二维码无效，请重新扫描二维码！</h3>
        <div style="height:65px"></div><h3 style="font-size: 90%;">微信搜索“&nbsp;掌上忻师&nbsp;”<br><br>即刻体验智慧校园</h3><div style="height:130px"></div><div class="footer"><div class="footer-zsxs">
        <image src="./images/logo-icon-w.png"></image><p>掌上忻师</p></div><div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
        <div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div></div></div></body></html>';
            die($error_html);
        }
        print $html;
    } else {
        $error_html = '<!DOCTYPE html><html lang="zh-CN"><meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"><title>在线报到丨忻州师范学院</title>
        <link rel="stylesheet" href="./css/style.css"><link rel="stylesheet" href="./css/app.css"><body><div class="login-container"><h1>忻州师范学院</h1><div class="connect">
        <p style="left: 0%;">在线报到系统 | 错误</p></div><div style="height:80px"></div><h3 style="font-size: 120%;">参数不正确，请重新扫描二维码！</h3>
        <div style="height:65px"></div><h3 style="font-size: 90%;">微信搜索“&nbsp;掌上忻师&nbsp;”<br><br>即刻体验智慧校园</h3><div style="height:130px"></div><div class="footer"><div class="footer-zsxs">
        <image src="./images/logo-icon-w.png"></image><p>掌上忻师</p></div><div class="footer-other">招生就业指导处 · 大学生就业创业小组</div>
        <div class="footer-other">Copyright © 2016-2017 XZTC. All Rights Reserved</div></div></div></body></html>';
        die($error_html);
    }
}
?>