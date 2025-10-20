<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Session\Session;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\OrderDetail;

session_start();
class CheckoutController extends Controller
{

    public function AuthLogin(){
        $admin_id=Session()->get('admin_id');
        if($admin_id)
        return redirect::to('/dashboard');
        else
        return redirect::to('/admin')->send();

    }
    public function login_checkout(Request $request){
        $cate_product=DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','desc')->get();
        
        $meta_desc= 'Login_checkout';
        $meta_keywords = 'Login_checkout shop Mrdũng';
        $meta_title = 'Login_checkout';
        $url_canonnial=$request->url();
        return view('pages.checkout.login_checkout')->with('categorys',$cate_product)->with('brands',$brand_product)
     ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonnial',$url_canonnial);
    }       


    public function add_customer(Request $request){
        $data= array();
        $data['customer_id']=$request->customer_id;
        $data['customer_name']=$request->customer_name;
        $data['customer_email']=$request->customer_email;
        $data['customer_password']=password_hash($request->customer_password, PASSWORD_DEFAULT);
        $data['customer_phone']=$request->customer_phone;
        $customer_id=DB::table('tbl_customer')->insertGetId($data);
        $request->Session()->put('customer_id',$customer_id);
        $request->Session()->put('customer_name',$request->customer_name);

        return Redirect::to('/checkout');
    }
    public function checkout(Request $request){
        $cate_product=DB::table('tbl_category_product')->where('category_status','0')->orderBy('category_id','desc')->get();
        $brand_product=DB::table('tbl_brand_product')->where('brand_status','0')->orderBy('brand_id','desc')->get();
        $meta_desc= 'Checkout';
        $meta_keywords = 'Checkout shop Mrdũng';
        $meta_title = 'Checkout';
        $url_canonnial=$request->url();
        return view('pages.checkout.checkout')->with('categorys',$cate_product)->with('brands',$brand_product)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonnial',$url_canonnial);
    }

   
    public function order(Request $request){
        $data=$request->all();
        $shipping = new Shipping();
        $shipping->shipping_name= $data['shipping_name'];
        $shipping->shipping_phone= $data['shipping_phone'];
        $shipping->shipping_email= $data['shipping_email'];
        $shipping->shipping_address= $data['shipping_address'];
        $shipping->shipping_notes= $data['shipping_notes'];
        $shipping->payment_method= $data['payment_method'];
        $shipping->save();
        $shipping_id=$shipping->shipping_id;
        
        $checkout_code=substr(md5(microtime()),rand(0,24),5);

        $order= new Order();
        $order->customer_id=session()->get('customer_id');
        $order->shipping_id=$shipping_id;
        $order->order_status=1;
        $order->order_code=$checkout_code;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $order->created_at=now();        
        $order->save();  
        if(session()->get('cart')==true){
            foreach(session()->get('cart') as $key =>$cart){ 
                    $order_detail= new OrderDetail();
                    $order_detail->order_code=$checkout_code;
                    $order_detail->product_id=$cart["product_id"];
                    $order_detail->product_name=$cart["product_name"];
                    $order_detail->product_price=$cart["product_price"];
                    $order_detail->product_sales_qty=$cart["product_qty"];
                    $order_detail->product_size=$cart["product_size"]; 
                    $order_detail->save();
            }
        }
        Session()->forget('cart');
    }
     
    public function logout_checkout(){
        Session()->flush();
        return Redirect::to('/login-checkout');
    }
    public function login_customer(Request $request){
        session()->get('cart');

        $email=$request->email_accout;
        $password=$request->password_accout;
        $result =DB::table('tbl_customer')->where('customer_email',$email)->first();
        $passworddt=$result->customer_password;
        $emaildt=$result->customer_email;
        if($email==$emaildt){
            if(password_verify($password,$passworddt)){ 
                $request->session()->put('customer_id',$result->customer_id);
                return Redirect('/checkout');
            }
            else{
                Session()->put('message','Tên tài khoản hoặc mật khẩu sai!');
                return Redirect::to('/login-checkout');
    
            }      
        }else{
            Session()->put('message','Tên tài khoản hoặc mật khẩu sai!');
            return Redirect::to('/login-checkout');
        }
    }  
}
