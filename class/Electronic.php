<?php
    class Electronic extends Product {
        
        private string $brand;
        private int $warranty_fee;

        public function __construct(
            int $id = 1,
            string $name = "",
            array $photo = [],
            int $price = 0,
            string $description = "",
            int $quantity = 0,
            string $created_at = "",
            string $updated_at = "",
            int $id_category = 1,
            string $brand = "",
            int $warranty_fee = 0
        ) {
            parent::__construct(
                $id, $name, $photo, $price, $description, $quantity, $created_at, $updated_at, $id_category
            );
            $this->brand = $brand;
            $this->warranty_fee = $warranty_fee;
        }

        public function getBrand(): string {
            return $this->brand;
        }
        public function getWarrantyFee(): int {
            return $this->warranty_fee;
        }

        public function findAll(): array
        {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM product WHERE category_id = 1");
            $req->execute();
            $products = $req->fetchAll(PDO::FETCH_ASSOC);
            $electronics = [];
            foreach ($products as $product) {
                $electronic = new Electronic(
                    $product['id'],
                    $product['name'],
                    json_decode($product['photo']),
                    $product['price'],
                    $product['description'],
                    $product['quantity'],
                    $product['created_at'],
                    $product['updated_at'],
                    $product['category_id'],
                    $product['brand'],
                    $product['warranty_fee']
                );
                array_push($electronics, $electronic);
            }
            return $electronics;
        }
    }