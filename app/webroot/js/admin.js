 
$(document).ready(function (){  


	var slides_form = $('#slides').closest('form');

	$( "#slides" ).sortable({
		placeholder: "ui-state-highlight",
		update: function(){
			$.post(slides_form.attr('action'), slides_form.serialize());
		}
	});

	//$( "#slides" ).disableSelection();




	$('.change-status').click(function(ev){
		ev.preventDefault();
		var self = $(this);
		$.get(self.attr('href'), function(data){
			if(self.hasClass('busy') && data=='active' ){
				self.removeClass('busy');
				self.addClass('active');
			}
			if(self.hasClass('active') && data=='busy' ){
				self.removeClass('active');
				self.addClass('busy');
			}
		})
	})


	$("table.sortable tbody,ul.sortable ").closest('form').submit(function(ev){
		ev.preventDefault();
	})


	$("table.sortable tbody,ul.sortable ").sortable({
		update: function() {
			var form_el = $(this).closest('form');
			var action = form_el.attr('action');
			$.post(action, form_el.serialize());
		  //  form_el.submit();
		},
		cancel: '.disable'

	});


	$('textarea.tinymce').tinymce({
		  // Location of TinyMCE script
		  script_url : cakeRoot +'tiny_mce/tiny_mce.js',

		  // General options
		  theme : "advanced",
		  skin : "o2k7",
		  plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist,wordcount",

		  // Theme options
		  theme_advanced_buttons1 : "justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		  theme_advanced_buttons2 : "bold,italic,underline,forecolor,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink",
		  theme_advanced_buttons3 : "",
		  theme_advanced_buttons4 : "",
		  theme_advanced_toolbar_location : "top",
		  theme_advanced_toolbar_align : "center",
		  theme_advanced_statusbar_location : "bottom",
		  theme_advanced_resizing : true,
		  theme_advanced_resize_horizontal : false,
		  // Example content CSS (should be your site CSS)
		  content_css : "css/content.css",
		  width: "380",
		  height: "480",
		  // Drop lists for link/image/media/template dialogs
		  template_external_list_url : "lists/template_list.js",
		  external_link_list_url : "lists/link_list.js",
		  external_image_list_url : "lists/image_list.js",
		  media_external_list_url : "lists/media_list.js",
	});


	$('textarea.tinymce-category').tinymce({
		// Location of TinyMCE script
		script_url : cakeRoot +'tiny_mce/tiny_mce.js',

		// General options
		theme : "advanced",
		skin : "o2k7",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

		  // Theme options
		theme_advanced_buttons1 : "justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "bold,italic,underline,forecolor,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,link,unlink",
		theme_advanced_buttons3 : "",
		theme_advanced_buttons4 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "center",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_resize_horizontal : false,
		// Example content CSS (should be your site CSS)
		content_css : "css/content.css",
		height: "200",
		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
	  	external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",
	});




})