<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    public function send_mail(){
        $to_name='trananhdung';
        $to_email='tadung.20it8@vku.udn.vn';
        $data=array('name'=>'mail  từ MrDũng','body'=>'vd');
        Mail::send('pages.send_mail',$data,function ($messaage) use($to_name,$to_email){
            $messaage->to($to_email)->subject('test');
            $messaage->to($to_email,$to_name);
        });
        return Redirect('/');
    }
    public function index(Request $request){
        $meta_desc='MrDung Shop Quần Áo Và Phụ Kiện Thời Trang Nam Nữ Đẹp Chuyên Các Dòng Áo Khoác, Quần Áo Nam Nữ Đẹp Được Ưa Chuộng Của Giới Trẻ.';
        $meta_keywords ='quan ao dep, quan ao nam, quan ao nu';
        $meta_title ='MrDung Shop Quần Áo Và Phụ Kiện Thời Trang';
        $url_canonnial=$request->url();

        $cate_product=DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','asc')->get();
        $brand_product=DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','asc')->get();
        $all_product=DB::table('tbl_product')->where('product_status','0')->orderBy('product_id','desc')->paginate(8);
        return view('pages.home')->with('categorys',$cate_product)->with('brands',$brand_product)->with('products',$all_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonnial',$url_canonnial);
    }
    public function search(Request $request){
        $keywords=$request->submit_keyword;
        $cate_product=DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','asc')->get();
        $brand_product=DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','asc')->get();
        $search_product=DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->limit(6)->get();
            $meta_desc= 'Tìm kiếm sản phẩm';
            $meta_keywords = 'Tìm kiếm sản phẩm';
            $meta_title = 'Tìm kiếm sản phẩm';
            $url_canonnial=$request->url();
        
            return view('pages.product.search')->with('categorys',$cate_product)->with('brands',$brand_product)->with('search_product',$search_product)
            ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonnial',$url_canonnial);

       

        
    }
}
