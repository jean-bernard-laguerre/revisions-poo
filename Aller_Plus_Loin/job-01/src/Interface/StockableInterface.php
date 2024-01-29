<?php namespace App;
    interface StockableInterface {
        public function addStock(int $quantity): void;
        public function removeStock(int $quantity): void;
    }