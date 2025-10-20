@extends('admin_layout');
@section('admin_content')

<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa thông tin sản phẩm
                </header>
                <div class="panel-body">
                        <?php
                        $message =session()->get('message');
                        echo '<div style="color: red;text-align: center">',$message,'</div>';
                        Session()->put('message',null);
                        ?>
                        <div class="position-center">
                            @foreach($edit_product as $key =>$edit_value)
                                    <form role="form" action="{{URL::to('/update-product/'.$edit_value->product_id)}}" method="POST" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Tên sản phẩm</label>
                                        <input type="text" value="{{$edit_value->product_name}}" class="form-control" name="product_name" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group">
                                         <label for="exampleInputEmail1">Số lượng</label>
                                         <input type="text" class="form-control" name="product_qty" id="exampleInputEmail1" placeholder="số lượng">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Image sản phẩm</label>
                                        <input type="file" class="form-control" name="product_image" id="exampleInputEmail1">
                                        <img src="{{ URL::to('upload/product/'.$edit_value->product_image) }}" style="height: 76px;width: 80px ">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Giá sản phẩm</label>
                                        <input type="text" value="{{$edit_value->product_price}}" class="form-control" name="product_price" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                        <textarea type="text" style="resize: none" rows="5" class="form-control" name="product_desc" id="exampleInputPassword1" >{{$edit_value->product_desc}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">content </label>
                                        <textarea type="text" style="resize: none" rows="5" class="form-control" name="product_content" id="exampleInputPassword1" >{{$edit_value->product_content}}</textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                        <select name="product_brand" class="form-control input-sm ms-15">
                                            @foreach ($brand_product as $key =>$brand)
                                            @if($brand->brand_id==$edit_value->brand_id)
                                            <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @else
                                            <option selected value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                        @endif
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Hiển thị</label>
                                        <select name="product_cate" class="form-control input-sm ms-15">
                                            @foreach ($cate_product as $key =>$cate):
                                                @if($cate->category_id==$edit_value->category_id):
                                                    <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                                @else
                                                    <option selected value="{{$cate->category_id}}">{{$cate->category_name}}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Hiển thị</label>
                                        <select name="product_status" class="form-control input-sm ms-15">
                                                <option value="0">Ân </option>
                                                <option value="1">Hiện </option>

                                        </select>
                                    </div>
                                    <button type="submit" name="update_product" class="btn btn-info">Them danh muc</button>
                                </form>
                            @endforeach
                    </div>
            </section>
    </div>
</div>
<script>
    CKEDITOR.replace('brand_product_desc');
</script>
@endsection
