<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    use HasFactory;
    protected $fillable=[
        'file','name','subject_id'
    ];

    public function subjects(){
        return  $this->belongsTo(Subject::class);
      }
}
