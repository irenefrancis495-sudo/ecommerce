<?php
namespace Mpemba\Entity;

class User {
    public $id;
    public $username;
    public $password;
    public $email;
    public $role; // 'admin' or 'customer'

    public function __construct($id = null, $username = null, $password = null, $email = null, $role = 'customer') {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->role = $role;
    }

    public function save(): void {
        global $db;
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);
        if ($this->id) {
            $db->update('users', [
                'username' => $this->username,
                'password' => $hashedPassword,
                'email' => $this->email,
                'role' => $this->role,
            ], ['id' => $this->id]);
        } else {
            $db->insert('users', [
                'username' => $this->username,
                'password' => $hashedPassword,
                'email' => $this->email,
                'role' => $this->role,
            ]);
            $this->id = $db->lastInsertId();
        }
    }

    public function delete(): void {
        global $db;
        if ($this->id) {

            $db->delete('users', ['id' => $this->id]);      
        }
    }

    public static function findByUsername($username): ?User {
        global $db;
        $stmt = $db->prepare('SELECT * FROM users WHERE username = ?');
        $result = $stmt->executeQuery([$username]);
        $data = $result->fetchAssociative();
        if ($data) {
            return new User($data['id'], $data['username'], $data['password'], $data['email'], $data['role']);
        }
        return null;
    }

    public static function authenticate($username, $password): ?User {
        $user = self::findByUsername($username);
        if ($user && password_verify($password, $user->password)) {
            return $user;
        }
        return null;
    }
}