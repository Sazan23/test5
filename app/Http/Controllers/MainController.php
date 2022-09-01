<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Files;

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
}
