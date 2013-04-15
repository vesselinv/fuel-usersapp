<?php
/**
 * The development database settings. These get merged with the global settings.
 */

return array(
	'default' => array(
		'type'           => 'pdo',
			'connection'     => array(
				'dsn'            => 'mysql:host=localhost;dbname=usersapp',
				'username'       => 'fuel_user',
				'password'       => 'nottooshabby',
				'persistent'     => false,
				'compress'       => true,
			),
		'identifier'     => '`',
		'table_prefix'   => '',
		'charset'        => 'utf8',
		'enable_cache'   => true,
		'profiling'      => false,
	),
);
