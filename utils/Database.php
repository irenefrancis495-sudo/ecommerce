<?php
namespace Mpemba\Utils;

Use Mpemba\Utils\Utility;

class Database {
    
    public static function generateOrderNumber(): string {
        return 'ORD-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
    }
    
    public static function calculateTax($subtotal, $taxRate = 0.1): float {
        return round($subtotal * $taxRate, 2);
    }
    
    public static function calculateTotal($subtotal, $tax = 0, $shippingCost = 0): float {
        return round($subtotal + $tax + $shippingCost, 2);
    }
    
    public static function formatPrice($price): string {
        return '$' . number_format($price, 2);
    }
    
    public static function isValidEmail($email): bool {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }
    
    public static function isValidPassword($password): bool {
        return strlen($password) >= 6;
    }
    
    public static function sanitize($input): string {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
    
    public static function generateSlug($text): string {
        $text = strtolower(trim($text));
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        return trim($text, '-');
    }
    
    public static function getIPAddress(): string {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
    
    public static function logAudit($userId, $action, $entityType, $entityId, $changes = null): void {
        global $db;
        try {
           Utility::insert('audit_logs', [
                'user_id' => $userId,
                'action' => $action,
                'entity_type' => $entityType,
                'entity_id' => $entityId,
                'changes' => $changes ? json_encode($changes) : null,
                'ip_address' => self::getIPAddress(),
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            ]);
        } catch (\Exception $e) {
            // Fail silently for audit logging
        }
    }
    
    public static function respondJson($status, $data = null, $message = null, $httpCode = 200): void {
        header('Content-Type: application/json');
        http_response_code($httpCode);
        
        $response = ['status' => $status];
        if ($data !== null) $response['data'] = $data;
        if ($message !== null) $response['message'] = $message;
        
        echo json_encode($response);
    }
    
    public static function respondError($message, $httpCode = 400): void {
        self::respondJson('error', null, $message, $httpCode);
    }
    
    public static function getUsers(): array {
        $usersFile = __DIR__ . '/../data/users.json';
        if (file_exists($usersFile)) {
            $users = json_decode(file_get_contents($usersFile), true);
            return $users ?: [];
        }
        return [];
    }

    public static function saveUsers(array $users): bool {
        $usersFile = __DIR__ . '/../data/users.json';
        return file_put_contents($usersFile, json_encode($users, JSON_PRETTY_PRINT)) !== false;
    }

    public static function getUserById($id) {
        $users = self::getUsers();
        foreach ($users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }

    public static function getUserByUsername($username) {
        $users = self::getUsers();
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                return $user;
            }
        }
        return null;
    }
}
?>
