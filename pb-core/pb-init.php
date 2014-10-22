<?php 

include_once 'pb-vendor/Slim/Slim.php';
\Slim\Slim::registerAutoloader();

$config = array();

include_once 'pb-config.php'; 

$config = array_merge(array(
	// pb: theme
	'pb.theme.url' => $config['pb.site.url'].'/pb-themes/'.$config['pb.theme.name'].'/',
	'pb.theme.dir' => $config['pb.site.dir'].'pb-themes/'.$config['pb.theme.name'].'/',
	
	// pb: contents dir
	'pb.contents.dir' => $config['pb.site.dir'].'pb-contents/',
	
	// slim: templates
	'templates.path' => $config['pb.site.dir'].'pb-themes/'.$config['pb.theme.name'],
	
    // slim: debugging
    'debug' => true,

    // slim: logging
    'log.enabled' => true
), $config);

$pb = new \Slim\Slim($config);
$pb->setName($config['pb.site.name']);

$pb->container->singleton('loader', function() use ($config){
	return new PlainbookLoader($config);
});

include_once 'pb-vendor/Parsedown.php'; 
include_once 'pb-vendor/ParsedownExtra.php'; 

include_once 'pb-lib/pb-base.php';
include_once 'pb-lib/pb-fs.php'; 
include_once 'pb-lib/pb-site.php';
include_once 'pb-lib/pb-infos.php'; 
include_once 'pb-lib/pb-data.php'; 
include_once 'pb-lib/pb-theme.php'; 
include_once 'pb-lib/pb-loader.php';

include_once 'pb-router.php';

$pb->run();

?>