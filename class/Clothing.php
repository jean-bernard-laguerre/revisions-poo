<?php
    class Clothing extends Product {
        private string $size;
        private string $color;
        private string $type;
        private int $material_fee;

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
            string $size = "",
            string $color = "",
            string $type = "",
            int $material_fee = 0
        ) {
            parent::__construct(
                $id, $name, $photo, $price, $description, $quantity, $created_at, $updated_at, $id_category
            );
            $this->size = $size;
            $this->color = $color;
            $this->type = $type;
            $this->material_fee = $material_fee;
        }

        public function getSize(): string {
            return $this->size;
        }
        public function getColor(): string {
            return $this->color;
        }
        public function findAll(): array
        {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM product WHERE category_id = 2");
            $req->execute();
            $products = $req->fetchAll(PDO::FETCH_ASSOC);
            $clothings = [];
            foreach ($products as $product) {
                $clothing = new Clothing(
                    $product['id'],
                    $product['name'],
                    json_decode($product['photo']),
                    $product['price'],
                    $product['description'],
                    $product['quantity'],
                    $product['created_at'],
                    $product['updated_at'],
                    $product['category_id'],
                    $product['size'],
                    $product['color'],
                    $product['type'],
                    $product['material_fee']
                );
                array_push($clothings, $clothing);
            }
            return $clothings;
        }
    }