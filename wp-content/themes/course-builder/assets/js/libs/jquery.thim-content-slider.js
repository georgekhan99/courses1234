/**
 * jQuery Content Slider plugin
 *
 * @author ThimPress
 */
;
(function ($) {
	$.thimContentSlider = function (el, options) {
		this.$el = $(el).addClass('thim-content-slider');
		this.$items = [];
		this.options = $.extend({}, $.fn.thimContentSlider.defaults, options);
		var root = this,
			$win = $(window),
			$doc = $(document),
			$body = $(document.body),
			containerWidth = 0,
			updateTimer = null,
			playTimer = null,
			midElement = 0,
			activeElement = 0,
			viewPortWidth = 0,
			scrolling = false,
			currentItem = 0,
			maxItems = 0,
			ratio = this.options.activeItemRatio || 2.5,
			activeItemPadding = this.options.activeItemPadding,
			itemWidth = 0,
			midItemWidth = 0,
			itemsVisible = this.options.itemsVisible || 7,
			midPosition = 0,
			navDuration = 250,
			touch = {},
			isTouch = "ontouchstart" in window || window.navigator.msMaxTouchPoints,
			events = {
				start: isTouch ? 'touchstart' : 'mousedown',
				move : isTouch ? 'touchmove' : 'mousemove',
				end  : isTouch ? 'touchend' : 'mouseup'
			},
			_speed = '',
			_showContent = true;

		function createItem(args) {
			var $item = $(' \
				<li> \
					<div class="slide-content" style="margin: ' + _opt('itemPadding') + 'px;"> \
						<img src="' + args.image + '" /> \
					</div> \
				</li> \
			');
			return $item;
		}

		function parseItems() {
			var itemType = typeof root.options.items,
				$items = null;
			if (itemType == 'string') {
				$items = $(root.options.items);
			} else if (itemType == 'object') {
				$items = $(root.options.items).children();
			}
			if ($items) {
				root.options.items = [];
				$items.each(function () {
					var $item = $(this),
						$img = $item.find('img' + root.options.imageSelector + ':first'),
						$url = $img.parent();
					root.options.items.push({
						image  : $img.attr('src'),
						url    : $url.is('a') ? $url.attr('href') : '',
						content: $item.find(root.options.contentSelector)
					});
				});
			}
		}

		function createHTML() {
			var $html = $(' \
					<div class="slides-content"></div>\
					<div class="slides-wrapper"> \
						<ul class="scrollable"></ul> \
						<a href="prev" class="control-nav prev"></a> \
						<a href="next" class="control-nav next"></a> \
					</div> \
				'),
				items = root.options.items;
			root.$el.html($html);
			root.$slidesWrapper = root.$el.find('.slides-wrapper');
			root.$scrollable = root.$el.find('.scrollable').css({
				marginTop   : -_opt('itemPadding'),
				marginBottom: -_opt('itemPadding')
			});
			root.$slideContent = root.$el.find('.slides-content');
			for (var i = 0, n = items.length; i < n; i++) {
				var $item = createItem({image: items[i].image}),
					$content = $('<div class="slide-content" />').append(items[i].content);
				root.$scrollable.append($item);
				root.$slideContent.append($content);
			}
			root.$items = root.$scrollable.children();

			itemsVisible = _opt('itemsVisible') <= _opt('items').length ? _opt('itemsVisible') : _opt('items').length;
			midElement = Math.floor(itemsVisible / 2);
			activeElement = midElement;
			maxItems = root.$items.length;
			currentItem = activeElement;

			root.$el
				.on('click', '.control-nav', _controlNav)
				.on('click', '.scrollable > li', _controlNav);

			if (root.options.mouseWheel) {
				root.$el
					.on('mousewheel', function (e, t, n, r) {
						e.preventDefault();
						if (t != -1) _prevItem();
						else _nextItem();
					});
			}

			if (root.options.autoPlay) {
				_autoPlay();
			}

			if (root.options.pauseOnHover) {
				root.$el.hover(function () {
					_pause();
				}, function () {
					_restart();
				});
			}

			root.$scrollable
				.bind(events.start, _touchStart)
				.bind(events.move, _touchMove)
				.bind(events.end, _touchEnd)

			_initNav();
			root.$slideContent.children().eq(activeElement).css({opacity: 1}).addClass('current').siblings().removeClass('current');
		}

		function _touchStart() {
			// TODO:
		}

		function _touchMove() {
			// TODO:
		}

		function _touchEnd() {
			// TODO:
		}

		function _showNav() {
			var $nav = root.$nav,
				navHeight = $nav.height(),
				left = _opt('controlNav') == 'behind' ? (containerWidth - midItemWidth) / 2 - navHeight + 20 : 20;
			$nav.show();
			$nav.first().css({
				left   : left,
				opacity: 0
			}).stop().animate({
				opacity: 1,
				left   : left - 20
			}, navDuration);
			$nav.last().css({
				right  : left,
				opacity: 0
			}).stop().animate({
				opacity: 1,
				right  : left - 20
			}, navDuration);
		}

		function _hideNav() {
			var $nav = root.$nav;
			$nav.first().stop().animate({
				opacity: 0,
				left   : '+=20'
			}, navDuration);
			$nav.last().stop().animate({
				opacity: 0,
				right  : '+=20'
			}, navDuration);
		}

		function _initNav() {
			var $nav = root.$el.find('.control-nav')
			root.$el.hover(function () {
				root.$el.addClass('hover');
				//_showNav();
			}, function () {
				root.$el.removeClass('hover');
				//_hideNav();
			});
			root.$nav = $nav;
		}

		function updateNav() {
			var navHeight = root.$nav.height(),
				css = {
					top      : (midItemWidth - _opt('itemPadding') * 2) / 2,
					marginTop: -navHeight / 2
				};
			if (_opt('controlNav') == 'behind') {

			}
			root.$nav.css(css);
		}

		function _getItemOffset(item) {
			if (item.hasClass('mid-item')) {
				return 0;
			}
			var itemIndex = root.$items.index(item),
				midIndex = root.$items.index(root.$items.filter('.mid-item')),
				offset = itemIndex - midIndex;
			return offset;
		}

		function _controlNav(e) {
			e.preventDefault();
			var nav = $(this).attr('href');
			switch (nav) {
				case 'prev':
					_prevItem();
					break;
				case 'next':
					_nextItem();
					break;
				default:
					var $item = $(e.target);
					if (!$item.is('li')) {
						$item = $item.closest('li');
					}
					_move(_getItemOffset($item));

			}
		}

		function _animateDone(dir, callback) {
			if (dir == 'prev') {
				root.$items.last().remove();
			} else {
				root.$items.first().remove();
			}
			_getItems();
			root.$items.eq(midElement).addClass('mid-item').siblings().removeClass('mid-item');
			if (_showContent) {
				root.$slideContent.children().eq(currentItem).stop().show().animate({opacity: 1}).siblings().hide();
			}
			scrolling = false;
			_restart();
			if (root.$el.hasClass('hover')) {
				//_showNav();
			}
			$.isFunction(callback) && callback.apply(root);
		}

		function _move(offset) {
			if (offset == 0) {
				_speed = '';
				_showContent = true;
				return;
			} else if (Math.abs(offset) == 1) {
				_showContent = true;
			} else {
				_showContent = false;
			}
			//_hideNav();
			_speed = 250;
			var dir = offset < 0 ? _prevItem : _nextItem;
			dir.call(this, function () {
				_move(offset < 0 ? offset + 1 : offset - 1);
			})
		}

		function _prevItem(callback) {
			if (scrolling) return;
			_pause();
			//_hideNav();
			scrolling = true;
			root.$slideContent.children().eq(currentItem).stop().animate({opacity: 0});
			currentItem--;
			if (currentItem < 0) {
				currentItem = maxItems - 1;
			}
			var itemPadding = _opt('itemPadding'),
				top = parseInt( ( midItemWidth - itemWidth ) / 2 ),
				start = 0,
				end = root.$items.length,
				count = 0,
				_done = function () {
					count++;
					if (count == end) {
						_animateDone('prev', callback);
					}
				};
			var $clone = root.$items.last().clone();
			$clone.insertBefore(root.$items.first()).css({
				left: parseInt(root.$items.first().css('left')) - itemWidth
			});
			_getItems();
			root.$el.find('.mid-item').removeClass('mid-item');
			root.$items.eq(activeElement + 1).addClass('mid-item');
			for (var i = start; i <= end; i++) {
				var animation = {
					left : midPosition - ( activeElement - i ) * itemWidth,
					width: itemWidth,
					top  : top
				}
				if (i < activeElement) {
					animation.left -= activeItemPadding;
				} else if (i == activeElement) {
					animation.left = midPosition;
					animation.top = 0;
					animation.width = midItemWidth
				} else if (i == activeElement + 1) {
					animation.left = midPosition + midItemWidth + activeItemPadding;
					animation.top = top;
					animation.width = itemWidth
				} else {
					animation.left += (midItemWidth - itemWidth) + activeItemPadding;
				}
				root.$items.eq(i).stop().show().animate(animation, _speed, _done);
			}
		}

		function _nextItem(callback) {
			if (scrolling) return;
			_pause();
			//_hideNav();
			scrolling = true;
			root.$slideContent.children().eq(currentItem).stop().animate({opacity: 0});
			currentItem++;
			if (currentItem >= maxItems) {
				currentItem = 0;
			}
			var itemPadding = _opt('itemPadding'),
				top = parseInt( ( midItemWidth - itemWidth ) / 2 ),
				start = 0,
				end = root.$items.length,
				count = 0,
				_done = function () {
					count++;
					if (count == end) {
						_animateDone('next', callback);
					}
				};
			var $clone = root.$items.first().clone();
			$clone.insertAfter(root.$items.last()).css({
				left: parseInt(root.$items.last().css('left')) + itemWidth
			});
			_getItems();
			root.$el.find('.mid-item').removeClass('mid-item');
			root.$items.eq(activeElement + 1).addClass('mid-item');
			for (var i = start; i <= end; i++) {
				var animation = {
					left : midPosition - ( activeElement - i ) * itemWidth,
					width: itemWidth,
					top  : top
				}
				if (i < activeElement) {
					animation.left -= itemWidth + activeItemPadding;
				} else if (i == activeElement) {
					animation.left -= itemWidth + activeItemPadding;
					animation.top = top;
					animation.width = itemWidth;
				} else if (i == activeElement + 1) {
					animation.left = midPosition;
					animation.top = 0;
					animation.width = midItemWidth;
				} else {
					animation.left = midPosition + midItemWidth + ( i - activeElement - 2 ) * itemWidth + activeItemPadding
				}
				root.$items.eq(i).stop().show().animate(animation, _speed, _done);
			}
		}

		function _getItems() {
			root.$items = root.$scrollable.children();
		}

		function _opt(key) {
			return root.options[key];
		}

		function _autoPlay() {
			playTimer && clearTimeout(playTimer);
			playTimer = setTimeout(function () {
				_autoPlay();
				_nextItem();
			}, _opt('pauseTime'))
		}

		function _pause() {
			playTimer && clearTimeout(playTimer);
		}

		function _restart() {
			if (_opt('autoPlay')) {
				_autoPlay();
			}
		}

		function calculate(args) {
			root.$scrollable.css("width", "");
			args = $.extend({
				itemPadding : _opt('itemPadding'),
				itemMaxWidth: _opt('itemMaxWidth'),
				itemsVisible: itemsVisible,
				itemMinWidth: _opt('itemMinWidth')
			}, args || {});
			containerWidth = root.$el.width();
			midItemWidth = parseInt( args.itemMaxWidth + 2 * args.itemPadding );
			itemWidth = parseInt( midItemWidth / ratio );
			viewPortWidth = itemWidth * ( args.itemsVisible - 1 ) + midItemWidth + 2 * activeItemPadding;

			if (viewPortWidth > containerWidth) {
				var mod = viewPortWidth - containerWidth,
					dx = mod / ( args.itemsVisible + ratio - 1 );
				if (midItemWidth - dx * ratio < args.itemMinWidth) {
					if (args.itemsVisible - 2 >= 1) {
						args.itemsVisible -= 2;
						calculate({
							itemsVisible: args.itemsVisible,
						});
						return;
					}
				} else {
					midItemWidth -= dx * ratio;
					itemWidth -= dx;
				}
				viewPortWidth = containerWidth;//???
			} else {
				root.$scrollable.width(viewPortWidth);
			}
			midPosition = parseInt( ( viewPortWidth - midItemWidth ) / 2 );
		}

		function _update() {
			calculate();
			updateNav();
			var itemPadding = _opt('itemPadding');
			root.$scrollable.height(midItemWidth);
			var left = 0,
				top = parseInt( ( midItemWidth - itemWidth ) / 2 ),
				start = 0,
				end = root.$items.length - 1;
			root.$items.hide();
			for (var i = start; i <= end; i++) {
				root.$items.eq(i).show();
				if (i == activeElement) {
					root.$items.eq(i)
						.css({
							left : parseInt( midPosition ),
							width: parseInt( midItemWidth ),
						})
						.addClass('mid-item')
						.find('.slide-content').css({
							margin: itemPadding
						});
				} else {
					left = midPosition - ( activeElement - i ) * itemWidth;
					if (i > activeElement) {
						left += ( midItemWidth - itemWidth ) + activeItemPadding;
					} else {
						left -= activeItemPadding;
					}
					root.$items.eq(i).css({
						width: parseInt( itemWidth ),
						left : parseInt( left ),
						top  : parseInt( top )
					}).removeClass('mid-item');
				}
			}
		}

		function update(force) {
			if (force) {
				_update();
			} else {
				updateTimer && clearTimeout(updateTimer);
				updateTimer = setTimeout(function () {
					_update();
				}, 350)
			}
		}

		function init() {
			parseItems();
			createHTML();
			$win.on('resize.thim-content-slider', function () {
				update();
			}).trigger('resize.thim-content-slider');
			_update();
		}

		// global function
		this.pause = _pause;
		this.restart = _restart;
		this.prev = _prevItem;
		this.next = _nextItem;
		this.update = _update;
		this.move = _move;

		init();
	}

	$.fn.thimContentSlider = function (opt) {
		var method = false,
			args = [];
		if (arguments.length > 0) {
			if (typeof arguments[0] == 'string') {
				method = arguments[0];
				for (var i = 1; i < arguments.length; i++) {
					args[i - 1] = arguments[i];
				}
			}
		}
		return $.each(this, function () {
			var $el = $(this),
				contentSlider = $el.data('thim-content-slider');
			if (!contentSlider) {
				contentSlider = new $.thimContentSlider(this, opt);
				$el.data('thim-content-slider', contentSlider);
			}
			if (method) {
				if ($.isFunction(contentSlider[method])) {
					return contentSlider[method].apply(contentSlider, args);
				}
				throw 'Method thimContentSlider.' + method + '() does not exists';
			} else {
				return $el;
			}
		});
	}

	$.fn.thimContentSlider.defaults = {
		items            : [
			{
				image: '', // thumb of user or product
				url  : '', // full image of user or product to display in the light-box
				html : '' // the content to display beside item
			}
		],
		itemMaxWidth     : 200,
		itemMinWidth     : 150,
		itemsVisible     : 7,
		itemPadding      : 10,
		activeItemRatio  : 2,
		activeItemPadding: 0,
		mouseWheel       : true,
		autoPlay         : true,
		pauseTime        : 3000,
		pauseOnHover     : true,
		imageSelector    : '',
		contentSelector  : '.content',
		controlNav       : 'behind'
	}
})(jQuery);