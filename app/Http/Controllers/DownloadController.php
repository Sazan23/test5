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
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function downloadXLS(Request $request, $id)
    {
        PHPExcel_Utils::formationXLS_Report($id);
    }

    /**
     * Download single record report
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function downloadPDF_record(Request $request, $file_id, $id)
    {
        $pdf = new TCPDF_Outer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');
        $pdf->singleRecordReport($file_id, $id);
    }

    /**
     * Download full record report
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function downloadPDF_fullReport(Request $request, $file_id)
    {
        $pdf = new TCPDF_Outer(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8');
        $pdf->fullRecordReport($file_id);
    }
}
