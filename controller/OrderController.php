<?php
namespace Mpemba\Controller;

use Mpemba\Entity\Order;
use Mpemba\Entity\Product;

class OrderController {
    public static function index() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }
        $orders = Order::findByUserId($_SESSION['user_id']);
        header('Content-Type: application/json');
        echo json_encode($orders);
    }

    public static function show($id) {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }
        $order = Order::findById($id);
        if ($order && $order->user_id == $_SESSION['user_id']) {
            header('Content-Type: application/json');
            echo json_encode($order);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Order not found']);
        }
    }

    public static function store() {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $order = new Order(null, $_SESSION['user_id'], $data['total'], 'pending');
        $order->save();
        foreach ($data['items'] as $item) {
            $order->addItem($item['product_id'], $item['quantity'], $item['price']);
        }
        header('Content-Type: application/json');
        echo json_encode(['id' => $order->id]);
    }

    public static function updateStatus($id) {
        session_start();
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
            http_response_code(403);
            echo json_encode(['error' => 'Access denied']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $order = Order::findById($id);
        if ($order) {
            $order->status = $data['status'];
            $order->save();
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Order not found']);
        }
    }
}