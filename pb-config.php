<?php

// pb: site name
$config['pb.site.name'] = 'Plainbook';
$config['pb.site.url'] = 'http://localhost/dev/Plainbook';
$config['pb.site.dir'] = realpath(dirname(__FILE__)).'/';

// pb: theme
$config['pb.theme.name'] = 'default';

// pb: contents
$config['pb.contents.orderBy'] = '';
$config['pb.contents.orderAsc'] = true;
$config['pb.contents.excerpt_length'] = 30;
$config['pb.contents.extension'] = '.md';

// pb: keywords
$config['pb.keywords.template'] = 'template';
$config['pb.keywords.tags'] = 'tags';
$config['pb.keywords.pagination'] = 'pp';

// pb: regex base word
$config['pb.regexp.word'] = '(\w*-*\w+)+-*';

// slim config
$config['mode'] = 'development';
$config['debug'] = true;
$config['log.enabled'] = true;

// timezone
date_default_timezone_set('Europe/Rome');
	
?>