<?php

    require_once 'vendor/autoload.php';

    $clothing = new App\Clothing(
        null,
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
    
