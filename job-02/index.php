<?php
    include_once './classes/Product.php';
    include_once './classes/Category.php';

    $product = new Product(
        1,
        'T-shirt',
        ['https://ptcsum.photos/20@/30@'],
        1000,
        'A beautiful T-shirt',
        10,
        new DateTime(),
        new DateTime(),
        1
    );