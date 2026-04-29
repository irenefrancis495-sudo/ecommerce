<?php
namespace Mpemba\Controller;

use Mpemba\Entity\Product;

class ProductController {
    public static function index() {
        $products = Product::getProducts();
        header('Content-Type: application/json');
        echo json_encode($products);
    }

    public static function show($id) {
        $product = Product::findById($id);
        if ($product) {
            header('Content-Type: application/json');
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
        }
    }

    public static function store() {
        $data = json_decode(file_get_contents('php://input'), true);
        $product = new Product(null, $data['name'], $data['price'], $data['stock'], $data['category']);
        $product->save();
        header('Content-Type: application/json');
        echo json_encode(['id' => $product->id]);
    }

    public static function update($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        $product = Product::findById($id);
        if ($product) {
            $product->name = $data['name'];
            $product->price = $data['price'];
            $product->stock = $data['stock'];
            $product->category = $data['category'];
            $product->save();
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
        }
    }

    public static function destroy($id) {
        $product = Product::findById($id);
        if ($product) {
            $product->delete();
            echo json_encode(['success' => true]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
        }
    }
}