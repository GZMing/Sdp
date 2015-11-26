<?php
require_once ('config.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="text/html; charset=utf-8" />
<title>SUC管理中心</title>
<?php include 'head.html';?>
<?php
	//判断用户权限
	if($_SESSION['member'] != "$adminor"){
	echo "<script>alert('请进行登陆');location='index.php';</script>";
	}
	//分页显示
	$sql="select * from member order by id asc";
	$result=mysql_query($sql);
	$total=mysql_num_rows($result);
	$page=isset($_GET['page'])?intval($_GET['page']):1;  
	$info_num=2; 
	$pagenum=ceil($total/$info_num); 
	If($page>$pagenum || $page == 0){
       Echo "Error : Can Not Found The page .";
       Exit;
	}
	$offset=($page-1)*$info_num; 
	$info=mysql_query("select * from member order by id desc limit $offset,$info_num"); 
?>
<?php
	//删除用户
	if($_GET["tj"]=="del"){
	mysql_query($sql="delete from member where member_user='".$_GET['member']."'");
	echo "<script>alert('删除成功');location='admin_index.php';</script>";
	}
?>
<?php
	//修改用户
	if($_GET["tj"]=="modify"){
	$sql="select * from member where member_user='".$_GET['member']."'";
	$rs=mysql_fetch_array(mysql_query($sql));
	//提交修改
	if($_POST["submit"]){	
	mysql_query($sql="update member set member_name='".$_POST['member_name']."',member_qq='".$_POST['member_qq']."',member_phone='".$_POST['member_phone']."',member_email='".$_POST['member_email']."' where member_user='".$_GET['member']."'");
	echo "<script>alert('修改成功');location='admin_index.php';</script>";
	}
?>
</head>
<body>
<form method="post" action="" style="margin-top:3px; margin-bottom:3px; font-weight: bold;">
<table width="auto" height="239" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td height="26" colspan="2" align="center" bgcolor="#EBEBEB"><p>修改用户<? echo $user; ?>的信息</p></td>
    </tr>
  <tr>
    <td width="59" height="26" align="center" bgcolor="#FFFFFF"> 账号：</td>
    <td width="268" align="left" bgcolor="#FFFFFF"><? echo $rs['member_user'];?></td>
  </tr>
  <tr>
    <td height="28" align="center" bgcolor="#FFFFFF">姓名：</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_name" type="text" id="member_name" maxlength="20" value="<? echo $rs['member_name'];?>"/></td>
  </tr>
  <tr>
    <td height="26" align="center" bgcolor="#FFFFFF">性别：</td>
    <td align="left" bgcolor="#FFFFFF"><? echo $rs['member_sex'];?></td>
  </tr>
  <tr>
    <td height="28" align="center" bgcolor="#FFFFFF">QQ：</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_qq" type="text" id="member_qq" value="<? echo $rs['member_qq'];?>" maxlength="20"/></td>
  </tr>
  <tr>
    <td height="33" align="center" bgcolor="#FFFFFF">手机：</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_phone" type="text" id="member_phone" value="<? echo $rs['member_phone'];?>" maxlength="20"/></td>
  </tr>
  <tr>
    <td height="36" align="center" bgcolor="#FFFFFF">邮箱：</td>
    <td align="left" bgcolor="#FFFFFF"><input name="member_email" type="text" id="member_email" value="<? echo $rs['member_email'];?>" maxlength="30"/></td>
  </tr>
  <tr>
    <td height="27" colspan="2" align="center" bgcolor="#FFFFFF"><input type="reset" name="button" id="button" value="重置" />
      <input type="submit" name="submit" id="submit" value="提交" /></td>
    </tr>
</table>
</form>
<?php } ?>
<table width="auto" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td align="center" bgcolor="#FFFFFF">
      <?php echo "SUC有".$total."个用户，请对用户信息进行管理";?>&nbsp;<a href='member.php'>返回个人中心
    </td>
  </tr>
</table>

<?php while($rs=mysql_fetch_array($info)){ ?>
<table width="350" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
  <tr>
    <td colspan="2" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td width="62" align="center" bgcolor="#FFFFFF">账号:</td>
    <td width="265" bgcolor="#FFFFFF"><?php echo $rs['member_user']; ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">姓名</td>
    <td bgcolor="#FFFFFF"><?php echo $rs['member_name']; ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">性别</td>
    <td bgcolor="#FFFFFF"><?php echo $rs['member_sex']; ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">QQ</td>
    <td bgcolor="#FFFFFF"><?php echo $rs['member_qq']; ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">手机</td>
    <td bgcolor="#FFFFFF"><?php echo $rs['member_phone']; ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">邮箱</td>
    <td bgcolor="#FFFFFF"><?php echo $rs['member_email']; ?></td>
  </tr>
  <tr>
    <td align="center" bgcolor="#FFFFFF">管理</td>
    <td bgcolor="#FFFFFF"><?php echo "<a href='?tj=modify&member=".$rs['member_user']."'>修改</a>&nbsp&nbsp";?>
	<?php echo "<a href='?tj=del&member=".$rs['member_user']."'>删除</a>" ?>	</td>
  </tr>
</table>
<?php } ?>
	<table width="350" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B3B3B3">
      <tr>
        <td align="center" bgcolor="#FFFFFF"><?php
	if( $page > 1 )
    {
    	echo "<a href='admin_index.php?page=".($page-1)."'>前一页</a>&nbsp";
	}else{
   	echo "前一页&nbsp&nbsp";
	}
	for($i=1;$i<=$pagenum;$i++){
       $show=($i!=$page)?"<a href='admin_index.php?page=".$i."'>".$i."</a>":"$i";
       Echo $show." ";
	}
	if( $page<$pagenum)
    {
    	echo "<a href='admin_index.php?page=".($page+1)."'>后一页</a>";
	}else
	{
		echo "后一页";
     }
?></td>
</tr>
</table>

<?php include 'footer.html';?>
</body>
</html>