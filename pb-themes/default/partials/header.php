<?php $settings = $data->get('#settings'); ?>

<!DOCTYPE html>
<html lang="en">
    <head>
		<meta charset="UTF-8">
		<meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width, height=device-height">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="title" content="<?php echo $site->name; ?>">
        <meta name="description" content="<?php echo $settings->meta->description; ?>">
		<meta name="keywords" content="<?php echo $settings->meta->keywords; ?>">
		<meta name="author" content="Alessandro Bellini - ilmente">
		<meta name="generator" content="Plainbook CMS">
		<meta name="robot" content="index,follow">

		<link type='text/css' rel='stylesheet' href='//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,300italic,600italic|Lobster'>
		<link type='text/css' rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.3/styles/docco.min.css">
		<link type='text/css' rel="stylesheet" href="<?php echo $theme->url; ?>assets/css/normalize.css">
		<link type='text/css' rel="stylesheet" href="<?php echo $theme->url; ?>assets/css/style.css">
		
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/8.3/highlight.min.js"></script>
		<script src="<?php echo $theme->url; ?>assets/js/cmh.js"></script>
		<script src="<?php echo $theme->url; ?>assets/js/main.js"></script>
		<script>pb.baseUrl = '<?php echo $site->url; ?>';</script>
		
        <title><?php echo $data->current->meta->title; ?> | <?php echo $site->name; ?></title>
	</head>
    <body>
		<nav>
			<ul>
			<?php foreach($data->all(array('deep' => 1, 'orderBy' => 'order')) as $page){ 
				echo '<li><a class="navigation '.(($page->isCurrent || $page->isParent) ? 'current' : '').'" href="'.$page->url.'">'.$page->meta->title.'</a></li>';
			} ?>
			</ul>
		</nav>
		
		<div id="container">
			<header>
				<a id="menu" href="#nav"></a>
				
				<div class="inner">
					<h1 class="title"><a href="<?php echo $site->url; ?>"><?php echo $settings->meta->name; ?></a></h1>
					<div class="clearfix"></div>
				</div>
			</header>
			
			