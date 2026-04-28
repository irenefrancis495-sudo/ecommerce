<?php
namespace Mpemba\Entity;

use Doctrine\DBAL\Connection;

class Product {
    private Connection $db;

    public $id;
    public $name;
    public $price;
    public $stock;
    public $category;

    public function __construct(Connection $db, $id = null, $name = null, $price = null, $stock = null, $category = null) {
        $this->db = $db;
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->stock = $stock;
        $this->category = $category;
    }

    public static function getProducts(Connection $db = null): array {
        if (!$db) {
            global $db;
        }
        $stmt = $db->prepare('SELECT * FROM products');
        $result = $stmt->executeQuery();
        return $result->fetchAllAssociative();
    }

    public function save(): void {
        if ($this->id) {
            $this->db->update('products', [
                'name' => $this->name,
                'price' => $this->price,
                'stock' => $this->stock,
                'category' => $this->category,
            ], ['id' => $this->id]);
        } else {
            $this->db->insert('products', [
                'name' => $this->name,
                'price' => $this->price,
                'stock' => $this->stock,
                'category' => $this->category,
            ]);
            $this->id = $this->db->lastInsertId();
        }
    }

    public function delete(): void {
        if ($this->id) {
            $this->db->delete('products', ['id' => $this->id]);
        }
    }

    public static function findById($id, Connection $db = null): ?Product {
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