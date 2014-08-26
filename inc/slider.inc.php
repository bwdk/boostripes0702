
	<!-- SLIDER 750x354 -->
	<div class="span8 slide-height">
        <div class="slider-wrapper theme-dark">
            <!--div class="ribbon"></div-->
            <div id="slider" class="nivoSlider">
			<?php
						$sSlider = "
							SELECT * 
							FROM slider 
							ORDER BY dateSlider DESC Limit 5"; 
						$resSlider = mysql_query($sSlider) or die('Erreur SQL !'.$sSlider.'<br>'.mysql_error());
					
						if($row_jx_slider = mysql_fetch_array($resSlider)) { 
						do{
                        ?>
						
                <a href=""><img src="<?php echo $url; ?>img/slide/<?php echo $row_jx_slider['previewSlider']; ?>" alt="" title="<?php echo $row_jx_slider['titleSlider']; ?>" data-transition="slideInLeft"/></a>
         
				<?php }while($row_jx_slider = mysql_fetch_array($resSlider)); } else{ ?>
				<img src="<?php echo $url; ?>img/slide/000000.jpg" alt="img_maquette" title="No pic to display" data-transition="none"/>
				<?php } ?>
				
            </div>
        </div>
		</div>
