<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    protected $fillable = [
        'name'
    ];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function subjects(){
        return $this->hasMany(Subject::class);
    }
}
