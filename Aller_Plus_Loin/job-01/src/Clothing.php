<?php namespace App;
    use DateTime;
    use PDO;
    class Clothing extends AbstractProduct implements StockableInterface{
        
        public function __construct(
            ?int $id = null,
            ?string $name = null,
            ?array $photo = null,
            ?int $price = null,
            ?string $description = null,
            ?int $quantity = null,
            ?DateTime $created_at = null,
            ?DateTime $updated_at = null,
            ?int $id_category = null,
            private ?string $size = null,
            private ?string $color = null,
            private ?string $type = null,
            private ?int $material_fee = null
        ) {
            $this->id_category = 3;
            parent::__construct(
                $id,
                $name,
                $photo,
                $price,
                $description,
                $quantity,
                $created_at,
                $updated_at,
                $id_category
            );
        }

        public function getSize(): string {
            return $this->size;
        }
        public function getColor(): string {
            return $this->color;
        }
        public function getType(): string {
            return $this->type;
        }
        public function getMaterialFee(): int {
            return $this->material_fee;
        }
        public function findAll(): array {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM clothing
                INNER JOIN product ON clothing.product_id = product.id");
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
                    new DateTime($product['created_at']),
                    new DateTime($product['updated_at']),
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
        public function findOneById(int $id): Clothing {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM clothing
                INNER JOIN product ON clothing.product_id = product.id
                WHERE clothing.product_id = :id");
            $req->bindParam(':id', $id);
            if($req->execute()) {
                $product = $req->fetch(PDO::FETCH_ASSOC);
                return new Clothing(
                    $product['id'],
                    $product['name'],
                    json_decode($product['photo']),
                    $product['price'],
                    $product['description'],
                    $product['quantity'],
                    new DateTime($product['created_at']),
                    new DateTime($product['updated_at']),
                    $product['category_id'],
                    $product['size'],
                    $product['color'],
                    $product['type'],
                    $product['material_fee']
                );
            }
            return false;
        }
        public function create(): Clothing {
            parent::create();
            $db = new Database();
            $req = $db->bdd->prepare("INSERT INTO clothing (size, color, type, material_fee, product_id)
                VALUES (:size, :color, :type, :material_fee, :product_id)");
            $req->bindParam(':size', $this->size);
            $req->bindParam(':color', $this->color);
            $req->bindParam(':type', $this->type);
            $req->bindParam(':material_fee', $this->material_fee);
            $req->bindParam(':product_id', $this->id);
            if($req->execute()) {
                return $this;
            }
            return false;
        }
        public function update(): Clothing {
            parent::update();
            $db = new Database();
            $req = $db->bdd->prepare("UPDATE clothing SET size = :size, color = :color, type = :type, material_fee = :material_fee
                WHERE product_id = :product_id");
            $req->bindParam(':size', $this->size);
            $req->bindParam(':color', $this->color);
            $req->bindParam(':type', $this->type);
            $req->bindParam(':material_fee', $this->material_fee);
            $req->bindParam(':product_id', $this->id);
            if($req->execute()) {
                return $this;
            }
            return false;
        }

        public function addStock(int $quantity): void {
            $this->quantity += $quantity;
        }
        public function removeStock(int $quantity): void {
            $this->quantity -= $quantity;
        }
    }