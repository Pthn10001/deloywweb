<?php

namespace App\Http\Controllers;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;


class CategoryProduct extends Controller
{
    public function AuthLogin(){
        $admin_id=Session()->get('admin_id');
        if($admin_id)
        return redirect::to('/dashboard');
        else
        return redirect::to('/admin')->send();

    }
    public function add_category_product(){
        $this->AuthLogin();
        return view('/admin.add_category_product');
    }

    public function all_category_product(){
        $this->AuthLogin();
        $all_category_product = DB::table('tbl_category_product')->orderBy('category_id','desc')->paginate(8);
        $manager_category_product =view('admin.all_category_product')->with('all_category_product', $all_category_product);

        return view('admin_layout')->with('admin.all_category_product',$manager_category_product);
    }
    public function save_category_product(Request $request){
        $data = array();
        $data['category_name'] =$request->category_product_name;
        $data['category_desc'] =$request->category_product_desc;
        $data['category_status'] =$request->category_product_status;
        $data['meta_keyword'] =$request->category_meta_keyword;
        $data['slug_category_product'] =$request->slug_category_product;

        DB::table('tbl_category_product')->insert($data);
        $request->session()->put('message', 'them thanh công');
        return Redirect::to('add-category-product');
    }
    public function unactive_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>1]);
        session()->put('message','Kích hoạt thành công');
         return redirect::to('all-category-product');

    }
    public function active_category_product($category_product_id){
        $this->AuthLogin();
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status'=>0]);
        session()->put('message','Hủy kích hoạt thành công');
         return redirect::to('all-category-product');

    }
    public function edit_category_product($category_product_id){
        $this->AuthLogin();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
        $manager_category_product =view('admin.edit_category_product')->with('edit_category_product', $edit_category_product);

        return view('admin_layout')->with('admin.edit_category_product',$manager_category_product);
    }
    public function update_category_product(Request $request, $category_product_id)
    {
        $this->AuthLogin();
        $data=array();
        $data['category_name'] =$request->category_product_name;
        $data['category_desc'] =$request->category_product_desc;
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        $request->session()->put('message', 'Cập nhật thành công');
        return Redirect::to('all-category-product');
    }
    public function delete_category_product($category_product_id){
        $this->AuthLogin();
       DB::table('tbl_category_product')->where('category_id',$category_product_id)->delete();
       session()->put('message',' Xóa thành công');
       return Redirect::to('all-category-product');
    }
    // End page admin

    public function showCategoryhome(Request $request,$slug_category_product){
        $cate_product=DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','asc')->get();
        $brand_product=DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','asc')->get();

        $category_by_id=DB::table('tbl_product')->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')
        ->where('tbl_category_product.slug_category_product',$slug_category_product)->get();
        foreach($category_by_id as $val){
            $meta_desc= $val->category_desc;
            $meta_keywords = $val->meta_keyword;
            $meta_title = $val->category_name;
            $url_canonnial=$request->url();
        }
        $category_name=DB::table('tbl_category_product')->where('tbl_category_product.slug_category_product',$slug_category_product)->get();
        return view('pages.show_category')->with('categorys',$cate_product)->with('brands',$brand_product)->with(
            'category_by_id',$category_by_id)->with('category_name',$category_name) ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonnial',$url_canonnial);
    }
}
