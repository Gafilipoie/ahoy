
function TextSlider(){
	this.slider = $('#text-slider');
	this.tContainer = $('#text-container');
	this.tElements = $('#text-slider > li');
	this.currentTIndex = -1;
	this.total_TSlides = 0;
	this.t = null;
	this.t2 = null;
	this.isOpen = 0;
	this.slideTime = 300;
	this.openTime = 2000;
	this.closeTime = 2000;
	this.swipeTime = 1000;
	this.swipeEasing = "easeOutExpo";
	this.openEasing = "easeOutExpo";
	this.closeEasing = "easeOutExpo";
	this.slideEasing = "easeOutExpo";
	this.hoverSpeed = 1;
	this.animating = false;
	this.eventsOn = false;
	this.jsonCache = [];
}

/*************** GET FUNCTIONS ****************/
TextSlider.prototype.getSliderHeight = function() {
	var sliderPadding = 32;
	return parseInt($('#text-slider').height() + sliderPadding * 2);
}

TextSlider.prototype.getSliderWidth = function() {
	return parseInt($('#text-slider').outerWidth(true));
}

TextSlider.prototype.getNavBarWidth = function() {
		return parseInt($('#text-lhover').first().width());
}

TextSlider.prototype.getTopDistance = function() {
	return parseInt((deviceHeight - this.getSliderHeight())/2);
}

TextSlider.prototype.getPaginationHeight = function() {
	return parseInt($('.text-pagination').first().outerHeight(true));
}

TextSlider.prototype.getResizeRatio = function() {
		return this.getSliderWidth() / 699;
}

TextSlider.prototype.getSliderPadding = function() {
	return parseInt(tSlider.slider.css('padding-top'));
}

TextSlider.prototype.initPagination = function() {
	$('.text-pagination').children().remove();
	for(var i = 0; i < this.json_data.Tab.length; i++){
		$('#text-lhover .text-pagination').append($('<li>'));
		$('#text-rhover .text-pagination').append($('<li>'));
	}
	$('#text-lhover .text-pagination li').first().addClass('active');
	$('#text-rhover .text-pagination li').first().addClass('active');
}

TextSlider.prototype.showPagination = function() {
		$('.text-pagination').show();
		$('.text-prev span').show();
		$('.text-next span').show();
}

TextSlider.prototype.hidePagination = function() {
		$('.text-pagination').hide();
		$('.text-prev span').hide();
		$('.text-next span').hide();
}

TextSlider.prototype.alignPagination = function() {
	var self = this;
	$('.text-prev span').show().css({'top': vSlider.getTopDistance()});
	$('.text-next span').show().css({'bottom': vSlider.getTopDistance()});
	$('.text-pagination').show().css({'top': (deviceHeight - self.getPaginationHeight()) / 2 });
	//if (clientDevice == 'ipad') self.hidePagination();
}

TextSlider.prototype.init = function(opt){

	var self = this;

	var settings = opt || null;
	if(settings) {
		self.slideTime = parseInt(settings.t_slide_time,10);
		self.openTime = parseInt(settings.t_open_time,10);
		self.closeTime = parseInt(settings.t_close_time,10);
		self.swipeTime = parseInt(settings.t_swipe_time,10);
		self.swipeEasing = settings.t_swipe_easing;
		self.openEasing = settings.t_open_easing;
		self.closeEasing = settings.t_close_easing;
		self.slideEasing = settings.t_slide_easing;
		self.hoverSpeed = parseInt(settings.t_hover_speed,10);
	}

	self.tElements = self.slider.children('li');
	self.total_TSlides = self.tElements.length;
	self.initEvents();
}


TextSlider.prototype.alignSlider = function() {
	this.slider.stop().animate({'top': (deviceHeight - this.getSliderHeight())/2 }, 500);
}

