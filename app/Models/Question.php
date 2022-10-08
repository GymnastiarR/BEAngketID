<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function form(){
        return $this->belongsTo(Form::class);
    }

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function answears(){
        return $this->hasMany(Answear::class);
    }

}
