<?php

$pb->get('/404/', function() use ($pb){
	$fileNotFound = function($e){
		echo '404: file not found';
	};
	
	$pb->loader->load('_404', $fileNotFound, 404);
	$pb->stop();
});

$pb->get('/500/', function() use ($pb){
	$fileNotFound = function($e){
		echo '500: server error';
	};
	
	$pb->loader->load('_500', $fileNotFound, 500);
	$pb->stop();
});

$pb->get('/(:path(/))', function($path = '') use ($pb, $config){
	$fileNotFound = function($path) use ($pb, $config){
		$pb->redirect($config['pb.site.url'].'/404/');
	};

	$path = str_replace('#', '', $path);
	$pb->loader->load($path, $fileNotFound);
});

$pb->notFound(function() use ($pb, $config){
	$pb->redirect($config['pb.site.url'].'/404/', 404);
});

?>