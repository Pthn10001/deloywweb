@extends('admin_layout');
@section('admin_content')

<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Quản lý đơn hàng</h3>
        </div>
        
        <!-- Search & Filter -->
        <div class="row w3-res-tb" style="padding: 15px;">
            <form method="GET" action="{{URL::to('/manager-order')}}" class="form-inline">
                <div class="form-group" style="margin-right: 10px;">
                    <label>Trạng thái:</label>
                    <select name="status" class="form-control input-sm" style="margin-left: 10px;">
                        <option value="">Tất cả</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Đơn hàng mới</option>
                        <option value="2" {{ request('status') == '2' ? 'selected' : '' }}>Đã hoàn thành</option>
                        <option value="3" {{ request('status') == '3' ? 'selected' : '' }}>Đã hủy</option>
                    </select>
                </div>
                <div class="form-group" style="margin-right: 10px;">
                    <label>Tìm kiếm:</label>
                    <input type="text" name="search" class="form-control input-sm" placeholder="Mã đơn hàng" 
                           value="{{ request('search') }}" style="margin-left: 10px; width: 200px;">
                </div>
                <button type="submit" class="btn btn-sm btn-primary">Tìm kiếm</button>
                <a href="{{URL::to('/manager-order')}}" class="btn btn-sm btn-default" style="margin-left: 10px;">Reset</a>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="row" style="padding: 15px;">
            <div class="col-md-3">
                <div class="panel panel-primary" style="border: none; background: #5cb85c; color: white; padding: 15px; border-radius: 5px;">
                    <strong style="font-size: 18px;">{{ $order->count() }}</strong>
                    <p>Tổng đơn hàng</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-primary" style="border: none; background: #0275d8; color: white; padding: 15px; border-radius: 5px;">
                    <strong style="font-size: 18px;">{{ $order->where('order_status', 1)->count() }}</strong>
                    <p>Đơn hàng mới</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-primary" style="border: none; background: #ffc107; color: white; padding: 15px; border-radius: 5px;">
                    <strong style="font-size: 18px;">{{ $order->where('order_status', 2)->count() }}</strong>
                    <p>Đã hoàn thành</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-primary" style="border: none; background: #dc3545; color: white; padding: 15px; border-radius: 5px;">
                    <strong style="font-size: 18px;">{{ $order->where('order_status', 3)->count() }}</strong>
                    <p>Đã hủy</p>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <?php
                    $message = session()->get('message');
                    echo '<div style="color: red">',$message,'</div>';
                    Session()->put('message',null);
                    ?>
        <table class="table table-striped b-t b-light">
            <thead>
            <tr>
                <th style="width:20px;">
                <label class="i-checks m-b-none">
                    <input type="checkbox"><i></i>
                </label>
                </th>
                <th>STT</th>
                <th>Mã đơn hàng</th>
                <th>Ngày đặt</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
                <th style="width:30px;"></th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i=0;
                @endphp
                @forelse ($order as $key => $ord)
                
                @php
                    $i++;
                @endphp
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>{{$i}}</td>
                        <td><strong>{{($ord->order_code)}}</strong></td>
                        <td>{{ date('d/m/Y H:i', strtotime($ord->created_at)) }}</td>
                        <td>
                            @if($ord->order_status==1)
                                <span class="badge badge-info">Đơn hàng mới</span>
                            @elseif($ord->order_status==2)
                                <span class="badge badge-success">Đã hoàn Thành</span>
                            @elseif($ord->order_status==3)
                                <span class="badge badge-danger">Đã hủy</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{URL::to('/view-order/'.$ord->order_code)}}" class="btn btn-xs btn-info">
                                <i class="fa fa-eye"></i> Xem
                            </a>
                        </td>
                        <td>
                        <a href="{{URL::to('/delete-order/'.$ord->order_id)}}" class="btn btn-xs btn-danger"
                           onclick="return confirm('Bạn chắc là muốn xóa đơn hàng này?')">
                            <i class="fa fa-trash"></i>
                        </a>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7" class="text-center" style="padding: 20px; color: #999;">
                            Không có đơn hàng nào
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</div>

@endsection
