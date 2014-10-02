<?php 

include('../connect/cn-boos.php'); 
$url="../";

require_once ($url."inc/doctype.inc.php");

?>
<title>Login Form</title>

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