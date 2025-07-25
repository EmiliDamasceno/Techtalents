<?php
session_start();

// Desativa cache para segurança 
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache"); 
header("Expires: 0");

// Destrói a sessão 
session_unset();
session_destroy();

// apaga cookie da sessão para garantir limpeza total
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redireciona para a página de login após logout
header("Location: login.html");
exit();
