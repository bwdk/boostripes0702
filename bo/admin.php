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

/* insert news */
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO news (titreNews, titreVideoNews, descriptionNews, categorieIdNews, auteurNews, videoNews, previewNews) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['title'], "text"),
					   GetSQLValueString($_POST['titlev'], "text"),
                       GetSQLValueString($_POST['text'], "text"),
                       GetSQLValueString($_POST['categorie'], "int"),
                       GetSQLValueString($_POST['author'], "text"),
					   GetSQLValueString($_POST['video'], "text"),
                       GetSQLValueString($_FILES['preview']['name'], "text"));
 
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
  $Result1 = mysql_query($insertSQL, $cn_bwdkadw) or die(mysql_error());
  
  //

}



/* news deletion */ 
if ((isset($_GET['idNews'])) && ($_GET['idNews'] != "")) {
  $deleteSQL = sprintf("DELETE FROM news WHERE idNews=%s",
                       GetSQLValueString($_GET['idNews'], "int"));
  mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
  $Result1 = mysql_query($deleteSQL, $cn_bwdkadw) or die(mysql_error());
	
}

/* paginate */
$maxRows_jx_news = 8;
$pageNum_jx_news = 0;
if (isset($_GET['pageNum_jx_news'])) {
  $pageNum_jx_news = $_GET['pageNum_jx_news'];
}
$startRow_jx_news = $pageNum_jx_news * $maxRows_jx_news;
/**/


mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);

/* cn news */
$query_jx_news = "SELECT * FROM news ORDER BY dateNews DESC";
$query_limit_jx_news = sprintf("%s LIMIT %d, %d", $query_jx_news, $startRow_jx_news, $maxRows_jx_news);
$jx_news = mysql_query($query_limit_jx_news, $cn_bwdkadw) or die(mysql_error());
$row_jx_news = mysql_fetch_assoc($jx_news);



if (isset($_GET['totalRows_jx_news'])) {
  $totalRows_jx_news = $_GET['totalRows_jx_news'];
} else {
  $all_jx_news = mysql_query($query_jx_news);
  $totalRows_jx_news = mysql_num_rows($all_jx_news);
}
$totalPages_jx_news = ceil($totalRows_jx_news/$maxRows_jx_news)-1;

$queryString_jx_news = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_jx_news") == false && 
        stristr($param, "totalRows_jx_news") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_jx_news = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_jx_news = sprintf("&totalRows_jx_news=%d%s", $totalRows_jx_news, $queryString_jx_news);



/* cn categories */
$query_jx_categories = "SELECT idCategorie, nomCategorie FROM categorie";
$jx_categories = mysql_query($query_jx_categories, $cn_bwdkadw) or die(mysql_error());
//$row_jx_categories = mysql_fetch_assoc($jx_categories);
//$totalRows_jx_categories = mysql_num_rows($jx_categories);



// substring
define('MAX_LENGHT_NEWS_PREVIEW', 82); //On enlève les pointillés dans le calcul donc 65 caractères apparaitront
//

?>
 <!--DOCTYPE-->
 
 <?php require_once ($url."inc/doctype.inc.php");?>
<title>AdminSide Home</title>

<!--HEADER-->
<?php require_once ($url."inc/header.inc.php");?>
<!--SIDEBAR-->

<!--ZONE CONTENT-->
<div class="row-fluid">
<a href="add-work.php"><button>Vers Ajout de works</button></a> &nbsp; <a href="add-slide.php"><button>Vers Ajout de slides</button></a>
<hr style="border-top:solid #CCCCCC 1px;"/>

<?php
		if($_SERVER['REQUEST_METHOD'] == 'POST')
		{
		   echo '<div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  Article <strong>'.$row_jx_news['titreNews'].'</strong> ajouté.</div>';
		   }
		   
		if ((isset($_GET['idNews'])) && ($_GET['idNews'] != "")) {
		echo '<div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  Article <strong>'.$row_jx_news['titreNews'].'</strong> supprimé.</div>';
		   }

?>


	<table border="1" cellpadding="1" cellspacing="1" id="affichePost" class="table table-striped">
<?php 

		$sDescription = $row_jx_news['descriptionNews']; //Récupère la description de la news
    		if( strlen($row_jx_news['descriptionNews']) > MAX_LENGHT_NEWS_PREVIEW ){ //Test si la longueur de la description dépasse le maximum 			défini plus haut
        $sDescription = substr($row_jx_news['descriptionNews'],0,MAX_LENGHT_NEWS_PREVIEW).'...';
		}
