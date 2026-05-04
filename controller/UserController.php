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

    public function loginAdmin($login, $password) {
        $adminUser = $this->getAdminUser();
        $loginNormalized = strtolower($login);

        if ($loginNormalized === strtolower($adminUser['username']) || $loginNormalized === strtolower($adminUser['email'])) {
            $isValidPassword = hash_equals($adminUser['password'], $password) || strcasecmp($adminUser['password'], $password) === 0;

            if ($isValidPassword) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_user'] = [
                    'id' => $adminUser['id'],
                    'username' => $adminUser['username'],
                    'email' => $adminUser['email'],
                    'first_name' => $adminUser['first_name'],
                    'last_name' => $adminUser['last_name'],
                    'role' => $adminUser['role']
                ];
                $_SESSION['user'] = $_SESSION['admin_user'];

                return [
                    'success' => true,
                    'message' => 'Admin login successful',
                    'user' => $_SESSION['admin_user'],
                    'redirect' => '/admin/index'
                ];
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

        $users = $this->db->getUsers();

        foreach ($users as $user) {
            if ($user['username'] === $username && password_verify($password, $user['password'])) {
                // Start session and store user data
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'first_name' => $user['first_name'],
                    'last_name' => $user['last_name'],
                    'role' => $user['role']
                ];
                return ['success' => true, 'message' => 'Login successful', 'user' => $_SESSION['user']];
            }
        }

        return ['success' => false, 'message' => 'Invalid username or password'];
    }

    public function register($username, $email, $password, $firstName = '', $lastName = '') {
        $users = $this->db->getUsers();

        // Check if username already exists
        foreach ($users as $user) {
            if ($user['username'] === $username) {
                return ['success' => false, 'message' => 'Username already exists'];
            }
            if ($user['email'] === $email) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
        }

        // Create new user
        $newUser = [
            'id' => count($users) + 1,
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'role' => 'customer'
        ];

        $users[] = $newUser;
        $this->db->saveUsers($users);

        // Start session
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