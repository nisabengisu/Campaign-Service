<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    protected $table= 'basket';
    public $timestamps= false;
    protected $guarded= ['id'];
}
