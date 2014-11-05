var pb = {
	hasStorage: !!window.localStorage,
	
	initialize: function(){
		hljs.initHighlightingOnLoad();
		pb.bindEvents();
	},
	
	bindEvents: function(hasStorage){
		$(document).ready(function(){
			pb.router();
			
			$(window).on('hashchange', pb.router);
		});
	},
	
	router: function(){
		var hash = window.location.hash;
		pb.changeColor();
		
		if (hash == '#/nav'){
			$('body').addClass('open-nav');
			$('#menu').attr('href', '#/');
		} else {
			$('body').removeClass('open-nav');
			$('#menu').attr('href', '#/nav');
		}
	},
	
	changeColor: function(){
		if (pb.hasStorage){
			var prevIndex = window.localStorage.colorIndex || 1;
			$('body').attr('color', prevIndex);
	
			setTimeout(function(){
				var nextIndex = Math.round((1 + Math.random() * 10) / 2);
				if (prevIndex == nextIndex) nextIndex += (nextIndex == 5) ? -1 : 1;
				window.localStorage.colorIndex = nextIndex;
				$('body').attr('color', nextIndex);
			}, 200);
		}
	}
};

pb.initialize();

