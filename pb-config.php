<?php

define('PB_SITE_NAME', 'Plainbook');

define('PB_BASE_URL', 'http://localhost/dev/Plainbook'); // must not ends with '/'
define('PB_BASE_DIR', realpath(dirname(__FILE__)).'/');

define('PB_CONTENT_DIR', PB_BASE_DIR.'pb-content/');
define('PB_CONTENT_EXCERPT_LENGTH', 30);
define('PB_CONTENT_META_TEMPLATE', 'template');
define('PB_CONTENT_EXT', '.md');


date_default_timezone_set('Europe/Rome');
	
?>