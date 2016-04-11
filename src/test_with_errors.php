<?php

$loader = require __DIR__.'/../vendor/autoload.php';

$container = require 'bootstrap.php';

$ad = new \Entity\Ad();

$ad
    ->setCategoryId(10)
    ->setEmail('invalid@email')
    ->setImages([
        ['href' => 'http:invalid/link'],
        ['href' => 'http://valid/link/test.png'],
        []
    ])
    ->setPerson('d')
    ->setPhone('llloooooooooonnnnnnnnnnggggg')
    ->setTitle('inv')
    ->setPrivateBusiness('test')
    ->setParams([
        'param_price' => [
            'type' => 'iv_price',
            'to' => 'error',
            'currency' => 'FAIL'
        ],
        'not_supported' => [
            'type' => 'price',
            'from' => 100,
            'to' => 1000,
            'currency' => 'UZS'
        ],
    ]);

$validator  = $container->get('validator.builder')->getValidator();
$violations = $validator->validate($ad, null, ['Default', 'UnauthorizedUser']);

echo '>>>>>>>>>>> Testing general errors.' . PHP_EOL;

if (count($violations) > 0) {
    foreach ($violations as $violation) {
        echo $violation->getPropertyPath() . ' => ' .  $violation->getMessage() . PHP_EOL;
    }
} else {
    echo 'Ups!! This should not appear!' . PHP_EOL;
}

echo '>>>>>>>>>>> Testing group errors.' . PHP_EOL;

$violations = $validator->validate($ad, null, ['Default', 'AuthorizedUser']);

if (count($violations) > 0) {
    foreach ($violations as $violation) {
        echo $violation->getPropertyPath() . ' => ' .  $violation->getMessage() . PHP_EOL;
    }
} else {
    echo 'Ups!! This should not appear!' . PHP_EOL;
}