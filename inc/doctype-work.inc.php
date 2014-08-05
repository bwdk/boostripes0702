<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="bowdik, site perso, infographiste multimédia, webdesigner" />
	<meta name="description" content="CdiXit" />
	<meta name="generator" content="Notepad++, Dreamweaver CS6, PSPad" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

	<!--  LESS -->
    <link href="<?php echo $url; ?>css/styles.less" rel="stylesheet/less" type="text/css" >
	<!--  CSS -->
	<link href="<?php echo $url; ?>css/colorbox/colorbox.css" rel="stylesheet" type="text/css"/>
	<link href="<?php echo $url; ?>css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo $url; ?>css/bootstrap-responsive.css&" rel="stylesheet" type="text/css">
	<link href="<?php echo $url; ?>css/style.css" rel="stylesheet">
	<!-- Imports General CSS and jQuery CSS -->
	<link href="<?php echo $url; ?>css/work/screen.css" rel="stylesheet" media="screen" type="text/css" />
	
	

	
	<!-- IE Stylesheet ie7 - Added in 1.2 -->
	<!--[if lt IE 8]> <html lang="en" class="ie7"> <![endif]-->
	
	<!-- IE Stylesheet ie8 - Added in 1.1 -->
	<!--[if IE 8 ]> <html lang="en" class="ie8"> <![endif]-->

	
	<!-- IE Canvas Fix for Visualize Charts - Added in 1.1 -->
	<!--[if IE]><script type="text/javascript" src="js/excanvas.js"></script><![endif]-->
	
	<!-- jQuery thats loaded before document ready to prevent flickering - Rest are found at the bottom -->
	<script type="text/javascript" src="<?php echo $url; ?>js/work/jquery-1.4.1.min.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>js/work/jquery.cookie.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>js/work/jquery.styleswitcher.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>js/work/jquery.visualize.js"></script>
	<script type="text/javascript" src="<?php echo $url; ?>js/colorbox/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/colorbox/jquery.colorbox.js"></script>
	
	<script>
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				$(".group1").colorbox({rel:'group2'});//({transition:"fade", maxWidth:"95%", maxHeight:"95%", slideshow:false, scalePhotos:true, scrolling:false, overlayClose:true})
				$(".ajax").colorbox();
				$(".youtube").colorbox({iframe:true, innerWidth:425, innerHeight:344});
				$(".vimeo").colorbox({iframe:true, innerWidth:500, innerHeight:409});
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				$(".inline").colorbox({inline:true, width:"50%"});
				$(".callbacks").colorbox({
					onOpen:function(){ alert('onOpen: colorbox is about to open'); },
					onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
					onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
					onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
					onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
				});

				$('.non-retina').colorbox({rel:'group5', transition:'none'})
				$('.retina').colorbox({rel:'group5', transition:'none', retinaImage:true, retinaUrl:true});
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
	