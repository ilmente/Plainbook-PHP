/*
 *
 * CSS Motions Handler
 * jQuery plugin by Alessandro Bellini - ilmente
 *
 */

(function(window, $){
	$.fn.extend({
		addClass: (function($addClass){
			return function(className, options){
				$addClass.call(this, className || '');
				this._cssMotionHandlers(options);
			};
		})($.fn.addClass),
		
		removeClass: (function($removeClass){
			return function(className, options){
				$removeClass.call(this, className || '');
				this._cssMotionHandlers(options);
			};
		})($.fn.removeClass),
		
		_cssMotionHandlers: function(options){
			if (!!options){
				if (!!options.onTransitionEnd) this.one('transitionend webkitTransitionEnd oTransitionEnd', options.onTransitionEnd);
				if (!!options.onAnimationEnd) this.one('animationend webkitAnimationEnd oAnimationEnd', onAnimationEnd);
			}
		}
	});
})(window, jQuery);