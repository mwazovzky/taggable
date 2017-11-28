<?php

try {
    $myFile = json_decode(file_get_contents('composer.json'), true);

    $myFile['autoload']['psr-4']["MWazovzky\\Taggable\\"] = 'vendor/MWazovzky/Taggable/src/';

    file_put_contents('composer.json', json_encode($myFile, JSON_PRETTY_PRINT));
} catch (Exception $e) {
    echo 'Failed to modify composer.json. Error message: ' . $e->getMessage();
}

echo 'composer.json autoload sections has neen updated.';
