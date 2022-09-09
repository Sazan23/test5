<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Files;
use Illuminate\Support\Facades\DB;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_STYLE_ALIGNMENT;
use PHPExcel_STYLE_FILL;
use PHPExcel_Style_NumberFormat;

class Records extends Model
{
    use HasFactory;
}
