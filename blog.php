<?php require_once('connect/cn-boos.php'); ?>
<?php


mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
$query_jx_categories =" 
		SELECT *
		FROM categorie 
		";
$jx_categories = mysql_query($query_jx_categories, $cn_bwdkadw) or die(mysql_error());

$totalRows_jx_categories = mysql_num_rows($jx_categories);

$maxRows_jx_news = 9;
$pageNum_jx_news = 0;
if (isset($_GET['pageNum_jx_news'])) {
  $pageNum_jx_news = $_GET['pageNum_jx_news'];
}
$startRow_jx_news = $pageNum_jx_news * $maxRows_jx_news;


if (isset($_GET['totalRows_jx_news'])) {
  $totalRows_jx_news = $_GET['totalRows_jx_news'];
} else {
  $all_jx_news = mysql_query($query_jx_news);
  $totalRows_jx_news = mysql_num_rows($all_jx_news);
}
$totalPages_jx_news = ceil($totalRows_jx_news/$maxRows_jx_news)-1;


$query_jx_news = "
	SELECT n.idNews, n.titreNews, n.descriptionNews, YEAR(n.dateNews) AS annee, DAYOFMONTH(n.dateNews) AS jour, MONTH(n.dateNews) AS mois, n.previewNews, n.categorieIdNews, c.idCategorie, c.nomCategorie, videoNews, titreVideoNews
    FROM news n, categorie c
	WHERE n.categorieIdNews = c.idCategorie
    ORDER BY dateNews DESC";//Requête BDD permettant de récupérer toutes les news de la base
$jx_news = mysql_query($query_jx_news, $cn_bwdkadw) or die(mysql_error());//Ressource contenant les résultats de la requête précédente
//$row_jx_news = mysql_fetch_assoc($jx_news);// enlever cette ligne pour voir s'afficher le premier enregistrement
$totalRows_jx_news = mysql_num_rows($jx_news);



$url="";



define('MAX_LENGHT_NEWS_PREVIEW', 82); //On enlève les pointillés dans le calcul donc 65 caractères apparaitront

$sPath = "news/"; // Le chemin du dossier contenant les images des news
$sExtensionImage = ".jpg"; //L'extension unique des images

?>
 <!--DOCTYPE-->
 
<?php require_once ($url."inc/doctype.inc.php");?>
<title>Blog</title>

<!--HEADER-->
<?php require_once ($url."inc/header.inc.php");?>

<!--SIDEBAR-->
<?php require_once ($url."inc/sidebar.inc.php");?>


<!--ZONE CONTENT-->
<div class="row-fluid rowfluidblog">

		
<?php

		$maxRows_jx_news = 9; //Nombre maximum de news affich�es
		if( mysql_num_rows($jx_news) <= 9){
			$maxRows_jx_news = mysql_num_rows($jx_news);
		}
		

		for($i = 0; $i < $maxRows_jx_news; $i++ ){ //Boucle permettant de parcourir toutes les news
			$row_jx_news = mysql_fetch_array($jx_news, MYSQL_ASSOC); //Recupere dans un tableau une news
			
			$row_jx_categories = mysql_fetch_array($jx_categories, MYSQL_ASSOC); //Recupere dans un tableau une categorie
			
			$sDescription = $row_jx_news['descriptionNews']; //Recupere la description de la news
			if( strlen($row_jx_news['descriptionNews']) > MAX_LENGHT_NEWS_PREVIEW ){ //Test si la longueur de la description depasse le maximum defini plus haut
				$sDescription = substr($row_jx_news['descriptionNews'],0,MAX_LENGHT_NEWS_PREVIEW).'...';
					
			}
			
			$iMonth = $row_jx_news['mois'];
			if( $row_jx_news['mois'] < 10 ){ //Rajoute un zero si le mois est inferieur a 10
				$iMonth = '0'.$row_jx_news['mois'];
			}
			
			$iDay = $row_jx_news['jour'];
			if( $row_jx_news['jour'] < 10 ){ //Rajoute un zero si le jour est inferieur a 10
				$iDay = '0'.$row_jx_news['jour'];
			}
			
			$iCateg = $row_jx_news['nomCategorie'];
			//$label_info = 'label-info';
	
			
		switch($iCateg){
				case 'Work':
					$couleur='#7BA7E1';//a remplacer par le code hexa de la couleur voulue #bleu....
				break;
				case 'Text':
					$couleur='#FF7575';//a remplacer par le code hexa de la couleur voulue #rouge...
				break;
				case 'Video':
					$couleur='#1FCB4A';//a remplacer par le code hexa de la couleur voulue #vert....
				break;
				case 'News':
					$couleur='#C03000';//a remplacer par le code hexa de la couleur voulue #vert....
				break;
			}
?>

	 <ul class="thumbnails">	   
			<li class="span4 blogblock">
			<div class="thumbnail">

			<span class="label"><?php  echo $iDay.'/'.$iMonth.'/'.$row_jx_news['annee']; ?></span>	
			
			<a href="pages-categorie.php?categorie=<?php echo $row_jx_news['idCategorie'];?>"><span class="label" style="background-color:<?php echo $couleur; ?>"><?php echo $iCateg; ?></span></a>
			
			<div class="videohome2 videoWrapper">
			<?php if ($row_jx_news['videoNews']) { echo $row_jx_news['videoNews'];} ?>
			<img src="img/news/<?php echo $row_jx_news['previewNews']; ?>" alt="" class="pull-left"/>	
			</div>
			
			<?php if ($row_jx_news['titreVideoNews']) { echo '<div class="space"></div>'.'<h5 class="titlectg left-align">'.$row_jx_news['titreVideoNews'].'</h5>';} ?>
			<?php if ($row_jx_news['titreNews']) { echo '<h5 class="titlectg left-align">'.$row_jx_news['titreNews'].'</h5>';} ?>
			
			</div>
			<div>
            <?php
				if( strlen($row_jx_news['descriptionNews']) > MAX_LENGHT_NEWS_PREVIEW ){ //Test si la longueur de la description depasse le maximum defini plus haut
			?>
                        <a class="btn btn-right pull-right" href="pages.php?article=<?php echo $row_jx_news['idNews']; ?>"> suite </a>
			<?php
			}
			?>
            </div>
			
			</li>
			<?php	
			}
			?>
			
		</ul>
	</div>


<!--FOOTER-->
<?php require_once ($url."inc/footer.inc.php");?>	
 