<?php
    class Category {
        private int $id;
        private string $name;
        private string $description;
        private DateTime $created_at;
        private DateTime $updated_at;

        public function __construct(
            int $id,
            string $name,
            string $description
        ) {
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->created_at = new DateTime();
            $this->updated_at = new DateTime();
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

        public function save(): void {
            $db = new Database();
            $req = $db->bdd->prepare("INSERT INTO category (name, description, created_at, updated_at)
                VALUES (:name, :description, :created_at, :updated_at)");
            $req->bindParam(':name', $this->name);
            $req->bindParam(':description', $this->description);
            $req->bindParam(':created_at', $this->created_at->format('Y-m-d H:i:s'));
            $req->bindParam(':updated_at', $this->updated_at->format('Y-m-d H:i:s'));
            $req->execute();
        }
    }
