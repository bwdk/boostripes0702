<?php
require_once('connect/cn-boos.php');
include("inc/function.inc.php");


$url="";


mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
$query_jx_categories = "
	SELECT * 
	FROM categorie 
	";
$jx_categories = mysql_query($query_jx_categories, $cn_bwdkadw) or die(mysql_error());
//$row_jx_categories = mysql_fetch_assoc($jx_categories);
$totalRows_jx_categories = mysql_num_rows($jx_categories);

$query_jx_news = "
	SELECT idNews, titreNews, descriptionNews, YEAR(dateNews) AS annee, DAYOFMONTH(dateNews) AS jour, MONTH(dateNews) AS mois, previewNews, categorieIdNews, idCategorie, nomCategorie, videoNews, titreVideoNews
    FROM news 
	LEFT JOIN categorie
	ON categorieIdNews = idCategorie
    ORDER BY dateNews DESC";//Requete BDD permettant de recuperer toutes les news de la base
$jx_news = mysql_query($query_jx_news, $cn_bwdkadw) or die(mysql_error());//Ressource contenant les resultats de la requete precedente
//$row_jx_news = mysql_fetch_assoc($jx_news); enlever cette ligne pour voir s'afficher le premier enregistrement
$totalRows_jx_news = mysql_num_rows($jx_news);

//--REDUIRE LE TEXTE DANS UN BLOC--
define('MAX_LENGHT_NEWS_PREVIEW', 110); //On enleve les pointilles dans le calcul donc 65 caracteres apparaitront

//--

 ?>
 <!-- DOCTYPE -->
 
 <?php require_once ($url."inc/doctype.inc.php");?>
<title>Home</title>

<!-- HEADER -->
<?php require_once ($url."inc/header.inc.php");?>

<!-- SLIDER -->
<div class="row-fluid">

 <?php require_once ($url."inc/slider.inc.php");?>   
	
<!-- SIDEBAR -->
<?php require_once ($url."inc/sidebar.inc.php");?>

<div class="span4 welcome pull-right">
		<h4></h4>
		<p><br/><span class="pull-right"></span></p>
</div>	
</div>	
<!--  CONTENT   -->	
<!-- BLOCS -->
<div class="row-fluid" id="line2">
	<h4 class="span8 title-blg pull-left">Derniers posts</h4>
	<h4 class="span4 title-side pull-right">Titres</h4>
</div>

	<ul class="thumbnails">	
	<?php

		$maxRows_jx_news = 2; //Nombre maximum de news affichees
		if( mysql_num_rows($jx_news) <= 2){
			$maxRows_jx_news = mysql_num_rows($jx_news);
		}
		
		$maxRows_jx_categories = 3; //Nombre maximum de news affichees
		

		for($i = 0; $i < $maxRows_jx_news; $i++ ){ //Boucle permettant de parcourir toutes les news
			$row_jx_news = mysql_fetch_array($jx_news, MYSQL_ASSOC); //Recupere dans un tableau une news
		
		   
				
			$sDescription = $row_jx_news['descriptionNews']; //Recupere la description de la news
			if( strlen($row_jx_news['descriptionNews']) > MAX_LENGHT_NEWS_PREVIEW ){ //Test si la longueur de la description d�passe le maximum defini plus haut
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

	       <!--http://placehold.it/300x200 pour image -->
			<li class="span4 blogblock thumbnailhome">
			<div class="thumbnail">
			<span class="label"><?php echo $iDay.'.'.$iMonth; ?> <?php echo $row_jx_news['annee']; ?></span>
			
			<a href="pages-categorie.php?categorie=<?php echo $row_jx_news['idCategorie'];?>"><span class="label" style="background-color:<?php echo $couleur; ?>"><?php echo $iCateg; ?></span></a>
			
			<div width="auto" class="videohome"><!--div class="videoWrapper"-->
			
				<?php if ($row_jx_news['videoNews']) { echo $row_jx_news['videoNews'];} ?>
				
			<img src="img/news/<?php echo $row_jx_news['previewNews']; ?>" alt="" class="pull-left"/>	
			</div>
			
			<?php if ($row_jx_news['titreVideoNews']) { echo '<h5 class="titleblog">'.$row_jx_news['titreVideoNews'].'</h5>';} ?>
			<?php if ($row_jx_news['titreNews']) { echo '<h5 class="titleblog">'.$row_jx_news['titreNews'].'</h5>';} ?>

			<p><?php echo $sDescription; ?></p>
			</div>
			
            
            <div>
            <?php
				if( strlen($row_jx_news['descriptionNews']) > MAX_LENGHT_NEWS_PREVIEW ){ //Test si la longueur de la description depasse le maximum défini plus haut
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
			<li class="span4 blocside pull-right">
			
			<li>
		</ul>



<!-- FOOTER -->
<?php require_once ($url."inc/footer.inc.php");?>	
 