<?php

namespace App\Utility;

use App\Models\Files;
use App\Models\Records;
use PHPExcel_IOFactory;
use Illuminate\Support\Facades\Storage;

class FileUploader
{
    /**
     * Setting default settings
     * 
     * @param  Illuminate\Http\UploadedFile  $file
     */
    public function __construct($file) {
        $this->file = $file;
        $this->upload_folder = 'files';
        $this->name = $file->getClientOriginalName();
        $this->hash_name = $file->hashName();
        Storage::putFile($this->upload_folder, $this->file);
    }

    /**
     * Get content from uploaded excel file
     * 
     * @return void
     */
    public function uploadXLSfile(){
        $model_file = new Files;
        $model_file->file_name = $this->name;
        $model_file->file_hash = $this->hash_name;
        $model_file->save();
        $file_id = $model_file->id;
        $storagePath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();
        $full_path = $storagePath . $this->upload_folder . DIRECTORY_SEPARATOR . $this->hash_name;
        $reader = PHPExcel_IOFactory::createReader(PHPExcel_IOFactory::identify($full_path));
        $content = $reader->load($full_path);
        $this->contentToDB($content, $file_id);
    }

    /**
     * Loading content into the database
     * 
     * @return void
     */
    private function contentToDB($content, $file_id){
        foreach($content->getWorksheetIterator() as $worksheet) {
            $lists[] = $worksheet->toArray();
        }

        foreach($lists as $list) {
            foreach ($list as $key => $row) {
                if ($key === 0) continue;
                if ( $this->isEmptyRow($row) ) continue;
                $record = new Records();
                $record->file_id = $file_id;
                $record->record_name = $row[0];
                $record->record_phone = $row[1];
                $record->record_email = $row[2];
                $record->record_date = date('Y-m-d', strtotime($row[3]));
                $record->record_company = $row[4];
                $record->record_city  = $row[5];
                $record->record_region = $row[6];
                $record->save();
            }
        }
    }

    /**
     * Checks if the given row is not empty
     * 
     * @param  array  $row
     * @return boolean
     */
    private function isEmptyRow($row) {
        $res = true;
        for ($i = 0; $i <= 6; $i++) {
           if ($row[$i] !== null) $res = false;
        }

        return $res;
    }
}