<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $fillable=['name','description','image','section_id','year','chapter','type'];

    public function lectuers(){
      return  $this->hasMany(Lecture::class);
    }

    public function sections(){
       return  $this->belongsTo(Section::class);
    }
}
