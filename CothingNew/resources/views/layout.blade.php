<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- SEO: dự phòng để không lỗi khi controller chưa truyền --}}
    <meta name="description" content="{{ $meta_desc ?? 'ShopClothing - Thời trang cao cấp, giao nhanh' }}">
    <meta name="keywords" content="{{ $meta_keywords ?? 'thời trang, quần áo, shop' }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ $url_canonical ?? url()->current() }}">
    <title>{{ $meta_title ?? 'ShopClothing' }}</title>

    <link rel="stylesheet" href="{{ asset('frontend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/plugin.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <script src="{{ asset('frontend/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    <link href="{{ asset('frontend/css/sweetalert.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('frontend/images/ico/favicon.ico') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
</head>

<body>
    <div class="pos_page">
        <div class="container">
            <div class="pos_page_inner">
                <!-- header -->
                <div class="header_area">
                    <!-- header top -->
                    <div class="header_top">
                        <div class="row align-items-center">
                            <div class="col-lg-6 col-md-6">
                                <div class="switcher">
                                    <ul>
                                        <li class="languages">
                                            <a href="#"><img src="{{ asset('assets/img/logo/fontlogo.jpg') }}" alt="">+0993282493</a>
                                        </li>
                                        <li class="currency">
                                            <a href="mailto:NgoMtien@gmail.com">NgoMtien@gmail.com</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6">
                                {{-- LINKS TRÊN HEADER (đã thêm Lịch sử đơn hàng) --}}
                                <div class="header_links">
                                    @php
                                    $customerId = session('customer_id');
                                    $customerName = session('customer_name');
                                    $customerEmail = session('customer_email');
                                    @endphp
                                    <ul>
                                        @if($customerId)
                                        <li>
                                            <span>Xin chào, <strong>{{ $customerName ?: $customerEmail ?: 'bạn' }}</strong></span>
                                        </li>
                                        <li>
                                            <a href="{{ url('/orders') }}"><i class="fa fa-list-alt"></i> Lịch sử đơn hàng</a>
                                        </li>
                                        <li><a href="{{ url('/checkout') }}">Thanh toán</a></li>
                                        <li><a href="{{ url('/giohang') }}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                                        <li><a href="{{ url('/logout-checkout') }}"><i class="fa fa-lock"></i> Đăng xuất</a></li>
                                        @else
                                        <li><a href="{{ url('/login-checkout') }}">Thanh toán</a></li>
                                        <li><a href="{{ url('/giohang') }}"><i class="fa fa-shopping-cart"></i> Giỏ hàng</a></li>
                                        <li><a href="{{ url('/login-checkout') }}"><i class="fa fa-lock"></i> Đăng nhập</a></li>
                                        @endif
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- header top end -->

                    <!-- header middle -->
                    <div class="header_middel">
                        <div class="row align-items-center">
                            <!-- logo -->
                            <div class="col-lg-3 col-md-3">
                                <div class="logo">
                                    <a href="{{ url('/trang-chu') }}"><img src="{{ asset('frontend/images/home/logo.jpg') }}" alt=""></a>
                                </div>
                            </div>

                            <div class="col-lg-9 col-md-9">
                                <div class="header_right_info">
                                    <div class="search_bar">
                                        <form action="{{ URL::to('/timkiem') }}" method="post">
                                            {{ csrf_field() }}
                                            <input type="text" name="submit_keyword" placeholder="Nhập từ khóa...">
                                            <button type="submit" value="Tìm kiếm"><i class="fa fa-search"></i></button>
                                        </form>
                                    </div>

                                    <div class="shopping_cart">
                                        <a href="#"><i class="fa fa-shopping-cart"></i> Giỏ hàng <i class="fa fa-angle-down"></i></a>
                                        <div class="mini_cart">
                                            @php $cart = Session()->get('cart', []); @endphp
                                            @if($cart)
                                            @foreach($cart as $item)
                                            <div class="cart_item">
                                                <div class="cart_img">
                                                    <a href="{{ url('/giohang') }}">
                                                        <img src="{{ asset('upload/product/'.$item['product_image']) }}" alt="">
                                                    </a>
                                                </div>
                                                <div class="cart_info">
                                                    <a href="{{ url('/giohang') }}">{{ $item['product_name'] ?? ('SP #'.$item['product_id']) }}</a>
                                                    <p>Giá: {{ number_format($item['product_price'] ?? 0, 0, ',', '.') }} đ</p>
                                                    <p>SL: {{ $item['product_qty'] ?? 1 }}</p>
                                                </div>
                                            </div>
                                            @endforeach
                                            @else
                                            <p class="p-3">Giỏ hàng trống.</p>
                                            @endif

                                            <div class="cart_button">
                                                <a href="{{ url('/checkout') }}">Thanh toán</a>
                                            </div>
                                        </div>
                                    </div><!-- /shopping_cart -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- header middle end -->

                    {{-- Fallback để không lỗi khi controller không truyền biến --}}
                    @php
                    $categorys = $categorys ?? collect();
                    $brands = $brands ?? collect();
                    @endphp

                    <div class="header_bottom">
                        <div class="row">
                            <div class="col-12">
                                <div class="main_menu_inner">
                                    <div class="main_menu d-none d-lg-block">
                                        <nav>
                                            <ul>
                                                <li class="active"><a href="{{ URL::to('/trang-chu') }}">Trang chủ</a></li>
                                                <li>
                                                    <a href="{{ URL::to('/trang-chu') }}">Shop</a>
                                                    <div class="mega_menu">
                                                        <div class="mega_top fix">
                                                            <div class="mega_items">
                                                                <h3><a href="#">Danh mục</a></h3>
                                                                @foreach(($categorys ?? []) as $key => $cate)
                                                                <ul>
                                                                    <li><a href="{{ URL::to('/danh-sach-san-pham/'.$cate->slug_category_product) }}">{{ $cate->category_name }}</a></li>
                                                                </ul>
                                                                @endforeach
                                                            </div>
                                                            <div class="mega_items">
                                                                <h3><a href="#">Thương hiệu</a></h3>
                                                                @foreach(($brands ?? []) as $key => $brand)
                                                                <ul>
                                                                    <li><a href="{{ URL::to('/thuong-hieu-san-pham/'.$brand->brand_id) }}">{{ $brand->brand_name }}</a></li>
                                                                </ul>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li><a href="{{ URL::to('/checkout') }}">Thanh toán</a></li>
                                                <li><a href="{{ URL::to('/giohang') }}">Giỏ hàng</a></li>
                                                <li><a href="#">Liên hệ</a></li>
                                                <li><a href="blog.html">blog</a></li>
                                                <li><a href="contact.html">contact us</a></li>
                                            </ul>
                                        </nav>
                                    </div>

                                    <div class="mobile-menu d-lg-none">
                                        <nav>
                                            <ul>
                                                <li><a href="{{ URL::to('/trang-chu') }}">Home</a></li>
                                                <li>
                                                    <a href="{{ URL::to('/trang-chu') }}">Shop</a>
                                                    <div>
                                                        <div class="mega_top fix">
                                                            <div class="mega_items">
                                                                <h3><a href="#">Danh mục</a></h3>
                                                                @foreach(($categorys ?? []) as $key => $cate)
                                                                <ul>
                                                                    <li><a href="{{ URL::to('/danh-sach-san-pham/'.$cate->slug_category_product) }}">{{ $cate->category_name }}</a></li>
                                                                </ul>
                                                                @endforeach
                                                            </div>
                                                            <div class="mega_items">
                                                                <h3><a href="#">Thương hiệu</a></h3>
                                                                @foreach(($brands ?? []) as $key => $brand)
                                                                <ul>
                                                                    <li><a href="{{ URL::to('/thuong-hieu-san-pham/'.$brand->brand_id) }}">{{ $brand->brand_name }}</a></li>
                                                                </ul>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li><a href="{{ URL::to('/checkout') }}">Thanh toán</a></li>
                                                <li><a href="{{ URL::to('/giohang') }}">Giỏ hàng</a></li>
                                                <li><a href="#">pages</a></li>
                                                <li><a href="#">blog</a></li>
                                                <li><a href="#">contact us</a></li>
                                            </ul>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- header end -->

                <!--pos home section-->
                <div class=" pos_home_section">
                    <div class="row pos_home">
                        <div class="col-lg-3 col-md-8 col-12">
                            <!--sidebar banner-->
                            <div class="sidebar_widget banner mb-35">
                                <div class="banner_img mb-35">
                                    <a href="#"><img src="{{('frontend/images/home/banner7.jpg')}}" alt=""></a>
                                </div>
                                <div class="banner_img">
                                    <a href="#"><img src="{{('frontend/images/home/banner8.jpg')}}" alt=""></a>
                                </div>
                            </div>
                            <!--sidebar banner end-->

                            <!--categorie menu start-->
                            <div class="sidebar_widget catrgorie mb-35">
                                <h3>Danh mục</h3>
                                @foreach($categorys as $key =>$cate)<ul class="list-cates">
                                    <a class="list-cate" href="{{URL::to('/danh-sach-san-pham/'.$cate->slug_category_product)}}">{{$cate->category_name}}</a>

                                </ul>
                                @endforeach
                            </div>
                            <!--categorie menu end-->

                            <!--popular tags area-->
                            <div class="sidebar_widget tags mb-35">
                                <div class="block_title">
                                    <h3>Tìm kiếm nhiều</h3>
                                </div>
                                <div class="block_tags">
                                    <a href="#">Áo thun</a>
                                    <a href="#">Áo sơ mi nam</a>
                                    <a href="#">Áo khoác </a>
                                    <a href="#">Váy xinh</a>
                                    <a href="#">Quần jean</a>
                                    <a href="#">Giày thể thao</a>
                                    <a href="#">Túi xách</a>
                                </div>
                            </div>
                            <!--popular tags end-->

                            <!--newsletter block start-->
                            <div class="sidebar_widget newsletter mb-35">
                                <div class="block_title">
                                    <h3>Thông báo</h3>
                                </div>
                                <form action="#">
                                    <p>Đăng ký nhận thông báo của bạn</p>
                                    <input placeholder="Email" type="text">
                                    <button type="submit">Đăng ký</button>
                                </form>
                            </div>
                            <!--newsletter block end-->
                        </div>
                        <div class="col-lg-9 col-md-12">
                            <!--banner slider start-->
                            <div class="banner_slider slider_1">
                                <div class="slider_active owl-carousel">
                                    <div class="single_slider" style="background-image: url(frontend/images/home/slider_2.png)">
                                        <div class="slider_content">
                                            <div class="slider_content_inner">
                                                <h1>Thiên đường mua sắm</h1>
                                                <p>Thời trang cao cấp, uy tín, chất lượng vận chuyển nhanh chóng!</p>
                                                <a href="{{URL::to('/trang-chu')}}">shop now</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single_slider" style="background-image: url(frontend/images/home/slider_2.png)">
                                        <div class="slider_content">
                                            <div class="slider_content_inner">
                                                <h1>Giá cả phải chăng </h2>
                                                    <p>Thời trang cao cấp, uy tín, chất lượng vận chuyển nhanh chóng! </p>
                                                    <a href="{{URL::to('/trang-chu')}}">shop now</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single_slider" style="background-image: url(frontend/images/home/slider_3.png)">
                                        <div class="slider_content">
                                            <div class="slider_content_inner">
                                                <h1>Chất lượng làm nên thương hiệu </h2>
                                                    <p>Thời trang cao cấp, uy tín, chất lượng vận chuyển nhanh chóng! </p>
                                                    <a href="{{URL::to('/trang-chu')}}">shop now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--banner slider start-->

                            <!--content-->
                            <div class="featured_product">
                                <div class="row">
                                    @yield('content')
                                </div>
                            </div>
                            <!--content-->

                            <!--banner area start-->
                            <div class="banner_area mb-60">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="single_banner">
                                            <a href="#"><img src="{{('frontend/images/home/banner7.jpg')}}" alt=""></a>
                                            <div class="banner_title">
                                                <p>Lên đến <span> 40%</span> Giảm</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="single_banner">
                                            <a href="#"><img src="{{('frontend/images/home/banner8.jpg')}}" alt=""></a>
                                            <div class="banner_title title_2">
                                                <p>Giảm giá <span> 30%</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--banner area end-->

                            <!--brand logo strat-->
                            <div class="brand_logo mb-60">
                                <div class="block_title">
                                    <h3>Brands</h3>
                                </div>
                                <div class="row">
                                    <div class="brand_active owl-carousel">
                                        @foreach($brands as $key=>$brand)
                                        <div class="col-lg-2">
                                            <div class="single_brand">
                                                <li class="hass" style="width: 80px;height: 28px; background-color: #00bba6; font-size: 18px;"><a style="padding: 6px;" href="{{URL::to('/thuong-hieu-san-pham/'.$brand->brand_id)}}">{{$brand->brand_name}}</a></li>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <!--brand logo end-->
                        </div>
                    </div>
                </div>
                <!--pos home section end-->
            </div>
            <!--pos page inner end-->
        </div>
    </div>
    <footer id="footer" style="background-color: #00bba6; color: #fff;"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <h2 style="color: #fff; font-size: 25px; margin-top: 26px;"><span>SHOP</span>Colthing</h2>
                            <p>Thời trang cao cấp, uy tín, chất lượng vận chuyển nhanh chóng!</p>
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="col-sm-3">
                            <div class="video-gallery text-center">
                                <a href="#">
                                    <div class="footer-img">

                                    </div>
                                    <div class="overlay-icon">
                                        <i class="fa fa-play-circle-o"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="{{('frontend/images/home/map.png')}}" alt="" />
                            <p>Quận Thanh Khê - Thành Phố Đà Nẵng<< /p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2 style="color: #fff; font-size: 25px;">MUA HÀNG TRỰC TUYẾN</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">0935938598</a></li>
                                <li><a href="#">NgoMTien@gmail.com</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2 style="color: #fff; font-size: 25px;">HOTLINE GÓP Ý</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">0935938598</a></li>
                                <li><a href="#">NgoMTien@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2 style="color: #fff ; font-size: 25px">Thông tin</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Về chúng tôi</a></li>
                                <li><a href="#">Liên hệ</a></li>
                                <li><a href="#">Đối tác</a></li>
                                <li><a href="#">Tuyển dụng</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="single-widget">
                            <h2 style="color: #fff; font-size: 25px;">Chính sách</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Chính sách đổi hàng</a></li>
                                <li><a href="#">Chính sách bảo mật</a></li>
                                <li><a href="#">Chính sách bảo hành </a></li>
                                <li><a href="#">Chính sách hoàn tiền</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-3 col-sm-offset-1">
                        <div class="single-widget">
                            <h2 style="color: #fff; font-size: 25px;">FAQ</h2>
                            <form action="#" class="searchform">
                                <input type="text" placeholder="Địa chỉ email" />
                                <button type="submit" class="btn btn-default"><i class="fa fa-arrow-circle-o-right"></i></button>
                                <p>Nhận các bản cập nhật gần đây nhất từ
                                    trang web của chúng tôi và được cập nhật bản thân của bạn ...</p>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p class="pull-left">Copyright © 2013 NMT.</p>
                </div>
            </div>
        </div>

    </footer><!--/Footer-->

    <script src="{{asset('frontend/js/vendor/jquery-1.12.0.min.js')}}"></script>
    <script src="{{asset('frontend/js/popper.js')}}"></script>
    <script src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('frontend/js/ajax-mail.js')}}"></script>
    <script src="{{asset('frontend/js/plugins.js')}}"></script>
    <script src="{{asset('frontend/js/main.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <!-- Messenger Plugin chat Code -->
    <div id="fb-root"></div>

    <!-- Your Plugin chat code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
        var chatbox = document.getElementById('fb-customer-chat');
        chatbox.setAttribute("page_id", "107148281781373");
        chatbox.setAttribute("attribution", "biz_inbox");

        window.fbAsyncInit = function() {
            FB.init({
                xfbml: true,
                version: 'v12.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = 'https://connect.facebook.net/vi_VN/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>


    <script type="text/javascript">
        $(document).ready(function() {
            $('.send_order').click(function() {

                var shipping_email = $('.shipping_email').val();
                var shipping_name = $('.shipping_name').val();
                var shipping_phone = $('.shipping_phone').val();
                var shipping_address = $('.shipping_address').val();
                var shipping_notes = $('.shipping_notes').val();
                var payment_method = $('.payment_method').val();

                var _token = $('input[name="_token"]').val();


                $.ajax({
                    url: "{{url('order')}}",
                    method: 'post',
                    data: {
                        shipping_email: shipping_email,
                        shipping_name: shipping_name,
                        shipping_phone: shipping_phone,
                        shipping_address: shipping_address,
                        shipping_notes: shipping_notes,
                        payment_method: payment_method,
                        _token: _token
                    },
                    success: function(data) {
                        swal("Mua hàng thành công!");
                        location.reload();
                    }
                });
            });
        });
    </script>

    <!-- <script type="text/javascript">
        $(document).ready(function(){
            $('.add-to-cart').click(function(){
                var id =$(this).data('id');
                var cart_product_id =$('.cart_product_id_'+id).val();
                var cart_product_name=$('.cart_product_name_'+id).val();
                var cart_product_image=$('.cart_product_image_'+id).val();
                var cart_product_price=$('.cart_product_price_'+id).val();
                var cart_product_qty=$('.cart_product_qty_'+id).val();
                var cart_product_size = [];
                    $('.cart_product_size').each(function(){
                            if($(this).is(":checked"))
                            {
                                cart_product_size.push($(this).val());
                            }
                    });
                    cart_product_size = cart_product_size.toString();

                var _token=$('input[name="_token"]').val();


                $.ajax({
                    url:"{{url('/add-cart-ajax')}}",
                    method:'post',
                    data:{cart_product_id:cart_product_id,cart_product_name:cart_product_name,cart_product_image:cart_product_image,
                        cart_product_price:cart_product_price,cart_product_qty:cart_product_qty,cart_product_size:cart_product_size,_token:_token},
                        success:function(data){
                            swal("Đã thêm sản phẩm vào giỏ hàng!")
                        }
                });

            });
        });
        </script> -->
</body>

</html>