TextSlider.prototype.open = function(){

	var self = this;
	self.isOpen = 1;
	hSlider.close();
	var el_height = self.getSliderHeight();
	self.tContainer.addClass('active');
	self.tContainer.show();
	loader.hide();

	$('#text-next,#text-prev').fadeIn(self.openTime);

	if(clientDevice == 'mobile') {
		$(self.tElements).each(function(){
			$('[style*=x-large]',this).css('font-size','medium');
		});
	}
		self.alignPagination();
}

TextSlider.prototype.close = function(callback){

	var self = this;
	self.tContainer.hide();
	if (callback) callback();
	$('#text-next,#text-prev').hide();

	/*
		self.slider.stop(true,false).animate({'opacity': 0},self.closeTime, self.closeEasing, function(){
		self.tElements.remove();
		self.isOpen = 0;
		self.tContainer.removeClass('active');
		self.tContainer.hide();
		if (callback) callback();
	});*/
}
TextSlider.prototype.getData = function(url) {

	var self = this;

	try {
		data = JSON.parse(self.jsonCache[url]);
		self.setData(data);
	}
	catch(error) {
		$.ajax({
			url: url,
			dataType: 'json',
			cache: true
		}).done(function(data){
			self.setData(data, url);
		});
	}
}


TextSlider.prototype.setData = function(json_data, url){

	var self = this;
	self.jsonCache[url] = JSON.stringify(json_data);
	self.json_data = json_data;

	self.clear();
	showLoader();

	for(var i = 0; i < json_data.Tab.length; i ++){

		var tab = json_data.Tab[i];
		var li_el = $('<li>').append($('<h3>').append($('<span>').html(tab.Tab.name_en)));
		var div_el = $('<div>');

		for(var j = 0; j < tab.Content.length; j++){
			var content = tab.Content[j];
			if(content.type == 'image'){
				var e_img = $('<img>').attr('src', getFullImagePath(content.image));
				if(content.image_alt) e_img.attr('alt', content.image_alt);
				if(content.image_title) e_img.attr('title', content.image_title);
				div_el.append(e_img);
			}

			if(content.type == 'text'){
				div_el.append($('<div>').addClass('text').addClass('clearfix').append($('<div>').addClass('en').html(content.text_en)).append($('<div>').addClass('de').html(content.text_de)));
				$('.text > .de').css('color', options.primary_text_color);
			}
		}

		li_el.append(div_el);
		self.slider.append(li_el);
	}

	self.init(json_settings);
	self.open();
	self.initPagination();
	self.resizeSlider(true); //true = first_time
	self.slider.show().css({'top': (deviceHeight - self.getSliderHeight())/2 });
	hideLoader();
	self.showPagination();
}


TextSlider.prototype.clear = function(){
	var self = this;
	self.destroyEvents();
	self.slider.html('');
}

