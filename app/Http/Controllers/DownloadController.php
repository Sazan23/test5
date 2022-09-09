<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utility\PHPExcel_Utils;
use App\Models\Files;
use App\Models\Records;
use TCPDF;

class DownloadController extends Controller
{
    /**
     * Download summary report
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function downloadXLS(Request $request, $id)
    {
        PHPExcel_Utils::formationXLS_Report($id);

        return;
    }

    /**
     * Download record report
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function downloadPDF_record(Request $request, $file_id, $id )
    {
        $file = Files::find($file_id);
        $record = Records::where('file_id', $file_id)
                         ->where('id', $id)
                         ->first();
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');

        // set document information
        $pdf->setCreator(PDF_CREATOR);
        $pdf->setAuthor('Oleg Denisenko');
        $pdf->setTitle('TCPDF Example 009');
        $pdf->setSubject('TCPDF Tutorial');
        $pdf->setKeywords('TCPDF, PDF, example, test, guide');

        // set default header data
        $pdf_header_string= "Отчёт по записи №". $id. "\nиз файла " . $file->file_name;
        $pdf->setHeaderData('logo.jpg', 20, PDF_HEADER_TITLE, $pdf_header_string);

        // set header and footer fonts
        $pdf->setHeaderFont(['dejavusans', '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont(['dejavusans', '', PDF_FONT_SIZE_DATA]);

        // set default monospaced font
        $pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->setHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->setFooterMargin(PDF_MARGIN_FOOTER);

        // -------------------------------------------------------------------
        $pdf->SetFont('dejavusans', '', 14, '', true);
        // add a page
        $pdf->AddPage();
        $col = 30;
        $line = 10;

        $pdf->Cell( '', 30, $file->file_name, 0, 0, 'C' );
        $pdf->Ln();
        $pdf->Cell( $col, $line, 'ФИО', 0, 0, 'L' );
        $pdf->Cell( '', $line, $record->record_name, 1, 0, 'L' );
        $pdf->Ln();
        $pdf->Cell( $col, $line, 'телефон', 0, 0, 'L' );
        $pdf->Cell( '', $line, $record->record_phone, 1, 0, 'L' );
        $pdf->Ln();
        $pdf->Cell( $col, $line, 'Email', 0, 0, 'L' );
        $pdf->Cell( '', $line, $record->record_email, 1, 0, 'L' );
        $pdf->Ln();
        $pdf->Cell( $col, $line, 'Company', 0, 0, 'L' );
        $pdf->Cell( '', $line, $record->record_company, 1, 0, 'L' );
        $pdf->Ln();
        $pdf->Cell( $col, $line, 'City', 0, 0, 'L' );
        $pdf->Cell( '', $line, $record->record_city, 1, 0, 'L' );
        $pdf->Ln();
        $pdf->Cell( $col, $line, 'Region', 0, 0, 'L' );
        $pdf->Cell( '', $line, $record->record_region, 1, 0, 'L' );
        $pdf->Ln();
        $pdf->Cell( $col, $line, 'GUID', 0, 0, 'L' );
        $pdf->Cell( '', $line, $record->record_guid, 1, 0, 'L' );
        $pdf->Ln();

        // -------------------------------------------------------------------

        //Close and output PDF document
        $pdf->Output('example_xxx.pdf', 'I');
        return;
    }
}
