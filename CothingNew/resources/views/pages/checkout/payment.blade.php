@extends('layout')
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                <li class="active">Thanh toán giỏ hàng</li>
            </ol>
        </div>

        <div class="review-payment">
            <h2>Xem lại giỏ hàng</h2>
            <div class="table-responsive cart_info">
                <?php
                use Gloudemans\Shoppingcart\Facades\Cart;
                $content = Cart::content();
                $total = 0;
                ?>
                <table class="table table-condensed" style="width: 86%;">
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Hình ảnh</td>
                            <td class="description">Sản phẩm</td>
                            <td class="price">Giá</td>
                            <td class="quantity">Số lượng</td>
                            <td class="total">Thành tiền</td>
                            <td>Xóa</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($content as $key => $v_content)
                            @php
                                $subtotal = $v_content->price * floatval($v_content->qty);
                                $total += $subtotal;
                            @endphp
                            <tr>
                                <td class="cart_product">
                                    <a href="#">
                                        <img src="{{ URL::to('upload/product/'.$v_content->options->image) }}" width="60" alt="">
                                    </a>
                                </td>
                                <td class="cart_description">
                                    <h4>{{ $v_content->name }}</h4>
                                    <p>Size: {{ $v_content->weight }}</p>
                                </td>
                                <td class="cart_price">
                                    <p>{{ number_format($v_content->price, 0, ',', '.') }}đ</p>
                                </td>
                                <td class="cart_quantity">
                                    <form action="{{ URL::to('/update-cart') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input class="cart_quantity_input" type="number" name="quantyti"
                                               value="{{ $v_content->qty }}" min="1" max="99" size="2" style="width:60px;">
                                        <input type="hidden" name="rowId_cart" value="{{ $v_content->rowId }}">
                                        <button type="submit" class="btn btn-sm btn-info">Cập nhật</button>
                                    </form>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">{{ number_format($subtotal, 0, ',', '.') }}đ</p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete text-danger"
                                       href="{{ URL::to('/delete-cart/'.$v_content->rowId) }}"
                                       onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="text-end mt-3">
                    <h4><strong>Tổng tiền:</strong> {{ number_format($total, 0, ',', '.') }}đ</h4>
                </div>
            </div>
        </div>

        {{-- ===================== THANH TOÁN ===================== --}}
        <h4 style="margin: 40px 0 20px; font-size: 28px;">Chọn hình thức thanh toán</h4>

        <form id="paymentForm" action="{{ URL::to('/order') }}" method="POST">
            @csrf
            <div class="payment-options" style="font-size: 17px; line-height: 1.8;">
                <div>
                    <label>
                        <input type="radio" name="payment_option" value="1" required>
                        Thanh toán bằng thẻ tín dụng
                    </label>
                </div>
                <div>
                    <label>
                        <input type="radio" name="payment_option" value="2">
                        Thanh toán khi nhận hàng (COD)
                    </label>
                </div>
                <div>
                    <label>
                        <input type="radio" name="payment_option" value="3">
                        Thanh toán bằng chuyển khoản ngân hàng
                    </label>
                </div>
                <br>
                <button type="submit" id="btnPay" class="btn btn-primary">
                    Thanh toán
                </button>
            </div>
        </form>
    </div>
</section>

{{-- ✅ JavaScript: kiểm tra form và chống double submit --}}
<script>
document.addEventListener('DOMContentLoaded', function(){
    const form = document.getElementById('paymentForm');
    const btn = document.getElementById('btnPay');

    form.addEventListener('submit', function(e){
        const checked = form.querySelector('input[name="payment_option"]:checked');
        if(!checked){
            e.preventDefault();
            alert('Vui lòng chọn phương thức thanh toán!');
            return;
        }

        btn.disabled = true;
        btn.innerText = 'Đang xử lý...';
    });
});
</script>
@endsection
