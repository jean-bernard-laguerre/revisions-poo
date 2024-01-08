<?php
    class Category {
        private int $id;
        private string $name;
        private string $description;
        private DateTime $created_at;
        private DateTime $updated_at;

        public function __construct(
            int $id = 1,
            string $name = "",
            string $description = "",
            string $created_at = "",
            string $updated_at = ""
        ) {
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->created_at = new DateTime($created_at);
            $this->updated_at = new DateTime($updated_at);
        }

        public function getId(): int {
            return $this->id;
        }
        public function getName(): string {
            return $this->name;
        }
        public function getDescription(): string {
            return $this->description;
        }
        public function getCreatedAt(): DateTime {
            return $this->created_at;
        }
        public function getUpdatedAt(): DateTime {
            return $this->updated_at;
        }
        
        public function setName(string $name): void {
            $this->name = $name;
        }
        public function setDescription(string $description): void {
            $this->description = $description;
        }

        public function create(): void {
            $db = new Database();
            $req = $db->bdd->prepare("INSERT INTO category (name, description, created_at, updated_at)
                VALUES (:name, :description, :created_at, :updated_at)");
            $req->bindParam(':name', $this->name);
            $req->bindParam(':description', $this->description);
            $req->bindValue(':created_at', $this->created_at->format('Y-m-d H:i:s'));
            $req->bindValue(':updated_at', $this->updated_at->format('Y-m-d H:i:s'));
            $req->execute();
        }

        public function getProducts(): array {
            $db = new Database();
            $req = $db->bdd->prepare("SELECT * FROM product WHERE category_id = :id");
            $req->bindParam(':id', $this->id);
            $req->execute();
            $result = $req->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $product) {
                $product = new Product(
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
                $products[] = $product;
            }

            return $products;
        }
    }
