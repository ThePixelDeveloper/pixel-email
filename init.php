<?php defined('SYSPATH') or die('No direct script access.');

Route::set('email', 'email')
	->defaults(array(
		'controller' => 'email',
		'action'     => 'list'
	));

Route::set('email-inbox', 'email/<email>', array('email' => '[^/]+'))
	->defaults(array(
		'controller' => 'email',
		'action'     => 'inbox'
	));

Route::set('email-read', 'email/<email>(/<id>(/<part>))', array('email' => '[^/]+', 'id' => '[0-9]++', 'part' => '[a-zA-Z]++'))
	->defaults(array(
		'controller' => 'email',
		'action'     => 'read'
	));