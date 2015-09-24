<?php

return array(
    'name' => 'Умный поиск',
    'description' => 'Автодополнение при поиске товаров в строке поиска',
    'vendor' => '985310',
    'version' => '1.0.2',
    'img' => 'img/smartsearch.png',
    'shop_settings' => true,
    'frontend' => true,
    'handlers' => array(
        'frontend_head' => 'frontendHead',
    ),
);
//EOF