TextSlider.prototype.initEvents = function(){

	var self = this;

	if(self.eventsOn == true){
					return;
	}


	self.eventsOn = true;

	self.slider.on('click','li > h3',function(){
		var that = $(this);
		self.showTSliderAtIndex(that.parent('li').index());
	})

	self.tContainer.on('click','.text-next', function(){
					self.showTSliderAtIndex(self.currentTIndex + 1);
	})
	self.tContainer.on('click','.text-prev', function(){
					self.showTSliderAtIndex(self.currentTIndex - 1);
	})


	if( clientDevice == 'desktop' ) {
		self.tContainer.on('mouseenter','.text-next', function(){
		var el_height = self.tElements.first().children('h3').outerHeight(true);

		self.t2 = setTimeout(function(){
			self.t = setInterval(function(){
				var top = parseInt(self.slider.css('top'), 10);
				top = top - self.hoverSpeed;
					if (top < 0) {
						var slider_height = self.slider.height();
						if (slider_height > deviceHeight && (slider_height+top+el_height) > deviceHeight) {
							self.slider.css({'top': top});
						}
					}
				} ,1);
			},200);
		})

		self.tContainer.on('mouseenter','.text-prev', function() {
			var el_height = self.tElements.first().children('h3').outerHeight(true);
			self.t2 = setTimeout(function() {
				self.t = setInterval(function() {
					var top = parseInt(self.slider.css('top'), 10);
					top = top + self.hoverSpeed;
					if( top < 0) {
						self.slider.css({'top': top});
					}
				}, 1)
			}, 200);
		})

		self.tContainer.on('mouseleave','.text-next,.text-prev', function(){
			clearInterval(self.t);
			clearTimeout(self.t2);
		})
	}


	self.slider.on('mousedown', function(ev){
		pointStart(ev, ev.clientX, ev.clientY);
	})

	self.slider.on('mousemove', function(ev){
		pointMove(ev, ev.clientX, ev.clientY);
	})

	self.slider.on('mouseup', function(ev){
		pointEnd(ev);
	})

	self.slider.on('touchstart', function(ev){
		if( ev.originalEvent.touches.length == 1){
						pointStart(ev, ev.originalEvent.targetTouches[0].pageX, ev.originalEvent.targetTouches[0].pageY);
		}
	})


	self.slider.on('touchmove', function(ev){
		if( ev.originalEvent.touches.length == 1){
						pointMove(ev, ev.originalEvent.targetTouches[0].pageX, ev.originalEvent.targetTouches[0].pageY);
		}
	})

	self.slider.on('touchend', function(ev){
		pointEnd(ev);

	})

	function pointStart(ev, x, y){

		self.slider.addClass('clicked');
		self.slider.removeClass('dragable');

		self.startTouchX = x;
		self.startTouchY = y;

		self.lastTouchMoveX = self.startTouchX;
		self.lastTouchMoveY = self.startTouchY;


		if(self.isSliding){
						ev.preventDefault();
		}

		self.slider.stop(true,false).css({'top' : self.slider.css('top')})

		self.difTouchX = self.startTouchX;
		self.difTouchY = self.startTouchY;
}

	function pointMove(ev, x, y){
		ev.preventDefault();

		if(self.slider.hasClass('clicked')) {

			self.slider.addClass('dragable');

			self.difTouchX = self.lastTouchMoveX;
			self.difTouchY = self.lastTouchMoveY;


			curX = x;
			curY = y;

			var vsliderTop = curY - self.lastTouchMoveY;

			var slider_height = self.slider.height();

			if(slider_height > deviceHeight+20){

							var top = parseInt(self.slider.css('top'), 10);

							if(top + vsliderTop < 10 && vsliderTop > 0){
															self.slider.stop(true,false).css({'top' : top + vsliderTop})
							}
							else{
											if(top >  deviceHeight - slider_height - 20 && vsliderTop < 0){
															self.slider.stop(true,false).css({'top' : top + vsliderTop})
											}
							}
			}

			self.lastTouchMoveX = curX;
			self.lastTouchMoveY = curY;
		}
	}

function pointEnd(ev){
				var difY = (self.difTouchY - self.lastTouchMoveY)/ 30;
				var difX = (self.difTouchX - self.lastTouchMoveX)/ 50;

				if( Math.abs(difY) >= 1){

								if( difY <= -1){
												difY = Math.floor(difY);
								}
								else{
												difY = Math.ceil(difY);
								}

								var sing = difY/Math.abs(difY);

								if(Math.abs(difY) == 1){
												self.moveUp()
												if(sing > 0 ){
																self.moveUp();
												}
												else{
																self.moveDown();
												}
								}
								else{
												setTimeout(function(){
																for(i=0;i< Math.abs(difY);i++){
																				if(sing > 0){
																								self.moveUp(Math.abs(difY))
																				}
																				else{
																								self.moveDown(Math.abs(difY));
																				}

																}
												},0)

								}

				}
				else{

								if(!( self.startTouchX - self.lastTouchMoveX == 0) && (self.startTouchY - self.lastTouchMoveY == 0)) {
												// NOT TAP EVENT
												ev.preventDefault();
								}
								/*
								if(Math.abs(difX) > 1 && Math.abs(difY) < 2){
												if(difX > 1) {
																changeCategory(+1);
												}
												else{
																changeCategory(-1);
												}

								}
								*/
				}
}

$('.text-pagination').on('click', 'li', function(){
				var that = this;

				var index = $(that).index();

				$('.text-pagination li').removeClass('active');
				$('#text-lhover .text-pagination li').eq(index).addClass('active');
				$('#text-rhover .text-pagination li').eq(index).addClass('active');

				self.showTSliderAtIndex(index);
});



tSlider.tContainer.mousewheel(function(event, delta, deltaX, deltaY) {
				if(!window.isMagicMouse && parseInt(deltaY) - deltaY != 0)
								window.isMagicMouse = true;

		if( deltaY < 0 ){
				 tSlider.moveUp(deltaY);
		}
		if( deltaY > 0 ){
					tSlider.moveDown(deltaY);
		}

	if( deltaX <= -1 ){
				clearTimeout($.data(this, 'timer'));
								$.data(this, 'timer', setTimeout(function() {
											changeCategory(1);
								}, 200));
	}
	if( deltaX >= 1 ){
				clearTimeout($.data(this, 'timer'));
								$.data(this, 'timer', setTimeout(function() {
							changeCategory(-1);
								}, 200));
	}


});



tSlider.tContainer.touchwipe({
				wipeRight:      function() {

								changeCategory(-1);

				},
				wipeLeft:       function() {

								changeCategory(+1);

				},

				min_move_x: 20,
				min_move_y: 20,
				preventDefaultEvents: true
})


}

