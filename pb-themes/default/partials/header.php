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

		<link type='text/css' rel="stylesheet" href='http://fonts.googleapis.com/css?family=Abril+Fatface'>
		<link type='text/css' rel="stylesheet" href="<?php echo $theme->url; ?>assets/css/normalize.css">
		<link type='text/css' rel="stylesheet" href="<?php echo $theme->url; ?>assets/css/style.css">
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="<?php echo $context->site->themeUri; ?>/assets/js/main.js"></script>
		
        <title><?php echo $data->current->meta->title; ?> | <?php echo $site->name; ?></title>
	</head>
    <body>
		<div id="container">
			<nav>
				<?php 
				foreach($data->query(array('root' => '/', 'deep' => 1, 'orderBy' => 'order')) as $page){ 
					echo '<a class="'.($page->isCurrent ? 'current' : '').'" href="'.$page->url.'">'.$page->meta->title.'</a>';
				} 
				?>
			</nav>
			<a class="open-nav" href="#open-nav">#</a>