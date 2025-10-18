@extends('layout1')

@section('content')
<div class="customer_login">
    <div class="row">
        <div class="col-12">
            <p>
                Vui lòng sử dụng Đăng ký và Thanh toán để dễ dàng truy cập vào lịch sử đơn đặt hàng của bạn
                hoặc sử dụng Thanh toán với tư cách Khách.
            </p>
        </div>

        <!-- checkout form -->
        <div class="col-lg-6 col-md-8 col-sm-12 col-lg-offset-3 col-md-offset-2">
            <div class="account_form">
                <h2>Hóa đơn thanh toán</h2>

                {{-- Form không cần action, mình submit bằng AJAX --}}
                <form id="checkoutForm" method="POST">
                    {{ csrf_field() }}

                    <label>Email <span>*</span></label>
                    <input type="email" name="shipping_email" class="shipping_email" placeholder="Email *" required>

                    <label>Họ và tên <span>*</span></label>
                    <input type="text" name="shipping_name" class="shipping_name" placeholder="Họ và tên *" required>

                    <label>Số điện thoại <span>*</span></label>
                    <input type="text" name="shipping_phone" class="shipping_phone" placeholder="Số điện thoại *" required>

                    <label>Địa chỉ <span>*</span></label>
                    <input type="text" name="shipping_address" class="shipping_address" placeholder="Địa chỉ *" required>

                    <label>Ghi chú</label>
                    <textarea name="shipping_notes" class="shipping_notes" placeholder="Nội dung ghi chú" rows="6"></textarea>

                    <label>Hình thức thanh toán</label>
                    <select name="payment_method" class="payment_method">
                        <option value="1">Thanh toán thẻ tín dụng</option>
                        <option value="2" selected>Thanh toán bằng tiền mặt</option>
                        <option value="3">Thanh toán bằng Credit Card</option>
                    </select>

                    <p></p>
                    <button type="button" class="btn btn-primary send_order">Gửi</button>
                </form>
            </div>
        </div>
        <!-- /checkout form -->
    </div>
</div>
@endsection

@push('scripts')
<script>
// đảm bảo có jQuery và csrf
(function($){
  const ORDERS_URL = "{{ route('orders.index') }}"; // lịch sử đơn hàng
  const ORDER_POST = "{{ url('/order') }}";         // endpoint tạo đơn

  $('.send_order').on('click', function(){
      const payload = {
          shipping_email:   $('.shipping_email').val(),
          shipping_name:    $('.shipping_name').val(),
          shipping_phone:   $('.shipping_phone').val(),
          shipping_address: $('.shipping_address').val(),
          shipping_notes:   $('.shipping_notes').val(),
          payment_method:   $('.payment_method').val(),
          _token:           $('input[name="_token"]').val()
      };

      // validate đơn giản
      if(!payload.shipping_email || !payload.shipping_name || !payload.shipping_phone || !payload.shipping_address){
          alert('Vui lòng nhập đầy đủ Email, Họ tên, SĐT và Địa chỉ.');
          return;
      }

      // gọi API tạo đơn
      $.ajax({
          url: ORDER_POST,
          method: 'POST',
          data: payload
      })
      .done(function(){
          // chuyển về lịch sử đơn hàng sau khi tạo thành công
          window.location.href = ORDERS_URL;
      })
      .fail(function(xhr){
          alert('Gửi đơn không thành công. Vui lòng thử lại!');
          console.error(xhr.responseText || xhr.status);
      });
  });
})(jQuery);
</script>
@endpush
