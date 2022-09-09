<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Records;

class Files extends Model
{
    use HasFactory;

    /**
     * Get all records of a file.
     */
    public function records()
    {
        return $this->hasMany(Records::class, 'file_id');
    }
}
