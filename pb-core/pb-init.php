<?php 

include_once 'pb-config.php'; 

include_once 'pb-vendor/Parsedown.php'; 
include_once 'pb-vendor/ParsedownExtra.php'; 

include_once 'pb-lib/pb-base.php';
include_once 'pb-lib/pb-fs.php'; 
include_once 'pb-lib/pb-site.php';
include_once 'pb-lib/pb-infos.php'; 
include_once 'pb-lib/pb-context.php'; 
include_once 'pb-lib/pb-app.php';

$app = new PlainbookApp();
$app->run();

?>