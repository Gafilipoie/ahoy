function HorizontalSlider() {
				this.slider = $('#horizontal-slider');
				this.hContainer = $('#horizontal-container');
				this.hElements = null;
				this.currentHIndex = 0;
				this.total_HSlides = 0;
				this.state = 0;
				this.t = null;
				this.t2 = null;
				this.isSliding = 0;
				this.videoIndex = 0;
				this.slideTime = 300;
				this.isOpen = false;
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
				this.eventsOn = false;
				this.mouseSens = 1;
				this.eventsOn = false;
				this.lazyLoadingDone == false;
				this.loadedImages = [];
				this.loadingSequence = [];
				this.backButtonsVisible = true;
				this.jsonCache = [];
				this.eventsAttached = false;
				this.navBarClicked = false;
				this.lastGoToIndex = 0;
				this.interruptGoTo = false;
}

/*************** GET FUNCTIONS ****************/
HorizontalSlider.prototype.resizeHorizontalHoverZones = function() {
	var bodyWidth = $('body').width();
	var vSliderLeft = parseInt(vSlider.vContainer.css('left'));
	var vSliderRight = parseInt(vSlider.vContainer.css('right'));
	var vSliderWidth = parseInt(vSlider.vContainer.css('width'));
	var vSliderMarginLeft = parseInt(vSlider.vContainer.css('margin-left'));
	var vSliderMarginRight = parseInt(vSlider.vContainer.css('margin-right'));

	if (vSliderMarginLeft == 0) {
		$('#h-hover-prev').css('width', vSliderLeft);
	} else {
		$('#h-hover-prev').css('width', vSliderMarginLeft);
	}

	if (vSliderMarginRight == 0) {
		$('#h-hover-next').css('width', bodyWidth - vSliderLeft - vSliderWidth);
	} else {
		$('#h-hover-next').css('width', vSliderMarginRight);
	}
}

HorizontalSlider.prototype.getSlideWidth = function() {
				try {
								return parseInt(this.hElements.find('li').first().outerWidth(true));
				}
				catch (error) {
								return Math.min(Math.floor(deviceWidth*0.49), 699);
				}
}

HorizontalSlider.prototype.getSlideHeight = function() {
				try {
								return parseInt(this.hElements.find('li').first().outerHeight(true));
				}
				catch (error) {
								var w = Math.min(Math.floor(deviceWidth*0.49), 699);
								return Math.ceil(w*0.67);
				}
}

HorizontalSlider.prototype.getPaginationWidth = function() {
				return parseInt($('.horizontal-pagination').first().outerWidth(true));
}

HorizontalSlider.prototype.getNavBarHeight = function() {
				return parseInt($('#horizontal-thover').first().height());
}

HorizontalSlider.prototype.getTopDistance = function() {
				return vSlider.getTopDistance() - vSlider.getTitleHeight();
}

HorizontalSlider.prototype.getLeftDistance = function() {
				return parseInt(vSlider.vContainer.offset().left);
}

HorizontalSlider.prototype.getRightDistance = function() {
				return parseInt(deviceWidth - this.getLeftDistance()- this.getSlideWidth());
}

HorizontalSlider.prototype.getSlideMargin = function() {
				return parseInt(this.slider.find('li').first().css('margin-left'));
}

HorizontalSlider.prototype.getLeftPosition = function() {
	var self = this;
	var halfslides = parseInt(self.getSlideCount()/2);
	var slideWidth =  self.getSlideWidth();
	var leftDistance =  this.getLeftDistance() + this.getSlideMargin();
	var newLeft = 0 - halfslides * slideWidth + leftDistance;
	if (clientDevice == 'mobile')
		return newLeft - 2;
	else
		return newLeft;
	return parseInt(newLeft);
}

HorizontalSlider.prototype.getCurrentLeft = function() {
				return parseInt(this.slider.css('left'));
}

HorizontalSlider.prototype.getFirstSlide = function() {
				return this.hElements.find('li').first();
}

HorizontalSlider.prototype.getLastSlide = function() {
				return this.hElements.find('li').last();
}

HorizontalSlider.prototype.getSlideCount = function() {
				return this.total_HSlides;
}

HorizontalSlider.prototype.getResizeRatio = function() {
				return this.getSlideHeight() / 469;
}

/*************** SET FUNCTIONS ****************/
HorizontalSlider.prototype.setCurrentIndex = function(index) {
				this.currentHIndex = index;
				if (this.currentHIndex < 0) this.currentHIndex = this.total_HSlides - 1;
				if (this.currentHIndex > this.total_HSlides - 1) this.currentHIndex = 0;
				this.selectBullet(this.currentHIndex);
}

HorizontalSlider.prototype.selectBullet = function(index) {
				$('.horizontal-pagination li').removeClass('active');
				$('#horizontal-thover .horizontal-pagination li').eq(index).addClass('active');
				$('#horizontal-bhover .horizontal-pagination li').eq(index).addClass('active');
}

