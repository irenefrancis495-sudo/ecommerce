<?php
namespace Mpemba\Entity;

class Order {
    public $id;
    public $user_id;
    public $total;
    public $status; // 'pending', 'completed', 'cancelled'
    public $created_at;
    public $items = [];

    public function __construct($id = null, $user_id = null, $total = 0, $status = 'pending', $created_at = null) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->total = $total;
        $this->status = $status;
        $this->created_at = $created_at ?? date('Y-m-d H:i:s');
    }

    public function save(): void {
        global $db;
        if ($this->id) {
            $db->update('orders', [
                'user_id' => $this->user_id,
                'total' => $this->total,
                'status' => $this->status,
                'created_at' => $this->created_at,
            ], ['id' => $this->id]);
        } else {
            $db->insert('orders', [
                'user_id' => $this->user_id,
                'total' => $this->total,
                'status' => $this->status,
                'created_at' => $this->created_at,
            ]);
            $this->id = $db->lastInsertId();
        }
    }

    public function delete(): void {
        global $db;
        if ($this->id) {
            $db->delete('orders', ['id' => $this->id]);
        }
    }

    public static function findById($id): ?Order {
        global $db;
        $stmt = $db->prepare('SELECT * FROM orders WHERE id = ?');
        $result = $stmt->executeQuery([$id]);
        $data = $result->fetchAssociative();
        if ($data) {
            $order = new Order($data['id'], $data['user_id'], $data['total'], $data['status'], $data['created_at']);
            $order->loadItems();
            return $order;
        }
        return null;
    }

    public static function findByUserId($user_id): array {
        global $db;
        $stmt = $db->prepare('SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC');
        $result = $stmt->executeQuery([$user_id]);
        $orders = [];
        while ($data = $result->fetchAssociative()) {
            $order = new Order($data['id'], $data['user_id'], $data['total'], $data['status'], $data['created_at']);
            $order->loadItems();
            $orders[] = $order;
        }
        return $orders;
    }

    public function loadItems(): void {
        global $db;
        $stmt = $db->prepare('SELECT * FROM order_items WHERE order_id = ?');
        $result = $stmt->executeQuery([$this->id]);
        $this->items = $result->fetchAllAssociative();
    }

    public function addItem($product_id, $quantity, $price): void {
        global $db;
        $db->insert('order_items', [
            'order_id' => $this->id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'price' => $price,
        ]);
    }
}