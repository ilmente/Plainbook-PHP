var pb = {
	hasStorage: !!window.localStorage,
	currentIndex: false,
	
	initialize: function(){
		if (!!window.hljs) hljs.initHighlightingOnLoad();
		
		$(document).ready(function(){
			pb.changeColor();
			
			$('#menu').on('click', function(){
				$('body').toggleClass('open-nav');
				return false;
			});
			
			$('html').on('click', '.open-nav #container', function(){
				$('body').removeClass('open-nav');
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
			
			$('.contents a').stop(true, true).on('mouseover', pb.changeColor);
		});
	},
	
	changeColor: function(){
		var changeColor = function(){
			var nextIndex = Math.round((1 + Math.random() * 10) / 2);
			pb.currentIndex = (pb.currentIndex == nextIndex) ? (nextIndex += (nextIndex == 5) ? -1 : 1) : nextIndex;
			$('body').attr('color', pb.currentIndex);
			
			if (pb.hasStorage) window.localStorage.colorIndex = pb.currentIndex;
		};
		
		if (pb.currentIndex || !pb.hasStorage){
			changeColor();
		} else {
			pb.currentIndex = window.localStorage.colorIndex || 1;
			$('body').attr('color', pb.currentIndex);
			
			setTimeout(changeColor, 50);
		}
	}
};

pb.initialize();

