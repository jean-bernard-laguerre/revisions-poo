<?php
    include_once './class/Database.php';
    include_once './class/Product.php';
    include_once './class/Category.php';

    $newProduct = new Product(
        1,
        'Poisson',
        ['photo1', 'photo2'],
        10,
        'Un poisson',
        5,
    );
    var_dump($newProduct);
    $newProduct->save();

    $newCategory = new Category(
        1,
        'Poisson',
        'Un poisson',
    );
    var_dump($newCategory);
    $newCategory->save();
