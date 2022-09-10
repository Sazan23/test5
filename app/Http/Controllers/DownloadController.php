<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utility\PHPExcel_Utils;
use App\Utility\TCPDF_Outer;

class DownloadController extends Controller
{
    /**
     * Download summary report
     *
     * @param  string  $id
     * @return void
     */
    public function downloadXLS($id)
    {
        PHPExcel_Utils::formationXLS_Report($id);
    }

    /**
     * Download single record report
     *
     * @param  string  $file_id
     * @param  string  $id
     * @return void
     */
    public function downloadPDF_record($file_id, $id)
    {
        $pdf = new TCPDF_Outer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');
        $pdf->singleRecordReport($file_id, $id);
    }

    /**
     * Download full record report
     *
     * @param  string  $file_id
     * @return void
     */
    public function downloadPDF_fullReport($file_id)
    {
        $pdf = new TCPDF_Outer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');
        $pdf->fullRecordReport($file_id);
    }
}
