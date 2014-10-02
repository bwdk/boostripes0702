<?php 
// insert into dans bko.tw drive
ob_start();
session_start();

include('../connect/cn-boos.php'); 
$url="../";

$username = $_POST['username'];
$password = $_POST['password'];

 
$conn = mysql_connect($hostname_cn_bwdkadw, $username_cn_bwdkadw, $password_cn_bwdkadw);
mysql_select_db($database_cn_bwdkadw, $conn);
 
$username = mysql_real_escape_string($username);
$query = "SELECT id, username, password, salt
FROM users
WHERE username = '$username';";
 
$result = mysql_query($query) or die(mysql_error());

if(mysql_num_rows($result) == 0) // User not found. So, redirect to login_form again.
{
header('Location: form.php');
exit();
}

$userData = mysql_fetch_array($result, MYSQL_ASSOC);
$hash = "pass";
/*$hash = hash('jojo', $userData['salt'] . hash('jojo', $password) );*/
 
if($hash != $userData['password']) // Incorrect password. So, redirect to login_form again.
{
header('Location: form.php');
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