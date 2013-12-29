<?php

return array(
    'name' => 'Умный поиск',
    'description' => 'Список последних добавленных продуктов',
    'vendor' => '985310',
    'version' => '1.0.0',
    'img' => 'img/novelties.png',
    'shop_settings' => true,
    'frontend' => true,
    'handlers' => array(
        'frontend_nav' => 'frontendNav',
        'frontend_category' => 'frontendCategory',
        'frontend_head' => 'frontendHead',
    ),
);
//EOF
