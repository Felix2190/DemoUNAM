/*
 * ************************************************************* *
 * Name       : plugins                                          *
 * Date       : March 2012                                       *
 * ************************************************************* *
 */
   
$(document).ready(function($){
	
	
	/* THIRD PARTY ----------------------------------------------------------- */

	/**
	 * Name        : jQuery layout
	 * Description : jQuery layout UI
	 * File Name   : layout.js
	 * Plugin Url  : http://layout.jquery-dev.net/index.cfm
	 * Updated     : --/--/----	
	 * Dependency  : jQuery core/ jQuery UI
	 * Developer   : Richard
	**/	
	
	if($('#jquery-layout-1').length){
		$("#jquery-layout-1").layout({ 
			applyDefaultStyles: false, 
			east__size:"50%",
			onresize_end: function(){
				// need to (re)initialize a plugin(s), do it here 
			} 	
		});
	}
	
	/* THIRD PARTY ----------------------------------------------------------- */

	/**
	 * Name        : Mansonry
	 * Description : Masonry layout plugin
	 * File Name   : masonry.pkgd.js
	 * Plugin Url  : http://masonry.desandro.com/
	 * Updated     : --/--/----	
	 * Dependency  : 
	 * Developer   : Richard
	**/	

	$('#mansory-container').masonry({
		columnWidth: 20,
		itemSelector: '.module-placeholder',
		transitionDuration: 0
	});

	/* THIRD PARTY ----------------------------------------------------------- */
		
	/**
	 * Name        : H5F
	 * Description : Crossbrowser support form forms
	 * Url         : https://github.com/ryanseddon/H5F
	 * Version     : 1.0	
	 * Updated     :
	 * Dependency  : h5f.js
	 * Developer   : Mark	 
	**/

	H5F.setup(document.getElementsByName("form"));
	
	/* CUSTOM/PREMIUM PLUGIN ----------------------------------------------- */
		   
	/**
	 * Name        : Bootstrap tabs extend
	 * Description : Extend the bootstrap tabs plugin with AJAX and responsive mode
	 * File Name   : bootstraptabsextend.js
	 * Plugin Url  : 
	 * Updated     : --/--/----	
	 * Dependency  : jQuery core, bootstrap
	 * Developer   : Mark
	**/	
	
	$('#res-tabs').bootstrapTabsExtend({
		responsive: true,
		responsiveClass: 'ext-tabs-responsive-mode',
		preloadAjax: false,
		onChange:function(ui){
			//ui.item(element)
			//ui.value(string)
		}
	});

	/* CUSTOM/PREMIUM PLUGIN ----------------------------------------------- */
		   
	/**
	 * Name        : Simple Select
	 * Description : Lightweigth select styling plugin
	 * File Name   : simpleselect.js
	 * Plugin Url  :  
	 * Updated     : --/--/----	
	 * Dependency  : jQuery core
	 * Developer   : Mark
	**/	
	
	$('.shortcut-menu, .simpleselect').simpleSelect({
		icon:'<i class="fa fa-caret-down"></i>',
		onChange:function(ui){
    		//ui.item(element)
       	    //ui.value(string)
		}
	});


	/* BOOTSTRAP ----------------------------------------------------------- */
	
	/** NOTICE: not the default bootstrap typeahead **/
	
	/**
	 * Name        : Bootstrap typeahead
	 * Description : Bootstrap typeahead(better version)
	 * File Name   : typeahead.js
	 * Plugin Url  : http://twitter.github.com/typeahead.js/ 
	 * Updated     : --/--/----	
	 * Dependency  : jQuery core, bootstrap
	 * Developer   : Mark
	**/	
	
	var ts = ['test', 'javascript', 'project', 'help','admin','cms','cmr','java','jquery','json', 'html5', 'help','hello','document','adobe','Buy this theme','Karma']
	
	// Toolbar 1
	$('#typeahead-toolbar-1').typeahead({
		name: 'toolbar',
		local: ts
	});
	
	// Toolbar 2
	$('#typeahead-toolbar-2').typeahead({
		name: 'toolbar',
		local: ts
	});
	
	// Main search
	$('#typeahead-sidebar-search').typeahead({
		name: 'sidebar-search',
		prefetch: 'js/plugins/data/typeahead-dummy.json',
		limit: 5,
		template: [
			'<div class="tt-block">',
			'<strong class="tt-name">{{name}}</strong>',
			'<p class="tt-description">{{description}}</p>',
			'</div>'
		].join(''),
		engine: Hogan //needed for the templating
		//ttl_ms: 1 // there's a bug right now that prevents it from being set to 0, will be fixed in v0.8.2
	});
		
	/* BOOTSTRAP ----------------------------------------------------------- */
	
	/**
	 * Name        : Bootstrap dropdown
	 * Description : Bootstrap dropdown menu's and buttons
	 * File Name   : bootstrap.js
	 * Plugin Url  : www.getbootstrap.com  
	 * Updated     : --/--/----	
	 * Dependency  : jQuery core, bootstrap
	 * Developer   : Richard
	**/	
	
	// notice that the dropdown plugin has been called true the data attributes,
	// but because of the lak of options on the plugin we have to call it again,
	// as we need some other plugins to work with the dropdown plugin, 
	// so this is the only solution for now.
	
	$('.dropdown-toggle').dropdown();

    /* BOOTSTRAP ----------------------------------------------------------- */
	 
	/**
	 * Name        : Bootstrap Tabs
	 * Description : Bootstrap tabs
	 * File Name   : bootstrap.js
	 * Plugin Url  : www.getbootstrap.com 
	 * Updated     : --/--/----	
	 * Dependency  : jQuery core, bootstrap
	 * Developer   : Richard
	**/	
				
	$('.ext-tabs-sidebar a, .ext-tabs-cmanager a, .ext-tabs a, .ext-tabs-vertical a, .ext-dropdown-tabs-ul a, .ext-tabs-vertical a').click(function(e){
		e.preventDefault();
		$(this).tab('show');
	});
	
	// This is a easy way to transform a button group into tabs.
	$('.ext-tabs-btn-group a').click(function(e){
		e.preventDefault();
		$(this).addClass('active').parent().find('.active').not($(this)).removeClass('active');
		$(this).tab('show');
	});
	
	
    /* BOOTSTRAP ----------------------------------------------------------- */
	 
	/**
	 * Name        : Bootstrap Tooltip
	 * Description : Bootstrap tooltip
	 * File Name   : bootstrap.js
	 * Plugin Url  : www.getbootstrap.com  
	 * Updated     : --/--/----	
	 * Dependency  : jQuery core, bootstrap
	 * Developer   : Richard
	**/				

	$('.tooltip-top, .table-tooltip').tooltip({
		placement: 'top',
		container: 'body'
	});
	$('.tooltip-right').tooltip({
		placement: 'right',
		container: 'body'
	});
	$('.tooltip-bottom').tooltip({
		placement: 'bottom',
		container: 'body'
	});
	$('.tooltip-left').tooltip({
		placement: 'left',
		container: 'body'
	});
  
	/* CUSTOM/PREMIUM PLUGIN ----------------------------------------------- */
		   
	/**
	 * Name        : Main Menu
	 * Description : Main drop down menu located in the sidebar(s)
	 * File Name   : mainmenu.js
	 * Plugin Url  :  
	 * Updated     : --/--/----	
	 * Dependency  : jQuery core
	 * Developer   : Mark
	**/	
	 	 	
	$('.sidebar-nav-v1, .sidebar-nav-v2').mainMenu({
		closeClass: 'fa-caret-down',
		openClass: 'fa-caret-left',
		speed: 400	
	});
	
	
	/* THIRD PARTY  ----------------------------------------------- */
		   
	/**
	 * Name        : Tiny srollbar
	 * Description : Styled scrollbar
	 * File Name   : tinycrollbar.js
	 * Plugin Url  : http://baijs.nl/tinyscrollbar/
	 * Updated     : --/--/----	
	 * Dependency  : jQuery core
	 * Developer   : Mark
	**/	

	/*
	* Vertical scrollbar
	* We wrap the scrollbars(plugin does not do this)
	*/
	$('.scrollbar-y, .ext-dropdown-chat-window')
	.wrapInner('<div class="overview">')
	.wrapInner('<div class="viewport">')
	.prepend('<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>');
	// run plugin	
	if($('.scrollbar-y').length){
		$('.scrollbar-y').tinyscrollbar({
			size:190// container height = 200px, scrollbar offset = 5px
		});
	}
	/*
	* Horizontal scrollbar
	* We wrap the scrollbars(plugin does not do this)
	*/
	$('.scrollbar-x')
	.wrapInner('<div class="overview">')
	.wrapInner('<div class="viewport">')
	.append('<div class="scrollbar"><div class="track"><div class="thumb"><div class="end"></div></div></div></div>');
	// run plugin
	if($('.scrollbar-x').length){
		$('.scrollbar-x').tinyscrollbar({ 
			axis: 'x'
		});
	}
	// main chat
	if($('#ext-dropdown-chat').length){
		$('#ext-dropdown-chat .btn').click(function(e){
			$(this).parents('.dropup, .dropdown').find('.ext-dropdown-chat-window').tinyscrollbar({size:210});
		});	
	}
	// demo chat
	if($('#ext-dropdown-chat-1, #ext-dropdown-chat-2, #ext-dropdown-chat-3, #ext-dropdown-chat-4, #ext-dropdown-chat-5, #ext-dropdown-chat-6').length){
		$('.ext-dropdown-chat-btn').click(function(e){
			$(this).parents('.dropup, .dropdown').find('.ext-dropdown-chat-window').tinyscrollbar({size:210});
		});	
	}
	// dropdown/dropup scrollbar demo's
	$('#trigger-scrollbar-1,#trigger-scrollbar-2,#trigger-scrollbar-3,#trigger-scrollbar-4,#trigger-scrollbar-5,#trigger-scrollbar-6').click(function(e){
		// notice we call the plugin twice, as the first time it wont get the dimensions right
		$(this).parent().find('.scrollbar-y').tinyscrollbar().tinyscrollbar({size:190});
	});	
	// reset if the screen gets resized
	$(window).resize(function(){
		// need to call the separtly
		if($('.scrollbar-y').length){
			$('.scrollbar-y').tinyscrollbar_update('relative');
		}
		if($('.scrollbar-x').length){
			$('.scrollbar-x').tinyscrollbar_update('top');// value 'relative' is buggy!
		}
	});
	// re-initialize(if tab is hidden it will not work)
	$('.ext-tabs-sidebar a').click(function(){
		$('.scrollbar-y').tinyscrollbar();
	});

	
	


});
