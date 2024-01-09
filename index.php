<?php

    require_once 'vendor/autoload.php';

    $db = new Database();

    $clothing = new Clothing(
        1,
        'T-shirt',
        ['tshirt.jpg'],
        15,
        'T-shirt en coton',
        10,
        new DateTime(),
        new DateTime(),
        1,
        'M',
        'Noir',
        "Homme",
        2
    );
    var_dump($clothing);
    
