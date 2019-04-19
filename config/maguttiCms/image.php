<?php

return [
	'size_limit' => 4096,
	'image_matte' => '#ffffff',
	'defaults' => [
		'w' => 640,
		'h' => 480,
		'c' => 'cover',
		'p' => 'center',
		'format' => 'jpg',
		'q' => '70',
		'e' => 1,
		'a' => 0,
		'filter' => []
	],
	'thumbnail' => [
		'w' => 300,
		'h' => 200,
		'c' => 'cover',
		'format' => 'jpg',
		'q' => '50',
		'e' => 1
	],
	'small' => [
		'w' => 64,
        'h' => 48,
		'format' => 'jpg',
		'q' => '60',
		'e' => 1
	],
	'medium' => [
		'w' => 1024,
		'format' => 'jpg',
		'q' => '60',
		'e' => 1
	],
	'large' => [
		'w' => 1920,
		'format' => 'jpg',
		'q' => '60',
		'e' => 1
	],
    'social' => [
        'w' => 1200,
        'h' => 630,
        'format' => 'jpg',
        'q' => '85',
        'e' => 0
    ],
	'admin' => [
		'w' => 100,
		'h' => 100,
		'q' => 50,
		'e' => 0
	]
];
