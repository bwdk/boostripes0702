<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_cn_bwdkadw = "127.0.0.1";
$database_cn_bwdkadw = "bwdkadw";
$username_cn_bwdkadw = "root";
$password_cn_bwdkadw = "";
$cn_bwdkadw = mysql_pconnect($hostname_cn_bwdkadw, $username_cn_bwdkadw, $password_cn_bwdkadw) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES UTF8"); 
mysql_query("SET lc_time_names = 'fr_FR'");
mysql_query("SET character_set_results = 'UTF8'");

?>
<?php
ini_set('display_errors','off');
?>