TextSlider.prototype.destroyEvents = function(){

				var self = this;

				if(self.eventsOn == false){
								return;
				}

				self.eventsOn = false;

				clearInterval(self.t);
				clearTimeout(self.t2);


				self.slider.off('mousedown');
				self.slider.off('mousemove');
				self.slider.off('mouseup');

				self.slider.off('touchstart');
				self.slider.off('touchmove');
				self.slider.off('touchend');

				self.slider.off('click','li > h3');
				self.tContainer.off('click','.text-next');
				self.tContainer.off('click','.text-prev');
				self.tContainer.off('mouseenter','.text-next');
				self.tContainer.off('mouseenter','.text-prev');
				self.tContainer.off('mouseleave','.text-next,.text-prev');


				$('.text-pagination').off('click', 'li');
}

TextSlider.prototype.showTSliderAtIndex = function(slideIndex){

				var self = this;
				if(!(slideIndex < 0 || slideIndex >= self.total_TSlides)){

								self.currentTIndex = slideIndex;
								clearInterval(self.t);

								if(self.tElements.eq(slideIndex).hasClass('active')){

												self.tElements.removeClass('active');
												self.tElements.children('h3').children('span').css({'color': '#231F20', 'border-bottom': 'none'});
												self.animating = true;
												self.tElements.eq(slideIndex).children('div').slideUp(self.slideTime ,self.slideEasing, function(){

																				var el_height = self.getSliderHeight();
																				var top_distance = self.getTopDistance();
																				self.slider.animate({'top': top_distance}, 300);

																				setTimeout(function () {self.animating = false;}, 500);
												});
								}

								else{
												if(self.tElements.filter('.active').length > 0){
																self.tElements.children('div').slideUp(self.slideTime ,self.slideEasing);
																self.tElements.removeClass('active');
																self.tElements.children('h3').children('span').css({'color': '#231F20', 'border-bottom': 'none'});
												}

												self.tElements.eq(slideIndex).addClass('active');
												// if (that.parent('li').hasClass('active')) {
												self.tElements.eq(slideIndex).children('h3').children('span').css({'color': options.primary_text_color, 'border-bottom': '2px solid '+options.primary_text_color});
												// } else {
												// 	that.children('span').css({'color': '#231F20', 'border-bottom': 'none'});
												// }
												self.animating = true;
												self.tElements.eq(slideIndex).children('div').slideDown(self.slideTime ,self.slideEasing);
												self.slider.animate({'top': 0}, 300);

												setTimeout(function () {self.animating = false;}, 500);
								}

				}
				$('.text-pagination li').removeClass('active');
				$('#text-rhover .text-pagination li').eq(self.currentTIndex).addClass('active');
				$('#text-lhover .text-pagination li').eq(self.currentTIndex).addClass('active');

}

