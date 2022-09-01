<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    
    /**
     * Show form for uploading and displaying Excel files.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return view('file_list');
    }
}
