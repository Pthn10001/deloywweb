{{-- resources/views/pages/order/history.blade.php --}}
@extends('layout')

@section('content')
<div class="col-12">
    <h2 class="mb-4">Đơn hàng của tôi</h2>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th class="text-end">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>#{{ $order->order_code }}</td>

                        {{-- Ngày đặt: dùng optional() để tránh lỗi nếu null --}}
                        <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}</td>


                        <td>
                            @switch($order->order_status)
                                @case(2) Hoàn tất @break
                                @case(3) Đã hủy @break
                                @default Đang xử lý
                            @endswitch
                        </td>

                        <td class="text-end">
                            <a class="btn btn-sm btn-outline-primary"
                               href="{{ route('orders.show', $order->order_code) }}">
                                Xem chi tiết
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Bạn chưa có đơn hàng nào.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