?>


   <tr>
   	<th>Image</th>
    <th>Titre</th>
	<th>Titre Video</th>
   	<th>Date</th>
    <th>Catégorie</th>
    <th>Edit</th>
	<th>Del</th>
  </tr>
   <?php do { ?>
  <tr> 
  	<td><a href="../pages.php?article=<?php echo $row_jx_news['idNews']; ?>"><img src="../img/news/<?php echo $row_jx_news['previewNews']; ?>" alt="N/A or video" width="60"/></a></td>
  	<td><a href="../pages.php?article=<?php echo $row_jx_news['idNews']; ?>"><?php echo $row_jx_news['titreNews']; ?></a></td>
	<td><a href="../pages.php?article=<?php echo $row_jx_news['idNews']; ?>"><?php echo $row_jx_news['titreVideoNews']; ?></a></td>
    <td><?php echo $row_jx_news['dateNews']; ?></td>
  	<td><?php echo $row_jx_news['categorieIdNews']; ?></td>
	<td><a href="edit.php?idEdit=<?php echo $row_jx_news['idNews']; ?>">OK</a></td>  
	<td><a href="admin.php?idNews=<?php echo $row_jx_news['idNews']; ?>">OK</a></td>
  </tr>
  <?php } while ($row_jx_news = mysql_fetch_assoc($jx_news)); ?>
</table>

<div class="pagination">
  <ul>
    <li><?php if ($pageNum_jx_news > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_jx_news=%d%s", $currentPage, 0, $queryString_jx_news); ?>"><i class="icon-fast-backward"></i></a>
        <?php } // Show if not first page ?></li>
    <li><?php if ($pageNum_jx_news > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_jx_news=%d%s", $currentPage, max(0, $pageNum_jx_news - 1), $queryString_jx_news); ?>"><i class="icon-chevron-left"></i></a>
        <?php } // Show if not first page ?></li>
    <li><?php if ($pageNum_jx_news < $totalPages_jx_news) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_jx_news=%d%s", $currentPage, min($totalPages_jx_news, $pageNum_jx_news + 1), $queryString_jx_news); ?>"><i class="icon-chevron-right"></i></a>
        <?php } // Show if not last page ?></li>
    <li><?php if ($pageNum_jx_news < $totalPages_jx_news) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_jx_news=%d%s", $currentPage, $totalPages_jx_news, $queryString_jx_news); ?>"><i class="icon-fast-forward"></i></a>
        <?php } // Show if not last page ?></li>
  </ul>
</div>
</div>

<div class="row-fluid">



<hr style="border-top:solid #CCCCCC 1px;"/>

<h4>Add article : <span style="color:#A3ADED;"></span></h4>
<form action="<?php echo $editFormAction; ?>" name="form" method="POST" enctype="multipart/form-data" class="cssform" >
<input type="hidden" name="MAX_FILE_SIZE" value="9999999" />
<table id="addPostTable" class="table table-striped">		
    <tr valign="baseline">
          <td align="right">Titre</td>
        <td><input name="title" type="text" id="title" class="fields_admin" value="" size="32" /></td>
    </tr>
	<tr valign="baseline">
          <td align="right">Titre Video</td>
        <td><input name="titlev" type="text" id="titlev" class="fields_admin" value="" size="32" /></td>
    </tr>
    
    <tr valign="baseline">    
          <td align="right">Catégorie</td>
         <td><select id="categorie" name="categorie">
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
        <td align="right" valign="middle">Article</td>
        <td><textarea name="text" cols="50" rows="5" id="text" value="" size="32"></textarea></td>
    </tr>
    
    <tr valign="baseline"> 	
        <td align="right">Auteur</td>
        <td><input name="author" type="text" id="author" class="fields_admin " value="" size="32" /></td>
    </tr>
    
    <tr valign="baseline"> 	
          <td align="right">Preview (600 x 400 px)</td>
          <td><input type="file" name="preview" id="preview" class="fields" /></td>
    </tr>
	
	<tr valign="baseline"> 	
          <td align="right">Video (290 x 193 px)</td>
          <td><input type="text" name="video" id="video" class="fields" /></td>
    </tr>
    
    <tr valign="baseline">	
          <td align="right">Poster</td>
          <td><input name="Submit" type="submit" id="Submit" value="OK"/></td>
          <input type="hidden" name="MM_insert" value="form" />
    </tr>    
</table>    
</form>


	</div>
	





<!--FOOTER-->

<?php require_once ($url."inc/footer.inc.php");?>	
 