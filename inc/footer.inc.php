  
</div><!--fin container-->
</div><!--fin wrap-->
<div id="push"></div> 
<!-- FOOTER -->
<div id="footer">
      <div class="container stick">
        <p class="muted credit"><a href="http://html-ipsum.com/">html-ipsum</a>. <a href="<?php echo $url; ?>bo/admin.php">AdminSide</a></p>
      </div>
	  
	  <div id="myModal" class="modal fade">
		<div class="modal-dialog">
		<div class="modal-content">
		<!-- dialog body -->
		<div class="modal-body">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		Hello world!
		</div>
		<!-- dialog buttons -->
		<div class="modal-footer"><button type="button" class="btn btn-primary">OK</button></div>
		</div>
		</div>
	  </div>

    </div>

	<!-- javascripts bootstrap-->	
<script src="<?php echo $url; ?>js/jquery.js"></script>
<script src="<?php echo $url; ?>js/bootstrap.min.js"></script>
<script src="<?php echo $url; ?>js/bootstrap.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<!-- sometime later, probably inside your on load event callback -->
<script>
$("#myModal").on("show", function() { // wire up the OK button to dismiss the modal when shown
$("#myModal a.btn").on("click", function(e) {
console.log("button pressed"); // just as an example...
$("#myModal").modal('hide'); // dismiss the dialog
});
});
 
$("#myModal").on("hide", function() { // remove the event listeners when the dialog is dismissed
$("#myModal a.btn").off("click");
});
$("#myModal").on("hidden", function() { // remove the actual elements from the DOM when fully hidden
$("#myModal").remove();
});
$("#myModal").modal({ // wire up the actual modal functionality and show the dialog
"backdrop" : "static",
"keyboard" : true,
"show" : true // ensure the modal is shown immediately
});
</script>

<!-- nivo scripts -->
<script type="text/javascript" src="<?php echo $url; ?>js/nivo-slider/demo/scripts/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?php echo $url; ?>js/nivo-slider/jquery.nivo.slider.js"></script>
<script type="text/javascript">
    $(window).load(function() {
        $('#slider').nivoSlider();
    });
    </script>
 <script type="text/javascript" src="<?php echo $url; ?>js/custom.js"></script> 
 

</body>

</html>