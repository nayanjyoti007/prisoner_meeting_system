<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeetingRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationship: A MeetingRequest belongs to a Visitor
    public function visitor()
    {
        return $this->belongsTo(Visitor::class, 'visitor_id');
    }

    // Relationship: A MeetingRequest belongs to a Prisoner
    public function prisoner()
    {
        return $this->belongsTo(Prisoner::class, 'prisoner_id');
    }

    // Relationship: A MeetingRequest belongs to a Jail
    public function jail()
    {
        return $this->belongsTo(Jail::class, 'jail_id');
    }
}