/*************** INIT FUNCTIONS ****************/
HorizontalSlider.prototype.init = function(settings){
				var self = this;
				var settings = settings || null;

				if ( settings ) {
								self.slideTime = parseInt(settings.h_slide_time,10);
								self.openTime = parseInt(settings.h_open_time,10);
								self.closeTime = parseInt(settings.h_close_time,10);
								self.autoPositionTime = parseInt(settings.h_autopos_time,10);
								self.swipeStopTime = parseInt(settings.h_swipe_stop_time,10);
								self.openEasing = settings.h_open_easing;
								self.closeEasing = settings.h_close_easing;
								self.slideEasing = settings.h_slide_easing;
								self.autoPositionEasing = settings.h_autopos_easing;
								self.swipeStopEasing = settings.h_swipe_stop_easing;
								self.hoverSpeed = parseInt(settings.h_hover_speed,10);
								self.xSwipeSens = parseInt(settings.h_x_swipe_sens,10);
								self.ySwipeSens = parseInt(settings.h_y_swipe_sens,10);
								self.mouseSens = parseFloat(settings.mouse_sens);
				}

				self.hElements = self.slider.children('ul');
				self.hoverSlide = $('<div id="hover-slide"><h3>BACK TO PROJECTS</h3></div>');
				self.currentHIndex = 0;

}

HorizontalSlider.prototype.initPosition = function(){
	var self = this;
	var slideWidth =  self.getSlideWidth();
	var total = self.getSlideCount();

	self.slider.css('width', total * slideWidth);
	self.hContainer.css('top', self.getTopDistance());
	self.slider.css('left', self.getLeftPosition());
}

HorizontalSlider.prototype.initPagination = function() {

				var self = this;
				var count = self.getSlideCount();

				$('.horizontal-pagination').children().remove();
				for(var i = 0; i < count; i++) {
								$('.horizontal-pagination').append($('<li>'))
				}
				self.selectBullet(self.currentHIndex);
}

HorizontalSlider.prototype.alignPagination = function() {

				var self = this;
				var difference = (self.getSlideWidth() - self.getPaginationWidth())/2
				var hasSmall = $('.horizontal-pagination').hasClass('small');

				self.showPagination();

				$('.horizontal-prev span').css({'left': self.getLeftDistance() + self.getSlideMargin() * 2 });
				$('.horizontal-next span').css({'right': self.getRightDistance() });

				//if (difference < 80 && !hasSmall) {
								$('.horizontal-pagination').show(0).addClass('small');
								hasSmall = true;
				//}

				difference = (self.getSlideWidth() - self.getPaginationWidth())/2

				if (difference < 50 && hasSmall) {
								$('.horizontal-pagination').hide(0);
				}

				if (difference > 50 && hasSmall) {
								$('.horizontal-pagination').show(0);
				}

				difference = (self.getSlideWidth() - self.getPaginationWidth())/2;

				/*if (difference > 80 && hasSmall) {
								$('.horizontal-pagination').show(0).removeClass('small');
				}*/

				$('.horizontal-pagination').css({'left': self.getLeftDistance() + (self.getSlideWidth() - self.getPaginationWidth())/2 + 15});
}

HorizontalSlider.prototype.showPagination = function() {
				$('.horizontal-pagination').show(0);
				$('.horizontal-next span').show(0);
				$('.horizontal-prev span').show(0);
}

HorizontalSlider.prototype.hidePagination = function() {
				$('.horizontal-pagination').hide(0);
				$('.horizontal-next span').hide(0);
				$('.horizontal-prev span').hide(0);
}

