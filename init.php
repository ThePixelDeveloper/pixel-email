<?php defined('SYSPATH') or die('No direct script access.');

Route::set('email', 'emails')
	->defaults(array(
		'controller' => 'email',
		'action'     => 'list'
	));

Route::set('email-inbox', 'emails/<email>', array('email' => '[^/]+'))
	->defaults(array(
		'controller' => 'email',
		'action'     => 'inbox'
	));

Route::set('email-read', 'emails/<email>(/<id>(/<part>))', array('email' => '[^/]+', 'id' => '[0-9]++', 'part' => '[a-zA-Z]++'))
	->defaults(array(
		'controller' => 'email',
		'action'     => 'read'
	));