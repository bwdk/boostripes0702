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

$currentPage = $_SERVER["PHP_SELF"];

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}


$erreur=""; // initialisation de la variable erreur	
/* insert works */
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO works (idWork, titleWork, subcatIdWork, imageWork, imagethWork) VALUES (%s, %s, %s, %s, %s)",
					   GetSQLValueString($_POST['idwork'], "int"),
                       GetSQLValueString($_POST['titlework'], "text"),
					   GetSQLValueString($_POST['subcat'], "text"),
					   GetSQLValueString($_FILES['previewwork']['name'], "text"),
                       GetSQLValueString($_FILES['previewthwork']['name'], "text"));
 
 //***** vérification du format du fichier ****//
 
 if(!preg_match('#jpg|jpeg|bmp|png|gif|tif#i',$_FILES['previewthwork']['name'])) $erreur=5;
 else {
 //****** upload du fichier ****//
 
  
  $source=$_FILES['previewthwork']['tmp_name'];
  $cible="../img/work/thumbs/".$_FILES['previewthwork']['name']; 
  move_uploaded_file($source,$cible);
 }
  //******** vérification erreur de transfert 
  if ($_FILES['previewthwork']['error']!=0)
  $erreur=$_FILES['previewthwork']['error'];
  
  
  mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
  $Result1 = mysql_query($insertSQL, $cn_bwdkadw) or die(mysql_error());
  
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

  
}



/* works deletion */ 
if ((isset($_GET['idWork'])) && ($_GET['idWork'] != "")) {
  $deleteSQL = sprintf("DELETE FROM works WHERE idWork=%s",
                       GetSQLValueString($_GET['idWork'], "int"));

  mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
  $Result1 = mysql_query($deleteSQL, $cn_bwdkadw) or die(mysql_error());
}
/* paginate */
$maxRows_jx_works = 5;
$pageNum_jx_works = 0;
if (isset($_GET['pageNum_jx_works'])) {
  $pageNum_jx_works = $_GET['pageNum_jx_works'];
}
$startRow_jx_works = $pageNum_jx_works * $maxRows_jx_works;
/**/


mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);


/* cn works */
$query_jx_works = "SELECT * FROM works ORDER BY dateWork DESC";
$query_limit_jx_works = sprintf("%s LIMIT %d, %d", $query_jx_works, $startRow_jx_works, $maxRows_jx_works);
$jx_works = mysql_query($query_limit_jx_works, $cn_bwdkadw) or die(mysql_error());
$row_jx_works = mysql_fetch_assoc($jx_works);

if (isset($_GET['totalRows_jx_works'])) {
  $totalRows_jx_works = $_GET['totalRows_jx_works'];
} else {
  $all_jx_works = mysql_query($query_jx_works);
  $totalRows_jx_works = mysql_num_rows($all_jx_works);
}
$totalPages_jx_works = ceil($totalRows_jx_works/$maxRows_jx_works)-1;

$queryString_jx_works = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_jx_works") == false && 
        stristr($param, "totalRows_jx_works") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_jx_works = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_jx_works = sprintf("&totalRows_jx_works=%d%s", $totalRows_jx_works, $queryString_jx_works);


/* cn subcats */
$query_jx_subcats = "SELECT idSubcat, nomSubcat FROM subcats";
$jx_subcats = mysql_query($query_jx_subcats, $cn_bwdkadw) or die(mysql_error());


// substring
define('MAX_LENGHT_NEWS_PREVIEW', 82); //On enlève les pointillés dans le calcul donc 65 caractères apparaitront
//


?>
 <!--DOCTYPE-->
 
 <?php require_once ($url."inc/doctype.inc.php");?>
<title>AdminSide Add Work</title>

<!--HEADER-->
<?php require_once ($url."inc/header.inc.php");?>
<!--SIDEBAR-->

<!--ZONE CONTENT-->

