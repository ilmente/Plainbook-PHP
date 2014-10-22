<?php

// pb: site name
$config['pb.site.name'] = 'Plainbook';
$config['pb.site.url'] = 'http://localhost/dev/Plainbook';
$config['pb.site.dir'] = realpath(dirname(__FILE__)).'/';

// pb: theme
$config['pb.theme.name'] = 'default';

// pb: contents settings
$config['pb.contents.excerpt_lenght'] = 30;
$config['pb.contents.extension'] = '.md';

// pb: keywords
$config['pb.keywords.template'] = 'template';

// slim config
$config['mode'] = 'development';

// timezone
date_default_timezone_set('Europe/Rome');
	
?>