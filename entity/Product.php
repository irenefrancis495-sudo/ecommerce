<?php
namespace Mpemba\Entity;

use Mpemba\Utils\Utility;

class Product{


 public static function getAllProducts(?int $itemsPerPage=10):array{

 $where = null;
 $totalFilter = null;

if(!empty($_GET['category'])){
    $where = " AND c.id = {$_GET['category']}";
    $totalFilter = " AND c.id = {$_GET['category']}";
}

if(!empty($_GET['search'])){
    $searchTerm = $_GET['search'];
    $where .= " AND (p.name LIKE '%$searchTerm%' OR p.description LIKE '%$searchTerm%')";
    $totalFilter .= " AND (p.name LIKE '%$searchTerm%' OR p.description LIKE '%$searchTerm%')";
}
    $data = Utility::safeQuery("SELECT p.*,c.name AS category_name 
    FROM `products`p INNER JOIN categories c 
    ON c.id = p.category WHERE 1=1 {$where} LIMIT {$itemsPerPage};");

    $total = self::getTotalProducts($totalFilter);
    $pages = ceil($total / $itemsPerPage);
    return ['products' => $data, 'total' => $total, 'pages' => $pages];
 }

 public static function getProductById($id){
    return Utility::safeQuery("SELECT p.*,c.name AS category_name 
    FROM `products`p INNER JOIN categories c 
    ON c.id = p.category WHERE p.id = ?;",[$id],'SELECT');
 }

 public static function getProductsByCategory($categoryId){
    return Utility::safeQuery("SELECT p.*,c.name AS category_name 
    FROM `products`p INNER JOIN categories c 
    ON c.id = p.category WHERE c.id = ?;",[$categoryId]);
 }

 public static function searchProducts($searchTerm){
    $likeTerm = '%' . $searchTerm . '%';
    return Utility::safeQuery("SELECT p.*,c.name AS category_name 
    FROM `products`p INNER JOIN categories c 
    ON c.id = p.category WHERE p.name LIKE ? OR p.description LIKE ?;",[$likeTerm, $likeTerm]);
 }

 public static function getTotalProducts($where = null){
    $whereClause = $where ? "WHERE 1=1 {$where}" : "";
    $result = Utility::safeQuery("SELECT COUNT(*) as total FROM `products` p INNER JOIN categories c ON c.id = p.category {$whereClause};", [], 'SELECT');
    return $result['total'] ?? 0;
 }

}