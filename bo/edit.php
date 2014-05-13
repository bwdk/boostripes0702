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


$erreur=""; // initialisation de la variable erreur	

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE news SET titreNews=%s, titreVideoNews=%s, descriptionNews=%s, categorieIdNews=%s, previewNews=%s, videoNews=%s WHERE idNews=%s",
                       GetSQLValueString($_POST['title'], "text"),
					   GetSQLValueString($_POST['titlev'], "text"),
                       GetSQLValueString($_POST['text'], "text"),
					   GetSQLValueString($_POST['categorie'], "int"),
					   GetSQLValueString($_FILES['preview']['name'], "text"),
					   GetSQLValueString($_POST['video'], "text"),
                       GetSQLValueString($_POST['idNews'], "int"));

   //***** vérification du format du fichier ****//
 
 if(!preg_match('#jpg|jpeg|bmp|png|gif|tif#i',$_FILES['preview']['name'])) $erreur=5;
 else {
 //****** upload du fichier ****//
  
  $source=$_FILES['preview']['tmp_name'];
  $cible="../img/news/".$_FILES['preview']['name']; 
  move_uploaded_file($source,$cible);
 }
  //******** vérification erreur de transfert 
  if ($_FILES['preview']['error']!=0)
  $erreur=$_FILES['preview']['error'];
  
 
  mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
  $Result1 = mysql_query($updateSQL, $cn_bwdkadw) or die(mysql_error());
  
  //


           switch ($erreur){
                   case 1: // UPLOAD_ERR_INI_SIZE
                   $erreur="Le fichier dépasse la limite autorisée par le serveur !";
                   break;
                   case 2: // UPLOAD_ERR_FORM_SIZE
                   $erreur= "Le fichier dépasse la limite autorisée dans le formulaire HTML !";
                   break;
                   case 3: // UPLOAD_ERR_PARTIAL
                   $erreur= "L'envoi du fichier a été interrompu pendant le transfert !";
                   break;
                   case 4: // UPLOAD_ERR_NO_FILE
                   $erreur ="Le fichier que vous avez envoyé a une taille nulle !";
                   break;
				   case 5: // RESULTAT EXPRESSION REGULIERE SUR LE TYPE
                   $erreur= "seuls les fichiers de type image sont autorisés!!";
                   break;
          }
  
  

  $updateGoTo = "admin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_jx_edit = "-1";
if (isset($_GET['idEdit'])) {
  $colname_jx_edit = $_GET['idEdit'];
}
mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
$query_jx_edit = sprintf("SELECT * FROM news WHERE idNews = %s", GetSQLValueString($colname_jx_edit, "int"));
$jx_edit = mysql_query($query_jx_edit, $cn_bwdkadw) or die(mysql_error());
$row_jx_edit = mysql_fetch_assoc($jx_edit);
$totalRows_jx_edit = mysql_num_rows($jx_edit);

mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
$query_jx_categories = "SELECT idCategorie, nomCategorie FROM categorie";
$jx_categories = mysql_query($query_jx_categories, $cn_bwdkadw) or die(mysql_error());

?>
 <!--DOCTYPE-->
 
 <?php require_once ($url."inc/doctype.inc.php");?>
<title>AdminSide Edit post</title>

<!--HEADER-->
<?php require_once ($url."inc/header.inc.php");?>

<!--SIDEBAR-->
<?php require_once ($url."inc/sidebar.inc.php");?>


<!--ZONE CONTENT-->
<div class="row-fluid rowfluidblog">

<h4>Editer un post</h4>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
<input type="hidden" name="MAX_FILE_SIZE" value="99999" />
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Id</td>
      <td><?php echo $row_jx_edit['idNews']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Titre</td>
      <td><input type="text" name="title" value="<?php echo htmlentities($row_jx_edit['titreNews'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
	<tr valign="baseline">
      <td nowrap align="right">Titre Video</td>
      <td><input type="text" name="titlev" value="<?php echo htmlentities($row_jx_edit['titreVideoNews'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
    <tr valign="top">
      <td nowrap align="right">Description</td>
      <td><textarea name="text" type="textarea" value="<?php echo htmlentities($row_jx_edit['descriptionNews'], ENT_COMPAT, ''); ?>" cols="50" rows="5"><?php echo htmlentities($row_jx_edit['descriptionNews'], ENT_COMPAT, ''); ?></textarea></td>
    </tr>
	<tr valign="baseline">
      <td nowrap align="right">Preview (600 x 400 px)</td>
      <td><input type="file" name="preview" id="preview" value="<?php echo htmlentities($row_jx_edit['previewNews'], ENT_COMPAT, ''); ?>" size="32"></td>
    </tr>
	<tr valign="top">
      <td nowrap align="right">Video (290 x 193 px)</td>
      <td><textarea name="video" type="text" value="<?php echo htmlentities($row_jx_edit['videoNews'], ENT_COMPAT, ''); ?>" size="64"><?php echo htmlentities($row_jx_edit['videoNews'], ENT_COMPAT, ''); ?></textarea></td>
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
      <td><input type="submit" value="Update"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1">
  <input type="hidden" name="idNews" value="<?php echo $row_jx_edit['idNews']; ?>">
</form>
<p><a href="admin.php">Vers AdminSide Home</a></p>
</div>
	</div>

<!--FOOTER-->
<?php require_once ($url."inc/footer.inc.php");?>	
 