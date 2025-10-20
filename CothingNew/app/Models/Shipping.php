<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    public $timestamps=false;
    protected $fillable = ['shipping_email','shipping_name','shipping_phone','shipping_address','shipping_notes','payment_method'];
    protected $primaryKey = 'shipping_id';
    protected $table = 'tbl_shipping';
}
