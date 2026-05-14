<?php
namespace Mpemba\Controller;

use Mpemba\Utils\Database;

class UserController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    private function getAdminUser(): array {
        return [
            'id' => 0,
            'username' => 'admin',
            'email' => 'admin@mpemba.local',
            'password' => 'Admin@123',
            'first_name' => 'Site',
            'last_name' => 'Admin',
            'role' => 'admin'
        ];
    }

    private function findUserByLogin($login): ?array {
        return Database::getUserByLogin($login);
    }

    public function loginAdmin($login, $password) {
        $adminUser = $this->getAdminUser();
        $loginNormalized = strtolower(trim($login));

        if ($loginNormalized === strtolower($adminUser['username']) || $loginNormalized === strtolower($adminUser['email'])) {
            $isValidPassword = hash_equals($adminUser['password'], $password) || strcasecmp($adminUser['password'], $password) === 0;

            if ($isValidPassword) {
                return $this->buildAdminSession($adminUser);
            }

            return ['success' => false, 'message' => 'Invalid username or password'];
        }

        $user = $this->findUserByLogin($login);
        if ($user && strtolower((string) ($user['role'] ?? 'customer')) === 'admin') {
            if (!empty($user['password']) && password_verify($password, (string) $user['password'])) {
                return $this->buildAdminSession($user);
            }

            return ['success' => false, 'message' => 'Invalid username or password'];
        }

        return null;
    }

    public function login($username, $password) {
        $adminLogin = $this->loginAdmin($username, $password);
        if ($adminLogin !== null) {
            return $adminLogin;
        }

        $user = $this->findUserByLogin($username);
        if ($user && !empty($user['password']) && password_verify($password, (string) $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'first_name' => $user['first_name'] ?? '',
                'last_name' => $user['last_name'] ?? '',
                'role' => $user['role'] ?? 'user'
            ];
            return ['success' => true, 'message' => 'Login successful', 'user' => $_SESSION['user']];
        }

        return ['success' => false, 'message' => 'Invalid username or password'];
    }

    private function buildAdminSession(array $user) {
        $_SESSION['user'] = [
            'id' => $user['id'] ?? 0,
            'username' => $user['username'] ?? 'admin',
            'email' => $user['email'] ?? '',
            'first_name' => $user['first_name'] ?? '',
            'last_name' => $user['last_name'] ?? '',
            'role' => $user['role'] ?? 'admin'
        ];
        return ['success' => true, 'message' => 'Login successful', 'user' => $_SESSION['user']];
    }

    public function register($username, $email, $password, $firstName = '', $lastName = '') {
        $existingUsername = Database::getUserByUsername($username);
        if ($existingUsername !== null) {
            return ['success' => false, 'message' => 'Username already exists'];
        }

        $existingEmail = Database::getUserByEmail($email);
        if ($existingEmail !== null) {
            return ['success' => false, 'message' => 'Email already exists'];
        }

        $newUser = [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'role' => 'user'
        ];

        $insertId = Database::insertUserToDb($newUser);
        if ($insertId !== null) {
            $newUser['id'] = (int) $insertId;
        } else {
            $users = $this->db->getUsers();
            $newUser['id'] = count($users) + 1;
            $users[] = $newUser;
            $this->db->saveUsers($users);
        }

        $_SESSION['user'] = [
            'id' => $newUser['id'],
            'username' => $newUser['username'],
            'email' => $newUser['email'],
            'first_name' => $newUser['first_name'],
            'last_name' => $newUser['last_name'],
            'role' => $newUser['role']
        ];

        return ['success' => true, 'message' => 'Registration successful', 'user' => $_SESSION['user']];
    }

    public function logout() {
        session_destroy();
        return ['success' => true, 'message' => 'Logged out successfully'];
    }

    public function getCurrentUser() {
        return isset($_SESSION['user']) ? $_SESSION['user'] : null;
    }

    public function isLoggedIn() {
        return isset($_SESSION['user']);
    }
}
?>