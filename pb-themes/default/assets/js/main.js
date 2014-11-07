var pb = {
	storage: window.localStorage,
	hasStorage: !!window.localStorage,
	currentIndex: false,
	
	initialize: function(){
		if (!!window.hljs) hljs.initHighlightingOnLoad();
		
		$(document).ready(function(){	
			pb.changeColor();
			
			$('#menu').on('click', function(){
				if ($('body').hasClass('open-nav')) $('body').removeClass('open-nav', pb.changeColorCallback);
				else $('body').addClass('open-nav', pb.changeColorCallback);
				return false;
			});
			
			$('html').on('click', '.open-nav #container', function(){
				$('body').removeClass('open-nav', pb.changeColorCallback);
				return false;
			});
			
			$('html').on('click', '.open-nav .navigation', function(){
				var href = $(this).attr('href');
				
				$('body').removeClass('open-nav', {
					onTransitionEnd: function(){
						window.location.href = href;
					}
				});
				
				return false;
			});
			
			$('.contents a').stop(true, true).on('mouseenter', pb.changeColor);
		});
	},
	
	changeColor: function(){
		var changeColor = function(){
			var nextIndex = Math.round((1 + Math.random() * 10) / 2);
			pb.currentIndex = (pb.currentIndex == nextIndex) ? (nextIndex += (nextIndex == 5) ? -1 : 1) : nextIndex;
			$('body').addClass('color');
			$('body').attr('color', pb.currentIndex);
			
			if (pb.hasStorage) pb.storage.pbColorIndex = pb.currentIndex;
		};
		
		if (pb.currentIndex || !pb.hasStorage){
			changeColor();
		} else {
			pb.currentIndex = pb.storage.pbColorIndex || 1;
			$('body').attr('color', pb.currentIndex);
			
			if (!!pb.storage.pbColorIndex) setTimeout(changeColor, 50);
			else pb.storage.pbColorIndex = pb.currentIndex;
		}
	},
	
	changeColorCallback: {
		onTransitionEnd: function(){
			pb.changeColor();
		}
	}
};

pb.initialize();

