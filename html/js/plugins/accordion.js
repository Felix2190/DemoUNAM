

function cambiar_acordeon(id){
                                            
		// Grab current anchor value
		var currentAttrValue = jQuery('#'+id).attr('href');

		if(jQuery('#'+id).hasClass('.active')) {
			close_accordion_section();
		}else {
			close_accordion_section();

			// Add active class to section title
			jQuery('#'+id).addClass('active');
			// Open up the hidden content panel
			jQuery('.accordion ' + currentAttrValue).slideDown(300).addClass('open'); 
		}

//		id.preventDefault();

}

	function close_accordion_section() {
		jQuery('.accordion .accordion-section-title').removeClass('active');
		jQuery('.accordion .accordion-section-content').slideUp(300).removeClass('open');
	}