TextSlider.prototype.moveUp = function(deltaY){

				var self = this;
				var slider_height = self.slider.height();
				var top = parseInt(self.slider.css('top'), 10);
				var buffer = 300;

				if(window.isMagicMouse) {
								top = top - 50 * Math.abs(deltaY);
								buffer = 100;
				} else {
								top = top - 300 * Math.abs(deltaY);
				}

				if(top <  deviceHeight - slider_height - buffer){
								var gotoIndex = Math.min(self.total_TSlides, self.currentTIndex + 1);
								if(self.currentTIndex != gotoIndex && !self.animating)
												this.showTSliderAtIndex(gotoIndex);
								// return;
				}

				if(self.animating)
								return;

				if(slider_height > deviceHeight+50){

								if(top <  deviceHeight - slider_height ){

												top = deviceHeight- slider_height - 50;

								}


								if(window.isMagicMouse) {
												self.slider.css({'top' : top});
								} else {
												self.slider.stop(true,false).animate({'top' : top}, self.swipeTime, self.swipeEasing);
								}
				}
}


TextSlider.prototype.moveDown = function(deltaY){

				var self = this;

				var slider_height = self.slider.height();
				var top = parseInt(self.slider.css('top'), 10);

				if(window.isMagicMouse) {
								top = top + 50 * Math.abs(deltaY);
				} else {
								top = top + 300 * Math.abs(deltaY);
				}

				if(top > 70){
								var gotoIndex = Math.max(0, self.currentTIndex - 1);
								if(self.currentTIndex != gotoIndex && !self.animating)
												this.showTSliderAtIndex(gotoIndex);
								// return;
				}

				if(self.animating)
								return;

				if(slider_height > deviceHeight){
								if( top > 10){
												top = 10;
								}

								if(window.isMagicMouse) {
												self.slider.css({'top' : top});
								} else {
												self.slider.stop(true,false).animate({'top' : top}, self.swipeTime, self.swipeEasing);
								}
				}
}

TextSlider.prototype.resizeSlider = function(first_time) {
		var self = this;
		var w = Math.min(Math.floor(deviceWidth*0.49), 699);
		var h = Math.floor(w*0.67);

		if (deviceWidth > 765) {
				$('#text-container').width(w);
				$('#text-slider').width(w);
		}
		/*else {
				var w = 250;//constant
				var h = 167;//constant
				var navBarWidth = 12;
				$('#text-container').width(w + 2 * navBarWidth);
				$('#text-slider').css({'width': w});
		}*/

		self.showPagination();
		self.alignPagination();
		self.resizeText();
		if (!first_time) self.alignSlider();
}

TextSlider.prototype.resizeText = function() {
		var ratio = this.getResizeRatio();
		$('#text-slider li h3').css({'font-size': 58*ratio+'px', 'line-height': 58*ratio+'px'});
		$('#text-slider li .en').css({'font-size': 17*ratio+'px', 'line-height': 24*ratio+'px'});
		$('#text-slider li .de').css({'font-size': 17*ratio+'px', 'line-height': 24*ratio+'px'});

		$('#text-slider li h3').hover(function(){
			$(this).css('color', options.primary_text_color);
		}, function(){
				$(this).css('color','#231F20');
			}
		);
}
