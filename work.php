<?php 

require_once('connect/cn-boos.php'); 

$url="";

mysql_select_db($database_cn_bwdkadw, $cn_bwdkadw);


/* cn categorie */
$query_jx_cat ="
		SELECT *
		FROM categorie 
		";
$jx_cat = mysql_query($query_jx_cat, $cn_bwdkadw) or die(mysql_error());
$row_jx_cat = mysql_fetch_assoc($jx_cat);
$totalRows_jx_cat = mysql_num_rows($jx_cat);


/* cn works */
$query_jx_works = "
	SELECT * FROM works w LEFT JOIN categorie c ON (c.idCategorie = w.idCategorie) ORDER BY dateWork DESC";//Requête BDD permettant de récupérer toutes les works de la base
$jx_works = mysql_query($query_jx_works, $cn_bwdkadw) or die(mysql_error());//Ressource contenant les résultats de la requête précédente
$row_jx_works = mysql_fetch_assoc($jx_works);// enlever cette ligne pour voir s'afficher le premier enregistrement
$totalRows_jx_works = mysql_num_rows($jx_works);


?>
<!--DOCTYPE-->

 <?php require_once ($url."inc/doctype-work.inc.php");?>
<title>Work</title>
<!--HEADER-->
<?php require_once ($url."inc/header.inc.php");?>

<!-- Start: Page Wrap -->
<div class="container_24">
	

<!-- 100% Box Grid Container: Start -->
<div class="grid_24">

	<!-- Box Header: Start -->
	<div class="box_top">
		
		<h2 class="title-work">Work<span><?php echo $totalRows_jx_works; ?></span></h2>
		
		<!-- Big Gallery Sorting: Start -->
		<ul class="sorting">
		<?php do {  ?>
			<li><a href="#" data-type="<?php echo $row_jx_cat['idCategorie']; ?>"><?php echo $row_jx_cat['nomCategorie']; ?></a></li>
		<?php } while ($row_jx_cat = mysql_fetch_assoc($jx_cat)); ?>
		</ul>
		
		<!-- Big Gallery Sorting: End -->
		
	</div>
	<!-- Box Header: End -->
	
	<!-- Box Content: Start -->
	<div class="box_content">
		
		<!-- Big Gallery Content: Start -->
		<ul class="gallery">
			
		<!-- Big Gallery Image: Start -->
			<?php do { ?>
			<li data-type="<?php echo $row_jx_works['idCategorie']; ?>" data-id="<?php echo $row_jx_works['idWork']; ?>">
				<div class="actions">
					<a href="img/work/thumbs/<?php echo $row_jx_works['imagethWork']; ?>" class="view popup">View</a>
				</div>
				<a href="img/work/thumbs/<?php echo $row_jx_works['imagethWork']; ?>" class="popup">
					<img src="img/work/thumbs/<?php echo $row_jx_works['imagethWork']; ?>" alt="<?php echo $row_jx_works['titleWork']; ?>" width="243px" height="203px"/>
				</a>
			</li>
			<?php } while ($row_jx_works = mysql_fetch_assoc($jx_works)); ?>
			<!-- Big Gallery Image: End -->

		</ul>
		<!-- Gallery Content: End -->
		
		<!-- Big Gallery Footer: Start -->
		<div class="padding">
			
			
			<!-- Pagination: Start >
			<ul class="pagination right nomargin">
				<li><a href="#" class="active">1</a></li>
				<li><a href="#">2</a></li>
				<li><a href="#">3</a></li>
				<li><a href="#">4</a></li>
				<li><a href="#">5</a></li>
				<li><a href="#">Next</a></li>
			</ul-->
			



			<!-- Pagination: End -->
		</div>
		<!-- Big Gallery Footer: End -->

		<!-- Delete Dialog: Start -->
		<div id="dialog-confirm" title="Delete this image?">
			<p>Do you really want to delete this?</p>
		</div>
		<!-- Delete Dialog: End -->
		
	</div>
	<!-- Box Content: End -->
	
</div>
<!-- 100% Box Grid Container: End -->




</div>
<!-- End: Page Wrap -->



<!-- FOOTER -->
<?php require_once ($url."inc/footer.inc.php");?>	
 