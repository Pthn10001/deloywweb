@extends('admin_layout');
@section('admin_content')


<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
        Danh mục sản phẩm
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
                    $i=0
                    ?>
        <table class="table table-striped b-t b-light">
            <thead>
            <tr>
                <th style="width:20px;">
                <label class="i-checks m-b-none">
                    <input type="checkbox"><i></i>
                </label>
                </th>
                <th>Tên sản phẩm</th>
                <th>Image</th>
                <th>Số lượng</th>
                <th>Mô tả</th>
                <th>Danh mục</th>
                <th>Thương hiệu</th>
                <th>Giá tiền</th>

                <th style="width:30px;"></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($all_product as $key => $product_pro)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$product_pro->product_name}}</td>
                        <td><img src="upload/product/{{$product_pro->product_image}}" height="80px", width="70px"></td>
                        <td>{{$product_pro->product_quantity}}</td>
                        <td><?php echo $product_pro->product_desc?></td>
                        <td>{{$product_pro->category_name}}</td>
                        <td>{{$product_pro->brand_name}}</td>
                        <td>{{number_format($product_pro->product_price).'đ'}}</td>

                        <td><span class="text-ellipsis">
                            <?php
                                if($product_pro->product_status==0){
                                ?>
                                    <a href="{{URL::to('/unactive-product/'.$product_pro->product_id)}}" class="check-styling"><i class="nuthien">Hiện</i></a>
                                <?php
                                }else {
                                ?>
                                     <a href="{{URL::to('/active-product/'.$product_pro->product_id)}}" class="check-styling"><i class="nutan">Ẩn</i></a>
                                <?php
                                }
                                ?>
                            </span>
                        </td>
                        {{-- <td><span class="text-ellipsis"><?php echo date("Y/m/d") ?></span></td> --}}
                        <td>
                        <a href="{{URL::to('/edit-product/'.$product_pro->product_id)}}" class="active" ui-toggle-class="">
                            <i class="nutsua">Sửa</i>
                        </a>
                        <a href="{{URL::to('/delete-product/'.$product_pro->product_id)}}">
                            <i class="nutxoa " onclick="return confirm('Bạn mốn xóa?')">Xóa</i>
                        </a>
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
        </div>
        <footer class="panel-footer">
        <div class="row">

            <div class="col-sm-5 text-center">
            <small class="text-muted inline m-t-sm m-b-sm">Hiển thị 10 trong số all mặt hàng</small>
            </div>
            <div class="col-sm-7 ">
                <ul class="pagination pagination-sm m-t-none m-b-none">
                    @if(isset($all_product)&&count($all_product)>0)
                        {{$all_product->links()}}
                    @endif
            </ul>
            </div>
        </div>
        </footer>
    </div>
</div>


@endsection
