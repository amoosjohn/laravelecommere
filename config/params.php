<?php
//$logo =  public_path() . '/front/images/logo1 (2).png'; 
$logo = 'https://duschewen.com/img/laravel_logo.png';
return [
    'site_name' => 'Vital Mart',
    'PDF_HEADER_LOGO' =>$logo ,
    'commission' => '15',
    'currencies' => [
        'PKR' => ['symbol' => 'Rs', 'name' => 'Pakistani rupee'],
        'EUR' => ['symbol' => '‎€', 'name' => 'Euro'],
    ],
    'currency_default' => 'PKR',
    'languages' => [
        'en_uk' => 'English (UK)',
        'en_us' => 'English (US)',
    ],
    'best_image_size' => '390 x 300 pixels',
    'language_default' => 'en_uk',
    'contentTypes' => [
        'page' => 'Page',
        'email' => 'Email',
        'block' => 'Block',
    ],
    'order_prefix' => "vitalmart",
    'titles' => [
        'Mr.' => 'Mr.',
        'Ms.' => 'Ms.',
        'Mrs.' => 'Mrs.',
        'Dr.' => 'Dr.',
    ],
    'imageMimes' => [
        'image/jpeg', 'image/jpg', 'image/png', 'image/JPG', 'image/bmp', 'image/PNG'
    ],
    'noreply_email'=>'noreply@vitalmart.pk',
    'admin_email'=>'admin@vitalmart.pk',
    'server_email'=>'amoos.golpik@gmail.com'
];
