<?php
use Entity\Ad;
use Entity\AdValidator;

require __DIR__.'/../vendor/autoload.php';

$ad = new Ad();

$ad
    ->setCategoryId(1)
    ->setEmail('sshostak@olx.pl')
    ->setImages([
        ['href' => 'https://valid/link/test.png'],
        ['href' => 'http://valid/link/test2.png'],
    ])
    ->setPerson('sergii')
    ->setPhone('978757848')
    ->setTitle('Best validation library')
    ->setPrivateBusiness('private')
    ->setParams([
        'param_price' => [
            'type' => 'price',
            'from' => 10000,
            'to' => 1000,
            'currency' => 'USD'
        ],
    ]);

try {
    (new AdValidator())->validate($ad);
    echo  "Ad is Valid";
} catch (Respect\Validation\Exceptions\NestedValidationException $e) {
    echo $e->getFullMessage();
}
