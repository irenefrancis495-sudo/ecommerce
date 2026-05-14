<?php
namespace Mpemba\Entity;

use Mpemba\Utils\Utility;

class Product{


 public static function getAllProducts(?int $itemsPerPage=10):array{
    $filters = '';
    $params = [];

    if (!empty($_GET['category'])) {
        $category = trim((string) $_GET['category']);
        if (ctype_digit($category)) {
            $filters .= ' AND c.id = ?';
            $params[] = (int) $category;
        } else {
            $categoryName = ucwords(strtolower(str_replace('-', ' ', $category)));
            $filters .= ' AND c.name = ?';
            $params[] = $categoryName;
        }
    }

    if (!empty($_GET['search'])) {
        $searchTerm = '%' . trim((string) $_GET['search']) . '%';
        $filters .= ' AND (p.name LIKE ? OR p.description LIKE ? OR c.name LIKE ?)';
        $params[] = $searchTerm;
        $params[] = $searchTerm;
        $params[] = $searchTerm;
    }

    $currentPage = max(1, (int) ($_GET['page'] ?? 1));
    $offset = max(0, ($currentPage - 1) * $itemsPerPage);
    $itemsPerPage = max(1, (int) $itemsPerPage);

    // Determine ORDER BY from optional sort parameter
    $allowedSorts = [
        'featured' => 'p.featured DESC, p.created_at DESC',
        'price-low' => 'p.price ASC',
        'price-high' => 'p.price DESC',
        'rating' => 'p.rating DESC',
        'name' => 'p.name ASC',
        'created' => 'p.created_at DESC'
    ];
    $sortKey = trim((string) ($_GET['sort'] ?? ''));
    $orderBy = $allowedSorts[$sortKey] ?? $allowedSorts['featured'];

    $data = Utility::safeQuery(
        "SELECT p.*, c.name AS category_name
         FROM `products` p
         INNER JOIN categories c ON c.id = p.category
         WHERE 1=1 {$filters}
         ORDER BY {$orderBy}
         LIMIT {$itemsPerPage} OFFSET {$offset};",
        $params
    );

    $total = self::getTotalProducts($filters, $params);
    $pages = $itemsPerPage > 0 ? (int) ceil($total / $itemsPerPage) : 1;

    return ['products' => $data, 'total' => $total, 'pages' => max(1, $pages)];
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

 public static function getTotalProducts($where = null, array $params = []){
    $whereClause = $where ? "WHERE 1=1 {$where}" : "";
    $result = Utility::safeQuery(
        "SELECT COUNT(*) as total FROM `products` p INNER JOIN categories c ON c.id = p.category {$whereClause};",
        $params,
        'SELECT',
        true
    );
    return $result['total'] ?? 0;
 }

}