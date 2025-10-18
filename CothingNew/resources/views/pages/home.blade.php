@extends('layout')
@section('content')
                    <div class="block_title">
                        <h3>Sản phẩm đặc trưng</h3>
                     </div>
            <div class="product_active owl-carousel">
                @foreach($products as $key=>$pro)
                    <div class="col-lg-3">
                        <div class="single_product">
                            <div class="product_thumb">
                                <a href="{{URL::to('/chi-tet-san-pham/'.$pro->product_id)}}"><img src="{{URL::to('upload/product/'.$pro->product_image)}}" alt=""></a>
                                <div class="hot_img">
                                    <img src="assets\img\cart\span-hot.png" alt="">
                                </div>
                                <div class="product_action">
                                    <a href="{{URL::to('/chi-tet-san-pham/'.$pro->product_id)}}"> <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                            <div class="product_content">
                                <span class="product_price">{{number_format($pro->product_price)."đ"}}</span>
                                <h3 class="product_title"><a href="{{URL::to('/chi-tet-san-pham/'.$pro->product_id)}}">{{$pro->product_name}}</a></h3>
                            </div>
                            <div class="product_info">
                                <ul>
                                    <li><a href="{{URL::to('/chi-tet-san-pham/'.$pro->product_id)}}" title=" Add to Wishlist ">Thêm vào yêu thích</a></li>
                                    <li><a href="{{URL::to('/chi-tet-san-pham/'.$pro->product_id)}}" data-toggle="modal" data-target="#modal_box" title="Quick view">Xem nhanh</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
                    <div class="col-sm-12 text-right" style="margin-left: 40%; margin-top: 12px;margin-bottom: 12px;" >
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        {{$products->links()}}
                    </ul>
                    </div>

@endsection
