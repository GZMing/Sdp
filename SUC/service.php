<?php
require_once ('config.php');
//判断用户是否登陆状态
if(empty($_SESSION['member'])){
  echo "<script>location='index.php';</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sdp PaaS for Services</title>
    <?php include 'head.html';?>
  <body>
<!--main:select services-->
<?php
//注销操作
if($_GET["tj"]=="destroy"){
session_destroy();
echo "<script>location='index.php';</script>";}
?>

<?php
//显示用户
$sql="select * from member where member_user='".$_SESSION['member']."'";
$rs=mysql_fetch_array(mysql_query($sql)); //members array
?>

<?php
//判断用户权限
if($_SESSION['member']) {
  //欢迎信息
?>
  <strong style="color:white">Welcome:<? echo $rs['member_name'];?></strong>&nbsp;&nbsp;
  <a href='?tj=destroy'>注销本次登录</a>&nbsp;&nbsp;
  <a href=member.php>返回个人中心</a>
<?php } else {
  echo "<script>location='index.php';</script>";
}
?>
<!--正文-->
<form action="" method="post">
<input name="name" type="text" id="name">
<input name="password" type="password" id="name">
<input name="submit2" type="submit" value="用户登录"/>
</form>

<?php include 'footer.html';?>
  </body>
</html>
