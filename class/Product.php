<?php
    class Product {
        private int $id;
        private string $name;
        private array $photo;
        private int $price;
        private string $description;
        private int $quantity;
        private DateTime $created_at;
        private DateTime $updated_at;

        public function __construct(
            int $id,
            string $name,
            array $photo,
            int $price,
            string $description,
            int $quantity
        ) {
            $this->id = $id;
            $this->name = $name;
            $this->photo = $photo;
            $this->price = $price;
            $this->description = $description;
            $this->quantity = $quantity;
            $this->created_at = new DateTime();
            $this->updated_at = new DateTime();
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

        public function save(): void {
            $db = new Database();
            $req = $db->bdd->prepare("INSERT INTO product (name, price, description, quantity, created_at, updated_at)
                                    VALUES (:name, :photo, :price, :description, :quantity, :created_at, :updated_at)");
            $req->bindParam(':name', $this->name);
            $req->bindParam(':price', $this->price);
            $req->bindParam(':description', $this->description);
            $req->bindParam(':quantity', $this->quantity);
            $req->bindParam(':created_at', $this->created_at->format('Y-m-d H:i:s'));
            $req->bindParam(':updated_at', $this->updated_at->format('Y-m-d H:i:s'));
            $req->execute();
            
            foreach ($this->photo as $photo) {
                $req = $db->bdd->prepare("INSERT INTO photo (name, product_id)
                                        VALUES (:name, :product_id)");
                $req->bindParam(':name', $photo);
                $req->bindParam(':product_id', $this->id);
                $req->execute();
            }
        }
    }
