<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

session_start();

class CartController extends Controller
{
    public function add_cart_ajax(Request $request)
    {
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0,13), 5);

        $cart = $request->session()->get('cart');

        if ($cart == true) {

            $is_available = 0;

            foreach ($cart as $key => $val) {

                // ============================
                // FIX QUAN TRỌNG: CHECK CẢ SIZE
                // ============================
                if (
                    $val['product_id'] == $data['cart_product_id'] &&
                    $val['product_size'] == $data['cart_product_size']
                ) {
                    $is_available++;
                    $cart[$key]['product_qty'] += $data['cart_product_qty'];
                }
            }

            // Nếu không trùng → thêm mới
            if ($is_available == 0) {
                $cart[] = array(
                    'session_id'        => $session_id,
                    'product_name'      => $data['cart_product_name'],
                    'product_id'        => $data['cart_product_id'],
                    'product_image'     => $data['cart_product_image'],
                    'product_qty'       => $data['cart_product_qty'],
                    'product_price'     => $data['cart_product_price'],
                    'product_tong'  => $data['cart_product_quantity'], // FIX
                    'product_size'      => $data['cart_product_size'],
                );
            }

            session()->put('cart', $cart);
        } 
        else {
            // Giỏ hàng chưa tồn tại → tạo mới
            $cart[] = array(
                'session_id'        => $session_id,
                'product_name'      => $data['cart_product_name'],
                'product_id'        => $data['cart_product_id'],
                'product_image'     => $data['cart_product_image'],
                'product_qty'       => $data['cart_product_qty'],
                'product_price'     => $data['cart_product_price'],
                'product_tong'  => $data['cart_product_quantity'], // FIX
                'product_size'      => $data['cart_product_size'],
            );

            session()->put('cart', $cart);
        }

        session()->save();
    }

    public function show_cart_ajax(Request $request)
    {
        $cate_product = DB::table('tbl_category_product')
                        ->where('category_status','0')
                        ->orderBy('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand_product')
                        ->where('brand_status','0')
                        ->orderBy('brand_id','desc')->get();

        return view('pages.cart.cart_ajax')
                ->with('categorys', $cate_product)
                ->with('brands', $brand_product)
                ->with('meta_desc', 'Giỏ hàng ajxax')
                ->with('meta_keywords', 'Giỏ hàng shop Mrdũng')
                ->with('meta_title', 'Giỏ hàng ajxax')
                ->with('url_canonnial', $request->url());
    }

    public function delete_cart($session_id)
    {
        $cart = session()->get('cart');

        if ($cart) {
            foreach ($cart as $key => $val) {
                if ($val['session_id'] == $session_id) {
                    unset($cart[$key]);
                }
            }

            session()->put('cart', $cart);
            return Redirect::to('/giohang')->with('message', 'xóa thành công!');
        }

        return Redirect::to('/giohang')->with('message', 'Xóa không thành công!');
    }

    public function update_cart(Request $request)
    {
        $data = $request->all();
        $cart = session()->get('cart');

        if ($cart == true) {

            // cập nhật số lượng
            foreach ($data['cart_qty'] as $key => $qty) {
                foreach ($cart as $session => $val) {
                    if ($val['session_id'] == $key) {
                        $cart[$session]['product_qty'] = $qty;
                    }
                }
            }

            // cập nhật size
            foreach ($data['cart_size'] as $key => $size) {
                foreach ($cart as $session => $val) {
                    if ($val['session_id'] == $key) {
                        $cart[$session]['product_size'] = $size;
                    }
                }
            }

            session()->put('cart', $cart);
            return Redirect()->back()->with('message', 'Cập nhật thành công!');
        }

        return Redirect()->back()->with('message', 'Cập nhật không thành công!');
    }
}
