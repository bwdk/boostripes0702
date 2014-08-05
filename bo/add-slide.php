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

/* insert slider */
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO slider (idSlider, titleSlider, categorieIdSlider, previewSlider) VALUES (%s, %s, %s, %s)",
					   GetSQLValueString($_POST['idslide'], "int"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['categorie'], "int"),
                       GetSQLValueString($_FILES['preview']['name'], "text"));
 
 //***** vérification du format du fichier ****//
 
 if(!preg_match('#jpg|jpeg|bmp|png|gif|tif#i',$_FILES['preview']['name'])) $erreur=5;
 else {
 //****** upload du fichier ****//
  
  $source=$_FILES['preview']['tmp_name'];
  $cible="../img/slide/".$_FILES['preview']['name']; 
  move_uploaded_file($source,$cible);
 }
  //******** vérification erreur de transfert 
  if ($_FILES['preview']['error']!=0)
  $erreur=$_FILES['preview']['error'];
  
  
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



/* slider deletion */ 
if ((isset($_GET['idSlider'])) && ($_GET['idSlider'] != "")) {
  $deleteSQL = sprintf("DELETE FROM slider WHERE idSlider=%s",
                       GetSQLValueString($_GET['idSlider'], "int"));

  mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
  $Result1 = mysql_query($deleteSQL, $cn_bwdkadw) or die(mysql_error());
}
/* paginate */
$maxRows_jx_slider = 5;
$pageNum_jx_slider = 0;
if (isset($_GET['pageNum_jx_slider'])) {
  $pageNum_jx_slider = $_GET['pageNum_jx_slider'];
}
$startRow_jx_slider = $pageNum_jx_slider * $maxRows_jx_slider;
/**/


mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);


/* cn slider */
$query_jx_slider = "SELECT * FROM slider ORDER BY dateSlider DESC";
$query_limit_jx_slider = sprintf("%s LIMIT %d, %d", $query_jx_slider, $startRow_jx_slider, $maxRows_jx_slider);
$jx_slider = mysql_query($query_limit_jx_slider, $cn_bwdkadw) or die(mysql_error());
$row_jx_slider = mysql_fetch_assoc($jx_slider);

if (isset($_GET['totalRows_jx_slider'])) {
  $totalRows_jx_slider = $_GET['totalRows_jx_slider'];
} else {
  $all_jx_slider = mysql_query($query_jx_slider);
  $totalRows_jx_slider = mysql_num_rows($all_jx_slider);
}
$totalPages_jx_slider = ceil($totalRows_jx_slider/$maxRows_jx_slider)-1;

$queryString_jx_slider = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_jx_slider") == false && 
        stristr($param, "totalRows_jx_slider") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_jx_slider = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_jx_slider = sprintf("&totalRows_jx_slider=%d%s", $totalRows_jx_slider, $queryString_jx_slider);



/* cn categories */
$query_jx_categories = "SELECT idCategorie, nomCategorie FROM categorie";
$jx_categories = mysql_query($query_jx_categories, $cn_bwdkadw) or die(mysql_error());




// substring
define('MAX_LENGHT_NEWS_PREVIEW', 82); //On enlève les pointillés dans le calcul donc 65 caractères apparaitront
//


?>
 <!--DOCTYPE-->
 
 <?php require_once ($url."inc/doctype.inc.php");?>
<title>AdminSide Add Slide</title>

<!--HEADER-->
<?php require_once ($url."inc/header.inc.php");?>
<!--SIDEBAR-->

<!--ZONE CONTENT-->

<div class="row-fluid">
<a href="admin.php"><button>Vers Ajout d'articles</button></a> &nbsp; <a href="add-work.php"><button>Vers Ajout de works</button></a>
<hr style="border-top:solid #CCCCCC 1px;"/>

