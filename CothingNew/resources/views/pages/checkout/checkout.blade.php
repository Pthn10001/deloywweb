@extends('layout1')

@section('content')
<div class="customer_login">
    <div class="row">
        <div class="col-12">
            <p>
                Vui lòng sử dụng Đăng ký và Thanh toán để dễ dàng truy cập vào lịch sử đơn hàng của bạn
                hoặc sử dụng Thanh toán với tư cách Khách.
            </p>
        </div>

        <!-- checkout form -->
        <div class="col-lg-6 col-md-8 col-sm-12 col-lg-offset-3 col-md-offset-2">
            <div class="account_form">
                <h2>Hóa đơn thanh toán</h2>

                {{-- ✅ Form thanh toán --}}
                <form id="checkoutForm" action="{{ url('/order') }}" method="POST">
                    {{ csrf_field() }}

                    <label>Email <span>*</span></label>
                    <input type="email" name="shipping_email" class="shipping_email form-control" placeholder="Email *" required>

                    <label>Họ và tên <span>*</span></label>
                    <input type="text" name="shipping_name" class="shipping_name form-control" placeholder="Họ và tên *" required>

                    <label>Số điện thoại <span>*</span></label>
                    <input type="text" name="shipping_phone" class="shipping_phone form-control"
                           placeholder="Số điện thoại *" pattern="[0-9]{9,11}"
                           title="Số điện thoại từ 9-11 số" required>

                    <label>Địa chỉ <span>*</span></label>
                    <input type="text" name="shipping_address" class="shipping_address form-control"
                           placeholder="Nhập địa chỉ của bạn *" required>

                    <label>Ghi chú</label>
                    <textarea name="shipping_notes" class="shipping_notes form-control" placeholder="Nội dung ghi chú" rows="4"></textarea>

                    <label>Hình thức thanh toán</label>
                    <select name="payment_method" class="payment_method form-select">
                        <option value="1">Thanh toán thẻ tín dụng</option>
                        <option value="2" selected>Thanh toán bằng tiền mặt</option>
                        <option value="3">Chuyển khoản ngân hàng</option>
                    </select>

                    <p></p>
                    <button type="button" class="btn btn-primary send_order w-100">
                        Gửi đơn hàng
                    </button>
                </form>

                {{-- ✅ Khu vực thông báo --}}
                <div id="checkoutAlert" class="mt-3"></div>
            </div>
        </div>
        <!-- /checkout form -->
    </div>
</div>
@endsection


@push('scripts')
<script>
(function($){
  const ORDER_POST  = "{{ url('/order') }}";
  const ORDERS_URL  = "{{ route('orders.index') }}";

  $('.send_order').on('click', function(e){
      e.preventDefault();

      const btn = $(this);
      btn.prop('disabled', true).text('Đang gửi...');

      const payload = {
          shipping_email:   $('.shipping_email').val().trim(),
          shipping_name:    $('.shipping_name').val().trim(),
          shipping_phone:   $('.shipping_phone').val().trim(),
          shipping_address: $('.shipping_address').val().trim(),
          shipping_notes:   $('.shipping_notes').val().trim(),
          payment_method:   $('.payment_method').val(),
          _token:           $('input[name="_token"]').val()
      };

      // ✅ Kiểm tra dữ liệu
      if(!payload.shipping_email || !payload.shipping_name || !payload.shipping_phone || !payload.shipping_address){
          alert('⚠️ Vui lòng nhập đầy đủ Email, Họ tên, SĐT và Địa chỉ.');
          btn.prop('disabled', false).text('Gửi đơn hàng');
          return;
      }

      // ✅ Kiểm tra số điện thoại
      const phoneRegex = /^[0-9]{9,11}$/;
      if(!phoneRegex.test(payload.shipping_phone)){
          alert('⚠️ Số điện thoại không hợp lệ (9–11 số).');
          btn.prop('disabled', false).text('Gửi đơn hàng');
          return;
      }

      // ✅ Gửi request AJAX
      $.ajax({
          url: ORDER_POST,
          method: 'POST',
          data: payload,
          success: function(res){
              $('#checkoutAlert').html(`
                  <div class="alert alert-success text-center">
                      ✅ Đặt hàng thành công! Đang chuyển đến trang lịch sử đơn hàng...
                  </div>
              `);
              $('#checkoutForm')[0].reset();
              btn.prop('disabled', false).text('Gửi đơn hàng');

              // 🔁 Tự động chuyển đến lịch sử đơn hàng
              setTimeout(() => {
                  window.location.href = ORDERS_URL;
              }, 1500);
          },
          error: function(xhr){
              let msg = '❌ Gửi đơn không thành công. Vui lòng thử lại!';
              if(xhr.responseJSON && xhr.responseJSON.message){
                  msg = xhr.responseJSON.message;
              }
              $('#checkoutAlert').html(`<div class="alert alert-danger text-center">${msg}</div>`);
              btn.prop('disabled', false).text('Gửi đơn hàng');
              console.error(xhr.responseText || xhr.status);
          }
      });
  });
})(jQuery);
</script>
@endpush