HorizontalSlider.prototype.initEvents = function() {
	var self = this;
	var slideWidth = self.getSlideWidth();
	var leftPosition        = self.getLeftPosition();

	$('body').bind('click', '#container', function(ev){
		if (ev.target.id == 'left-column' || ev.target.id == 'container') hSlider.close();
	});

	$('#horizontal-container').on('click', '.video-js', function(ev) {
		id = 'videoElem' + self.currentHIndex;
		//var player = new _V_(id, {"controls": true});
		/*if (player.paused()) player.play();
		else player.pause();*/
	});

	$('.horizontal-pagination li').on('click', function(ev){self.goToSlide($(this).index());});
	$('.horizontal-prev span').on('click', function(ev){self.navBarClicked = true; self.slidePrev(1);});
	$('.horizontal-next span').on('click', function(ev){self.navBarClicked = true; self.slideNext(1);});
	//self.hContainer.on('click', function(ev){console.log('hContainer click')});

	$('#horizontal-slider li .text a').on('click', function(ev){ ev.stopImmediatePropagation(); });
	$('#horizontal-slider li .text a').on('mouseup', function(ev){
			ev.stopImmediatePropagation();
			self.slider.removeClass('clicked');
			self.slider.removeClass('dragable');
	}); //!imp

	if (clientDevice == 'desktop') {
		// Added new -> This is the code that is working now
		$("#h-hover-prev").each(function() {
			$(this).on("mouseenter", function(){
				if (!self.navBarClicked)
					self.startAutoScroll('right');
			});
			$(this).on("mouseleave", function(){
				self.navBarClicked = false;
				self.stopAutoScroll('left');
			});
			$(this).on("click", function(){
				self.navBarClicked = true;
				self.slidePrev(1);
			});
		});

		$("#h-hover-next").each(function() {
			$(this).on("mouseenter", function(){
				if (!self.navBarClicked)
					self.startAutoScroll('left');
			});
			$(this).on("mouseleave", function(){
				self.navBarClicked = false;
				self.stopAutoScroll('right');
			});
			$(this).on("click", function(){
				self.navBarClicked = true;
				self.slideNext(1);
			});
		});
		// Added new -> This is the code that is working now

		//AutoSlide events
		// $('.horizontal-prev span').on('mouseenter', function(ev){
		// 				if (!self.navBarClicked)
		// 								setTimeout(function(){self.startAutoScroll('right');}, self.slideTime);
		// });
		// $('.horizontal-next span').on('mouseenter', function(ev){
		// 				if (!self.navBarClicked)
		// 								setTimeout(function(){self.startAutoScroll('left');}, self.slideTime);
		// });
		//
		// $('.horizontal-prev span').on('mouseleave', function(ev){
		// 				self.navBarClicked = false;
		// 				self.stopAutoScroll('left');
		// });
		// $('.horizontal-next span').on('mouseleave', function(ev){
		// 				self.navBarClicked = false;
		// 				self.stopAutoScroll('right');
		// });

		$('horizontal-container').on('mouseleave', function() { clearInterval(self.autoScrollInterval); })
		$('horizontal-slider').on('mouseenter', function() { clearInterval(self.autoScrollInterval); })

		self.slider.on('mousewheel', function(event, delta, deltaX, deltaY) {
			if(!window.isMagicMouse && parseInt(deltaY) - deltaY != 0) window.isMagicMouse = true;
			if (self.isSliding == true) return 0
			if(deltaY > 0) {
				self.scrollPrev(deltaY);
			} else if(deltaY < 0) {
				self.scrollNext(deltaY);
			}
		});
	}

	if(!Modernizr.touch) {
		self.slider.on('mousedown', function(ev){
			mouseDownEvent(ev, ev.clientX, ev.clientY, self);
		})

		self.slider.on('mousemove', function(ev){
			clearInterval(self.autoScrollInterval);
			mouseMoveEvent(ev, ev.clientX, ev.clientY, self);
		})

		self.slider.on('mouseup', function(ev){
			mouseUpEvent(ev);
		})
	} else {
		$('#h-hover-prev, #h-hover-next').css( "display", "none");
		self.slider.on('touchstart', function(ev){
			if( ev.originalEvent.touches.length == 1)
				mouseDownEvent(ev, ev.originalEvent.targetTouches[0].pageX, ev.originalEvent.targetTouches[0].pageY, self);
		})

		self.slider.on('touchmove', function(ev){
			if( ev.originalEvent.touches.length == 1)
				mouseMoveEvent(ev, ev.originalEvent.targetTouches[0].pageX, ev.originalEvent.targetTouches[0].pageY, self);
		})

		self.slider.on('touchend', function(ev){
			mouseUpEvent(ev);
		})
	}

	var clickedIndex = -1;

	function mouseDownEvent(ev, x, y, self) {
		clickedIndex =  convertID($(ev.target).parent('li').attr('id'));
		if (self.isVideo(clickedIndex)) return;
		self.slider.addClass('clicked');
		self.slider.removeClass('dragable');
		self.lastTouchMoveX = self.startTouchX = x;
		self.lastTouchMoveY = self.startTouchY = y;
		self.difTouchX = self.startTouchX;
		self.difTouchY = self.startTouchY;

		//if slider is clicked while goToSlide animation
		if (self.jumpDistance > 1) {
			var distanceLeft = self.getDistanceLeft(clickedIndex);
			var distanceRight = self.getDistanceRight(clickedIndex);
			self.interruptGoTo = true;
			self.jumpDistance = 0;

			if (distanceLeft < distanceRight) {
				for (var i=0; i<distanceLeft; i++) {
					self.moveLastLeft();
				}
			} else {
				for (var i=0; i<distanceRight; i++) {
					self.moveFirstRight();
				}
			}
			self.slider.stop();
			self.currentHIndex = clickedIndex;
			self.setCurrentIndex(clickedIndex);
			ev.preventDefault();
			self.centerSlider();
			return
		}

		if(self.isSliding) ev.preventDefault();
		self.slider.stop(false,true).css({'left' : self.slider.css('left')})
	}

	function mouseMoveEvent(ev, x, y, self) {
		ev.preventDefault();
		if(!self.slider.hasClass('clicked')) return;

		self.slider.addClass('dragable');
		self.difTouchX = self.lastTouchMoveX;
		self.difTouchY = self.lastTouchMoveY;
		curX = x;
		curY = y;

		var sliderLeft = curX - self.lastTouchMoveX;
		self.slider.stop(false,true).css({'left' : '+='+sliderLeft});
		var currentLeft  = self.getCurrentLeft();
		var leftPosition = self.getLeftPosition();
		var difference  = leftPosition - currentLeft;

		if(difference > 0 && difference > slideWidth /2 ) {
			self.moveFirstRight();
			self.hideBackButton();
			self.setCurrentIndex(self.currentHIndex+1);
		} else if (difference < 0 && Math.abs(difference) > slideWidth/2) {
			self.moveLastLeft();
			self.hideBackButton();
			self.setCurrentIndex(self.currentHIndex-1);
		}
		self.lastTouchMoveX = curX;
		self.lastTouchMoveY = curY;
	}

	self.lastIndex = self.currentHIndex;

	function mouseUpEvent(ev){
		ev.stopPropagation();
		self.slider.removeClass('clicked');
		self.slider.removeClass('dragable');

		if(clientDevice == 'mobile') {
			var difY = (self.difTouchY - self.lastTouchMoveY)/ 15;
			var difX = (self.difTouchX - self.lastTouchMoveX)/ 15;
		} else {
			var difY = (self.difTouchY - self.lastTouchMoveY)/ self.ySwipeSens;
			var difX = (self.difTouchX - self.lastTouchMoveX)/ self.xSwipeSens;
		}

		var mouseX = self.lastTouchMoveX;
		var mouseY = self.lastTouchMoveY;
		var leftDistance = self.getLeftDistance();
		var topDistance = self.getTopDistance();
		var currentID = '#hItem' + self.currentHIndex;

		if (self.currentHIndex == clickedIndex && self.isVideo(clickedIndex)) {
			return;
		}

		if (self.interruptGoTo == true) {
			self.interruptGoTo = false;
			return
		}

		if( Math.abs(difX) >= 1 || Math.abs(difX) >= 1) {
			if ($(currentID).find('video').length > 0 && mouseX == 0) return
			if( difX <= -1) {
				self.slidePrev(1);
				self.hideBackButton();
				return;
			}
			if( difX >= 1) {
				self.slideNext(1);
				self.hideBackButton();
				return;
			}
			if( difY <= -1) {
				self.slideNext(1);
				self.hideBackButton();
				return;
			}
			if( difY >= 1) {
				self.slidePrev(1);
				self.hideBackButton();
				return;
			}
		}
		else {
			//check if prev or next slide is clicked
			//if (Math.abs(difX) == 0 && Math.abs(difY) == 0 && clickedIndex != self.currentHIndex) {

			if (Math.abs(difX) == 0 && Math.abs(difY) == 0 && (mouseX < leftDistance || mouseX > leftDistance + self.getSlideWidth()) )     {
				if (mouseX > 0) {
					self.goToSlide(clickedIndex);
					self.hideBackButton();
				}
				return;
			}

			if (self.isVideo(clickedIndex)) return;

			//if click on center
			if (Math.abs(difX) == 0 && Math.abs(difY) == 0 && clickedIndex == self.currentHIndex) {
				if (self.isVideo(clickedIndex)) {
					return;
				}

				if ($('#hover-slide').css('display') != 'none')
					self.close();
				else
					self.showBackButton();
				return;
			}
		}

		if (Math.abs(difX) > 0 && Math.abs(difX) < 1) {
			self.centerSlider();
			return;
		}
	}
}

