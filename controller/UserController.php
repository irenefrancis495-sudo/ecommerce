<?php
namespace Mpemba\Controller;

use Mpemba\Utils\Database;

class UserController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($username, $password) {
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