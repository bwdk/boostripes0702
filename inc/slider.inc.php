
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
					
						while ($row_jx_slider = mysql_fetch_array($resSlider)) { 

                        ?>
						
                <a href=""><img src="<?php echo $url; ?>img/slide/<?php echo $row_jx_slider['previewSlider']; ?>" alt="" title="<?php echo $row_jx_slider['titleSlider']; ?>" data-transition="slideInLeft"/></a>
         
				<?php } ?>
            </div>
        </div>
		</div>
