(function(){
	$(document).ready(function(){
		$('a.open-nav').on('click', function(){
			$('body').toggleClass('open-nav');
			return false;
		});

		$('html').on('click', '.open-nav #main', function(){
			$('body').removeClass('open-nav');
			return false;
		});
	});
})();
