<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps=false;
    protected $fillable = ['product_name','product_id','product_price','order_code','product_sales_qty','product_size'];
    protected $primaryKey = 'order_detail_id';
    protected $table = 'tbl_details_id';
    public function product(){
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
