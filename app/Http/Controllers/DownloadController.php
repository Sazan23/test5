<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Files;
use App\Models\Records;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_STYLE_ALIGNMENT;
use PHPExcel_STYLE_FILL;
use PHPExcel_Style_Border;

class DownloadController extends Controller
{
    /**
     * 
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, $id)
    {
        $file = Files::where(['id'=>$id])->get();;
        $records = Records::where('file_id', $id)->get();

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                    ->setLastModifiedBy("Maarten Balliauw")
                    ->setTitle("Office 2007 XLSX Test Document")
                    ->setSubject("Office 2007 XLSX Test Document")
                    ->setDescription("Test document for Office 2007 XLSX")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Test result file");

        $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet = $objPHPExcel->getActiveSheet();


        $activeSheet->mergeCells('A2:D2');
        $activeSheet->setCellValue('A2','Сводный отчёт по загруженному файлу');
        $style_header = [
            //шрифт
            'font'=>[
                'bold' => true,
                'name' => 'Times New Roman',
                'size' => 20
            ],
            //выравнивание
            'alignment' => [
                'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
            ],
            //заполнение цветом
            'fill' => [
                'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
                'color'=>['rgb' => 'CFCFCF']
            ],
        ];
        $activeSheet->getStyle('A2:D2')->applyFromArray($style_header);



        // Add some data, resembling some different data types
        $activeSheet->setCellValue('A3', 'String')
                    ->setCellValue('B3', 'UTF-8')
                    ->setCellValue('C3', 'Создать MS Excel Книги из PHP скриптов');

        $activeSheet->setCellValue('A4', 'Number')
                    ->setCellValue('B4', 'Integer')
                    ->setCellValue('C4', '12');

        $activeSheet->setCellValue('A5', 'Number')
                    ->setCellValue('B5', 'Float')
                    ->setCellValue('C5', '34.56');

        $activeSheet->setCellValue('A6', 'Number')
                    ->setCellValue('B6', 'Negative')
                    ->setCellValue('C6', '-7.89');

        $activeSheet->setCellValue('A7', 'Boolean')
                    ->setCellValue('B7', 'True')
                    ->setCellValue('C7', 'true');

        $activeSheet->setCellValue('A8', 'Boolean')
                    ->setCellValue('B8', 'False')
                    ->setCellValue('C8', 'false');

        $dateTimeNow = time();
        //$activeSheet->setCellValue('A9', 'Date/Time')
        //                            ->setCellValue('B9', 'Date')
        //                            ->setCellValue('C9', PHPExcel_Shared_Date::PHPToExcel( $dateTimeNow ));
        //$activeSheet->getStyle('C9')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);

        //$activeSheet->setCellValue('A10', 'Date/Time')
        //                            ->setCellValue('B10', 'Time')
        //                            ->setCellValue('C10', PHPExcel_Shared_Date::PHPToExcel( $dateTimeNow ));
        //$activeSheet->getStyle('C10')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_TIME4);

        //$activeSheet->setCellValue('A11', 'Date/Time')
        //            ->setCellValue('B11', 'Date and Time')
        //            ->setCellValue('C11', PHPExcel_Shared_Date::PHPToExcel( $dateTimeNow ));
        //$activeSheet->getStyle('C11')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_DATETIME);


        $activeSheet->setTitle('Сводный отчёт');
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="01simple.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        return;
    }
}
