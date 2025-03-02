<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jail extends Model
{
    use HasFactory;

    public function visitors()
    {
        return $this->hasMany(Visitor::class, 'jailer_id', 'id');
    }
}
