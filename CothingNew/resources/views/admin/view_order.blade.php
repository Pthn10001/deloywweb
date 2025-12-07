@extends('admin_layout')

@section('admin_content')

{{-- ================== THÔNG TIN KHÁCH HÀNG ================== --}}
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">THÔNG TIN KHÁCH HÀNG</div>

    <div class="table-responsive">
      @if(session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
        @php Session()->forget('message'); @endphp
      @endif

      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th>Tên khách hàng</th>
            <th>Số điện thoại</th>
            <th>Email</th>
            <th>Hiển thị</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $customer->customer_name ?? '' }}</td>
            <td>{{ $customer->customer_phone ?? '' }}</td>
            <td>{{ $customer->customer_email ?? '' }}</td>
            <td>
              <span title="OK"><i class="fa fa-check text-success"></i></span>
              <span title="Không áp dụng"><i class="fa fa-times text-danger"></i></span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- ================== CHI TIẾT HÓA ĐƠN ================== --}}
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">CHI TIẾT HÓA ĐƠN</div>

    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th style="width:60px;">STT</th>
            <th>Ảnh</th>
            <th>Hàng còn</th>
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Size</th>
            <th style="min-width:220px;">Số lượng (có thể sửa)</th>
            <th>Thành tiền</th>
          </tr>
        </thead>
        <tbody>
          @php
            $subtotal = 0;
            $currentOrder  = $order[0] ?? null;
            $orderId       = $currentOrder->order_id ?? '';
            $currentStatus = $currentOrder->order_status ?? 1;
          @endphp

          @forelse($order_detailss as $idx => $detail)
            @php
              $product   = $detail->product ?? null;
              $stock     = $product->product_quantity ?? 0;
              $qty       = $detail->product_sales_qty ?? 0;
              $price     = $detail->product_price ?? 0;
              $lineTotal = $price * $qty;
              $subtotal += $lineTotal;
            @endphp

            <tr>
              <td>{{ $idx + 1 }}</td>
              <td><img src="{{ asset('upload/product/'.($product->product_image ?? 'no-image.png')) }}" width="45" height="55"></td>
              <td>{{ $stock }}</td>
              <td>{{ $detail->product_name ?? '' }}</td>
              <td>{{ number_format($price, 0, ',', '.') }}đ</td>
              <td>{{ $detail->product_size ?? '-' }}</td>

              {{-- ========== INPUT SỐ LƯỢNG ========== --}}
              <td>
                <input type="hidden" value="{{ $stock }}" class="product_quantity_{{ $detail->product_id }}">

                <div class="input-group" style="max-width:220px;">
                  @if($currentStatus == 2)
                    <input type="number" class="form-control" value="{{ $qty }}" disabled>
                    <span class="input-group-btn">
                      <button class="btn btn-secondary" disabled>Đã hoàn thành</button>
                    </span>
                  @else
                    <input type="number"
                           name="product_sales_quantity"
                           class="form-control order_qty_{{ $detail->product_id }}"
                           value="{{ $qty }}"
                           min="1"
                           max="{{ max(1, $stock) }}">
                    <span class="input-group-btn">
                      <button type="button"
                              class="btn btn-default order_update_btn"
                              data-product_id="{{ $detail->product_id }}">
                        Cập nhật
                      </button>
                    </span>
                  @endif
                </div>

                <input type="hidden" name="order_product_id" class="order_product_id" value="{{ $detail->product_id }}">
                <input type="hidden" class="order_code" value="{{ $detail->order_code }}">
              </td>

              <td>{{ number_format($lineTotal, 0, ',', '.') }}đ</td>
            </tr>
          @empty
            <tr><td colspan="8">Đơn hàng chưa có sản phẩm.</td></tr>
          @endforelse

          {{-- TỔNG TIỀN --}}
          <tr>
            <td colspan="5"></td>
            <td class="text-end" style="color:#c00; font-weight:600;">Tổng tiền:</td>
            <td colspan="2" style="color:#c00; font-weight:600;">{{ number_format($subtotal, 0, ',', '.') }}đ</td>
          </tr>

          {{-- TRẠNG THÁI ĐƠN --}}
          <tr>
            <td colspan="6" class="text-end">
              <form>
                @csrf
                <select class="form-control order_details"
                        style="max-width:260px; display:inline-block;"
                        {{ $currentStatus == 2 ? 'disabled' : '' }}>
                  <option value="">— Chọn trạng thái —</option>
                  <option id="{{ $orderId }}" value="1" {{ $currentStatus == 1 ? 'selected' : '' }}>Chưa xử lý</option>
                  <option id="{{ $orderId }}" value="2" {{ $currentStatus == 2 ? 'selected' : '' }}>Đã hoàn thành</option>
                  <option id="{{ $orderId }}" value="3" {{ $currentStatus == 3 ? 'selected' : '' }}>Đã hủy</option>
                </select>
              </form>
            </td>
            <td colspan="2" class="text-right">
              @if($currentStatus == 2)
                <button class="btn btn-secondary" disabled>Đơn đã hoàn thành</button>
              @else
                <button id="saveChangesBtn" type="button" class="btn btn-primary" style="display:none;">Lưu thay đổi</button>
              @endif
              <span id="saveSpinner" class="text-muted" style="display:none;">Đang lưu...</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- ================== THÔNG TIN VẬN CHUYỂN ================== --}}
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">THÔNG TIN VẬN CHUYỂN</div>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            <th></th>
            <th>Tên người nhận</th>
            <th>Địa chỉ</th>
            <th>Email</th>
            <th>SĐT</th>
            <th>Ghi chú</th>
            <th>Hình thức thanh toán</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td></td>
            <td>{{ $shipping->shipping_name ?? '' }}</td>
            <td>{{ $shipping->shipping_address ?? '' }}</td>
            <td>{{ $shipping->shipping_email ?? '' }}</td>
            <td>{{ $shipping->shipping_phone ?? '' }}</td>
            <td>{{ $shipping->shipping_notes ?? '' }}</td>
            <td>
              @php
                echo (($shipping->payment_method ?? 1) == 2) ? 'Trả tiền mặt' : 'Chuyển khoản';
              @endphp
            </td>
            <td>
              <span title="OK"><i class="fa fa-check text-success"></i></span>
              <span title="Không áp dụng"><i class="fa fa-times text-danger"></i></span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
