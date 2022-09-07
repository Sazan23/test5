<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Files;
use App\Models\Records;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_STYLE_ALIGNMENT;
use PHPExcel_STYLE_FILL;
use PHPExcel_Style_NumberFormat;

class DownloadController extends Controller
{
    /**
     * Download summary report
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function download(Request $request, $id)
    {
        $file = Files::find($id);
        $records = Records::where('file_id', $id)->get();
        $name_count = DB::table('records')->where('file_id', $id)->count('record_name');
        $city_count = DB::table('records')->where('file_id', $id)->count('record_city');
        $region_count = DB::table('records')->where('file_id', $id)->count('record_region');

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->getProperties()->setCreator("Oleg Denisenko")
                    ->setLastModifiedBy("Oleg Denisenko")
                    ->setTitle("Office 2007 XLSX Test Document")
                    ->setSubject("Office 2007 XLSX Test Document")
                    ->setDescription("Test document for Office 2007 XLSX")
                    ->setKeywords("office 2007 openxml php")
                    ->setCategory("Test result file");

        $objPHPExcel->setActiveSheetIndex(0);
        $activeSheet = $objPHPExcel->getActiveSheet();

        $activeSheet->getColumnDimension('A')->setWidth(80);
        $activeSheet->getColumnDimension('B')->setWidth(10);
        $activeSheet->getColumnDimension('C')->setWidth(10);
        $activeSheet->getColumnDimension('D')->setWidth(10);

        $activeSheet->mergeCells('A2:D2');
        $activeSheet->setCellValue('A2', 'Сводный отчёт по загруженному файлу ' . $file->file_name);
        $style_header = [
            'font'=>[
                'bold' => true,
                'name' => 'Times New Roman',
                'size' => 20
            ],
            'alignment' => [
                'horizontal' => PHPExcel_STYLE_ALIGNMENT::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_STYLE_ALIGNMENT::VERTICAL_CENTER,
            ],
            'fill' => [
                'type' => PHPExcel_STYLE_FILL::FILL_SOLID,
                'color'=>['rgb' => 'CFCFCF']
            ],
        ];
        $activeSheet->getStyle('A2:D2')->applyFromArray($style_header);

        $activeSheet->setCellValue('A4', 'Общее количество зарегистрированных пользователей')
                    ->setCellValue('B4', (string)$name_count);

        $activeSheet->setCellValue('A5', 'Общее количество городов')
                    ->setCellValue('B5', (string)$city_count);

        $activeSheet->setCellValue('A6', 'Общее количество регионов')
                    ->setCellValue('B6', (string)$region_count);

        $activeSheet->mergeCells('B8:D8');
        $date = date("d.m.Y H:i:s");
        $activeSheet->setCellValue('A8', 'Дата и время формирования отчёта');
        $activeSheet->setCellValue('B8', $date);
        $activeSheet->getStyle('B8')
                    ->getNumberFormat()
                    ->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX14);

        $activeSheet->setTitle('Сводный отчёт');
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="order_' . $date . '.xlsx"');
        header('Cache-Control: max-age=0');

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');

        return;
    }
}
