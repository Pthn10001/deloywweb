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
    public function blog(Request $request)
    {
    $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
    $brand_product = DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','desc')->get();

    $meta_desc = 'Blog thời trang';
    $meta_keywords = 'blog, tin tức thời trang, xu hướng mới';
    $meta_title = 'Tin tức - Blog thời trang MrDung';
    $url_canonnial = $request->url();

    // Nếu có bảng blog trong database thì bạn có thể fetch:
    // $posts = DB::table('tbl_blog')->orderBy('created_at','desc')->get();
    // Tạm thời demo dữ liệu tĩnh:
    $posts = [
        [
            'title' => 'Top xu hướng thời trang nam 2025',
            'image' => 'assets/img/blog/blog1.jpg',
            'summary' => 'Khám phá những phong cách mới giúp bạn nổi bật trong năm 2025...',
            'link' => '#'
        ],
        [
            'title' => 'Bí quyết phối đồ đơn giản mà tinh tế',
            'image' => 'assets/img/blog/blog2.jpg',
            'summary' => 'Chỉ cần một vài mẹo nhỏ, set đồ của bạn sẽ trở nên hoàn hảo hơn...',
            'link' => '#'
        ],
        [
            'title' => 'Cách chọn áo thun phù hợp với dáng người',
            'image' => 'assets/img/blog/blog3.jpg',
            'summary' => 'Không phải ai cũng biết chọn áo thun giúp tôn dáng – xem ngay bài viết này!',
            'link' => '#'
        ],
    ];

    return view('pages.blog.index')
        ->with('categorys', $cate_product)
        ->with('brands', $brand_product)
        ->with('meta_desc', $meta_desc)
        ->with('meta_keywords', $meta_keywords)
        ->with('meta_title', $meta_title)
        ->with('url_canonnial', $url_canonnial)
        ->with('posts', $posts);
}

}
