<?php

$loader = require __DIR__.'/../vendor/autoload.php';

$container = require 'bootstrap.php';

$ad = new \Entity\Ad();

$ad
    ->setCategoryId(1)
    ->setEmail('sshostak@olx.pl')
    ->setImages([
        ['href' => 'http://valid/link/test.png'],
        ['href' => 'http://valid/link/test2.png'],
    ])
    ->setPerson('sergii')
    ->setPhone('978757848')
    ->setTitle('Best validation library')
    ->setPrivateBusiness('private')
    ->setParams([
        'param_price' => [
            'type' => 'price',
            'from' => 10,
            'to' => 1000,
            'currency' => 'USD'
        ],
    ]);

$validator  = $container->get('validator.builder')->getValidator();
$violations = $validator->validate($ad);

if (count($violations) > 0) {
    echo 'Ups!! This should not appear!' . PHP_EOL;
} else {
    echo 'Everything works ok.' . PHP_EOL;
}