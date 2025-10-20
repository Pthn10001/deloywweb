@extends('layout')

@section('content')
<div class="container" style="padding: 15px;">
    <h2>Chi tiết đơn #{{ $order->order_code }}</h2>
    <p>
        <strong>Ngày đặt:</strong> {{ optional($order->created_at)->format('d/m/Y H:i') }} &nbsp;|&nbsp;
        <strong>Trạng thái:</strong>
        @switch($order->order_status)
            @case(1) Đang xử lý @break
            @case(2) Hoàn tất @break
            @case(3) Đã hủy @break
            @default {{ $order->order_status }}
        @endswitch
    </p>

    @if(isset($shipping))
    <div class="panel panel-default" style="margin-bottom:18px;">
        <div class="panel-heading"><strong>Thông tin giao hàng</strong></div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>Tên người nhận</th>
                        <th>Địa chỉ</th>
                        <th>Email</th>
                        <th>SĐT</th>
                        <th>Ghi chú</th>
                        <th>Thanh toán</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $shipping->shipping_name }}</td>
                        <td>{{ $shipping->shipping_address }}</td>
                        <td>{{ $shipping->shipping_email }}</td>
                        <td>{{ $shipping->shipping_phone }}</td>
                        <td>{{ $shipping->shipping_notes }}</td>
                        <td>{{ (int)$shipping->payment_method === 2 ? 'Tiền mặt' : 'Chuyển khoản' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Sản phẩm</strong></div>
        <div class="table-responsive">
            <table class="table table-striped b-t b-light">
                <thead>
                    <tr>
                        <th>SP</th>
                        <th>Giá</th>
                        <th>Size</th>
                        <th>SL</th>
                        <th>Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($order_details as $d)
                        @php
                            $line = (int)$d->product_price * (int)$d->product_sales_qty;
                            $total += $line;
                            $name = $d->product_name ?? optional($d->product)->product_name ?? ('SP #'.$d->product_id);
                        @endphp
                        <tr>
                            <td>{{ $name }}</td>
                            <td>{{ number_format($d->product_price, 0, ',', '.') }} đ</td>
                            <td>{{ $d->product_size }}</td>
                            <td>{{ $d->product_sales_qty }}</td>
                            <td>{{ number_format($line, 0, ',', '.') }} đ</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" class="text-right"><strong>Tổng cộng</strong></td>
                        <td><strong style="color:#e74c3c">{{ number_format($total, 0, ',', '.') }} đ</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('orders.index') }}">← Quay lại danh sách đơn</a>
</div>
@endsection
