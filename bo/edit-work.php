<?php 
require_once('../connect/cn-boos.php'); 
$url="../";

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE works SET titleWork=%s, categorieIdWork=%s, imageWork=%s WHERE idWork=%s",
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['categorie'], "int"),
					   GetSQLValueString($_FILES['previewwork']['name'], "text"),
					   GetSQLValueString($_POST['idWork'], "int"));


  mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
  $Result1 = mysql_query($updateSQL, $cn_bwdkadw) or die(mysql_error());

  $updateGoTo = "add-work.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_jx_edit = "-1";
if (isset($_GET['idEdit3'])) {
  $colname_jx_edit = $_GET['idEdit3'];
}
mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
$query_jx_edit = sprintf("SELECT * FROM works WHERE idWork = %s", GetSQLValueString($colname_jx_edit, "int"));
$jx_edit = mysql_query($query_jx_edit, $cn_bwdkadw) or die(mysql_error());
$row_jx_edit = mysql_fetch_assoc($jx_edit);
$totalRows_jx_edit = mysql_num_rows($jx_edit);

mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
$query_jx_categories = "SELECT idCategorie, nomCategorie FROM categorie";
$jx_categories = mysql_query($query_jx_categories, $cn_bwdkadw) or die(mysql_error());

?>
 <!--DOCTYPE-->
 
 <?php require_once ($url."inc/doctype.inc.php");?>
<title>AdminSide Edit slide</title>

<!--HEADER-->
<?php require_once ($url."inc/header.inc.php");?>

<!--SIDEBAR-->
<?php require_once ($url."inc/sidebar.inc.php");?>


<!--ZONE CONTENT-->
<div class="row-fluid rowfluidblog">

<h4>Editer un slide</h4>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Id:</td>
      <td><?php echo $row_jx_edit['idWork']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Titre:</td>
      <td><input type="text" name="title" value="<?php echo htmlentities($row_jx_edit['titleWork'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>

	<tr valign="baseline">    
          <td align="right">Catégorie</td>
         <td><select id="categorieSlide" name="categorie">
    <?php
    for($i = 0; $i < mysql_num_rows($jx_categories); $i++ ){
        $row_jx_categories = mysql_fetch_array($jx_categories, MYSQL_ASSOC); //Récupère dans un tableau une catégorie
    ?>
            <option value="<?php echo $row_jx_categories['idCategorie']; ?>"><?php echo $row_jx_categories['nomCategorie']; ?></option>
    <?php
    }
    ?>
        </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="Mettre à jour le post"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="idWork" value="<?php echo $row_jx_edit['idWork']; ?>">
</form>
<p><a href="add-slide.php">Vers AdminSide Add slide</a></p>
</div>
	</div>

<!--FOOTER-->
<?php require_once ($url."inc/footer.inc.php");?>	
 