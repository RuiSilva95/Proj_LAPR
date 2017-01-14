<?php
require "core/TCPDF/tcpdf.php";
//require_once '../core/TCPDF/tcpdf_include.php';



// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 006');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    include_once dirname(__FILE__).'/lang/eng.php';
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont('dejavusans', '', 10);

// add a page
$pdf->AddPage();

$html = '
<p class="long">
    <span class="left">
        Av. Bombeiros Voluntários, 700, 1-D<br />
        Apartado 25<br />
        4585-907 Rebordosa<br />
    </span>
    <span class="right">
      t. 00351 220992008<br />
        e. info@takemore.pt<br />
        w. www.takemore.pt<br />
    </span>
</p>
<h2>Ficha de Reparação</h2>
<div class="box">
    <table>
        <tr>
            <td>
                <span>Cliente</span>
            </td>
            <td>
                <span>Morada</span>
            </td>
            <td>
                <span>Contacto</span>
                <br />
                <br />
            </td>
        </tr>
        <tr>
            <td>
                <span>Consultor / Técnico</span>
                <br />
                <br />
            </td>
            <td>
                <span>Local</span>
                <br />Fabrica de Rebordosa
            </td>
            <td>
                <span>Data</span>
                <br />
                <br />
            </td>
        </tr>
    </table>
</div>

</div>
<p class="long"><span class="left1">O Cliente <br /><br /><br /> ________________________________________</span><span class="right1">O Técnico/Consultor <br /><br /><br />________________________________________</span></p>
<hr />
<p><span>*Os serviços de assistência terão sempre o custo da primeira hora nos serviços presenciais.</span></p>
<p><span>*Os serviços de assistência serão contabilizados em periodos de 15 minutos.</span></p>
<table>
<tr>
    <td><img src="img/partner/microsoft.jpg"/></td>
    <td><img src="img/partner/tmi_avat.jpg"/></td>
</tr>
</table>
</div>

';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
//Close and output PDF document
$pdf->Output('core/example_006.pdf', 'I');


    ?>
