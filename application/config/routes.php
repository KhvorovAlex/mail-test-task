<?php

return [
	// MainController
	'' => [
		'controller' => 'main',
		'action' => 'index',
	],

	// AccountController
	'account/login' => [
		'controller' => 'account',
		'action' => 'login',
	],
	'account/register' => [
		'controller' => 'account',
		'action' => 'register',
	],
	'account/profile' => [
		'controller' => 'account',
		'action' => 'profile',
	],
	'account/messages' => [
		'controller' => 'account',
		'action' => 'messages',
	],
	'account/message/{id:\d+}' => [
		'controller' => 'account',
		'action' => 'message',
	],
	'account/logout' => [
		'controller' => 'account',
		'action' => 'logout',
	],

	// AdminController
	'admin/login' => [
		'controller' => 'admin',
		'action' => 'login',
	],
	'admin/logout' => [
		'controller' => 'admin',
		'action' => 'logout',
	],
	'admin/add' => [
		'controller' => 'admin',
		'action' => 'add',
	],

];