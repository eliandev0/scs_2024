<?php

function checkEmail(string $email): bool {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function sanitizarString($dato): string {
    $dato = trim($dato);
    return htmlspecialchars($dato, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function sanitizarStringPassword($dato): string {
    $dato = trim($dato);
    $dato = htmlspecialchars($dato, ENT_NOQUOTES, 'UTF-8');
    return str_replace('&amp;', '&', $dato);
}

function obtenerIpUsuario(): string{
    if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP'])) {
      // IP compartida de internet
        return $_SERVER['HTTP_CLIENT_IP'];
    }
    else return "";
    
}
?>
