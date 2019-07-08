function routie(routeName, routeCallback) {
	if(typeof routeCallback == 'function') {
			$.router.add('/'+routeName, routeCallback);
	} else {
		$.router.go(routeName);
	}
}

$(document).ready(function() {

	initApplication()

	vSlider = new VerticalSlider();
	hSlider = new HorizontalSlider();
	tSlider = new TextSlider();

	tSlider.init(json_settings);
	mobile_init();
	menu_reposition();
	align_logo();

	resizeSliders(true);
	attachDocumentEvents();
	attachMenuEvents();

	if(settings) mouseSens = parseFloat(settings.mouse_sens);

	if (window.location.pathname == "/") {
		const pathName = '/category/our_top_100';
		routie(pathName);
		setDocumentTitle(pathName)

	} else {
		routie(window.location.pathname);
		setDocumentTitle(window.location.pathname)
	}

	menu_reposition();

});

/*********************************
				CUSTOM FUNCTIONS
**********************************/

function initApplication() {
	//Window variables
	window.baseTitle = document.title.split('---')[0];
	window.deviceWidth = $('body').width()
	window.deviceHeight = $('body').height();
	window.isMagicMouse = false;
	window.mouseSens = 1
	window.clientDevice = 'desktop';
	window.loader = $('#loader');
	window.mousewheelevent = (/Firefox/i.test(navigator.userAgent)) ? "DOMMouseScroll" : "mousewheel"
	window.orientation = Math.floor(deviceWidth/ deviceHeight);
	window.settings = json_settings || null;
	window.options = json_options || null;
	window.MobileMenu = $('#mobile-menu');
	window.MobileMenu_ul = MobileMenu.find('ul');
	window.MobileMenu_li = MobileMenu.find('li');
	window.mouseupEventName = 'mouseup';
	window.clientGesture = false;
	window.appURL = 'https://'+document.domain+'/';

	if (
		navigator.userAgent.match(/IEMobile/i) ||
		navigator.userAgent.match(/Opera Mini/i) ||
		navigator.userAgent.match(/Android/i) ||
		navigator.userAgent.match(/BlackBerry/i) ||
		navigator.userAgent.match(/iPhone/i) ||
		navigator.userAgent.match(/iPod/i) ||
		navigator.userAgent.match(/iTouch/i)
	) clientDevice = 'mobile';

	if (navigator.userAgent.match(/iPad/i))  {
		clientDevice = 'ipad';
		jQuery.fx.interval = 50;
	}

	/*if (typeof String.prototype.trim != 'function') { // detect native implementation
	  String.prototype.trim = function () {
	    return this.replace(/^\s+/, '').replace(/\s+$/, '');
	  };
	}*/
}

function setDocumentTitle(pathName = '') {
	const path = pathName.split('/');
	const project = path[3] ? `${path[3].toUpperCase()} | ` : '';
	const category = path[2] ? `${path[2].toUpperCase()} | ` : '';
	document.title = project + category + window.baseTitle;
}

function hideLoader() {
	loader.stop(true,false).hide(0);
}

function mobile_init(){
	//MobileMenu_ul.css('marginTop', -(MobileMenu_li.first().height()* MobileMenu_li.length )/2);
	setTimeout(function(){ window.scrollTo(0,1); }, 500);
	$('body').addClass(clientDevice);
}

function menu_reposition() {
	var moveMenuTopValue = hSlider.getTopDistance() + vSlider.getTitleHeight();
	$('#left-column').animate({'opacity':1}, 100,'easeOutExpo');
	$('#logo').css('padding-top', ( hSlider.getTopDistance() - $('#logo').height() )/2 );
	$('#logo').css('color', options.primary_text_color);
	$('#move-menu').css('top', moveMenuTopValue)

	var w = Math.min(Math.floor(deviceWidth*0.49), 699);
	var h = vSlider.getSlideHeight() ||  Math.floor(w*0.67);

	var menuItemsCount = $('#menu li').length;
	var lineHeight = (h - 70) / menuItemsCount;
	$('#menu li').css({'line-height': lineHeight + 'px', 'font-size': (lineHeight-4)+'px'})
	$('#social-instagram-wrapper').css('bottom', (-moveMenuTopValue-20) / 2)
	$('#social-instagram img').css({'width': (lineHeight-2)*2+'px', 'height': (lineHeight-4)*2+'px'})
}

