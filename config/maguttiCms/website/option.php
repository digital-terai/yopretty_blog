<?php
return [


    'app' => [
        'name'	   => 'MaguttiCms',
		'legal'		=> 'MaguttiCms Framework',
        'address'  => '5.3 maguttiCms Street',
        'locality' => 'Bergamo - Italy',
        'lat'      => '45.612310',
        'lng'      => '9.694187',
        'phone'	   => '+39 0363.123456',
        'fax'	   => '+39 035.123456',
        'vat'	   => 'XXXXXXXXX',
        'email'	   => 'hello@magutti.com',

    ],
    'email' => [
        'default'	   => 'hello@magutti.com',
        'footer'       => '© Copyright  GFStudio',
    ],

    'news' => [
        'item_home'	  => '3',
    ],

    'images' => [
        'gallery'	  => '1',
        'slider'	  => '2',
        'bottom'	  => '3',
    ],

	// FontAwesome or MaterialIcons
	'icons' => 'fa',
	// 'icons' => 'mi',

	'js_localization' => ['website','message'],

	'ghost_input' => [
		'models' => [
			'CartItem'
		]
	]
];
