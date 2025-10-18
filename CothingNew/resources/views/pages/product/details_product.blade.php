@extends('layout1')
@section('content')
    @foreach($detail_product as $key=>$value)
        <div class="product_details">
            <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="product_tab fix">

                            <div class="tab-content produc_tab_c">
                                <div class="tab-pane fade show active" id="p_tab1" role="tabpanel">
                                    <div class="modal_img">
                                        <a href="#"><img src="{{URL::to('upload/product/'.$value->product_image)}}" alt=""></a>
                                        <div class="img_icone">
                                            <img src="{{URL::to('upload/product/'.$value->product_image)}}" alt="">
                                        </div>
                                        <div class="view_img">
                                            <a class="large_view" href="{{URL::to('upload/product/'.$value->product_image)}}"><i class="fa fa-search-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6">
                        <div class="product_d_right">
                            <h1>{{$value->product_name}}</h1>
                                <div class="product_ratting mb-10">
                                <ul>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"><i class="fa fa-star"></i></a></li>
                                    <li><a href="#"> Nhận xét</a></li>
                                </ul>
                            </div>
                            <div class="product_desc">
                                <p>{{$value->product_content}}</p>
                            </div>

                            <div class="content_price mb-15">
                                <span>{{$value->product_price}}</span>
                            @if($value->product_quantity>0)
                                <p><b>Tình trạng: </b>
                                {{$value->product_quantity}}sản phẩm
                            @else
                                        Hết hàng
                                </p>
                                @endif
                                <p><b>Danh mục: </b>{{$value->category_name}}</p>
                                <p><b>Brand:    </b>{{$value->brand_name}}</p>

                            </div>
                            <div class="box_quantity mb-20">
                                @if($value->product_quantity>0)
                            <form >
                                @csrf
                                    <input type="hidden" value="{{$value->product_id}}" class="cart_product_id_{{$value->product_id}}">
                                    <input type="hidden" value="{{$value->product_name}}" class="cart_product_name_{{$value->product_id}}">
                                    <input type="hidden" value="{{$value->product_image}}" class="cart_product_image_{{$value->product_id}}">
                                    <input type="hidden" value="{{$value->product_price}}" class="cart_product_price_{{$value->product_id}}">
                                    <input type="hidden" value="{{$value->product_quantity}}" class="cart_product_quantity_{{$value->product_id}}">
                                    <input type="hidden" value="1" class="cart_product_qty_{{$value->product_id}}">
                                    <label style="font-size: 26px;margin-bottom: 4px;">S</label>
                                    <input type="checkbox"  value="S" class="cart_product_size" style="width: 24px;"/>
                                    <label style="font-size: 26px;">M</label>
                                    <input type="checkbox"  value="M" class="cart_product_size"style="width: 24px;"/>
                                    <label style="font-size: 26px;">L</label>
                                    <input type="checkbox"  value="L" class="cart_product_size"style="width: 24px;"/>


                                    <button type="button" class="btn btn-default add-to-cart" data-id="{{$value->product_id}}" name="add-to-cart">Thêm vào giỏ hàng </button>
                            </form>
                            @endif

                        </div>
                        <div
                                class="fb-like"
                                data-share="true"
                                data-width="460"
                                data-show-faces="true">
                                </div>
                            </div>
                    </div>
                </div>
        </div>
        <!--dexuat start-->
        <div class="new_product_area product_page">
            <div class="row">
                <div class="col-12">
                    <div class="block_title">
                    <h3>  CÁC ĐỀ MỤC ĐƯỢC ĐỀ XUẤT:</h3>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="single_p_active owl-carousel">
                @foreach($related as $key =>$value)
                    <div class="col-lg-3">
                        <div class="single_product">
                            <div class="product_thumb">
                                <a href="{{URL::to('/chi-tet-san-pham/'.$value->product_id)}}"><img src="{{URL::to('upload/product/'.$value->product_image)}}" alt=""></a>
                                <div class="product_action">
                                    <a href="{{URL::to('/chi-tet-san-pham/'.$value->product_id)}}"> <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                            <div class="product_content">
                                <span class="product_price">{{$value->product_price}}</span>
                                <h3 class="product_title"><a href="{{URL::to('/chi-tet-san-pham/'.$value->product_id)}}">{{$value->product_name}}</a></h3>
                            </div>
                            <div class="product_info">
                                <ul>
                                    <li><a href="{{URL::to('/chi-tet-san-pham/'.$value->product_id)}}" data-toggle="modal" data-target="#modal_box" title="Quick view">Xem chi tiết</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
        <!--dexuat start-->
@endsection























