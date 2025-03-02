<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistrictMaster extends Model
{
    use HasFactory;

    public function centers()
    {
        return $this->hasMany(Center::class, 'dist_id', 'id');
    }


    public function externalRecords()
    {
        return $this->hasMany(External::class, 'dist_id', 'id');
    }
}
