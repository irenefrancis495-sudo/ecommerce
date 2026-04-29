<?php
namespace Mpemba\Entity;

use Mpemba\Utils\Utility;

class Product {
    
    public $id;
    public $name;
    public $price;
    public $stock;
    public $category;

    public function __construct($id = null, ) {
       if(!empty($id)){
        $data = Utility::safeQuery('SELECT * FROM products WHERE id = ?',[$id]);
        $this->id = $data['id'];
        $this->name = $data['name'];
        $this->price = $data['price'];
        $this->stock = $data['stock'];
        $this->category = $data['category'];
       }
    }

    public static function getProducts(): array {
    
        return Utility::safeQuery('SELECT * FROM products');
    }

    public function save(): void {
        if ($this->id) {
            Utility::update('products',$this->id, [
                'name' => $this->name,
                'price' => $this->price,
                'stock' => $this->stock,
                'category' => $this->category,
            ]);
        } else {
           $this->id = Utility::insert('products', [
                'name' => $this->name,
                'price' => $this->price,
                'stock' => $this->stock,
                'category' => $this->category,
            ]);
        }
    }

    public function delete(): void {
        if ($this->id) {
            Utility::delete('products', $this->id);
        }
    }

    public static function findById($id): ?Product {
        if (!$db) {
            global $db;
        }
        $stmt = $db->prepare('SELECT * FROM products WHERE id = ?');
        $result = $stmt->executeQuery([$id]);
        $data = $result->fetchAssociative();
        if ($data) {
            return new Product($db, $data['id'], $data['name'], $data['price'], $data['stock'], $data['category']);
        }
        return null;
    }
}