(function($){
  const isCompleted = {{ ($currentOrder->order_status ?? 1) == 2 ? 'true' : 'false' }};
  let isDirty = false;

  if (isCompleted) {
    $('input[name="product_sales_quantity"]').prop('disabled', true);
    $('.order_update_btn').prop('disabled', true);
    $('.order_details').prop('disabled', true);
    $('#saveChangesBtn').hide();
    return; // Dừng hẳn JS update nếu đã hoàn thành
  }

  $(document).on('input', 'input[name="product_sales_quantity"]', () => { $('#saveChangesBtn').show(); isDirty = true; });
  $(document).on('change', '.order_details', () => { $('#saveChangesBtn').show(); isDirty = true; });

  $(document).on('click', '.order_update_btn', function(){
    const pid = $(this).data('product_id');
    const qty = parseInt($('.order_qty_'+pid).val(), 10) || 0;
    const stock = parseInt($('.product_quantity_'+pid).val(), 10) || 0;
    const code = $('.order_code').first().val();

    if (!pid || !code) return;
    if (qty < 1) { alert('Số lượng phải >= 1'); return; }
    if (qty > stock) { alert('Số lượng vượt quá hàng trong kho!'); return; }

    $.post("{{ url('/update-qty') }}", { order_product_id: pid, order_qty: qty, order_code: code })
      .done(() => { alert('Đã cập nhật số lượng!'); location.reload(); })
      .fail(() => { alert('Lỗi khi cập nhật số lượng.'); });
  });

  function getCurrentOrderInfo(){
    const $sel = $('.order_details');
    return { order_status: $sel.val() || '', order_id: $sel.children(':selected').attr('id') || '' };
  }

  function validateQuantities(){
    let ok = true, msg = '';
    $('input[name="product_sales_quantity"]').each(function(){
      const $q = $(this);
      const pid = ($q.attr('class').match(/order_qty_(\d+)/) || [])[1];
      const val = parseInt($q.val(), 10) || 0;
      const max = parseInt($('.product_quantity_'+pid).val(), 10) || 0;
      if (val < 1) { ok = false; msg = 'Số lượng phải >= 1'; return false; }
      if (val > max) { ok = false; msg = 'Số lượng vượt quá hàng trong kho!'; return false; }
    });
    if (!ok && msg) alert(msg);
    return ok;
  }

  function collectLines(){
    const quantity = [], productIds = [];
    $('input[name="product_sales_quantity"]').each(function(){ quantity.push($(this).val()); });
    $('input[name="order_product_id"]').each(function(){ productIds.push($(this).val()); });
    return { quantity, productIds };
  }

  $('#saveChangesBtn').on('click', async function(){
    if (!isDirty) return;
    if (!validateQuantities()) return;
    const $btn = $(this), $spin = $('#saveSpinner');
    $btn.prop('disabled', true); $spin.show();

    try {
      const code = $('.order_code').first().val();
      const { quantity, productIds } = collectLines();
      for (let i = 0; i < productIds.length; i++){
        await $.post("{{ url('/update-qty') }}", {
          order_product_id: productIds[i],
          order_qty: quantity[i],
          order_code: code
        });
      }

      const { order_status, order_id } = getCurrentOrderInfo();
      if (order_id) {
        await $.post("{{ url('/update-order') }}", {
          order_status, order_id, quantity, order_product_id: productIds
        });
      }

      alert('Đã lưu thay đổi!');
      location.reload();
    } catch (e) {
      console.error(e); alert('Có lỗi khi lưu!');
    } finally {
      $btn.prop('disabled', false); $spin.hide();
    }
  });

})(jQuery);
</script>
@endpush