<div class="row-fluid">
<a href="admin.php">Vers Ajout d'articles</a> - <a href="admin.php">Vers Ajout de slides</a>
<hr style="border-top:solid #CCCCCC 1px;"/>
<table border="1" cellpadding="1" cellspacing="1" id="afficheSlides" class="table-striped">
   <tr>
    <th>Id</th>
   	<th>Image</th>
	<th>Titre</th>
	<th>Cat</th>
	<th>Date</th>
	<th>Edit</th>
	<th>Del</th>
  </tr>
   <?php do { ?>
  <tr> 
    <td><?php echo $row_jx_works['idWork']; ?></td>
  	<td><a href="../work.php"><img src="../img/work/thumbs/<?php echo $row_jx_works['imagethWork']; ?>" alt="<?php echo $row_jx_works['titleWork']; ?>" width="60"/></a></td>
  	<td><?php echo $row_jx_works['titleWork']; ?></td>
	<td><?php echo $row_jx_works['subcatIdWork']; ?></td>
	<td><?php echo $row_jx_works['dateWork']; ?></td>
	<td><a href="edit-work.php?idEdit3=<?php echo $row_jx_works['idWork']; ?>">OK</a></td> 
	<td><a href="add-work.php?idWork=<?php echo $row_jx_works['idWork']; ?>">OK</a></td>  
  </tr>
  <?php } while ($row_jx_works = mysql_fetch_assoc($jx_works)); ?>
</table>
<table border="0" class="pager arrows">
  <tr>
    <td><?php if ($pageNum_jx_works > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_jx_works=%d%s", $currentPage, 0, $queryString_jx_works); ?>"><img src="First.gif" /></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_jx_works > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_jx_works=%d%s", $currentPage, max(0, $pageNum_jx_works - 1), $queryString_jx_works); ?>"><img src="Previous.gif" /></a>
        <?php } // Show if not first page ?></td>
    <td><?php if ($pageNum_jx_works < $totalPages_jx_works) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_jx_works=%d%s", $currentPage, min($totalPages_jx_works, $pageNum_jx_works + 1), $queryString_jx_works); ?>"><img src="Next.gif" /></a>
        <?php } // Show if not last page ?></td>
    <td><?php if ($pageNum_jx_works < $totalPages_jx_works) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_jx_works=%d%s", $currentPage, $totalPages_jx_works, $queryString_jx_works); ?>"><img src="Last.gif" /></a>
        <?php } // Show if not last page ?></td>
  </tr>
</table>
<hr style="border-top:solid #CCCCCC 1px;"/>

<h4>Add image work : <span style="color:#A3ADED;"></span></h4>

<form action="<?php echo $editFormAction; ?>" name="form" method="POST" enctype="multipart/form-data" class="cssform" >
<input type="hidden" name="MAX_FILE_SIZE" value="999999999" />
<table id="addSlide" class="table-striped">		
    <tr valign="baseline">
          <td align="right">Titre work</td>
        <td><input name="titlework" type="text" id="tltslide" class="fields_admin" value="" size="32" /></td>
    </tr>
	<tr valign="baseline">
          <td align="right">Sub-category</td>
        <td><select name="subcat" id="subcat" class="fields_admin">
		 <?php
    for($i = 0; $i < mysql_num_rows($jx_subcats); $i++ ){
        $row_jx_subcats = mysql_fetch_array($jx_subcats, MYSQL_ASSOC); //Recupere dans un tableau une sous-cat
    ?>
		<option value="<?php echo $row_jx_subcats['idSubcat']; ?>"><?php echo $row_jx_subcats['nomSubcat']; ?></option>
		<?php
    }
    ?>
		</select></td>
    </tr>

    <tr valign="baseline"> 	
          <td align="right">Image (1024 x 684)</td>
          <td><input type="file" name="previewwork" id="imgwork" class="fields" /></td>
    </tr>
	<tr valign="baseline"> 	
          <td align="right">Image thumb(243 x 203)</td>
          <td><input type="file" name="previewthwork" id="imgthwork" class="fields" /></td>
    </tr>
	
    <tr valign="baseline">	
          <td align="right">Valider</td>
          <td><input name="Submit" type="submit" id="Submit" value="Poster" /></td>
          <input type="hidden" name="MM_insert" value="form" />
    </tr>   
</table>    
</form>


</div>

<!--FOOTER-->

<?php require_once ($url."inc/footer.inc.php");?>	
 