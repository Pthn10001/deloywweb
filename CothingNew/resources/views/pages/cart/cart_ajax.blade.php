@extends('layout')
@section('content')

    <div class="shopping_cart_area container my-4">
        <div class="row">
            <div class="col-12">
                <div class="table_desc">
                    <div class="cart_page table-responsive">
                        @if(session('cart') && count(session('cart')) > 0)
                            <form action="{{ url('/update-cart') }}" method="POST">
                                @csrf
                                <table class="table table-bordered" style="width:100%; text-align:center;">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Xóa</th>
                                            <th>Hình ảnh</th>
                                            <th>Còn</th>
                                            <th>Sản phẩm</th>
                                            <th>Giá</th>
                                            <th>Số lượng</th>
                                            <th>Size</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $total = 0; @endphp
                                        @foreach(session('cart') as $key => $cart)
                                            @php
                                                $price = (int) $cart['product_price'];
                                                $qty = (int) $cart['product_qty'];
                                                $subtotal = $price * $qty;
                                                $total += $subtotal;
                                            @endphp
                                            <tr>
                                                <td>
                                                    <a href="{{ url('/delete-cart/' . $cart['session_id']) }}"
                                                        class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Xóa sản phẩm này khỏi giỏ hàng?')">
                                                        <i class="fa fa-trash-o"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <img src="{{ asset('upload/product/' . $cart['product_image']) }}" width="80"
                                                        height="80" alt="image">
                                                </td>
                                                <td>{{ $cart['product_tong'] }}</td>
                                                <td>{{ $cart['product_name'] }}</td>
                                                <td>{{ number_format($cart['product_price'], 0, ',', '.') }} đ</td>
                                                <td>
                                                    <input type="number" name="cart_qty[{{ $cart['session_id'] }}]"
                                                        value="{{ $cart['product_qty'] }}" min="1" max="{{ $cart['product_tong'] }}"
                                                        style="width:60px;" class="form-control form-control-sm text-center">
                                                </td>
                                                <td>
                                                    <input type="text" name="cart_size[{{ $cart['session_id'] }}]"
                                                        value="{{ $cart['product_size'] }}"
                                                        class="form-control form-control-sm text-center">
                                                </td>
                                                <td>{{ number_format($subtotal, 0, ',', '.') }} đ</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div class="row justify-content-between mt-3">
                                    <div class="col-md-4">
                                        <button type="submit" class="btn btn-primary w-100">Cập nhật giỏ hàng</button>
                                    </div>
                                    <div class="col-md-4 text-end">
                                        <h5 class="mb-0">Tổng tiền:
                                            <strong class="text-danger">
                                                {{ number_format($total, 0, ',', '.') }} đ
                                            </strong>
                                        </h5>
                                    </div>
                                </div>
                            </form>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <a href="{{ url('/') }}" class="btn btn-secondary w-100">Tiếp tục mua hàng</a>
                                </div>
                                <div class="col-md-6">
                                    @if(session('customer_id'))
                                        <a href="{{ url('/checkout') }}" class="btn btn-success w-100">Thanh toán</a>
                                    @else
                                        <a href="{{ url('/login-checkout') }}" class="btn btn-warning w-100">Đăng nhập để thanh
                                            toán</a>
                                    @endif

                                </div>
                            </div>

                            <div class="text-end mt-2">
                                <a href="{{ url('/clear-cart') }}" class="btn btn-outline-danger"
                                    onclick="return confirm('Bạn có chắc muốn xóa toàn bộ giỏ hàng?')">
                                    Xóa tất cả
                                </a>
                            </div>

                        @else
                            <div class="alert alert-warning text-center my-4">
                                Bạn chưa thêm sản phẩm nào vào giỏ hàng.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection