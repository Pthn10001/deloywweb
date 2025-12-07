<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shipping;
use App\Models\Customer;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function AuthLogin()
    {
        $admin_id = Session()->get('admin_id');
        if ($admin_id) {
            return Redirect::to('/dashboard');
        } else {
            return Redirect::to('/admin')->send();
        }
    }

    public function manager_order()
    {
        $this->AuthLogin();
        
        $query = Order::orderby('created_at', 'desc');
        
        // Filter by status
        if (request('status')) {
            $query->where('order_status', request('status'));
        }
        
        // Search by order code
        if (request('search')) {
            $query->where('order_code', 'like', '%' . request('search') . '%');
        }
        
        $order = $query->get();
        
        return view('admin.manager_order')->with(compact('order'));
    }

    public function view_order($order_code)
    {
        $order_details = OrderDetail::where('order_code', $order_code)->get();
        $order = Order::where('order_code', $order_code)->get();

        foreach ($order as $key => $ord) {
            $customer_id = $ord->customer_id;
            $shipping_id = $ord->shipping_id;
        }

        $customer = Customer::where('customer_id', $customer_id)->first();
        $shipping = Shipping::where('shipping_id', $shipping_id)->first();
        $order_detailss = OrderDetail::with('product')->where('order_code', $order_code)->get();

        return view('admin.view_order')->with(compact('order_details', 'customer', 'shipping', 'order_detailss', 'order'));
    }

    public function delete_order($order_id)
    {
        $this->AuthLogin();
        DB::table('tbl_order')->where('order_id', $order_id)->delete();
        session()->put('message', ' Xóa thành công');
        return Redirect::to('manager-order');
    }

    public function update_order(Request $request)
    {
        $data = $request->all();
        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();

        if ($order->order_status == 2) {
            foreach ($data['order_product_id'] as $key1 => $product_id) {
                $product = Product::find($product_id);
                $product_qty = $product->product_quantity;

                foreach ($data['quantity'] as $key2 => $qty) {
                    if ($key1 == $key2) {
                        $product_result = $product_qty - $qty;
                        $product->product_quantity = $product_result;
                        $product->save();
                    }
                }
            }
        } elseif ($order->order_status != 2 && $order->order_status != 3) {
            foreach ($data['order_product_id'] as $key1 => $product_id) {
                $product = Product::find($product_id);
                $product_qty = $product->product_quantity;

                foreach ($data['quantity'] as $key2 => $qty) {
                    if ($key1 == $key2) {
                        $product_result = $product_qty + $qty;
                        $product->product_quantity = $product_result;
                        $product->save();
                    }
                }
            }
        }
    }

    public function update_qty(Request $request)
    {
        $data = $request->all();
        $order_details = OrderDetail::where('product_id', $data['order_product_id'])
            ->where('order_code', $data['order_code'])->first();
        $order_details->product_sales_qty = $data['order_qty'];
        $order_details->save();
    }
    public function updateShipping(Request $request)
    {
        $request->validate([
            'order_code'       => 'required',
            'shipping_address' => 'required|string|max:255',
        ]);

        $order = Order::where('order_code', $request->order_code)->firstOrFail();
        $shipping = Shipping::findOrFail($order->shipping_id);

        $shipping->shipping_address = $request->shipping_address;
        $shipping->save();

        return response()->json(['message' => 'Cập nhật địa chỉ thành công']);
    }



    /* ======================= CUSTOMER VIEWS ======================= */

    // GET /orders — Lịch sử đơn của khách hiện đăng nhập
    public function order_history(Request $request)
    {
        $customer_id = session()->get('customer_id');
        if (!$customer_id) {
            return redirect('/login-checkout')->with('message', 'Vui lòng đăng nhập.');
        }

        try {
            $orders = Order::where('customer_id', $customer_id)
                ->orderBy('created_at', 'desc')
                ->get();

            // SEO meta cho layout
            return view('pages.order.history', compact('orders'))->with([
                'meta_desc'     => 'Lịch sử đơn hàng của tôi tại ShopClothing',
                'meta_keywords' => 'đơn hàng, lịch sử mua hàng, shopclothing',
                'meta_title'    => 'Đơn hàng của tôi',
                'url_canonical' => $request->url(),
            ]);
        } catch (\Exception $e) {
            \Log::error('order_history error: ' . $e->getMessage());
            return view('pages.order.history', ['orders' => []])
                ->with('meta_desc', 'Lịch sử đơn hàng')
                ->with('meta_keywords', 'đơn hàng')
                ->with('meta_title', 'Đơn hàng của tôi')
                ->with('url_canonical', $request->url());
        }
    }

    // GET /orders/{order_code} — Chi tiết đơn (thuộc về khách hiện đăng nhập)
    public function order_detail(Request $request, $order_code)
    {
        $customer_id = session()->get('customer_id');
        if (!$customer_id) {
            return redirect('/login-checkout')->with('message', 'Vui lòng đăng nhập.');
        }

        try {
            $order = Order::where('order_code', $order_code)
                ->where('customer_id', $customer_id)
                ->firstOrFail();

            $order_details = OrderDetail::where('order_code', $order_code)->get();
            $shipping = Shipping::find($order->shipping_id);

            // SEO meta cho layout
            return view('pages.order.detail', compact('order', 'order_details', 'shipping'))
                ->with('meta_desc', 'Chi tiết đơn hàng')
                ->with('meta_keywords', 'chi tiết đơn hàng')
                ->with('meta_title', 'Chi tiết đơn hàng #' . $order_code)
                ->with('url_canonical', $request->url());
        } catch (\Exception $e) {
            \Log::error('order_detail error: ' . $e->getMessage());
            return redirect('/orders')->with('error', 'Đơn hàng không tìm thấy.');
        }
    }
}
