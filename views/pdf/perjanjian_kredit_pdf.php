<?php
require_once '../lib/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
use Dompdf\Options;
$tanggal = format_date_only($transaction_date);
$dompdf = new Dompdf();
$html= '
<html>
<title>FAKTUR PEMBELIAN</title>
  <head>
  	<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />
  	<link href="../css/print/print.css" rel="stylesheet">
  </head>';
$html .='
  <body>
    <center>
      <div class="Section1">
        <table>
          <thead>
            <tr>
              <th>
              jhvjhvjv
              </th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
          </tfoot>
        </table>
      </div>
    </center>
  </body>
</html>';

$dompdf->loadHtml($html);
// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();
$dompdf->set_base_path('../css/bootstrap.min.css');
$dompdf->set_base_path('../css/print/print.css');
// Output the generated PDF to Browser
$dompdf->stream("perjanjian_kredit");