HorizontalSlider.prototype.isVideo = function(index) {
				if ( $('#hItem' + index).find('video').length > 0 ) return true;
				if ( $('#hItem' + index).find('object').length > 0 ) return true;
				return false;
}

HorizontalSlider.prototype.unbindEvents = function() {
				$('.horizontal-pagination li').off();
				$('.horizontal-prev').off();
				$('.horizontal-next').off();
				$('.horizontal-prev span').off();
				$('.horizontal-next span').off();
				$('#hover-slide').off();
				$('#hover-slide li').off();
				this.hContainer.off();
				this.slider.off();
				$('hover-slide').off();
				$("#h-hover-prev").off();
				$("#h-hover-next").off();
}

HorizontalSlider.prototype.resetSlider = function(){
				this.loadingSequence = [];
				this.loadedImages = [1];
				this.lazyLoadingDone = false;
				this.hElements.html('');
				this.insertEmptySlides();
				this.addHoverSlide()
				this.resizeSlider(true);
				this.initPosition();
				this.initPagination();
				this.unbindEvents();
				$('#hover-slide').hide();
				this.initEvents();
				this.generateLoadingSequence();
				clearInterval(this.loadingInterval1);
				clearInterval(this.loadingInterval2);
				clearInterval(this.loadingInterval3);
}

HorizontalSlider.prototype.addHoverSlide = function () {
				if ($('#hover-slide').length < 1) this.slider.append(this.hoverSlide.hide());
}

HorizontalSlider.prototype.appendCoverSlide = function() {

				var data = this.jsonData[0].Slide;
				var cover = $('<li id="hItem0"><div><div class="text"><div></div></div></div></li>');
				var content = '';
				if (data.type=="image" || data.type == 'video') return 0;

				if (!!data.title_en) content += '<h3>'+data.title_en+'</h3>';
				if (!!data.text_en) content += '<div class="en">'+data.text_en+'</div>';
				if (!!data.title_de) content += '<h3>'+data.title_de+'</h3>';
				if (!!data.text_de) content += '<div class="de">'+data.text_de+'</div>';
				if (content = "") content = "No content yet.";
				cover.find('div').last().html(content);
				this.hElements.append(cover);
}

