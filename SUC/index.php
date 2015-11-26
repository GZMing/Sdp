<?php
require_once ('config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sdp User Center</title>
<script language="javascript" src="static/check.js"></script>
<?php include 'head.html'; ?>
<?php include 'check.php'; ?>
</head>
<body>

<!--注册表单-->
<?php if($_GET['tj'] == 'register'){ ?>
<form id="theForm" name="theForm" method="post" action="" onSubmit="return chk(this)" runat="server" style="margin-bottom:0px; font-size: 12px;">
  <table width="307" border="0" align="center" cellpadding="7" cellspacing="0" bgcolor="#B3B3B3">
    <tr>
      <td colspan="2" align="center" bgcolor="#EBEBEB"> <font color="#FF0000"><strong style="font-size:16px">Sdp User Center -- Register</strong></font></td>
    </tr>
    <tr>
      <td width="78" align="right" bgcolor="#FFFFFF"><scan style="color:red;font-size:12px"><strong>*</strong></scan>账号:</td>
      <td width="206" bgcolor="#FFFFFF">
      <input name="member_user" type="text" id="member_user" value="由数字或字母组成" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF"><scan style="color:red;font-size:12px"><strong>*</strong></scan>密码:</td>
      <td bgcolor="#FFFFFF">
      <input name="member_password" type="password" id="member_password" size="20" maxlength="20" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF"><scan style="color:red;font-size:12px"><strong>*</strong></scan>确认密码:</td>
      <td bgcolor="#FFFFFF">
      <input name="pass" type="password" id="pass" size="20" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF"><scan style="color:red;font-size:12px"><strong>*</strong></scan>真实姓名:</td>
      <td bgcolor="#FFFFFF">
      <input name="member_name" type="text" id="member_name" values="中文名" size="20" /></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF"><scan style="color:red;font-size:12px"><strong>*</strong></scan>性别:</td>
      <td align="left" bgcolor="#FFFFFF">&nbsp; &nbsp; 
      <input name="member_sex" type="radio" id="0" value="男" checked="checked" />男
      <input type="radio" name="member_sex" value="女" id="1" />女</td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">QQ:</td>
      <td bgcolor="#FFFFFF">
      <input name="member_qq" type="text" id="member_qq" size="20"/></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">手机:</td>
      <td bgcolor="#FFFFFF">
      <input name="member_phone" type="text" id="member_phone" size="20"/></td>
    </tr>
    <tr>
      <td align="right" bgcolor="#FFFFFF">邮箱:</td>
      <td bgcolor="#FFFFFF">
      <input name="member_email" type="text" id="member_email" size="20"/></td>
    </tr>
    <tr>
      <td colspan="2" align="center" bgcolor="#FFFFFF">
      <input type="reset" name="button" id="button" value="重置表单" />
      <input type="submit" name="submit" id="submit" value="确定注册" />
      <a href="index.php">返回登录</a>
      </td>
    </tr>
  </table>
</form>

<!--registry-->
<?php
}
    //submit2=check login
	if($_GET['tj']== ''){
?>
<?php
if($_POST["submit2"]){
$name=$_POST['name'];
$pw=md5($_POST['password']);
$sql="select * from member where member_user='".$name."'"; 
$result=mysql_query($sql) or die("账号不正确");
$num=mysql_num_rows($result);
if($num==0){
	echo "<script>alert('帐号不存在');location='index.php';</script>";
	}
while($rs=mysql_fetch_object($result))
{
	if($rs->member_password!=$pw)
	{
		echo "<script>alert('密码不正确');location='index.php';</script>";
		mysql_close();
	}
	else 
	{
		$_SESSION['member']=$_POST['name'];
		header("Location:member.php");
		mysql_close();
		}
	}
}
?>

<!--登录表单-->
<form action="" method="post" name="regform" onSubmit="return Checklogin();" style="margin-bottom:0px; font-size: 12px;">
<table width="280" border="0" align="center" cellpadding="8" cellspacing="0" bgcolor="#B3B3B3">
    <tr>
      <td colspan="2" align="center" bgcolor="#EBEBEB" class="font"> <font color="#FF0000"><strong style="font-size:16px">Sdp User Center -- Login</strong></font></td>
    </tr>
    <tr>
      <td width="59" align="center" bgcolor="#FFFFFF" class="font">用户名:</td>
      <td width="189" bgcolor="#FFFFFF" class="font"><input name="name" type="text" id="name"></td>
    </tr>
    <tr>
      <td align="center" valign="top" bgcolor="#FFFFFF" class="font">登录密码:</td>
      <td bgcolor="#FFFFFF" class="font"><input name="password" type="password" id="name">        </td>
    </tr>
    <tr>
      <td colspan="2" align="center" valign="top" bgcolor="#FFFFFF" class="font">
      <input name="submit2" type="submit" value="用户登录"/>
      <a href='index.php?tj=register'>没有账号？立即注册！</a></td>
    </tr>
</table>
</form>
<?php } ?>

<?php include 'footer.html';?>
</body>
</html>