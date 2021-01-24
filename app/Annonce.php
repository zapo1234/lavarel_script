<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annonce extends Model
{
    //

    protected $table = 'annonce';


    public function categorie() {

     return $this->belongsTo(Categories::class);
    }
}
