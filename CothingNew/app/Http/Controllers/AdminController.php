<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Redirect;
session_start();
class AdminController extends Controller

{
    public function index() {
        return view('login_admin');
    }
    public function show_dashboard() {
       $tongquan=DB::table('tbl_product')->orderBy('product_id','asc')->get();
       $qty_category=DB::table('tbl_product')->join('tbl_category_product','tbl_category_product.category_id',"=",'tbl_product.category_id')->get();
        return view('admin.dashboard')->with(compact('tongquan','qty_category'));
    }
    public function dashboard(Request $request) {
        $admin_email = $request->admin_email;
        $admin_password = $request->admin_password;

        $result = DB::table('tbl_admin')->first();
        $pass=$result->admin_password;
        $admin_emaildt=$result->admin_email;
        // dd($pass);
        if($admin_email==$admin_emaildt){
            if(password_verify($admin_password, $pass)){
    
                Session()->put('admin_name', $result->admin_name);
                Session()->put('admin_id', $result->admin_id);
                 return Redirect::to('/dashboard');
            }
            else{
                Session()->put('message', 'Mật khẩu hoặc tài khoản sai!');
                return Redirect::to('/admin');
            }
        }
        else{
            Session()->put('message', 'Mật khẩu hoặc tài khoản sai!');
            return Redirect::to('/admin');
        }
        
    }
    public function logout() {

        return view('login_admin');

    }
}
