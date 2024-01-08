<?php
    include_once './class/Database.php';
    include_once './class/Product.php';
    include_once './class/Category.php';

    $db = new Database();

    $req = $db->bdd->prepare("SELECT * FROM product WHERE id = 7");
    $req->execute();
    $product = $req->fetch(PDO::FETCH_ASSOC);

    $product2 = new Product(
        $product['id'],
        $product['name'],
        json_decode($product['photo']),
        $product['price'],
        $product['description'],
        $product['quantity'],
        $product['created_at'],
        $product['updated_at'],
        $product['category_id']
    );

    $category = $product2->getCategory();
    $products = $category->getProducts();
    var_dump($products);
