<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="title" content="<?php echo $site->name; ?>">
        <meta name="description" content="eclettico mentecatto, dal 1986 / eclectic fool, since 1986">
		<meta name="keywords" content="alessandro bellini, ilmente.it, ilmente, web, web design, visual designer, design, siti, sites, progettazione, organizational behavior, sistemi informativi, grafica, graphics, stampa, print, tipogrfia, typography, cms, content management system, wordpress, ghost, tumblr, php, cv, cv online, social, frontend, frontend developer, html, css, js, jquery">
		<meta name="author" content="Alessandro Bellini - ilmente">
		<meta name="generator" content="Plainbook CMS">
		<meta name="copyright" content="Copyright 2014">
		<meta name="robot" content="index,follow">

		<!--link type='text/css' rel='stylesheet' href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,700,300italic,700italic|Playfair+Display:400,700|Noto+Serif:400,700'-->
		<link type='text/css' rel="stylesheet" href="<?php echo $theme->url; ?>assets/css/normalize.css">
		<link type='text/css' rel="stylesheet" href="<?php echo $theme->url; ?>assets/css/style.css">
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="<?php echo $context->site->themeUri; ?>/assets/js/main.js"></script>
		
        <title><?php echo $data->current->meta->title; ?> | <?php echo $site->name; ?></title>
	</head>
    <body>
		<div id="container">
			<header>
				<div class="inner">
					<h1 class="title">ilmente</h1>
				
					<nav>
						<ul>
						<?php 
						foreach($data->all(array('deep' => 1, 'orderBy' => 'order')) as $page){ 
							echo '<li><a class="'.(($page->isCurrent || $page->isParent) ? 'current' : '').'" href="'.$page->url.'">'.$page->meta->title.'</a></li>';
						} 
						?>
						</ul>
					</nav>
					
					<div class="clearfix"></div>
				</div>
			</header>
			
			<div class="main">
				<div class="content inner">
					<?php echo $data->current->content; ?>
				</div>
			</div>
			
			<footer>
				<div class="content inner">
					happily made with <a>plainbook</a>
				</div>
			</footer>
		</div>



		<!-- Big G analytics -->
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

			ga('create', 'UA-11393697-1', 'ilmente.it');
			ga('send', 'pageview');
		</script>
	</body>
</html>