function attachMenuEvents() {

	$('#menu a:not([rel="project-content"]), #mobile-menu li a:not([rel="project-content"])').each(function(){
		var self = $(this);
		var rel = self.attr('rel');
		var text = getSlug($(this).text());
		text = trimString(text);
		var linkHref = '/'+rel + '/' + text;
		self.attr('href', linkHref);
		routie(rel + '/' + text, function() {

			window.menuVisible = false;

			$('#menu li a').removeClass('selected');
			$('#mobile-menu').hide();
			self.addClass('selected');
			$('#menu a[href="'+linkHref+'"]').addClass('selected');
			$('#mobile-menu li a[href="'+linkHref+'"]').addClass('selected');
			if (rel == 'category') {
				vSlider.slider.html();
				hSlider.close();
				tSlider.close();
				vSlider.open(trimString(text));
			}
			else {
				var title = removeUnderscore(trimString(text));
				var href = $("#menu a:contains('"+title+"')").data('url');
				vSlider.close();
				hSlider.close();
				tSlider.tContainer.show();
				tSlider.getData(href + '/true')
			}
		});
	});

	$('#menu a, #mobile-menu li a').on('click', function(ev){
		ev.preventDefault()
		$('#menu a, #mobile-menu li a').removeClass('selected');

		routie($(this).attr('href'));
		$(this).addClass('selected');
		//routie($(this).attr('rel')+'/'+getSlug(trimString($(this).text())))
		return false;
	})

	$('#menu a[rel="project-content"], #mobile-menu li a[rel="project-content"]').each(function(){
		var self = $(this)
		var rel = self.attr('rel');
		var sluged = self.attr('data-slug');
		var based = self.attr('data-base');
		var basedID = self.attr('data-baseid');

		var routed = 'category/'+based+'/'+sluged;
		routie(routed, function() {
			l = $('a[data-catid='+basedID+']')
			if(l.length == 0) return false;
			window.menuVisible = false;

			$('#menu li a').removeClass('selected');
			$('#mobile-menu').hide();
			l.addClass('selected');

			vSlider.slider.html();
			//hSlider.close();
			tSlider.close();
			text = l.attr('href');
			text = text.replace('/category', '');
			vSlider.open(trimString(text), trimString(sluged));
			vSlider.activate_hslider_pagc(trimString(sluged));
		});

	});

	if(!Modernizr.touch) {
		$('#mobile-logo').on('click', function(){
			var self = $(this)
			if (!window.menuVisible) {
				$('#mobile-menu').show();
				window.menuVisible = true;
			}
			else {
				window.menuVisible = false;
				$('#mobile-menu').hide();
			}

		});
	} else {
		$('#mobile-logo').on('touchend', function(){
			var self = $(this)
			if (!window.menuVisible) {
				$('#mobile-menu').show();
				window.menuVisible = true;
			}
			else {
				window.menuVisible = false;
				$('#mobile-menu').hide();
			}

		});
	}
}

function showLoader() {

	if(clientDevice == 'mobile') {
		//loader.css('margin-top','-51px');
		loader.css('left', deviceWidth / 2).show(0);
	}
	else {
		var leftPosition = Math.max($('#vertical-container').offset().left, $('#text-container').offset().left );
		var containerWidth = Math.max($('#vertical-container').width(), $('#text-container').width() ) + 15;
		loader.css('left', leftPosition  + containerWidth / 2 - 10).show(0);
	}
}

function attachDocumentEvents() {

	if(clientDevice == 'mobile') {
		$(document).on('touchstart' ,function() {
			if($(window).scrollTop() == 0) { window.scrollTo(0,1); }
		});
	}

	$(document).on('keydown',function(ev){
		switch(ev.keyCode){
			case 37:
				if (hSlider.isOpen == true && hSlider.isSliding == false) hSlider.slidePrev(1);
				break;
			case 39:
				if (hSlider.isOpen == true && hSlider.isSliding == false) hSlider.slideNext(1);
				break;
			case 40:
				if (vSlider.isOpen == true && vSlider.isSliding == false) vSlider.slideNext(1);
				break;
			case 38:
				if (vSlider.isOpen == true && vSlider.isSliding == false) vSlider.slidePrev(1);
				break;
			case 27:
				if (hSlider.isOpen == true) hSlider.close();
				break;
		}
	})

	$(document).on('mousedown','img', function(ev) {
		ev.preventDefault();
	});

	if (clientDevice != 'desktop') {
		mouseupEventName = 'touchend';
	}

	$(document).on(mouseupEventName, function(ev) {
		var clickedElement = $(ev.target);
		var clickedOutsideOfHorizontalSlider = 0 === clickedElement.parents('#horizontal-container').length;
		//if (clickedOutsideOfHorizontalSlider && hSlider.isOpen == true) hSlider.close();

		vSlider.slider.removeClass('clicked');
		hSlider.slider.removeClass('clicked');
		tSlider.slider.removeClass('clicked');
	});


	$(window).resize(function(){
		deviceWidth = $('body').width();
		deviceHeight = $('body').height();
		resizeSliders();
		menu_reposition();
	});

	$(document).trigger('click');
}

function align_logo() {
	var w = Math.min(Math.floor(deviceWidth*0.49), 699);
	var h = Math.floor(w*0.67);
	var slideHeight = h + 30;
	var topDistance = parseInt((deviceHeight - slideHeight - 30) / 2) + 30
	$('#logo').css('padding-top', ( topDistance - parseInt($('#logo').height()) ) / 2 - 15);
	$('#move-menu').css('top', topDistance);
}

function resizeSliders(first_time) {
	vSlider.resizeSlider(first_time);
	hSlider.resizeSlider(first_time);
	tSlider.resizeSlider(first_time);
}

function removeUnderscore(text) {
	return text.replace("_", ' ');
}

function getSlug(text) {
	text = text.replace(/ & /g,"_");
	text = text.replace(/& /g,"");
	return text.replace(/ /g,"_");
}

function getFullImagePath(filename) {
	if (filename == null) return;

	var ext = filename.split('.').reverse().shift();

	if (ext.toLowerCase() == 'gif' || clientDevice == 'ipad' || clientDevice == 'desktop')
		return cakeRoot + 'img/uploads/desktop/'+ filename;
	else
		return cakeRoot + 'img/uploads/mobile/'+ filename;

}

function convertID(htmlID) {
	return parseInt(htmlID.slice(5));
}

function sleep(ms)
	{
		var dt = new Date();
		dt.setTime(dt.getTime() + ms);
		while (new Date().getTime() < dt.getTime());
	}

function trimString(text) {
	return text.replace(/^\s+/, '').replace(/\s+$/, '')
}
