<?php

    require_once 'vendor/autoload.php';

    $clothing = new App\Clothing();
    $clothing = $clothing->findOneById(17);
    
    var_dump($clothing);

    $clothing->setName('T-shirt noir');
    $clothing->setPrice(40);

    $clothing->update();

    var_dump($clothing);
    
