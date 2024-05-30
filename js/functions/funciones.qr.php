<?php
require_once __DIR__ . '/lib/endroidqr/vendor/autoload.php';
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\WriterInterface;
use Endroid\QrCode\Writer\PngWriter;

const CLAVE_CIFRAR = 'abcdefghijklmnopqrstuvwABCDEFGHIJKLMNOPQRSTUVWXYZ123456789325148';
const METODO_CIFRAR = "AES-256-CBC";
const ALGORITMO_HMAC_CIFRAR = "SHA256";

function generarToken(array $data): string {
    $clave = CLAVE_CIFRAR;
    $metodo = METODO_CIFRAR;
    $clave_cifrado = openssl_random_pseudo_bytes(openssl_cipher_iv_length($metodo));
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($metodo));

    $cifrado = openssl_encrypt(json_encode($data), $metodo, $clave, 0, $clave_cifrado);
    $hmac = hash_hmac(ALGORITMO_HMAC_CIFRAR, $cifrado, $clave_cifrado, true);

    return base64_encode($clave_cifrado.$iv.$hmac.$cifrado);
}


function descifrarToken(string $token): array | false {
    $clave = CLAVE_CIFRAR;
    $metodo = METODO_CIFRAR;
    $decoded = base64_decode($token);
    $iv_length = openssl_cipher_iv_length($metodo);
    $clave_cifrado = substr($decoded, 0, $iv_length);
    $iv = substr($decoded, $iv_length, $iv_length);
    $hmac = substr($decoded, $iv_length * 2, 32);
    $cifrado = substr($decoded, $iv_length * 2 + 32);

    $data = openssl_decrypt($cifrado, $metodo, $clave, 0, $clave_cifrado);
    $calculated_hmac = hash_hmac(ALGORITMO_HMAC_CIFRAR, $cifrado, $clave_cifrado, true);

    if (!hash_equals($hmac, $calculated_hmac)) {
		// Si HMAC no coincide, los datos han podido ser alterados
        return false;
    }

    return json_decode($data, true);
}

$datos = ['id' => 1, 'nombre' => 'Javier'];

$token = generarToken($datos);
echo $token;
echo "<br>";
$datosDescifrados = descifrarToken($token);
print_r($datosDescifrados);


// Preparamos el QR
$url = 'https://localhost/descifrar/documento.php?codigo='.$token;

$codigoQR = new QrCode($url);
$codigoQR->setErrorCorrectionLevel(ErrorCorrectionLevel::High);
$codigoQR->setSize(300);
$codigoQR->setMargin(1);

$writerQR = new PngWriter();

// Obtén la imagen en formato PNG
$imagenQR = $writerQR->write($codigoQR);

// Convierte la imagen en base64
$base64QR = base64_encode($imagenQR->getString());
$htmlQR = '<img style="width: 300px" src="data:image/png;base64,'.$base64QR.'">';

$htmlCodigoQRCompleto  = '';
$htmlCodigoQRCompleto .= '<table>';
$htmlCodigoQRCompleto .= '    <tr>';
$htmlCodigoQRCompleto .= '      <td class="text-center">'.$htmlQR;
$htmlCodigoQRCompleto .= '    </td>';
$htmlCodigoQRCompleto .= '    </tr>';
$htmlCodigoQRCompleto .= '</table>';
// Fin preparamos el QR

echo $htmlCodigoQRCompleto;


?>