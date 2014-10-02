<?php 
// insert into dans bko.tw drive
ob_start();
session_start();

include('../connect/cn-boos.php'); 
$url="../";

$username = $_POST['username'];
$password = $_POST['password'];
$page = "login.php";
 
$conn = mysql_connect($hostname_cn_bwdkadw, $username_cn_bwdkadw, $password_cn_bwdkadw);
mysql_select_db($database_cn_bwdkadw, $conn);
 
$username = mysql_real_escape_string($username);
$query = "SELECT id, username, password, salt
FROM users
WHERE username = '$username';";
 
$result = mysql_query($query) or die(mysql_error());

if(mysql_num_rows($result) == 0 AND $page == "login.php") // User not found. So, redirect to login_form again.
{
header('Location: login.php');
exit();
}

$userData = mysql_fetch_array($result, MYSQL_ASSOC);
$hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );
 
if($hash != $userData['password']) // Incorrect password. So, redirect to login_form again.
{
header('Location: login.php');
exit();
}else{ // Redirect to admin page after successful login.
session_regenerate_id();
$_SESSION['sess_user_id'] = $userData['id'];
$_SESSION['sess_username'] = $userData['username'];
session_write_close();
header('Location: admin.php');
exit();
}
?>
 <!--DOCTYPE-->
 
 <?php require_once ($url."inc/doctype.inc.php");?>
<title>Login</title>

<!--HEADER-->
<?php require_once ($url."inc/header.inc.php");?>



<!--ZONE CONTENT-->
<div class="row-fluid rowfluidblog">
<form id="form1" name="form1" method="post" action="admin.php">
<table width="510" border="0" align="center">
<tr>
<td colspan="2">Login Form</td>
</tr>
<tr>
<td>Username:</td>
<td><input type="text" name="username" id="username" /></td>
</tr>
<tr>
<td>Password</td>
<td><input type="password" name="password" id="password" /></td>
</tr>
<tr>
<td>&nbsp;</td>
<td><input type="submit" name="button" id="button" value="Submit" /></td>
</tr>
</table>
</form>
	</div>

<!--FOOTER-->
<?php require_once ($url."inc/footer.inc.php");?>	
 