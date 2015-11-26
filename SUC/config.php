<?php
if (!isset ($_SESSION)) {
	ob_start();
	session_start();
}
 $hostname="localhost"; //mysql地址
 $basename="root"; //mysql用户名
 $basepass=""; //mysql密码
 $database="reg"; //mysql数据库名称
 $adminor="admin"; //设置管理员账号

 $conn=mysql_connect($hostname,$basename,$basepass)or die("error!"); //连接mysql              
 mysql_select_db($database,$conn); //选择mysql数据库
 mysql_query("set names 'utf8'");//mysql编码
?>
