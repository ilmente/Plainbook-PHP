<?php

$pb->get('/404/', function() use ($pb){
	$fileNotFound = function($path){
		echo '404: file not found';
	};
	
	$pb->loader->load('_404', $fileNotFound, 404);
	$pb->stop();
});

$pb->get('/500/', function() use ($pb){
	$fileNotFound = function($path){
		$pb->halt(500, '500: server error');
	};
	
	$pb->loader->load('_500', $fileNotFound, 500);
	$pb->e500Unlooper = false;
	$pb->stop();
});

/*
$pb->get('/'.$pb->config('pb.keywords.tags').'/(:tag)', function($tag = '') use ($pb){
	echo 'tag page: #'.$tag;
});

$pb->get('/(:path+)'.$pb->config('pb.keywords.pagination').'/:page', function($path = array(), $page) use ($pb){
	$fileNotFound = function($path) use ($pb){
		$pb->redirect($pb->config('pb.site.url').'/404/', 404);
	};
	
	$pathLastIndex = count($path) - 1;
	if ($pathLastIndex >= 0 && $path[$pathLastIndex] == '') unset($path[$pathLastIndex]);

	$path = str_replace('#', '', implode('/', $path));
	$pb->load->pagination($path, $page, $fileNotFound);
});
*/

$pb->get('/(:path+)', function($path = array()) use ($pb){
	$fileNotFound = function($path) use ($pb){
		$pb->redirect($pb->config('pb.site.url').'/404/', 404);
	};
	
	$pathLastIndex = count($path) - 1;
	if ($pathLastIndex >= 0 && $path[$pathLastIndex] == '') unset($path[$pathLastIndex]);

	$path = str_replace('#', '', implode('/', $path));
	$pb->load->single($path, $fileNotFound);
});

$pb->notFound(function() use ($pb){
	$pb->redirect($pb->config('pb.site.url').'/404/', 404);
});

$pb->error(function(Exception $e) use ($pb){
	if ($pb->e500Unlooper){
		$pb->halt(500, '500: server error (loop)');
	} else {
		$pb->e500Unlooper = true;
		$pb->redirect($pb->config('pb.site.url').'/500/', 500);
	}
});

?>