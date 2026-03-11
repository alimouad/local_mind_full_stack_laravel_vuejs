<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    //
     protected $fillable = [
       
    ]; 

    public function user(){
        return $this->belongsTo(Question::class);
    }

    public function questions(){
        return $this->belongsTo(User::class);
    }
}
