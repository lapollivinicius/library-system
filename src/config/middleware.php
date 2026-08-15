<?php

namespace config;

session_start();

class middleware {

    public function auth() {
        if (empty($_SESSION['user_id']) && empty($_SESSION['role'])) {
            header('Location: /login');
            exit;
        }
    }

    public static function guest() {
        if (!empty($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
    }

    public static function csrfToken() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    public static function csrf() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return;
        }
        $token = $_POST['csrf_token'] ?? '';
        if (
            empty($_SESSION['csrf_token']) ||
            empty($token) ||
            !hash_equals($_SESSION['csrf_token'], $token)
        ) {
            exit('Invalid Token');
        }
    }
}