<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $timestamps=false;
    protected $fillable = ['product_name','	product_desc','product_price','category_id','brand_id','product_image','product_content','product_status','product_quantity'];
    protected $primaryKey = 'product_id';
    protected $table = 'tbl_product';
}
