<?php
class ManejoSesion implements SessionHandlerInterface {
    private static bool $active = false;
    private $key;
    private $iv;

    public function __construct() {
        $wasItSecure = false;
        while (!$wasItSecure) {
            $this->iv = openssl_random_pseudo_bytes(16, $wasItSecure);
        }
        $this->key = base64_encode(openssl_random_pseudo_bytes(32));
    }

    public function start($name , $lifetime = 0, $path = '/', $domain = NOMBRE_SESSION_SCS_DOMINIO, $secure = true, $httponly = true, $samesite = 'Strict') {
        global $_SESSION;
        if (!self::$active) {
            // Establecer el nombre de la sesión
            session_name($name);

            // Establecer la configuración de la cookie de sesión
            session_set_cookie_params($lifetime, $path, $domain, $secure, $httponly);
            ini_set('session.cookie_samesite', $samesite);


            // Iniciar la sesión
            session_start();
            if (!(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')) {
                session_regenerate_id(true);
            }

            if (!isset($_SESSION['helado'])) {
                $_SESSION['helado'] = $this->key;
            }

            if (!isset($_SESSION['tarta'])) {
                $_SESSION['tarta'] = $this->iv;
            }

            // Establecer la sesión como activa
            self::$active = true;
        }
    }

    public function open($save_path, $session_name) {
        return true;
    }

    public function close() {
        return true;
    }

    public function read($session_id) {
        if (!isset($_SESSION[$session_id])) {
            return false;
        }
        $data = openssl_decrypt($_SESSION[$session_id], 'AES-256-CBC', $_SESSION['helado'], 0, $_SESSION['tarta']);
        if ($data === false) {
            $this->destroySession();
            return false;
        }
        return $data;
    }

    public function write($session_id, $session_data) {
        $valorCifrado = openssl_encrypt($session_data, 'AES-256-CBC', $_SESSION['helado'], 0, $_SESSION['tarta']);
        $_SESSION[$session_id] = $valorCifrado;
        return true;
    }

    public function destroy($session_id) {
        unset($_SESSION[$session_id]);
        return true;
    }

    public function destroySession() {
        session_unset();
        session_destroy();
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
    }

    public function gc($maxlifetime) {
        return true;
    }
}

?>