<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    //
    protected $fillable = ['id','reservation_date','owner_name','owner_name_furigana',
        'animal_name','animal_type','tel','mailaddress','other'];

}
