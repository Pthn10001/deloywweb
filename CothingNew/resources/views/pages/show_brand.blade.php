@extends('layout')
@section('content')
			@foreach($brand_name as $key=>$brand_name)
			<div class="block_title">
                 <h3>{{$brand_name->brand_name}}</h3>
            </div>
			@endforeach

					<div class="product_active owl-carousel">
					@foreach($brand_by_id as $key=>$brand)
					 <div class="col-lg-3">
                        <div class="single_product">
                            <div class="product_thumb">
                                <a href="{{URL::to('/chi-tet-san-pham/'.$brand->product_id)}}"><img src="{{URL::to('upload/product/'.$brand->product_image)}}" alt=""></a>
                                <div class="hot_img">
                                    <img src="assets\img\cart\span-hot.png" alt="">
                                </div>
                                <div class="product_action">
                                    <a href="{{URL::to('/chi-tet-san-pham/'.$brand->product_id)}}"> <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                            <div class="product_content">
                                <span class="product_price">{{$brand->product_price}}</span>
                                <h3 class="product_title"><a href="{{URL::to('/chi-tet-san-pham/'.$brand->product_id)}}">{{$brand->product_name}}</a></h3>
                            </div>
                            <div class="product_info">
                                <ul>
                                    <li><a href="{{URL::to('/chi-tet-san-pham/'.$brand->product_id)}}" data-toggle="modal" data-target="#modal_box" title="Quick view">Xem nhanh</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                     @endforeach
                	</div>

@endsection
