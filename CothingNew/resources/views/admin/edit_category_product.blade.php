@extends('admin_layout');
@section('admin_content')



<div class="row">
    <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa danh mục sản phẩm
                </header>
                <div class="panel-body">
                    @foreach($edit_category_product as $key =>$edit_value)
                        <?php
                        $message =session()->get('message');
                        echo '<div style="color: red;text-align: center">',$message,'</div>';
                        Session()->put('message',null);
                        ?>
                        <div class="position-center">
                            <form role="form" action="{{URL::to('/update-category-product/'.$edit_value->category_id)}}" method="POST">
                                {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục</label>
                                <input type="text" value="{{$edit_value->category_name}}" class="form-control" name="category_product_name" id="exampleInputEmail1" placeholder="Tên danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả danh mục</label>
                                <textarea type="text" style="resize: none" rows="5" class="form-control" name="category_product_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{$edit_value->category_desc}}</textarea>
                            </div>
                            {{-- <div class="form-group">
                                <label for="exampleInputFile">File input</label>
                                <input type="file" id="exampleInputFile">
                            </div> --}}

                            <button type="submit" name="update_category_product" class="btn btn-info">Cập nhật danh muc</button>
                        </form>
                        </div>
                    @endforeach
                </div>
            </section>

    </div>
</div>
<script>
    CKEDITOR.replace('category_product_desc');
</script>
@endsection
