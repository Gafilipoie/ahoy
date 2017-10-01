
function VerticalSlider() {
	this.slider = $('#vertical-slider');
	this.vContainer = $('#vertical-container');
	this.vElements = $('#vertical-slider > ul');
	this.currentVIndex = 0;
	this.total_VSlides = 0;
	this.leftPosition = 0;
	this.topPosition = 0;
	this.currentVOpen = -99;
	this.t = null;
	this.t2 = null;
	this.isOpen = false;
	this.isSliding = false;
	this.slideTime = 300;
	this.openTime = 2000;
	this.closeTime = 2000;
	this.autoPositionTime = 600;
	this.swipeStopTime = 2500;
	this.openEasing = "easeOutExpo";
	this.closeEasing = "easeOutExpo";
	this.slideEasing = "easeOutExpo";
	this.autoPositionEasing = "easeOutExpo";
	this.swipeStopEasing = "easeOutExpo";
	this.xSwipeSens = 30;
	this.ySwipeSens = 50;
	this.hoverSpeed = 1;
	this.startTouchX = 0;
	this.startTouchY = 0;
	this.lastTouchMoveX = 0;
	this.lastTouchMoveY = 0;
	this.endTouchX = 0;
	this.endTouchY = 0;
	this.difTouchX = 0;
	this.difTouchY = 0;
	this.mouseSens = 1;
	this.eventsOn = false;
	this.lazyLoadingDone == false;
	this.loadedImages = [];
	this.loadingSequence = [];
	this.jsonCache = [];
	this.eventsAttached = false;
	this.navBarClicked = false;
	this.lastGoToIndex = 0;
	this.interruptGoTo = false;
}

/*************** GET FUNCTIONS ****************/
VerticalSlider.prototype.getSlideHeight = function() {
	return parseInt(this.vElements.find('li').first().outerHeight(true));
}

VerticalSlider.prototype.getTitleHeight = function() {
	return parseInt($('#vertical-slider ul li h5').first().height()) || 30;
}

VerticalSlider.prototype.getNavBarWidth = function() {
	return parseInt($('#vertical-lhover').first().width());
}

VerticalSlider.prototype.getPaginationHeight = function() {
	return parseInt($('.vertical-pagination').first().outerHeight(true));
}

VerticalSlider.prototype.getCurrentTop = function() {
	return parseInt(this.slider.css('top'));
}

VerticalSlider.prototype.getFirstSlide = function() {
	return this.vElements.find('li').first();
}

VerticalSlider.prototype.getLastSlide = function() {
	return this.vElements.find('li').last();
}

VerticalSlider.prototype.getSlideCount = function() {
	return this.total_VSlides;
}

VerticalSlider.prototype.getTopPosition = function() {
	var self = this;
	var halfslides = parseInt(self.getSlideCount()/2) - 1
	var slideHeight =  self.getSlideHeight();
	var h5_height = self.getTitleHeight();
	var halfDiff = (deviceHeight - slideHeight) / 2;
	var newTop = 0 - ((slideHeight - halfDiff) + h5_height/2 +  halfslides * slideHeight - h5_height);
	return parseInt(newTop);
}

VerticalSlider.prototype.getTopDistance = function() {
	return parseInt((deviceHeight - this.getSlideHeight() - this.getTitleHeight()) / 2) + this.getTitleHeight();
}

/*************** UPDATE FUNCTIONS ****************/
VerticalSlider.prototype.updateSlideCount = function() {
	this.total_VSlides = this.jsonData.Project.length;
}

VerticalSlider.prototype.setCurrentIndex = function(index) {
	this.currentVIndex = index;
	if (this.currentVIndex < 0) this.currentVIndex = this.total_VSlides;
	if (this.currentVIndex > this.total_VSlides) this.currentVIndex = 0;
	this.selectBullet(this.currentVIndex);
}

VerticalSlider.prototype.selectBullet = function(index) {
	$('.vertical-pagination li').removeClass('active');
	$('#vertical-lhover .vertical-pagination li').eq(index).addClass('active');
	$('#vertical-rhover .vertical-pagination li').eq(index).addClass('active');
}

VerticalSlider.prototype.getResizeRatio = function() {
	return this.getSlideHeight() / 499;
}

/*************** INIT FUNCTIONS ****************/
VerticalSlider.prototype.init = function(settings){
	var self = this;
	var settings = settings || null;

	if(settings) {
		self.slideTime = parseInt(settings.v_slide_time,10);
		self.openTime = parseInt(settings.v_open_time,10);
		self.closeTime = parseInt(settings.v_close_time,10);
		self.autoPositionTime = parseInt(settings.v_autopos_time,10);
		self.swipeStopTime = parseInt(settings.v_swipe_stop_time,10);
		self.openEasing = settings.v_open_easing;
		self.closeEasing = settings.v_close_easing;
		self.slideEasing = settings.v_slide_easing;
		self.autoPositionEasing = settings.v_autopos_easing;
		self.swipeStopEasing = settings.v_swipe_stop_easing;
		self.hoverSpeed = parseInt(settings.v_hover_speed,10);
		self.xSwipeSens = parseInt(settings.v_x_swipe_sens,10);
		self.ySwipeSens = parseInt(settings.v_y_swipe_sens,10);
		self.mouseSens = parseFloat(settings.mouse_sens);
	}
	self.initPagination();
	self.initEvents();
}

