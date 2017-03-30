<?php
require __DIR__  . '/vendor/autoload.php';

$accessToken = file_get_contents(__DIR__ . '/access_token');

$gateway = new Braintree_Gateway(array(
    'accessToken' => $accessToken,
));