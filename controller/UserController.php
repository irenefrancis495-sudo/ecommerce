<?php
namespace Mpemba\Controller;

use Mpemba\Entity\User;

class UserController {
    public static function login() {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = User::authenticate($data['username'], $data['password']);
        if ($user) {
            session_start();
            $_SESSION['user_id'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['role'] = $user->role;
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'user' => ['id' => $user->id, 'username' => $user->username, 'role' => $user->role]]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
        }
    }

    public static function logout() {
        session_start();
        session_destroy();
        echo json_encode(['success' => true]);
    }

    public static function register() {
        $data = json_decode(file_get_contents('php://input'), true);
        $existingUser = User::findByUsername($data['username']);
        if ($existingUser) {
            http_response_code(409);
            echo json_encode(['error' => 'Username already exists']);
            return;
        }
        $user = new User(null, $data['username'], $data['password'], $data['email']);
        $user->save();
        session_start();
        $_SESSION['user_id'] = $user->id;
        $_SESSION['username'] = $user->username;
        $_SESSION['role'] = $user->role;
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'user' => ['id' => $user->id, 'username' => $user->username, 'role' => $user->role]]);
    }

    public static function current() {
        session_start();
        if (isset($_SESSION['user_id'])) {
            echo json_encode(['user' => ['id' => $_SESSION['user_id'], 'username' => $_SESSION['username'], 'role' => $_SESSION['role']]]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Not authenticated']);
        }
    }
}