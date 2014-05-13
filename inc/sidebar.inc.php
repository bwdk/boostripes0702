								<!-- 1 -->
	<div class="span4 accordeons pull-right" id="sidebar">
	
			<div id="tab-categ1">
				<div class="carre"></div> DERNIERS POSTS
			</div>
		<div style="clear:both"></div>
		
				<div id="tabOne">
				<ul class="side-list">
                       <?php
                        $req = "SELECT idNews, titreNews, categorieIdNews FROM news ORDER BY dateNews DESC Limit 5"; 
                        $res = mysql_query($req) or die('Erreur SQL !'.$req.'<br>'.mysql_error());;
                        
						while ($row_jx_news = mysql_fetch_array($res)) { 
                        ?>
                        <li><a href="pages.php?article=<?php echo $row_jx_news['idNews']; ?>"><?php echo $row_jx_news['titreNews']; ?></a></li>
                        <?php } ?>
                </ul>
		</div>
												
												<!-- 2 -->
		<div id="tab-categ2">
				<div class="carre"></div> CATEGORIES
		</div>
				<div style="clear:both"></div>
				
				<div id="tabTwo">
                    <ul class="side-list">
						<?php
						$sQueryNewsCount = "
							SELECT categorieIdNews, nomCategorie, COUNT(idNews) AS nb
							FROM news AS n, categorie AS c
							WHERE n.categorieIdNews = c.idCategorie
							GROUP BY categorieIdNews
						"; //Requete permettant de recuperer toutes les categories : leurs ID, nom, et le nombre de news que chacune possede => COUNT(id)
						$rResQuNeCount = mysql_query($sQueryNewsCount);
						
						for($a=0;$a<mysql_num_rows($rResQuNeCount);$a++){
							$aTemp = mysql_fetch_array($rResQuNeCount);
							$aAllCategories[$aTemp['categorieIdNews']] = array(
								'nb' => $aTemp['nb'],
								'nom' => $aTemp['nomCategorie'],
							);
						}//Creation d'une variable de type tableau qui permettra d'etre reutilise dans la boucle while
						
						foreach( $aAllCategories as $iCategoryID => $aThisCategory ){ 
						?>
					
                      <li><a href="pages-categorie.php?categorie=<?php echo $iCategoryID;?>"><?php echo $aThisCategory['nom'].' ('.$aThisCategory['nb'].')'; ?></a></li>
						<?php } ?>
                    </ul>
                </div> 
												
												<!-- 3 -->
		<div id="tab-categ3">
					<div class="carre"></div> ARCHIVES
		</div>
				<div style="clear:both"></div>
                
				<div id="tabThree">
                    <ul class="side-list">
					<li class="nav-header">Mois</li>
						<?php
						
						$sQueryArchives = "
							SELECT idNews, MONTH(dateNews) AS mois, YEAR(dateNews) AS annee, COUNT(idNews) AS nba, dateNews
							FROM news 
							GROUP BY mois
							ORDER BY datenews DESC "; 
						$resArchives = mysql_query($sQueryArchives) or die('Erreur SQL !'.$sQueryArchives.'<br>'.mysql_error());
					
						while ($row_jx_news = mysql_fetch_array($resArchives)) { 
						
						$iMonth = $row_jx_news['mois'];
						if( $row_jx_news['mois'] < 10 ){ //Rajoute un zero si le mois est inférieur a 10
						$iMonth = '0'.$row_jx_news['mois'];
						}
                        ?>
                        <li><a href="pages-archives.php?mois=<?php echo $iMonth; ?>&annee=<?php echo $row_jx_news['annee']; ?>"><?php echo $iMonth; ?>/<?php echo $row_jx_news['annee'].' ('.$row_jx_news['nba'].')'; ?>
						</a></li>
                        <?php } ?>
						
                    </ul>
					<ul class="nav nav-list">
						<li class="divider"></li>
						<li class="nav-header">Années</li>
						<?php
						$sQueryArchiveYear = "
							SELECT idNews, YEAR(dateNews) AS annee, COUNT(idNews) AS nby, dateNews
							FROM news 
							GROUP BY annee
							ORDER BY datenews DESC "; 
						$resArchiveYear = mysql_query($sQueryArchiveYear) or die('Erreur SQL !'.$sQueryArchiveYear.'<br>'.mysql_error());
					
						while ($row_jx_news = mysql_fetch_array($resArchiveYear)) { 

                        ?>
						<li class=""><a href="pages-archives-y.php?annee=<?php echo $row_jx_news['annee']; ?>"><?php echo $row_jx_news['annee'].' ('.$row_jx_news['nby'].')'; ?></a></li>
						<?php } ?>
					</ul>
                </div>		
				
		</div>
		
		
      
    
		
		