HorizontalSlider.prototype.insertEmptySlides = function() {
				var self = this;
				var total = self.total_HSlides;

				for (i=0; i<total/2; i++) {
								switch (self.jsonData[i].Slide.type) {
												case 'image': self.addEmptySlide(i, 'after'); break;
												case 'text':  self.addTextSlide(i, 'after'); break;
												case 'video': self.addVideoSlide(i, 'after'); break;
								}
				}
				for (i=total-1; i>=total/2; i--) {
								switch (self.jsonData[i].Slide.type) {
												case 'image': self.addEmptySlide(i, 'before'); break;
												case 'text':  self.addTextSlide(i, 'before'); break;
												case 'video': self.addVideoSlide(i, 'before'); break;
								}
				}

				self.slider.show(0).width(self.getSlideWidth() * self.total_HSlides);
				self.currentHIndex = 0;
				self.slider.css('left', self.getLeftPosition());
}

HorizontalSlider.prototype.addEmptySlide = function(index, position) {

				var self = this;
				var li_elem = $('<li id="hItem'+index+'"></li>');
				var h5_elem = $('<h5></h5>');
				self.loadedImages[index] = 1;
				if (!!self.jsonData[index].Slide.name_de) h5_elem.append('<span>'+self.jsonData[index].Slide.name_de+'/ </span>');
				if (!!self.jsonData[index].Slide.name_en) h5_elem.append('<span>'+self.jsonData[index].Slide.name_en+'/ </span>');
				if (h5_elem.html != '') li_elem.append(h5_elem);
				if (position == 'before')
								self.hElements.prepend(li_elem);
				else
								self.hElements.append(li_elem);
}

HorizontalSlider.prototype.addTextSlide = function(index, position) {

				var self = this;
				var data = this.jsonData[index].Slide;
				var li_elem = $('<li id="hItem'+index+'"></li>');
				var content = $('<div><div class="text"><div class="en"></div><div class="de"></div><div></div></div></div>');
				self.loadedImages[index] = 1;
				if (!data.title_en) data.title_en = '&nbsp;';
				if (!data.text_en) data.text_en= '&nbsp;';
				if (!data.title_de) data.title_de= '&nbsp;';
				if (!data.text_de) data.text_de= '&nbsp;';


				content.find('.en').append('<h3>'+data.title_de+'</h3>');
				content.find('.en').append(data.text_de);
				content.find('.de').append('<h3>'+data.title_en+'</h3>');
				content.find('.de').append(data.text_en);
				content.find('.de').css('color', options.primary_text_color);

				li_elem.append(content);
				if (position == 'before')
								this.hElements.prepend(li_elem);
				else
								this.hElements.append(li_elem);
}

HorizontalSlider.prototype.addVideoSlide = function(index, position) {
	var self = this;
	var data = this.jsonData[index].Slide;

	var video_tag = $('<video id="videoElem'+index+'" class="video-js vjs-default-skin vjs-big-play-centered" data-setup="{}"><source src="'+appURL+'img/uploads/videos/'+data.mp4+'" type="video/mp4" /></video>');
	var li_elem = $('<li id="hItem'+index+'"></li>').append(video_tag.wrap('<div></div>'));

	self.loadedImages[index] = 1;

	if (position == 'before')
		self.hElements.prepend(li_elem);
	else
		self.hElements.append(li_elem);

	if(videojs.getPlayers()["videoElem" + index + ""]) {
		delete videojs.getPlayers()["videoElem" + index + ""];
	}
	videojs("videoElem" + index + "", {"controls": true, "preload": "auto"}, function(){ });
	videojs("videoElem" + index + "").controlBar.hide()
	$('#videoElem'+index).css({'height': '100%', 'width': '100%'});
}

HorizontalSlider.prototype.alignVideos = function() {
		$("#horizontal-container li").find('video').each(function(){
			var vid = $(this);
			var parent = $(this).parent();
			var top = ( parent.height() - vid.height() ) / 2;
			var left = ( parent.width() - vid.width() ) / 2;
			parent.css('background', '#000000');
			vid.css({
				top: top,
				left: left
			})
		})

}

HorizontalSlider.prototype.toogleVideoControls = function (status){

		var currentID = '#hItem' + this.currentHIndex;
		if ($('#horizontal-container').find('video').length == 0) return;

		if ($(currentID).find('video').length > 0 || status == 'on') {
			var id = "videoElem" + this.currentHIndex;
			if (document.getElementById(id).readyState != 4) $(this).load();
			$('#'+id).attr('controls', 'true')

		}
		else {
			$("video").each(function(){
				$(this).removeAttr("controls").get(0).pause();
			});
		}
		//$('.vjs-men-title').remove();
		//$('.vjs-menu-item').remove();
		this.alignVideos();
}

