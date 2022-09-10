<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Files;
use App\Models\Records;

class MainController extends Controller
{
    
    /**
     * Show form for uploading and displaying Excel files.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $files = new Files();
        return view('file_list', ['files'=>$files->all()]);
    }
    
    /**
     * Show form for uploading and displaying Excel files.
     * 
     * @param  int  $file_id
     * @return \Illuminate\Http\Response
     */
    public function records($file_id)
    {
        $file = Files::where(['id'=>$file_id])->get();
        $records = Records::where('file_id', $file_id)->get();
        return view('records', ['records'=>$records, 'file'=>$file[0]] );
    }
}
