<?php

namespace App\Http\Controllers;

use App\Models\Files;
use App\Models\Records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPExcel_IOFactory;

class UploadController extends Controller
{
    /**
     * 
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if ($request->isMethod('post') && $request->file('xls_file')) {
            $file = $request->file('xls_file');
            $upload_folder =  'files';
            $name = $file->getClientOriginalName();
            $hash_name = $file->hashName();
            Storage::putFile($upload_folder, $file);
            $model_file = new Files;
            $model_file->file_name = $name;
            $model_file->file_hash = $hash_name;
            $model_file->save();
            $file_id = $model_file->id;
            $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
            $full_path = $storagePath . $upload_folder . DIRECTORY_SEPARATOR . $hash_name;
            $reader = PHPExcel_IOFactory::createReader(PHPExcel_IOFactory::identify($full_path));
            $content = $reader->load($full_path);
            foreach($content->getWorksheetIterator() as $worksheet) {
                $lists[] = $worksheet->toArray();
            }

            foreach($lists as $list) {
                foreach ($list as $key => $row) {
                    if ($key === 0) continue;
                    if (   $row[0] === null
                        && $row[1] === null
                        && $row[2] === null
                        && $row[3] === null
                        && $row[4] === null
                        && $row[5] === null
                        && $row[6] === null
                        && $row[7] === null ) continue;
                    $record = new Records();
                    $record->file_id = $file_id;
                    $record->record_name = $row[0];
                    $record->record_phone = $row[1];
                    $record->record_email = $row[2];
                    $record->record_date = date('d.m.Y', strtotime($row[3]));
                    $record->record_company = $row[4];
                    $record->record_city  = $row[5];
                    $record->record_region = $row[6];
                    $record->record_guid = $row[7];
                    $record->save();
                }
            }
            return redirect('list');
        }
        return redirect('home');
    }
}
