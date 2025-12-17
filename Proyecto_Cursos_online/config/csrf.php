<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}

function csrf(): string {
    return '<input type="hidden" name="token" value="' .
        htmlspecialchars($_SESSION['token'], ENT_QUOTES, 'UTF-8') . '">';
}

function check_csrf(): void {
    if (
        !isset($_POST['token']) ||
        !hash_equals($_SESSION['token'], (string) $_POST['token'])
    ) {
        http_response_code(403);
        exit('CSRF inválido');
    }
}
