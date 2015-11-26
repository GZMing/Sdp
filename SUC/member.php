<?php 
require_once ('config.php'); 
//判断用户权限
if(empty($_SESSION['member'])){
	echo "<script>alert('请进行登陆或注册');location='index.php';</script>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SUC个人中心</title>
<?php include 'head.html';?>
</head>
<body>
<?php
//注销操作
if($_GET["tj"]=="destroy"){
session_destroy();
echo "<script>location='index.php';</script>";}
?>
<?php
//用户修改
if($_GET["tj"]=="modify") {
if($_POST["submit"]){
	mysql_query($sql="update member set member_name='".$_POST['member_name']."',member_qq='".$_POST['member_qq']."',member_phone='".$_POST['member_phone']."',member_email='".$_POST['member_email']."' where member_user='".$_SESSION['member']."'");
	echo "<script>alert('修改成功');location='member.php';</script>";
} ?>
<?php
//显示用户
$sql="select * from member where member_user='".$_SESSION['member']."'";
$rs=mysql_fetch_array(mysql_query($sql));
?>
<table width="350" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td align="center" bgcolor="#EBEBEB">修改我的信息&nbsp;&nbsp;<a href="member.php">返回个人中心</a></td>
  </tr>
</table>
<form method="post" action="" style="margin-top:3px; margin-bottom:3px;">
<table width="350" height="212" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td width="59" height="26" align="center" bgcolor="#FFFFFF">账号:</td>
    <td width="268" align="left" bgcolor="#FFFFFF"><? echo $rs['member_user'];?></td>
  </tr>
  <tr>
    <td height="28" align="center" bgcolor="#FFFFFF">姓名:</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_name" type="text" id="member_name" maxlength="20" value="<? echo $rs['member_name'];?>"/></td>
  </tr>
  <tr>
    <td height="26" align="center" bgcolor="#FFFFFF">性别:</td>
    <td align="left" bgcolor="#FFFFFF"><? echo $rs['member_sex'];?></td>
  </tr>
  <tr>
    <td height="28" align="center" bgcolor="#FFFFFF">QQ：</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_qq" type="text" id="member_qq" value="<? echo $rs['member_qq'];?>" maxlength="20"/></td>
  </tr>
  <tr>
    <td height="33" align="center" bgcolor="#FFFFFF">手机:</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_phone" type="text" id="member_phone" value="<? echo $rs['member_phone'];?>" maxlength="20"/></td>
  </tr>
  <tr>
    <td height="36" align="center" bgcolor="#FFFFFF">邮箱:</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_email" type="text" id="member_email" value="<? echo $rs['member_email'];?>" maxlength="30"/></td>
  </tr>
  <tr>
    <td height="27" colspan="2" align="center" bgcolor="#FFFFFF"><input type="reset" name="button" id="button" value="重置" />
      <input type="submit" name="submit" id="submit" value="提交" /></td>
    </tr>
</table>
</form>
<?php } ?>
<?php
if($_SESSION['member'])
{?>
<?php
$result=mysql_query("select * from member where member_user='".$_SESSION['member']."'"); 
while($rs=mysql_fetch_array($result)){
?>
<table width="350" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td width="327" align="center" bgcolor="#EBEBEB" class="font">
	  <strong>Welcome:<? echo $rs['member_name'];?></strong>&nbsp;&nbsp;
	  <?php if($_SESSION['member']=="$adminor"){?><a href="admin_index.php">管理</a><?php }?>&nbsp;&nbsp;
	  <a href="service.php">云服务</a>&nbsp;&nbsp;
	  <?php echo "<a href='?tj=modify'>修改信息</a>";?>&nbsp;&nbsp;
	  <a href='?tj=destroy'>注销</a>
	</td>
  </tr>
</table>
<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="3"></td>
  </tr>
</table>

<table width="350" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td bgcolor="#FFFFFF">账号</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_user']); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">姓名</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_name']); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">性别</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_sex']); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">Q&nbsp;Q</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_qq']); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">号码</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_phone']); ?></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">邮箱</td>
    <td bgcolor="#FFFFFF"><?php echo htmlspecialchars($rs['member_email']); ?></td>
  </tr>
</table>

<table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="3"></td>
  </tr>
</table>
<?php } 
}
?>
<?php include 'footer.html';?>
</body>
</html>