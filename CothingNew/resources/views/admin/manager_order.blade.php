@extends('admin_layout');
@section('admin_content')


<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        Danh mục đơn hàng
        </div>
        <div class="row w3-res-tb">
        <div class="col-sm-5 m-b-xs">
            <select class="input-sm form-control w-sm inline v-middle">
            <option value="0">Bulk action</option>
            <option value="1">Delete selected</option>
            <option value="2">Bulk edit</option>
            <option value="3">Export</option>
            </select>
            <button class="btn btn-sm btn-default">Apply</button>
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-3">
            <div class="input-group">
            <input type="text" class="input-sm form-control" placeholder="Search">
            <span class="input-group-btn">
                <button class="btn btn-sm btn-default" type="button">Tìm kiếm</button>
            </span>
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
                <th>Order code</th>
                <th>Ngày thêm</th>
                <th>Trạng thái</th>

                <th style="width:30px;"></th>
            </tr>
            </thead>
            <tbody>
                @php
                    $i=0;
                @endphp
                @foreach ($order as $key => $order)
                
                @php
                    $i++;
                @endphp
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>{{$i}}</td>
                        <td>{{($order->order_code)}}</td>
                        <td>{{($order->created_at)}}</td>
                        <td>
                            @if($order->order_status==1)
                                Đơn hàng mới
                            @elseif($order->order_status==2)
                                Đã hoàn Thành
                            @elseif($order->order_status==3)
                                Đã hủy
                            @endif
                        </td>
                        
                        <td>
                        <a href="{{URL::to('/view-order/'.$order->order_code)}}" class="active" ui-toggle-class="">
                            <i class="fa fa-eye text-success text-active"></i>
                        </a>
                        <a href="{{URL::to('/delete-order/'.$order->order_id)}}">
                            <i class="fa fa-trash text-danger text " onclick="return confirm('Bạn chắc là muốn xóa đơn hàng này?')"></i>
                        </a>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
        </div>
    </div>
</div>


@endsection