VerticalSlider.prototype.initEvents = function(){
	var self = this;
	var slideHeight = self.getSlideHeight();
	var topPosition	= self.getTopPosition();
	self.unbindEvents();

	$('#vertical-container').on('click', function(ev){ev.stopImmediatePropagation()});

	if(!Modernizr.touch) {
		self.slider.on('mousedown', function(ev){
			mouseDownEvent(ev, ev.clientX, ev.clientY, self);
		});

		self.slider.on('mousemove', function(ev){
			mouseMoveEvent(ev, ev.clientX, ev.clientY, self);
		});

		self.slider.off('mouseup').on('mouseup', function(ev){
			mouseUpEvent(ev);
		});
	} else {
		$('#v-hover-prev, #v-hover-next').css( "display", "none");
		self.slider.off('touchstart').on('touchstart', function(ev){
			if( ev.originalEvent.touches.length == 1)
				mouseDownEvent(ev, ev.originalEvent.targetTouches[0].pageX, ev.originalEvent.targetTouches[0].pageY, self);
		});

		self.slider.on('touchmove', function(ev){
			if( ev.originalEvent.touches.length == 1)
				mouseMoveEvent(ev, ev.originalEvent.targetTouches[0].pageX, ev.originalEvent.targetTouches[0].pageY, self);
		});

		self.slider.off('touchend').on('touchend', function(ev){
			mouseUpEvent(ev);
		});
	}

	self.slider.on('click', 'li a', function(ev){ ev.preventDefault(); });

	$('.vertical-prev').on('click', function(ev){
		if (hSlider.isOpen) hSlider.close();
	})

	$('.vertical-next').on('click', function(ev){
		if (hSlider.isOpen) hSlider.close();
	})

	$('.vertical-prev span').on('click', function(ev){
		ev.stopImmediatePropagation();
		self.navBarClicked = true;
		if (hSlider.isOpen)
			hSlider.close();
		else
			self.slidePrev(1);
	});

	$('.vertical-next span').on('click', function(ev){
		ev.stopImmediatePropagation();
		self.navBarClicked = true;
		if (hSlider.isOpen)
			hSlider.close();
		else
			self.slideNext(1);
	});

	$('.fb-share').on('click', function(ev){
		ev.stopImmediatePropagation();
		var thisSlug = this.parentElement.parentElement.getAttribute('data-project-slug')
		var url = window.location.href + '/' + thisSlug;
		var title = 'Fb Share';
		var descr = 'Facebook share popup';
		var image = '';
		var winWidth = 520;
		var winHeight = 350;
		var winTop = (window.innerHeight / 2) - (winHeight / 2);
		var winLeft = (window.innerWidth / 2) - (winWidth / 2);
		window.open('http://www.facebook.com/sharer.php?s=100&p[title]=' + title + '&p[summary]=' + descr + '&p[url]=' + url + '&p[images][0]=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
	});

	$('.pi-share').on('click', function(ev){
		ev.stopImmediatePropagation();
		var thisSlug = this.parentElement.parentElement.getAttribute('data-project-slug')
		var thisImage = this.parentElement.parentElement.children[0].children[0].getAttribute('src');
		var url = window.location.href + '/' + thisSlug;
		var winWidth = 520;
		var winHeight = 350;
		var winTop = (window.innerHeight / 2) - (winHeight / 2);
		var winLeft = (window.innerWidth / 2) - (winWidth / 2);
		window.open('https://www.pinterest.com/pin/create/link/?url=' + url + '&media=' + thisImage, 'ceva', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
	});

	if (clientDevice == 'desktop') {
		// Added new - This is the working version
		$("#v-hover-prev").each(function() {
			$(this).on("mouseenter", function(){
				if (!self.navBarClicked)
					self.startAutoScroll('down');
			});
			$(this).on("mouseleave", function(){
				self.navBarClicked = false;
				self.stopAutoScroll('up');
			});
			$(this).on("click", function(){
				self.navBarClicked = true;
				self.slidePrev(1);
			});
		});

		$("#v-hover-next").each(function() {
			$(this).on("mouseenter", function(){
				if (!self.navBarClicked)
					self.startAutoScroll('up');
			});
			$(this).on("mouseleave", function(){
				self.navBarClicked = false;
				self.stopAutoScroll('down');
			});
			$(this).on("click", function(){
				self.navBarClicked = true;
				self.slideNext(1);
			});
		});
		// Added new - This is the working version

		$('.vertical-pagination li').on('click', function(ev){ev.stopImmediatePropagation(); self.goToSlide($(this).index());});

		// $('.vertical-prev span').on('mouseenter', function(ev){
		// 	if (!self.navBarClicked)
		// 		setTimeout(function(){self.startAutoScroll('down');}, this.slideTime);
		// });
		//
		// $('.vertical-next span').on('mouseenter', function(ev){
		// 	if (!self.navBarClicked)
		// 		setTimeout(function(){self.startAutoScroll('up');}, this.slideTime);
		// });
		//
		// $('.vertical-prev span').on('mouseleave', function(ev){
		// 		self.navBarClicked = false;
		// 		self.stopAutoScroll('down');
		// });
		//
		// $('.vertical-next span').on('mouseleave', function(ev){
		// 	self.navBarClicked = false;
		// 	self.stopAutoScroll('up');
		// });

		$('vertical-container').on('mouseleave', function() { clearInterval(this.autoScrollInterval); })
		$('vertical-slider').on('mouseenter', function() { clearInterval(self.autoScrollInterval); })

		self.slider.on('mousewheel', function(event, delta, deltaX, deltaY) {
			if (hSlider.isOpen || this.isSliding) return;
			if(!window.isMagicMouse && parseInt(deltaY) - deltaY != 0) {
				window.isMagicMouse = true;
			}
			if(deltaY > 0) {
				self.scrollDown(deltaY);
			} else if(deltaY < 0) {
				self.scrollUp(deltaY);
			}
		});
	}

	/**/
	if (self.eventsAttached) return 0;  // !!! Don't atach other events
	self.eventsAttached = true;

	//$('#guide-image').on('click', function() { if (self.currentVIndex == 0) $(this).hide(); });

	self.vContainer.on('click', function(ev){ev.stopImmediatePropagation();})

	var clickedIndex = -1;

	function mouseDownEvent(ev, x, y, self) {
		//if (self.isSliding) return;
		clickedIndex =  convertID($(ev.target).closest('li').attr('id'));
		self.slider.addClass('clicked');
		self.slider.removeClass('dragable');
		self.lastTouchMoveX = self.startTouchX = x;
		self.lastTouchMoveY = self.startTouchY = y;
		self.difTouchX = self.startTouchX;
		self.difTouchY = self.startTouchY;

		//if slider is clicked while goToSlide animation
		if (self.jumpDistance > 1) {
			var distanceUp = self.getDistanceUp(clickedIndex);
			var distanceDown = self.getDistanceDown(clickedIndex);
			self.interruptGoTo = true;
			self.jumpDistance = 0;

			if (distanceUp < distanceDown) {
				for (var i=0; i<distanceUp; i++) {
					self.moveLastUp();
				}
			}
			else {
				for (var i=0; i<distanceDown; i++) {
					self.moveFirstDown();
				}
			}

			self.slider.stop();
			self.currentVIndex = clickedIndex;
			self.setCurrentIndex(clickedIndex);
			ev.preventDefault();
			self.centerSlider();
			return
		}

		if(self.isSliding) ev.preventDefault();
		self.slider.stop(false,true).css({'top' : self.slider.css('top')})
	}

	function mouseMoveEvent(ev, x, y, self) {
		ev.preventDefault();

		if(!self.slider.hasClass('clicked')  || hSlider.isOpen) return;

		self.slider.addClass('dragable');
		self.difTouchX = self.lastTouchMoveX;
		self.difTouchY = self.lastTouchMoveY;
		curX = x;
		curY = y;
		var sliderTop = curY - self.lastTouchMoveY;
		self.slider.stop(false,true).css({'top' : '+='+sliderTop});
		var currentTop  = self.getCurrentTop();
		topPosition = self.getTopPosition();
		var difference  = topPosition - currentTop;

		if(difference > 0 && difference > slideHeight /2 ) {
			self.moveFirstDown();
			self.setCurrentIndex(self.currentVIndex+1);
		} else if (difference < 0 && Math.abs(difference) > slideHeight/2) {
			self.moveLastUp();
			self.setCurrentIndex(self.currentVIndex-1);
		}

		self.lastTouchMoveX = curX;
		self.lastTouchMoveY = curY;
	}

	function mouseUpEvent(ev){

		ev.stopPropagation();
		vSlider.slider.removeClass('clicked');
		self.slider.removeClass('dragable');

		if(clientDevice == 'mobile') {
			var difY = (self.difTouchY - self.lastTouchMoveY)/ 15;
			var difX = (self.difTouchX - self.lastTouchMoveX)/ 15;
		} else {
			var difY = (self.difTouchY - self.lastTouchMoveY)/ self.ySwipeSens;
			var difX = (self.difTouchX - self.lastTouchMoveX)/ self.xSwipeSens;
		}

		var mouseY = self.lastTouchMoveY;
		var topDistance = self.getTopDistance();

		if (self.interruptGoTo == true) {
			self.interruptGoTo = false;
			return;
		}

		if( Math.abs(difY) >= 1) {
			if (hSlider.isOpen) return;
			if( difY <= -1) {
				if (hSlider.isOpen)  { hSlider.close(); return; }
				self.isSwiping = true;
				self.slidePrev(1);
			}
			else {
				if (hSlider.isOpen)  { hSlider.close(); return; }
				self.isSwiping = true;
				self.slideNext(1);
			}
		}
		else {
			//check if prev or next slide is clicked
			//if (Math.abs(difX) == 0 && Math.abs(difY) == 0 && clickedIndex != self.currentVIndex) {
			if (Math.abs(difX) == 0 && Math.abs(difY) == 0 && (mouseY < topDistance || mouseY > deviceHeight - topDistance) )	{
				if (hSlider.isOpen)  { hSlider.close(); return; }
				self.goToSlide(clickedIndex);
				return;
			}
			if (hSlider.isOpen) return;
			//if click on center
			if (Math.abs(difX) == 0 && Math.abs(difY) == 0 && clickedIndex == self.currentVIndex) {

				var slide = self.slider.find('li:hover');
				var id = convertID(slide.attr('id'));
				if (id != 0) {
					showLoader();
					projslug = slide.attr('data-project-slug');
					whereIsNow = $('#menu a.selected, #mobile-menu li a.selected').eq(0).attr('href');
					history.pushState({}, projslug, whereIsNow+'/'+projslug);
					hSlider.open(slide.find('a').first().attr('href'));
				}
				else {
					if($('#guide-image').css('display') == 'none') {
						$('#guide-image').off('click');
						$('#guide-image').show(0);
						setTimeout(function() {
								$('#guide-image').off('click').on('click', function(ev) {
									if (self.currentVIndex == 0) { $(this).hide() };
								});
						}, 600);
					}
				}
				return;
			}

			if (Math.abs(difY) > 0 && Math.abs(difY) < 1) {
				self.centerSlider();
				return;
			}
			/*if (difY > 0 && difY < 1) {
				if (Math.abs(self.startTouchY - self.lastTouchMoveY) < 200) {
					self.slideNext(1);
					return
				}
			} else {
				if (Math.abs(self.startTouchY - self.lastTouchMoveY) < 200) {
					self.slidePrev(1);
					return
				}
			}

			self.centerSlider();
		*/
		}
	}

}

/* ACTIVATE HSLIDER FROM PAGE */
VerticalSlider.prototype.activate_hslider_pagc = function (baseinfo){
	//ev.stopPropagation();
	self = this;
	//vSlider = this;
	//vSlider.slider.removeClass('clicked');
	//convertID($(ev.target).closest('li').attr('id'))
	self.slider.removeClass('dragable');
	showLoader();

	hSlider.open('/slides/view/'+baseinfo);

}

VerticalSlider.prototype.goToFindByLink = function(baseinfo) {
	self = this;
	ass = self.slider.find('a');
	for(idx = 0; idx < ass.length; idx++) {
		ar = $(ass[idx]);
		t = ar.attr('href');
		if(t.indexOf(baseinfo) != -1) {
			arId = convertID(ar.closest('li').attr('id'));
			self.goToSlide(arId);
			return true;
		}
	}
}
VerticalSlider.prototype.unbindEvents = function () {
	this.slider.off();
	$('.vertical-prev').off();
	$('.vertical-next').off();
	$('.vertical-prev span').off();
	$('.vertical-next span').off();
	$('#guide-image').off();
}

VerticalSlider.prototype.startAutoScroll = function (direction) {
	var self = this;
	if (hSlider.isOpen) return;
	if (direction == 'up') direction = -1;
	if (direction == 'down') direction = 1;

	clearInterval(self.autoScrollInterval);
	self.autoScrollInterval = setInterval(function(){

		if (self.navBarClicked) {
			self.stopAutoScroll();
			return 0;
		}

		self.slider.stop(false, true);
		var currentTop = self.getCurrentTop()
		var topPosition = self.getTopPosition();

		var callback = function() {
			var currentTop = self.getCurrentTop();
			var slideHeight = self.getSlideHeight();
			var difference = Math.abs(topPosition - currentTop);

			if (difference > slideHeight) {
				if (direction == -1) {
					self.moveFirstDown();
					self.setCurrentIndex(self.currentVIndex + 1);
				} else {
					self.moveLastUp();
					self.setCurrentIndex(self.currentVIndex - 1);
				}
			}
		}

		var newTop = currentTop + self.mouseSens * direction * 1.5;
		self.isSliding = true;
		self.slider.animate({'top': newTop}, 250, 'linear', callback);

	}, 250)
}

VerticalSlider.prototype.stopAutoScroll = function (direction) {
	var self = this;
	clearInterval(self.autoScrollInterval);
	self.isSliding = false;

	var difference = Math.abs(self.getTopPosition() - self.getCurrentTop());
	if (difference >100 && difference < self.getSlideHeight() + 100) {
		if (direction == 'up') self.slideNext(1, 900, 'easeOutExpo');
		if (direction == 'down') self.slidePrev(1, 900, 'easeOutExpo');
	}
	else {
		self.centerSlider();
	}

	/*
	setTimeout(function() {
		if (self.isSliding == false) {
					}
	}, 300)*/
}

VerticalSlider.prototype.open = function(category, goTo){
	var self = this;
	category = getSlug(category);

	var w = Math.min(Math.floor(deviceWidth*0.49), 699);
	var navBarWidth = 32; if (clientDevice == 'ipad') navBarWidth = 32;
	self.vContainer.css('width', w + 2 * navBarWidth).show();

	if (hSlider.isOpen) hSlider.close();

	self.hidePagination();
	this.slider.hide();
	showLoader();

	try {
		data = JSON.parse(self.jsonCache[category])
		self.openActions(data, category);
		self.jsonData = data;
		if(goTo) self.goToFindByLink(goTo);
	}
	catch(error) {
		$.ajax({
			url: appURL + 'projects/view/'+category+'/true',
			dataType: 'json',
			cache: true
		}).done(function(data){
			self.openActions(data, category);
			if(goTo) self.goToFindByLink(goTo);
		});
	}
}

VerticalSlider.prototype.openActions = function (data, category) {
	var self = this;
	self.jsonCache[category] = JSON.stringify(data);
	self.jsonData = data;
	self.isOpen = true;
	self.resetSlider();
	self.loadingInterval1  = window.setInterval(function(){self.loadNextImage();},400)
	self.loadingInterval2  = window.setInterval(function(){self.loadNextImage();},400)
	self.resizeSlider(true);
	self.init(json_settings);
	self.slider.css('top', self.getTopPosition() - 2 * self.getSlideHeight());

	self.slider.show(0).animate({'top': self.getTopPosition()}, 1100);
	hideLoader();

}

VerticalSlider.prototype.resetSlider = function(){
	this.updateSlideCount();
	this.loadingSequence = [];
	this.loadedImages = [];
	this.lazyLoadingDone = false;
	this.vElements.html('');
	this.addCoverSlide();
	this.insertEmptySlides();
	this.generateLoadingSequence();
	clearInterval(this.loadingInterval1);
	clearInterval(this.loadingInterval2);
}

VerticalSlider.prototype.generateLoadingSequence = function() {
	var self = this;
	var total = self.getSlideCount();
	for (i=1; i<=total; i++) {
		self.loadedImages[i] = 0;
	}
	for (i=1; i<=total/2; i++){
		self.loadingSequence.push(i);
		self.loadingSequence.push(total - i + 1);
	}
	if (total % 2 == 1) self.loadingSequence.push(parseInt(total/2) + 1);
}

VerticalSlider.prototype.insertEmptySlides = function() {
	var self = this;
	var total = self.getSlideCount();

	for (i=0; i<total/2; i++) {
		switch (self.jsonData.Project[i].Slide.type) {
			case 'image': self.addEmptySlide(i, 'after'); break;
			case 'text':  self.addTextSlide(i, 'after'); break;
			case 'video': self.addVideoSlide(i, 'after'); break;
		}
	}
	for (i=total-1; i>=total/2; i--) {
		switch (self.jsonData.Project[i].Slide.type) {
			case 'image': self.addEmptySlide(i, 'before'); break;
			case 'text':  self.addTextSlide(i, 'before'); break;
			case 'video': self.addVideoSlide(i, 'before'); break;
		}
	}

	self.currentVIndex = 0;
	self.slider.css('top', self.getTopPosition());
	self.slider.css('display', 'block');

	// Pinterest script
	var e = document.createElement('script');
	e.setAttribute('type','text/javascript');
	e.setAttribute('src','http://assets.pinterest.com/js/pinit.js');
	document.body.appendChild(e);
}

VerticalSlider.prototype.addEmptySlide = function(index, position) {
	var self = this;
	var category = self.jsonData.Project[index].Project.slug.replace(" ","_");
	var href  = appURL + "/slides/view/" + category;
	var li_elem = $('<li id="vItem'+(index+1)+'"></li>');
	var aimg_elem = $('<a href="'+href+'"></a>');
	var h5_elem = $('<h5><span>'+self.jsonData.Project[index].Project.name_en+' / </span>'+self.jsonData.Project[index].Project.name_de+'</h5>');
	h5_elem.children('span').css('color', options.primary_text_color);
	// Social Media Share Buttons
	var socialButtons = $('<div class="social-media" style="position:absolute;bottom:0px;right:0px;opacity:0;width:auto;height:auto;"></div>');
	var fbButton = $('<div class="fb-share" style="display:inline-block;">Facebook</div>');
	var piButton = $('<div class="pi-share" style="display:inline-block;">Pinterest</div>');
	socialButtons.html(fbButton).append(piButton);

	li_elem.html(aimg_elem).append(h5_elem).append(socialButtons);
	li_elem.attr('data-project-slug', String(self.jsonData.Project[index].Project.slug).toLowerCase());
	if (position == 'before')
		self.vElements.prepend(li_elem);
	else
		self.vElements.append(li_elem);
}

VerticalSlider.prototype.addCoverSlide = function() {

	var data = this.jsonData;
	var cover = $('<li id="vItem0"><div><div class="text"><div></div></div></div></li>');
	var content = '';

	if (!data.Category) data.Category = {name_en: 'No content'}
	if (!!data.Category.name_en) content += '<h3>'+data.Category.name_en+'</h3>';
	if (!!data.Category.text_en) content += '<div class="en">'+data.Category.text_en+'</div>';
	if (!!data.Category.name_de) content += '<h3>'+data.Category.name_de+'</h3>';
	if (!!data.Category.text_de) content += '<div class="de">'+data.Category.text_de+'</div>';
	cover.find('.text div').html(content);
	cover.append('<div id="guide-image"><img src="'+appURL+'/img/guide_to_navigation.png"/></div>');
	this.vElements.append(cover);
}


VerticalSlider.prototype.addTextSlide = function(index, position) {

	var data = this.jsonData[index].Slide;
	var li_elem = $('<li id="hItem'+index+'"></li>');
	var content = $('<div><div class="text"><div class="en"></div><div class="de"></div><div></div></div></div>');
	this.loadedImages[index] = 1;

	if (!!data.title_en) content.find('.en').append('<h3>'+data.title_en+'</h3>');
	if (!!data.text_en) content.find('.en').append(data.text_en);
	if (!!data.title_de) content.find('.de').last().append('<h3>'+data.title_de+'</h3>');
	if (!!data.text_de) content.find('.de').last().append(data.text_de);
	li_elem.append(content);
	if (position == 'before')
		this.hElements.prepend(li_elem);
	else
		this.hElements.append(li_elem);
}

VerticalSlider.prototype.addVideoSlide = function(index, position) {
	var self = this;
	var data = this.jsonData.Project[index].Slide;
	// var category = self.jsonData.Project[index].Project.slug.replace(" ","_");
	// var href  = appURL + "/slides/view/" + category;
	// var aimg_elem = $('<a href="'+href+'" style="position:absolute;top:-26px;left:0px;padding-top:26px;opacity:0;box-sizing:border-box;"></a>');
	var h5_elem = $('<h5><span>'+self.jsonData.Project[index].Project.name_en+' / </span>'+self.jsonData.Project[index].Project.name_de+'</h5>');
	h5_elem.children('span').css('color', options.primary_text_color);
	// class="video-js vjs-default-skin vjs-big-play-centered"
	var video_tag = $('<video id="videoElem'+(index+1)+'" preload="auto" data-setup="{}"><source src="'+appURL+'img/uploads/videos/'+data.mp4+'" type="video/mp4" /></video>');
	var li_elem = $('<li id="vItem'+(index+1)+'"></li>');
	var aimg_elem = $('<div class="video-slide video-js vjs-big-play-centered" style="position:absolute;top:0px;height:95%;background-color:rgba(255,255,255,0);"> \
		<button class="vjs-big-play-button"></button></div>');

	// Social Media Share Buttons
	// var socialButtons = $('<div class="social-media" style="position:absolute;bottom:0px;right:0px;opacity:0;width:auto;height:auto;"></div>');
	// var fbButton = $('<div class="fb-share" style="display:inline-block;">Facebook</div>');
	// var piButton = $('<div class="pi-share" style="display:inline-block;">Pinterest</div>');
	// socialButtons.html(fbButton).append(piButton);

	self.loadedImages[index] = 1;
	if (position == 'before')
		self.vElements.prepend(li_elem);
	else
		self.vElements.append(li_elem);

	li_elem.append(video_tag).append(aimg_elem).append(h5_elem)//.append(socialButtons)
	li_elem.attr('data-project-slug', String(self.jsonData.Project[index].Project.slug).toLowerCase());
	// if(videojs.getPlayers()["videoElem" + (index+1) + ""]) {
		// delete videojs.getPlayers()["videoElem" + (index+1) + ""];
	// }
	// videojs("videoElem" + (index+1) + "", {}, function(){ });
	$('#videoElem'+(index+1)).css({'height': '95%', 'width': '100%'});
}

VerticalSlider.prototype.getNextUnloadedImage = function() {
	for (var i = 1; i<= this.getSlideCount(); i++) {
		if (this.loadedImages[this.loadingSequence[i]] == 0)  return this.loadingSequence[i];
	}
	this.lazyLoadingDone = true;
	return this.getSlideCount() + 1;
}

VerticalSlider.prototype.loadNextImage = function() {
	var self = this;
	var index = -1;
	var sw = 0; //check if current index or neighbours are loaded

	if (self.isOpen == false) return;
	if (sw == 0 && self.loadedImages[self.currentVIndex] == 0)   { sw = 1; index = self.currentVIndex;}
	if (sw == 0 && self.loadedImages[self.currentVIndex-1] == 0) { sw = 1; index = self.currentVIndex-1;}
	if (sw == 0 && self.loadedImages[self.currentVIndex+1] == 0) { sw = 1; index = self.currentVIndex+1;}

	if (index == -1) index = self.getNextUnloadedImage();
	if (index <= self.getSlideCount()) {
		self.loadedImages[index] = 1;
		image_alt = self.jsonData.Project[index-1].Slide.image_alt;
		image_title = self.jsonData.Project[index-1].Slide.image_title;
		var src = getFullImagePath(self.jsonData.Project[index-1].Slide.image);

		$("<img>", { src: src, alt: image_alt, title: image_title }).on('load error', function() {
			$('#vItem' + index).find('a').html(this);
			self.alignImage($('#vItem' + index).find('img'));
		});
	}
	if (self.lazyLoadingDone == true) {
		this.lazyLoadingDone = true;
		clearInterval(self.loadingInterval1);
		clearInterval(self.loadingInterval2);
	}
}

VerticalSlider.prototype.alignImages = function(image) {
	var self = this;
	$('#vertical-slider li img').each(function(){ self.alignImage($(this)); })
}

VerticalSlider.prototype.alignImage = function(image) {
	var slideHeight = this.getSlideHeight();
	var titleHeight = this.getTitleHeight();
	var imgHeight = image.height();
	image.css({'margin-top': (slideHeight - titleHeight - imgHeight)/2});
	image.parent().css('background', 'white');
}

VerticalSlider.prototype.initPagination = function() {
	var self = this;
	var count = self.getSlideCount();
	self.hidePagination();
	$('.vertical-pagination').children().remove();
	for(var i = 0; i <= count; i++){
		$('#vertical-lhover .vertical-pagination').append($('<li>'))
		$('#vertical-rhover .vertical-pagination').append($('<li>'))
	}
	$('#vertical-lhover .vertical-pagination li').first().addClass('active');
	$('#vertical-rhover .vertical-pagination li').first().addClass('active');

	self.alignPagination();

}

VerticalSlider.prototype.showPagination = function() {
	$('.vertical-pagination').show(0);
	$('#vertical-rhover span').show(0)
	$('#vertical-lhover span').show(0)
}

VerticalSlider.prototype.hidePagination = function() {
	$('.vertical-pagination').hide(0);
	$('#vertical-rhover span').hide(0)
	$('#vertical-lhover span').hide(0)
}

VerticalSlider.prototype.alignPagination = function() {
	var self = this;
	var difference = (self.getSlideHeight() - self.getPaginationHeight())/2
	var hasSmall = $('.vertical-pagination').hasClass('small');

	self.showPagination();

	$('.vertical-prev span').css({'top': self.getTopDistance(), 'bottom': 'auto'});
	$('.vertical-next span').css({'bottom': self.getTopDistance() + 1, 'top': 'auto'});

	//if (difference < 80 && !hasSmall) {
		$('.vertical-pagination').show(0).addClass('small');
		hasSmall = true;
	//}

	var difference = (self.getSlideHeight() - self.getPaginationHeight())/2

	if (difference < 80 && hasSmall) {
		$('.vertical-pagination').hide();
	}

	if (difference > 50 && hasSmall) {
		$('.vertical-pagination').show(0);
	}

	var difference = (self.getSlideHeight() - self.getPaginationHeight())/2

	/*if (difference > 80 && hasSmall) {
		$('.vertical-pagination').show(0).removeClass('small');
	}*/

	$('.vertical-pagination').css({'top': (deviceHeight - self.getPaginationHeight())/2});

}

VerticalSlider.prototype.goToSlide = function(index, speed, easing) {
	var self = this;

	if (index < 0) index = self.total_HSlides-1;
	if (index == self.total_HSlides) index = 0;

	self.isSliding = true;
	self.lastGoToIndex = index;

	var speed = speed || self.openTime;
	var easing = easing || self.openEasing;

	//var total  = self.getSlideCount() + 1;
	//var currentIndex = self.currentVIndex;
	/*
	if(currentIndex < index) {
		var distanceUp = Math.abs(total - index + currentIndex);
		var distanceDown = Math.abs(index - currentIndex);
	} else {
		var distanceDown = Math.abs(total - currentIndex + index);
		var distanceUp = Math.abs(index - currentIndex);
	}*/

	var distanceUp = self.getDistanceUp(index)
	var distanceDown = self.getDistanceDown(index)

	if (distanceUp < distanceDown) {
		self.slidePrev(distanceUp, speed, easing);
	} else {
		self.slideNext(distanceDown, speed, easing);
	}
}

VerticalSlider.prototype.getDistanceUp = function(index) {
	var total  = this.getSlideCount() + 1;

	if(this.currentVIndex < index)
		return Math.abs(total - index + this.currentVIndex);
	else
		return Math.abs(index - this.currentVIndex);
}

VerticalSlider.prototype.getDistanceDown = function(index) {
	var total  = this.getSlideCount() + 1;

	if(this.currentVIndex < index)
		return Math.abs(index - this.currentVIndex);
	else
		return Math.abs(total - this.currentVIndex + index);
}

VerticalSlider.prototype.slidePrev = function(distance, speed, easing) {
	this.isSliding = true;
	var speed = speed || this.openTime;

	var easing = easing || this.openEasing;

	var self = this;
	var currentTop = self.getCurrentTop();
	var topPosition = self.getTopPosition();
	var slideHeight = self.getSlideHeight();
	var difference =  slideHeight - Math.abs(topPosition - currentTop);
	var newTop = currentTop + slideHeight * (distance - 1) + difference;

	self.jumpDistance = distance;

	self.slider.stop(false,true).animate({
		top: newTop
	}, speed, easing, function() {

		if (self.interruptGoTo == true) return

		for (var i = distance - 1; i >= 0; i--) {
			self.moveLastUp();
			self.setCurrentIndex(self.currentVIndex  - 1);
		};

		self.isSliding = false;
		self.jumpDistance = 0;
		setTimeout(function(){if (!self.isSliding) self.centerSlider()}, 30);
	});
}

VerticalSlider.prototype.slideNext = function(distance, speed, easing) {
	var speed = speed || this.openTime;
	var easing = easing || this.openEasing;

	var self = this;
	var currentTop = self.getCurrentTop();
	var topPosition = self.getTopPosition();
	var slideHeight = self.getSlideHeight();
	var difference =  slideHeight - Math.abs(topPosition - currentTop);
	var newTop = currentTop - slideHeight * (distance - 1) - difference;

	self.jumpDistance = distance;

	self.slider.stop(false,true).animate({
		top: newTop
	}, speed, easing, function() {

		if (self.interruptGoTo == true) return

		for (var i = distance - 1; i >= 0; i--) {
			self.moveFirstDown();
			self.setCurrentIndex(self.currentVIndex + 1);
		};

		self.isSliding = false;
		setTimeout(function(){if (!self.isSliding) self.centerSlider()}, 30);
		self.jumpDistance = 0;
	});
}

VerticalSlider.prototype.centerSlider = function(index) {
	this.slider.stop(false,true).animate({top: this.getTopPosition()});
}

VerticalSlider.prototype.scrollDown = function(delta) {
	var self = this;
	clearTimeout(self.timeoutEvent);
	self.timeoutEvent = setTimeout(function(){self.scrollStop('down');}, 300);
	this.slider.stop(false, true);
	var currentTop = parseInt(self.slider.css('top'));
	var topPosition = self.getTopPosition();

	var callback = function() {

		var currentTop = parseInt(self.slider.css('top'));
		var slideHeight = parseInt(self.vElements.find('li').first().outerHeight(true));
		var difference = Math.abs(topPosition - currentTop);
		if (difference > slideHeight) {
			self.moveLastUp();
			self.setCurrentIndex(self.currentVIndex-1);
		}
	};

	if(!window.isMagicMouse) {
		var newTop = currentTop + self.mouseSens * 1;
		self.slider.animate({top: newTop}, 200, callback);
	} else {
		var newTop = currentTop + self.mouseSens * delta;
		self.slider.css({top: newTop});
		setTimeout(callback, 0);
	}
}

VerticalSlider.prototype.scrollUp = function(delta) {
	var self = this;
	clearTimeout(self.timeoutEvent);
	self.timeoutEvent = setTimeout(function(){self.scrollStop('up');}, 300);
	this.slider.stop(false, true);
	var currentTop = parseInt(self.slider.css('top'));
	var topPosition = self.getTopPosition();
	var callback = function() {
		var currentTop = parseInt(self.slider.css('top'));
		var slideHeight = parseInt(self.vElements.find('li').first().outerHeight(true));
		var difference = Math.abs(topPosition - currentTop);
		if (difference > slideHeight) {
			self.moveFirstDown();
			self.setCurrentIndex(self.currentVIndex+1);
		}
	}

	if(!window.isMagicMouse) {
		var newTop = currentTop - self.mouseSens * 1;
		self.slider.animate({top: newTop}, 200, callback);
	} else {
		var newTop = currentTop + self.mouseSens * delta;
		self.slider.css({top: newTop});
		setTimeout(callback, 0);
	}
}

VerticalSlider.prototype.scrollStop = function(direction) {
	var difference = Math.abs(this.getTopPosition() - this.getCurrentTop());

	if (difference > 90) {
		if (direction == 'up') this.slideNext(1, 900, 'easeOutExpo');
		if (direction == 'down') this.slidePrev(1, 900, 'easeOutExpo');
	}
	//this.centerSlider();
}

VerticalSlider.prototype.moveFirstDown = function() {
	var first_slide = this.getFirstSlide().appendTo(this.vElements);
	this.slider.css('top', this.getCurrentTop() + this.getSlideHeight())
}

VerticalSlider.prototype.moveLastUp = function() {
	var last_slide = this.getLastSlide().prependTo(this.vElements);
	this.slider.css('top', this.getCurrentTop() - this.getSlideHeight())
}

VerticalSlider.prototype.close = function() {
	this.unbindEvents();
	this.vContainer.hide();
	this.slider.hide();
	this.hidePagination();
}

VerticalSlider.prototype.resizeSlider = function(first_time) {
	var self = this;
	var w = Math.min(Math.floor(deviceWidth*0.49), 699);
	var h = Math.floor(w*0.67);

	if (deviceWidth > 765) {
		$('#vertical-container').width(w + self.getNavBarWidth()*2);
		$('#vertical-slider').css({'width': w, 'left': self.getNavBarWidth()});
		$('#vertical-slider li').height(h + self.getTitleHeight());
		$('#vertical-slider li a').height(h);
		$('#vItem0').css({height:h, 'padding-bottom':self.getTitleHeight() });
		$('#vItem0 img').height(h);
	}
	else {
		var w = 250;//constant
		var h = 167;//constant
		var navBarWidth = 12;
		var slideTitleHeight = 12;
		$('#vertical-container').width(w + 2 * navBarWidth);
		$('#vertical-slider').css({'width': w, 'left': navBarWidth});
		$('#vertical-slider li').height(h + slideTitleHeight);
		$('#vertical-slider li a').height(h);
		$('#vItem0').css({height:h, 'padding-bottom':slideTitleHeight });
		$('#vItem0 img').height(h);
	}

	self.alignImages();
	self.resizeText();
	self.slider.css('top', self.getTopPosition());
	self.alignPagination();
}

VerticalSlider.prototype.resizeText = function() {
	var self = this;
	var ratio = this.getResizeRatio();

	$('#vertical-slider .text span').css('font-size', 'inherit')
	$('#vertical-slider .de span').css('color', '#fff');


	if (deviceWidth > 765) {
		$('#vertical-slider .text h3').css({'font-size': 38*ratio+'px', 'line-height': 41*ratio+'px'});
		$('#vertical-slider .text .en').css({'font-size': 22*ratio+'px', 'line-height': 23*ratio+'px'});
		$('#vertical-slider .text .de').css({'font-size': 22*ratio+'px', 'line-height': 23*ratio+'px'});
		$('#vertical-slider .text .en').css({'margin': 20*ratio+'px 0px'});
	}
	else {
		$('#vertical-slider .text h3').css({'font': '14px', 'font-weight': 'bold'});
		$('#vertical-slider .text .en').css({'font-size': '8px', 'line-height': '9px', 'font-weight': 'bold'});
		$('#vertical-slider .text .de').css({'font-size': '8px', 'line-height': '9px', 'font-weight': 'bold'});
		$('#vertical-slider .text .en').css({'margin': '10px'});
	}

	/*var centerSlideContentHeight = parseInt($('#vItem0 h3').height()) + parseInt($('#vItem0 .en').height()) + parseInt($('#vItem0 .de').height())
	var slideHeight = self.getSlideHeight();
	$('#vItem0 h3').css('margin-top', (slideHeight - centerSlideContentHeight) / 2);*/
}
