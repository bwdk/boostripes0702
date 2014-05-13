<?php 

require_once('connect/cn-boos.php'); 
$url="";

mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);
$query_jx_news = "
	SELECT idNews, titreNews, descriptionNews, YEAR(dateNews) AS annee, DAYOFMONTH(dateNews) AS jour, MONTH(dateNews) AS mois, previewNews, categorieIdNews, idCategorie, nomCategorie, titreVideoNews, videoNews
    FROM news 
	LEFT JOIN categorie
	ON categorieIdNews = idCategorie
	WHERE idNews = {$_GET['article']}
	";
	//Requête BDD permettant de récupérer la news dont l'ID est passée en GET
	//GET signifie que la valeur se trouve dans l'URL, par exemple : http://172.17.20.74/bk/pages.php?article=155
	//Si tu demandes $_GET['article'], tu obtiens 155
	
$jx_news = mysql_query($query_jx_news, $cn_bwdkadw) or die(mysql_error());//Ressource contenant les résultats de la requête précédente
$row_jx_news = mysql_fetch_assoc($jx_news);
$totalRows_jx_news = mysql_num_rows($jx_news);


$query_jx_categories = "SELECT * FROM categorie";
$jx_categories = mysql_query($query_jx_categories, $cn_bwdkadw) or die(mysql_error());
$row_jx_categories = mysql_fetch_assoc($jx_categories);
$totalRows_jx_categories = mysql_num_rows($jx_categories);

define('MAX_LENGHT_NEWS_PREVIEW', 82); //On enlève les pointillés dans le calcul donc 65 caractères apparaitront

$sPath = "news/"; // Le chemin du dossier contenant les images des news
$sExtensionImage = ".jpg"; //L'extension unique des images

  $sDescription = $row_jx_news['descriptionNews']; //Récupère la description de la news
   
	$iMonth = $row_jx_news['mois'];
	if( $row_jx_news['mois'] < 10 ){ //Rajoute un zéro si le mois est inférieur à 10
		$iMonth = '0'.$row_jx_news['mois'];
	}
	
	$iDay = $row_jx_news['jour'];
	if( $row_jx_news['jour'] < 10 ){ //Rajoute un zéro si le jour est inférieur à 10
		$iDay = '0'.$row_jx_news['jour'];
	}
	
	$iTitle = $row_jx_news['titreNews'];
	$iTitleVideo = $row_jx_news['titreVideoNews'];
	$iPict =  $row_jx_news['previewNews'];
	$lPicture = '<p class="descr-space-l">'.$sDescription.'</p>';


	
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
 <!--DOCTYPE-->
 
 <?php require_once ($url."inc/doctype.inc.php");?>
<title><?php echo $row_jx_news['nomCategorie']; ?></title>

<!--HEADER-->
<?php require_once ($url."inc/header.inc.php");?>



<!--ZONE CONTENT-->
<div class="span8 rowfluidblog">
				<div class="thumbnail blcpage">
		
						<span class="label datepage"><?php echo $iDay.'.'.$iMonth; ?> <?php echo $row_jx_news['annee']; ?></span>

							<a href="pages-categorie.php?categorie=<?php echo $row_jx_news['idCategorie'];?>"><span class="label" style="background-color:<?php echo $couleur; ?>"><?php echo $iCateg; ?></span></a>
							
							<hr class="hrpage"/>
							<?php if ($iTitleVideo) { echo '<h4 class="titleblogpage">'.$iTitleVideo.'</h4>';} ?>
							<?php if ($iTitle) { echo '<h4 class="titleblogpage">'.$iTitle.'</h4>';} ?>
							
							<div class="videoWrapper">
							<?php if ($row_jx_news['videoNews']) { echo $row_jx_news['videoNews'];} ?>
							<?php if ($iPict) { echo '<img src="img/news/'.$iPict.'" alt="" class="pull-left"/>';} ?>
						   </div>	
						   
		
							<?php if ($row_jx_news['videoNews']) { echo '<p class="descr-space-vid">'.$sDescription.'</p>';} ?>
							<?php if ($iPict) { echo $lPicture;} ?>
	
							
			   </div>
		
	</div>
	
<!--SIDEBAR-->

<?php require_once ($url."inc/sidebar.inc.php");?>
<!--FOOTER-->
<?php require_once ($url."inc/footer.inc.php");?>	
 