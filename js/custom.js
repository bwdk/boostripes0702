// JQuery Sidebar Toggle
     $(document).ready(function(){
    //close divs on page load
    $('#tabOne').hide();
    $('#tabTwo').hide();
	$('#tabThree').hide();
	
    
    // toggle
    $('#tab-categ1').click(function(){
    $('#tabOne').slideToggle();
    });
    
    // toggle
    $('#tab-categ2').click(function(){
    $('#tabTwo').slideToggle();
    });
    
     // toggle
    $('#tab-categ3').click(function(){
    $('#tabThree').slideToggle();
    });
	
    });
	
     /* toggle
    $('#tab_categ3').click(function(){
    $(this).siblings('.list_tab3').slideToggle();
    });
	
    });*/
	