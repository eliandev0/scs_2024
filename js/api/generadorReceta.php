<?php
//require_once __DIR__."/api/comprobarLogIn.php";
require_once __DIR__."/config/config.globales.php";
require_once __DIR__."/class/class.Administrador.php";
require_once __DIR__."/class/class.Medico.php";
require_once __DIR__."/class/class.Paciente.php";

require_once __DIR__."/lib/mpdf/vendor/autoload.php";

global $sesion;

$medico = new Medico(14);

$paciente = new Medico(16);

$mpdf = new \Mpdf\Mpdf([
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 5,
    'margin_bottom' => 10,
    'margin_header' => 10,
    'margin_footer' => 10,

]);
$mpdf->SetTitle('Receta');
$mpdf->showImageErrors = true;
$mpdf->charset_in = 'UTF-8';


$htmlPDF = '
<table>
    <tbody>
        <tr>
            <td><img src="http://localhost/scs_old2/images/logo_2.jpg" height="100px"></td>
            <td style="width: 400px"></td>
            <td>Médico: '.$medico->getNombre().' '.$medico->getApellido1().'<br>Nº Colegiado: '.$medico->getNumeroColegiado().'</td>
        </tr>
    </tbody>
</table>
<hr>

<table>
    <tbody>
        <tr>
        <td class="cabeceraSeccionReceta" >DATOS DEL PACIENTE</td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td>Nombre: '.$paciente->getNombre().'<br>CIP: '.$paciente->getNumeroColegiado().'</td>
            
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
        <td class="cabeceraSeccionReceta" >PRESCRIPCIÓN MÉDICA</td>
        </tr>
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <td>Ubicaína Forte: 1 cada vez que desubique.</td>
        </tr>
    </tbody>
</table>
';
$contenidoCSS = file_get_contents('receta.css');
$mpdf->writeHtml($contenidoCSS, 1);
$mpdf->WriteHTML($htmlPDF,2);

$mpdf->Output('nombre_receta_'.$paciente->getNumeroColegiado().'.pdf', \Mpdf\Output\Destination::INLINE);