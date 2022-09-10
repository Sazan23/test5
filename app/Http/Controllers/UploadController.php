<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Utility\FileUploader;

class UploadController extends Controller
{
    /**
     * Upload file to server
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
        if ($request->isMethod('post') && $request->file('xls_file')) {
            $file = $request->file('xls_file');
            $file_uploader = new FileUploader($file);
            $file_uploader->uploadXLSfile();
            return redirect('list');
        }
        return redirect('home');
    }
}
