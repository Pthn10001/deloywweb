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
                    ?>
        <table class="table table-striped b-t b-light">
            <thead>
            <tr>
                <th style="width:20px;">
                <label class="i-checks m-b-none">
                    <input type="checkbox"><i></i>
                </label>
                </th>
                <th>Tên Danh mục</th>
                <th>Mô tả</th>
                <th>Keyword</th>
                <th>Hiển thị</th>
                
                <th style="width:30px;"></th>
            </tr>
            </thead>
            <tbody>
                @foreach ($all_category_product as $key => $cate_pro)
                    <tr>
                        <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                        <td>{{($cate_pro->category_name)}}</td>
                        <td><?php echo $cate_pro->category_desc?></td>
                        <td>{{($cate_pro->meta_keyword)}}</td>
                        <td><span class="text-ellipsis">
                            <?php
                                if($cate_pro->category_status==0){
                                ?>
                                    <a href="{{URL::to('/unactive-category-product/'.$cate_pro->category_id)}}" class="check-styling"><span class="nuthien">Hiện</span></a>
                                <?php
                                }else {
                                ?>
                                     <a href="{{URL::to('/active-category-product/'.$cate_pro->category_id)}}" class="check-styling"><span class="nutan">Ẩn</span></a>
                                <?php
                                }
                                ?>
                            </span>
                        </td>

  
                        <td>
                        <a href="{{URL::to('/edit-category-product/'.$cate_pro->category_id)}}" class="active" ui-toggle-class="">
                            <i class="nutsua">Sửa</i>
                        </a>
                        </td><td>
                        <a href="{{URL::to('/delete-category-product/'.$cate_pro->category_id)}}">
                            <i class="nutxoa" onclick="return confirm('Bạn muốn xóa?')">Xóa</i>
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
            
            </div>
            <div class="col-sm-7 text-right text-center-xs">
            <ul class="pagination pagination-sm m-t-none m-b-none">
                {{$all_category_product->links()}}
            </ul>
            </div>
        </div>
        </footer>
    </div>
</div>


@endsection