HorizontalSlider.prototype.generateLoadingSequence = function() {
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

HorizontalSlider.prototype.getNextUnloadedImage = function() {
				for (var i = 1; i<= this.getSlideCount(); i++) {
								if (this.loadedImages[this.loadingSequence[i]] == 0)  return this.loadingSequence[i];
				}
				this.lazyLoadingDone = true;
}

HorizontalSlider.prototype.loadNextImage = function(index) {

				var self = this;

				var index = index || -1;
				var sw = 0; //check if current index or neighbours are loaded
				var cIndex = self.currentHIndex;

				if (index < 1 || self.loadedImages[index] == 1) {
								if (sw == 0 && self.loadedImages[cIndex+1] == 0)   { sw = 1; index = cIndex + 1;}
								if (sw == 0 && self.loadedImages[cIndex] == 0) { sw = 1; index = cIndex;}
								if (sw == 0 && self.loadedImages[cIndex+2] == 0) { sw = 1; index = cIndex+2;}
								if (sw == 0) index = self.getNextUnloadedImage();
				}

				//console.log ('Load image', index);
				if (index <= self.getSlideCount()) {
								if (self.jsonData[index-1].Slide.type == 'video') return;
								self.loadedImages[index] = 1;

								image_alt = self.jsonData[index-1].Slide.image_alt;
								image_title = self.jsonData[index-1].Slide.image_title;
								var src = getFullImagePath(self.jsonData[index-1].Slide.image);
								$("<img>", { src: src, alt: image_alt, title: image_title }).on('load error', function() {
												$('#hItem' + (index-1)).prepend(this);
												var img = $(this)
												setTimeout(function(){ self.alignImage(img) }, 0);
								});
				}
				if (self.lazyLoadingDone == true) {
								this.lazyLoadingDone = true;
								clearInterval(self.loadingInterval1);
								clearInterval(self.loadingInterval2);
								clearInterval(self.loadingInterval3);
				}
}

HorizontalSlider.prototype.open = function(url) {

				vSlider.isOpen = false;
				this.isOpen = true;

				var self = this;
				var w = Math.min(Math.floor(deviceWidth*0.49), 699);
				var h = Math.ceil(w*0.67);
				var cHeight = Math.max(191, h + self.getNavBarHeight() * 2)

				$('#horizontal-container').css({'top': self.getTopDistance(), 'height': cHeight});
				if (clientDevice == 'mobile') $('#horizontal-container').css('top', '-95.5px');

				self.hContainer.show(0);
				showLoader();
				self.slider.hide(0);

				vSlider.vContainer.addClass('grayscale');

				try {
								data = JSON.parse(self.jsonCache[url])
								self.openActions(data, url);
								self.jsonData = data;
				}
				catch(error) {
								$.ajax({
												url: url,
												dataType: 'json',
												cache: true
								}).done(function(data){
												self.openActions(data, url);
								});
				}
}

HorizontalSlider.prototype.openActions = function (data, url) {
				var self = this;

				self.jsonCache[url] = JSON.stringify(data);
				self.total_HSlides = data.length;
				self.jsonData = data;
				self.init(json_settings);
				self.resetSlider();
				self.initPosition();
				self.alignPagination();
				hideLoader();

				self.loadingInterval1  = setInterval(function(){self.loadNextImage(1);},400)
				self.loadingInterval2  = setInterval(function(){self.loadNextImage(self.total_HSlides-1);},400)
				self.loadingInterval3  = setInterval(function(){self.loadNextImage(self.total_HSlides);},400)

				self.slider.css('left', self.getLeftPosition() + self.getSlideWidth() * 2 );
				self.slider.show(0).animate({'left': self.getLeftPosition()}, 1200);
}

HorizontalSlider.prototype.close = function() {

				var self = this;

				whereIsNow = $('#menu a.selected, #mobile-menu li a.selected').eq(0).attr('href');
				history.pushState({}, '', whereIsNow);
				this.hContainer.fadeOut(200);
				hideLoader();
				$(".video-js").remove();
				this.slider.hide(0);
				this.hidePagination();
				clearInterval(self.loadingInterval1);
				clearInterval(self.loadingInterval2);
				clearInterval(self.loadingInterval3);
				vSlider.isOpen = true;
				vSlider.vContainer.removeClass('grayscale');
				this.isOpen = false;
}

HorizontalSlider.prototype.goToSlide = function(index, speed, easing) {
	var self = this;
	if (index < 0) index = this.total_HSlides-1;
	if (index == this.total_HSlides) index = 0;
	this.isSliding = true;
	self.lastGoToIndex = index;

	var speed = speed || this.openTime;
	var easing = easing || this.openEasing;
	var distanceLeft = self.getDistanceLeft(index);
	var distanceRight = self.getDistanceRight(index);

	if (distanceLeft < distanceRight) {
		self.slidePrev(distanceLeft, speed, easing);
	} else {
		self.slideNext(distanceRight, speed, easing);
	}
}

HorizontalSlider.prototype.getDistanceLeft = function(index) {
	var total  = this.total_HSlides;
	if(this.currentHIndex < index)
		return Math.abs(total - index + this.currentHIndex);
	else
		return Math.abs(index - this.currentHIndex);
}

HorizontalSlider.prototype.getDistanceRight = function(index) {

				var total  = this.total_HSlides;

				if(this.currentHIndex < index)
								return Math.abs(index - this.currentHIndex);
				else
								return Math.abs(total - this.currentHIndex + index);
}

HorizontalSlider.prototype.slidePrev = function(distance, speed, easing) {
	var speed = speed || this.openTime;
	var easing = easing || this.openEasing;
	var self = this;
	var currentLeft = self.getCurrentLeft()
	var leftPosition = self.getLeftPosition();
	var slideWidth = self.getSlideWidth();
	var difference =  slideWidth - Math.abs(leftPosition - currentLeft);
	var newLeft = currentLeft + slideWidth * (distance - 1) + difference;

	self.jumpDistance = distance;

	self.slider.stop(false,true).animate({left: newLeft}, speed, easing, function() {
		if (self.interruptGoTo == true) return
		for (var i = distance - 1; i >= 0; i--) {
			self.moveLastLeft();
			self.setCurrentIndex(self.currentHIndex - 1);
		};
		self.toogleVideoControls();
		self.isSliding = false;
		setTimeout(function(){if (!self.isSliding) self.centerSlider()}, 30);
	});
}

HorizontalSlider.prototype.slideNext = function(distance, speed, easing) {
	var speed = speed || this.openTime;
	var easing = easing || this.openEasing;

	var self = this;
	var currentLeft = self.getCurrentLeft();
	var leftPosition = self.getLeftPosition();
	var slideWidth = self.getSlideWidth();
	var difference =  slideWidth - Math.abs(leftPosition - currentLeft);
	var newLeft = currentLeft - slideWidth * (distance - 1) - difference;

	self.jumpDistance = distance;

	self.slider.stop(false,true).animate({left: newLeft}, speed, easing, function() {
		if (self.interruptGoTo == true) return
		for (var i = distance - 1; i >= 0; i--) {
			self.moveFirstRight();
			self.setCurrentIndex(self.currentHIndex + 1);
		};
		self.toogleVideoControls();
		self.isSliding = false;
		setTimeout(function(){if (!self.isSliding) self.centerSlider()}, 30);
	});
}

HorizontalSlider.prototype.moveFirstRight = function() {
				var self = this;
				self.slider.css('left', self.getCurrentLeft() + self.getSlideWidth())
				var first_slide = this.getFirstSlide().appendTo(this.hElements);
}

HorizontalSlider.prototype.moveLastLeft = function() {
				this.slider.css('left', this.getCurrentLeft() - this.getSlideWidth())
				var last_slide = this.getLastSlide().prependTo(this.hElements);
}

HorizontalSlider.prototype.showBackButton = function() {
				if ($('#hItem' + this.currentHIndex).find('video').length > 0) return 0;
				$('#hover-slide').prependTo('#hItem' + this.currentHIndex).show();
				this.backButtonsVisible = true;
}

HorizontalSlider.prototype.hideBackButton = function() {
				$('#hover-slide').hide(0);
				this.backButtonsVisible = false;
}

HorizontalSlider.prototype.centerSlider = function() {
	this.slider.stop(false,true).animate({left: this.getLeftPosition()});
}

HorizontalSlider.prototype.scrollPrev = function(delta) {
	var self = this;
	clearTimeout(self.timeoutEvent);
	clearTimeout(self.scrollStopTimeout);
	self.timeoutEvent = setTimeout(function(){self.scrollStop('right');}, 300);
	this.slider.stop(false, true);
	var currentLeft = self.getCurrentLeft();
	var leftPosition = self.getLeftPosition();

	var callback = function() {
		var currentLeft = self.getCurrentLeft()
		var slideWidth = self.getSlideWidth();
		var difference = Math.abs(leftPosition - currentLeft);
		if (difference > slideWidth) {
			self.moveLastLeft();
			self.setCurrentIndex(self.currentHIndex - 1);
		}
	}

	// if(!window.isMagicMouse) {
	// 	var newLeft = currentLeft + self.mouseSens;
	// 	self.slider.animate({left: newLeft}, 200, callback);
	// } else {
	// 	var newLeft = currentLeft + self.mouseSens * delta;
	// 	self.slider.css({left: newLeft});
	// 	setTimeout(callback, 0);
	// }
	var newLeft = currentLeft + 40 * delta;
	self.slider.css({left: newLeft});
	setTimeout(callback, 0);
}

HorizontalSlider.prototype.scrollNext = function(delta) {
	var self = this;
	clearTimeout(self.timeoutEvent);
	clearTimeout(self.scrollStopTimeout);
	self.timeoutEvent = setTimeout(function(){self.scrollStop('left');}, 300);
	this.slider.stop(false, true);
	var currentLeft = self.getCurrentLeft();
	var leftPosition = self.getLeftPosition();

	var callback = function() {
		var currentLeft = self.getCurrentLeft();
		var slideWidth = self.getSlideWidth();
		var difference = Math.abs(leftPosition - currentLeft);
		if (difference > slideWidth) {
			self.moveFirstRight();
			self.setCurrentIndex(self.currentHIndex + 1);
		}
	};

	// if(!window.isMagicMouse) {
	// 	var newLeft = currentLeft - self.mouseSens ;
	// 	self.slider.animate({left: newLeft}, 200, callback);
	// } else {
	// 	var newLeft = currentLeft + self.mouseSens * delta;
	// 	self.slider.css({left: newLeft});
	// 	setTimeout(callback, 0);
	// }
	var newLeft = currentLeft + 40 * delta;
	self.slider.css({left: newLeft});
	setTimeout(callback, 0);
}

HorizontalSlider.prototype.scrollStop = function(direction) {
	var self = this;
	// var difference = Math.abs(this.getLeftPosition() - this.getCurrentLeft());
	// if (difference > 90) {
	// 	if (direction == 'left') this.slideNext(1, 900, 'easeOutExpo');
	// 	if (direction == 'right') this.slidePrev(1, 900, 'easeOutExpo');
	// }
	self.scrollStopTimeout = setTimeout(function() {
		self.centerSlider();
	}, 300)
}

HorizontalSlider.prototype.startAutoScroll = function (direction) {
	var self = this;
	if (direction == 'left') direction = -1;
	if (direction == 'right') direction = 1;

	clearInterval(self.autoScrollInterval);
	self.autoScrollInterval = setInterval(function(){
		if (self.navBarClicked) {
			self.stopAutoScroll();
			return 0;
		}

		self.slider.stop(false, true);
		var currentLeft = self.getCurrentLeft()
		var leftPosition = self.getLeftPosition();

		var callback = function() {
			var currentLeft = self.getCurrentLeft();
			var slideWidth = self.getSlideWidth();
			var difference = Math.abs(leftPosition - currentLeft);

			if (difference > slideWidth) {
				if (direction == -1) {
					self.moveFirstRight();
					self.setCurrentIndex(self.currentHIndex + 1);
				} else {
					self.moveLastLeft();
					self.setCurrentIndex(self.currentHIndex - 1);
				}
			}
		}

		var newLeft = currentLeft + self.mouseSens * direction * 1.5;
		self.isSliding = true;
		self.slider.animate({'left': newLeft}, 500, 'linear', callback);
	}, 500)
}

HorizontalSlider.prototype.stopAutoScroll = function (direction) {
	var self = this;
	clearInterval(self.autoScrollInterval);
	self.isSliding = false;

	// var difference = Math.abs(self.getLeftPosition() - self.getCurrentLeft());
	// if (difference > 100  && difference < self.getSlideWidth() + 100) {
	// 	if (direction == 'left') self.slidePrev(1, 900, 'easeOutExpo');
	// 	if (direction == 'right') self.slideNext(1, 900, 'easeOutExpo');
	// }
	// else {
	// 	self.centerSlider();
	// }

	setTimeout(function() {
		self.centerSlider();
	}, 300)
}

HorizontalSlider.prototype.alignImages = function() {
				var self = this;
				$('.horizontal-slider li img').each(function(){ self.alignImage($(this)); })
}

HorizontalSlider.prototype.alignImage = function(image) {
				var slideHeight = this.getSlideHeight();
				var imgHeight = image.height();
				image.css({'margin-top': (slideHeight - imgHeight)/2});
				image.parent().css('background', 'white');
}

HorizontalSlider.prototype.resizeSlider = function(first_time) {
	var self = this;
	var w = Math.min(Math.floor(deviceWidth*0.49), 699);
	var h = Math.ceil(w*0.67);
	var cHeight = h + vSlider.getTitleHeight()*2;

	if (deviceWidth >= 765) {
		$('#horizontal-container').height(h + self.getNavBarHeight() * 2);
		$('#horizontal-slider').height(h);
		$('#horizontal-slider').css('top', self.getNavBarHeight());
		$('#horizontal-slider li').width(w);
		$('#horizontal-slider li').height(h);
	}
	else {
		var w = 250;//constant
		var h = 167;//constant
		var navBarWidth = 12;
		$('#horizontal-slider').attr( "style", "" );
		$('#horizontal-container').height(h + 2 * navBarWidth);
		$('#horizontal-slider').height(h);
		$('#horizontal-slider li').width(w);
		$('#horizontal-slider li').height(h);
	}

	$('#hover-slide h3').css('line-height', h + 'px');
	$('#horizontal-container').css('top', self.getTopDistance());

	self.alignImages();

	self.resizeText()
	self.slider.width(self.getSlideWidth() * self.total_HSlides);
	self.slider.css('left', self.getLeftPosition());
	if (!first_time) {
		self.alignPagination();
		self.alignVideos();
	}

	self.resizeHorizontalHoverZones();
}

HorizontalSlider.prototype.resizeText = function() {
				var ratio = this.getResizeRatio();

				$('#horizontal-slider .text span').css('font-size', 'inherit');

				if (deviceWidth > 765) {
								$('#horizontal-slider .en h3').css({'font-size': 20*ratio+'px', 'line-height': 26*ratio+'px'});
								$('#horizontal-slider .de h3').css({'font-size': 20*ratio+'px', 'line-height': 26*ratio+'px'});
								$('#horizontal-slider .en p').css({'font-size': 17*ratio+'px', 'line-height': 24*ratio+'px'});
								$('#horizontal-slider .de p').css({'font-size': 17*ratio+'px', 'line-height': 24*ratio+'px'});
				}
				else {
								$('#horizontal-slider .en h3').css({'font-size': '8px', 'line-height': '9px'});
								$('#horizontal-slider .de h3').css({'font-size': '8px', 'line-height': '9px'});
								$('#horizontal-slider .en p').css({'font-size': '7px', 'line-height': '8px', 'font-weight': 'bold'});
								$('#horizontal-slider .de p').css({'font-size': '7px', 'line-height': '8px', 'font-weight': 'bold'});
				}
}