<?php
		if((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form"))
		{
		   echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  Article <a href="../pages.php?article='.$row_jx_news['idNews'].'"><strong>'.$row_jx_news['titreNews'].'</strong></a> ajouté.</div>';
		   }
		   
	elseif ((isset($_GET['idSlider'])) && ($_GET['idSlider'] != "")) {
		echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  Slide supprimé.</div>';
		   }

?>

<table border="1" cellpadding="1" cellspacing="1" id="afficheSlides" class="table table-striped">
   <tr>
    <th>Id</th>
   	<th>Image</th>
	<th>Titre</th>
	<th>Catégorie</th>
	<th>Date</th>
	<th>Edit</th>
	<th>Del</th>
  </tr>
   <?php do { ?>
  <tr> 
    <td><?php echo $row_jx_slider['idSlider']; ?></td>
  	<td><a href="../index.php"><img src="../img/slide/<?php echo $row_jx_slider['previewSlider']; ?>" alt="<?php echo $row_jx_slider['preview']['name']; ?>" width="60"/></a></td>
  	<td><?php echo $row_jx_slider['titleSlider']; ?></td>
	<td><?php echo $row_jx_slider['categorieIdSlider']; ?></td>
	<td><?php echo $row_jx_slider['dateSlider']; ?></td>
	<td><a href="edit-slide.php?idEdit2=<?php echo $row_jx_slider['idSlider']; ?>">OK</a></td> 
	<td><a href="add-slide.php?idSlider=<?php echo $row_jx_slider['idSlider']; ?>">OK</a></td>  
  </tr>
  <?php } while ($row_jx_slider = mysql_fetch_assoc($jx_slider)); ?>
</table>
<div class="pagination">
  <ul>
    <li><?php if ($pageNum_jx_slider > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_jx_slider=%d%s", $currentPage, 0, $queryString_jx_slider); ?>"><i class="icon-fast-backward"></i></a>
        <?php } // Show if not first page ?></li>
    <li><?php if ($pageNum_jx_slider > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_jx_slider=%d%s", $currentPage, max(0, $pageNum_jx_slider - 1), $queryString_jx_slider); ?>"><i class="icon-chevron-left"></i></a>
        <?php } // Show if not first page ?></li>
    <li><?php if ($pageNum_jx_slider < $totalPages_jx_slider) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_jx_slider=%d%s", $currentPage, min($totalPages_jx_slider, $pageNum_jx_slider + 1), $queryString_jx_slider); ?>"><i class="icon-chevron-right"></i></a>
        <?php } // Show if not last page ?></li>
    <li><?php if ($pageNum_jx_slider < $totalPages_jx_slider) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_jx_slider=%d%s", $currentPage, $totalPages_jx_slider, $queryString_jx_slider); ?>"><i class="icon-fast-forward"></i></a>
        <?php } // Show if not last page ?></li>
  </ul>
</div>
<hr style="border-top:solid #CCCCCC 1px;"/>

<h4>Add image slide : <span style="color:#A3ADED;"></span></h4>

<form action="<?php echo $editFormAction; ?>" name="form" method="POST" enctype="multipart/form-data" class="cssform" >
<input type="hidden" name="MAX_FILE_SIZE" value="999999999" />
<table id="addSlide" class="table table-striped">		
    <tr valign="baseline">
          <td align="right">Titre slide</td>
        <td><input name="title" type="text" id="tltslide" class="fields_admin" value="" size="100" /></td>
    </tr>

    <tr valign="baseline"> 	
          <td align="right">Image (750 x 354 px)</td>
          <td><input type="file" name="preview" id="imgslide" class="fields" /></td>
    </tr>
	<tr valign="baseline">    
          <td align="right">Catégorie</td>
         <td>
		 <select id="categslide" name="categorie">
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
          <td align="right">Valider</td>
          <td><input name="Submit" type="submit" id="Submit" value="Poster" /></td>
          <input type="hidden" name="MM_insert" value="form" />
    </tr>   
</table>    
</form>


</div>

<!--FOOTER-->

<?php require_once ($url."inc/footer.inc.php");?>	
 