<?php

    include_once './class/Product.php';
    include_once './class/Category.php';

    $product = new Product();
    $product = $product->findOneById(7);

    $category =  $product->getCategory();