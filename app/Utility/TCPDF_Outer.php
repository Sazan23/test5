<?php

namespace App\Utility;

use App\Models\Files;
use App\Models\Records;
use TCPDF;

class TCPDF_Outer extends TCPDF
{
    public function __construct( $orientation, $unit, $format ) {
        parent::__construct( $orientation, $unit, $format, true, 'UTF-8', false );

        $this->setCreator(PDF_CREATOR);
        $this->setAuthor('Oleg Denisenko');
        $this->setTitle('TCPDF Example 009');
        $this->setSubject('TCPDF Tutorial');
        $this->setKeywords('TCPDF, PDF, example, test, guide');

        $header_string= "Ad poenitendum properat, cito qui judicat. \nActum atque tractatum.";
        $this->setHeaderData('logo.jpg', 20, PDF_HEADER_TITLE, $header_string);

        $this->setHeaderFont(['dejavusans', '', PDF_FONT_SIZE_MAIN]);
        $this->setFooterFont(['dejavusans', '', PDF_FONT_SIZE_DATA]);

        $this->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        $this->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $this->setHeaderMargin(PDF_MARGIN_HEADER);
        $this->setFooterMargin(PDF_MARGIN_FOOTER);
    }

    public function singleRecordReport($file_id, $id) {
        $file = Files::find($file_id);
        $record = Records::where('file_id', $file_id)
                         ->where('id', $id)
                         ->first();
        $this->sheetСontentGeneration($file, $record);
        $this->generatePDF('singleRecordReport_' . $id . '.pdf');
    }

    public function fullRecordReport($file_id) {
        $file = Files::find($file_id);
        $records = Files::find($file_id)->records;
        foreach ($records as $record) {
            $this->sheetСontentGeneration($file, $record);
        }
        $this->generatePDF('fullRecordReport.pdf');
    }

    private function sheetСontentGeneration($file, $record) {
        $col = 30;
        $line = 10;        
        $this->SetFont('dejavusans', '', 14, '', true);
        $this->AddPage();
        $this->Cell( '', 30, $file->file_name, 0, 0, 'C' );
        $this->Ln();
        $this->Cell( $col, $line, 'ФИО', 0, 0, 'L' );
        $this->Cell( '', $line, $record->record_name, 1, 0, 'L' );
        $this->Ln();
        $this->Cell( $col, $line, 'телефон', 0, 0, 'L' );
        $this->Cell( '', $line, $record->record_phone, 1, 0, 'L' );
        $this->Ln();
        $this->Cell( $col, $line, 'Email', 0, 0, 'L' );
        $this->Cell( '', $line, $record->record_email, 1, 0, 'L' );
        $this->Ln();
        $this->Cell( $col, $line, 'Company', 0, 0, 'L' );
        $this->Cell( '', $line, $record->record_company, 1, 0, 'L' );
        $this->Ln();
        $this->Cell( $col, $line, 'City', 0, 0, 'L' );
        $this->Cell( '', $line, $record->record_city, 1, 0, 'L' );
        $this->Ln();
        $this->Cell( $col, $line, 'Region', 0, 0, 'L' );
        $this->Cell( '', $line, $record->record_region, 1, 0, 'L' );
        $this->Ln();
        $this->Cell( $col, $line, 'GUID', 0, 0, 'L' );
        $this->Cell( '', $line, $record->record_guid, 1, 0, 'L' );
        $this->Ln();
    }
    
    private function generatePDF(string $file_name) {
        $this->Output($file_name, 'I');
        return;
    }
}