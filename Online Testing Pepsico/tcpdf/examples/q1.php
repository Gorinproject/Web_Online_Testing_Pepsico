<?
require_once('tcpdf_include.php');
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
}
mysql_connect("sql107.byethost4.com", "b4_16627716", "qwer890");
mysql_select_db("b4_16627716_question");
mysql_query("SET NAMES 'utf8';");
mysql_query("SET CHARACTER SET 'utf8';");
mysql_query("SET SESSION collation_connection = 'utf8_general_ci';"); 
 $score_true = 50;
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = 'images/sert.jpg';
        $this->Image($img_file, 0, 0, 297, 210, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}
if(isset($_POST['key'])){
$query = mysql_query("SELECT `name`, `score`, `key` FROM `result` WHERE `key` = '".mysql_real_escape_string($_POST['key'])."' LIMIT 1;");
if (!$query)
{
 $message  = 'Неверный запрос: ' . mysql_error() . "\n";
    $message .= 'Запрос целиком: ' . $query;
    die($message);
}
while ($row = mysql_fetch_assoc($query)) {
   $name_certificate = $row['name'];
   $score = $row['score'];
   $key = $row['key'];
}
if($_POST['key']==$key and $score > $score_true)
{
$date_time_array = getdate( time() );
$date_certificate = $date_time_array['mday'].'/'.$date_time_array['mon'].'/'.$date_time_array['year'];
// create new PDF document 
$pdf = new MYPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('TCPDF Example 051');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);
// remove default footer
$pdf->setPrintFooter(false);
//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
//set some language-dependent strings
$pdf->setLanguageArray($l);
// set font
$pdf->SetFont('dejavusans', '', 18);
// add a page
$pdf->AddPage();
// Print a text
$html = '<span style="color:#42619d;">'.$name_certificate.'</span>';
// Print a text
$pdf->SetXY(100, 105);
//$pdf->writeHTMLCell(200, 200, '', '', $html, 0, 1, 0, true, '', true);
$pdf->writeHTML($html, true, false, true, false, '');
$html = '<span style="color:#42619d;">'.$date_certificate.'</span>';
$pdf->SetXY(150, 148);
$pdf->writeHTML($html, true, false, true, false, '');
// add a page
// ---------------------------------------------------------
ob_clean();
//Close and output PDF document
$pdf->Output('certificate.pdf', 'I');
}}
//============================================================+
// END OF FILE
//============================================================+
?>