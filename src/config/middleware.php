<?php

namespace config;

class middleware {

    public function run($middlewares) {
        foreach ($middlewares as $middleware) {
            switch ($middleware) {
                case 'auth':
                    $this->auth();
                    break;
                case 'guest':
                    $this->guest();
                    break;
                case 'csrf':
                    $this->csrf();
                    break;
            }
        }
    }

    private function auth() {
        if (empty($_SESSION['user_id']) && empty($_SESSION['role'])) {
            header('Location: /login');
            exit;
        }
    }

    private function guest() {
        if (!empty($_SESSION['user_id']) && !empty($_SESSION['role'])) {
            header('Location: /');
            exit;
        }
    }

    private static function guest() {
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

    private static function csrf() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            return;
        }
        $token = $_POST['csrf_token'] ?? '';
        if (
            empty($_SESSION['csrf_token']) ||
            empty($token) ||
            !hash_equals($_SESSION['csrf_token'], $token)
        ) {
            http_response_code(403);
            exit('Invalid Token');
        }
    }
}