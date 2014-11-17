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
	
	// pb: regular expressions
	'pb.regexp.visible_directories' => '/(\/[^.#]'.$config['pb.regexp.word'].')$/i',
	'pb.regexp.visible_files' => '/(\/[^._#]'.$config['pb.regexp.word'].'\\'.$config['pb.contents.extension'].')$/i',
	'pb.regexp.path' => '/\?.*/',
	'pb.regexp.uri' => '/((\/index\\'.$config['pb.contents.extension'].')$|(\\'.$config['pb.contents.extension'].')$)/i',
	'pb.regexp.meta.all' => '/^@'.$config['pb.regexp.word'].':.+/im',
	'pb.regexp.meta.key' => '/(^@|:.+)/',
	'pb.regexp.meta.value' => '/^@'.$config['pb.regexp.word'].':/i',
	'pb.regexp.meta.template' => '/^@'.preg_quote(trim($config['pb.keywords.template']), '/').':.+/im',
	'pb.regexp.meta.tags' => '/^@'.preg_quote(trim($config['pb.keywords.tags']), '/').':.+/im',
	
	// slim: templates
	'templates.path' => $config['pb.site.dir'].'pb-themes/'.$config['pb.theme.name'],
), $config);

$pb = new \Slim\Slim($config);

$pb->e500Unlooper = false;
$pb->setName($config['pb.site.name']);

$pb->container->singleton('load', function() use ($config){
	return new PlainbookLoader($config);
});

unset($config);

include_once 'pb-vendor/Parsedown.php'; 
include_once 'pb-vendor/ParsedownExtra.php'; 

include_once 'pb-lib/pb-base.php';
include_once 'pb-lib/pb-dummy.php';
include_once 'pb-lib/pb-fs.php'; 
include_once 'pb-lib/pb-site.php';
include_once 'pb-lib/pb-infos.php'; 
include_once 'pb-lib/pb-data.php'; 
include_once 'pb-lib/pb-theme.php'; 
include_once 'pb-lib/pb-loader.php';

include_once 'pb-router.php';

$pb->run();

?>