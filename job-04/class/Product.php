<?php
    class Product {

        public function __construct(
            protected ?int $id = null,
            protected ?string $name = null,
            protected ?array $photo = null,
            protected ?int $price = null,
            protected ?string $description = null,
            protected ?int $quantity = null,
            protected ?DateTime $created_at = null,
            protected ?DateTime $updated_at = null,
            protected ?int $id_category = null
        ) {
  
        }

        public function getId(): int {
            return $this->id;
        }
        public function getName(): string {
            return $this->name;
        }
        public function getPhoto(): array {
            return $this->photo;
        }
        public function getPrice(): int {
            return $this->price;
        }
        public function getDescription(): string {
            return $this->description;
        }
        public function getQuantity(): int {
            return $this->quantity;
        }
        public function getCreatedAt(): DateTime {
            return $this->created_at;
        }
        public function getUpdatedAt(): DateTime {
            return $this->updated_at;
        }
        public function getIdCategory(): int {
            return $this->id_category;
        }

        public function setName(string $name): void {
            $this->name = $name;
        }
        public function setPhoto(array $photo): void {
            $this->photo = $photo;
        }
        public function setPrice(int $price): void {
            $this->price = $price;
        }
        public function setDescription(string $description): void {
            $this->description = $description;
        }
        public function setQuantity(int $quantity): void {
            $this->quantity = $quantity;
        }
        public function setUpdatedAt(DateTime $updated_at): void {
            $this->updated_at = $updated_at;
        }
        public function setCreatedAt(DateTime $created_at): void {
            $this->created_at = $created_at;
        }
        public function setIdCategory(int $id_category): void {
            $this->id_category = $id_category;
        }

        public function create(): Product {
            $db = new Database();
            $req = $db->bdd->prepare("INSERT INTO product (name, price, description, photo, quantity, created_at, updated_at, category_id)
                                    VALUES (:name, :price, :description, :photo, :quantity, :created_at, :updated_at, :id_category)");
            $req->bindParam(':name', $this->name);
            $req->bindParam(':price', $this->price);
            $req->bindParam(':description', $this->description);
            $req->bindValue(':photo', json_encode($this->photo));
            $req->bindParam(':quantity', $this->quantity);
            $req->bindValue(':created_at', $this->created_at->format('Y-m-d H:i:s'));
            $req->bindValue(':updated_at', $this->updated_at->format('Y-m-d H:i:s'));
            $req->bindParam(':id_category', $this->id_category);
            if($req->execute()) {
                $this->id = $db->bdd->lastInsertId();
                return $this;
            }
            return false;
        }
        public function update(): Product {
            $db = new Database();
            $req = $db->bdd->prepare("UPDATE product SET name = :name, price = :price, description = :description, photo = :photo , quantity = :quantity, updated_at = :updated_at, category_id = :id_category WHERE id = :id");
            $req->bindParam(':name', $this->name);
            $req->bindParam(':price', $this->price);
            $req->bindParam(':description', $this->description);
            $req->bindParam(':photo', json_encode($this->photo));
            $req->bindParam(':quantity', $this->quantity);
            $req->bindValue(':updated_at', $this->updated_at->format('Y-m-d H:i:s'));
            $req->bindParam(':id_category', $this->id_category);
            $req->bindParam(':id', $this->id);
            if($req->execute()) {
                return $this;
            }
            return false;
        }
        public function getCategory(): Category {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM category WHERE id = :id");
            $req->bindParam(':id', $this->id_category);
            $req->execute();
            $category = $req->fetch(PDO::FETCH_ASSOC);
            return new Category(
                $category['id'],
                $category['name'],
                $category['description'],
                new DateTime($category['created_at']),
                new DateTime($category['updated_at'])
            );
        }
        public function findOneById(int $id): Product {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM product WHERE id = :id");
            $req->bindParam(':id', $id);
            $req->execute();
            $product = $req->fetch(PDO::FETCH_ASSOC);
            return new Product(
                $product['id'],
                $product['name'],
                json_decode($product['photo']),
                $product['price'],
                $product['description'],
                $product['quantity'],
                new DateTime($product['created_at']),
                new DateTime($product['updated_at']),
                $product['category_id']
            );
        }
        public function findAll(): array {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM product");
            $req->execute();
            $products = $req->fetchAll(PDO::FETCH_ASSOC);
            $productsArray = [];
            foreach($products as $product) {
                $productsArray[] = new Product(
                    $product['id'],
                    $product['name'],
                    json_decode($product['photo']),
                    $product['price'],
                    $product['description'],
                    $product['quantity'],
                    new DateTime($product['created_at']),
                    new DateTime($product['updated_at']),
                    $product['category_id']
                );
            }
            return $productsArray;
        }
    }
