<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;

class BrandProduct extends Controller
{
    public function AuthLogin(){
        $admin_id=Session()->get('admin_id');
        if($admin_id)
        return redirect::to('/dashboard');
        else
        return redirect::to('/admin')->send();

    }
    public function add_brand_product(){
        $this->AuthLogin();
        return view('/admin.add_brand_product');
    }

    public function all_brand_product(){
        $this->AuthLogin();
        // $all_brand_product = DB::table('tbl_brand_product')->get();
        $all_brand_product=Brand::orderBy('brand_id','asc')->paginate(8);
        $manager_brand_product =view('admin.all_brand_product')->with('all_brand_product', $all_brand_product);

        return view('admin_layout')->with('admin.all_brand_product',$manager_brand_product);
    }
    public function save_brand_product(Request $request){
        $data=$request ->all();
        $brand=new Brand();
        $brand->brand_name=$data['brand_product_name'];
        $brand->brand_desc= $data['brand_product_desc'];
        $brand->brand_status= $data['brand_product_status'];
        $brand->meta_keyword=$data['meta_keyword'];
        $brand->slug_brand_product= $data['slug_brand_product'];
        $brand->save();
        $request->session()->put('message', 'them thanh công');
        return Redirect::to('add-brand-product');
    }
    public function unactive_brand_product($brand_product_id){
        $this->AuthLogin();
        Brand::where('brand_id',$brand_product_id)->update(['brand_status'=>1]);
        session()->put('message','Hủy kích hoạt thành công');
         return redirect::to('all-brand-product');

    }
    public function active_brand_product($brand_product_id){
        $this->AuthLogin();
       Brand::where('brand_id',$brand_product_id)->update(['brand_status'=>0]);
        session()->put('message',' Kích hoạt thành công');
         return redirect::to('all-brand-product');

    }
    public function edit_brand_product($brand_product_id){
        $this->AuthLogin();
        $edit_brand_product = Brand::find($brand_product_id);
        $manager_brand_product =view('admin.edit_brand_product')->with('edit_brand_product', $edit_brand_product);

        return view('admin_layout')->with('admin.edit_brand_product',$manager_brand_product);
    }
    public function update_brand_product(Request $request, $brand_product_id)
    {
        $this->AuthLogin();
        $data=$request ->all();
        $brand= Brand::find($brand_product_id);
        $brand->brand_name=$data['brand_product_name'];
        $brand->brand_desc= $data['brand_product_desc'];
        $brand->save();
        $request->session()->put('message', 'Cập nhật thành công');
        return Redirect::to('all-brand-product');
    }
    public function delete_brand_product($brand_product_id){
        $this->AuthLogin();
        Brand::where('brand_id',$brand_product_id)->delete();
       session()->put('message',' Xóa thành công');
       return Redirect::to('all-brand-product');
    }

    //End category admin
    public function showBrandhome(Request $request,$brand_id){
        $cate_product=DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','asc')->get();
        $brand_product=Brand::where('brand_status','0')->orderBy('brand_id','asc')->get();
        $brand_by_id=DB::table('tbl_product')->join('tbl_brand_product','tbl_product.brand_id','=','tbl_brand_product.brand_id')
        ->where('tbl_product.brand_id',$brand_id)->get();
        foreach($brand_by_id as $val){
            $meta_desc= $val->brand_desc;
            $meta_keywords = $val->meta_keyword;
            $meta_title = $val->brand_name;
            $url_canonnial=$request->url();
        }

        $brand_name=Brand::where('tbl_brand_product.brand_id',$brand_id)->get();
        return view('pages.show_brand')->with('categorys',$cate_product)->with('brands',$brand_product)->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonnial',$url_canonnial);
    }
}
