<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <title>Admin | Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{ asset('backend/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/style-responsive.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/font.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/morris.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/monthly.css') }}">
</head>

<body>
    <section id="container">
        <!-- Header -->
        <header class="header fixed-top clearfix">
            <div class="brand">
                <a href="{{ url('/dashboard') }}" class="logo">ADMIN</a>
                <div class="sidebar-toggle-box">
                    <div class="fa fa-bars"></div>
                </div>
            </div>

            <div class="top-nav clearfix">
               
                <ul class="nav pull-right top-menu">
                    <li>
                        <input type="text" class="form-control search" placeholder="Tìm kiếm">
                    </li>

                    {{-- USER DROPDOWN --}}
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                            {{-- Logo: ưu tiên file .png, nếu không có thì fallback sang .jpg --}}
                            <img
                                src="{{ asset('frontend/images/home/logo.png') }}"
                                
                                alt="logo" style="height:26px">
                            <span class="username">{{ Session()->get('admin_name') ?? 'Admin' }}</span>
                            <b class="caret"></b>
                        </a>

                        <ul class="dropdown-menu extended logout">
                            {{-- Nếu sau này bạn có route hồ sơ/cài đặt thì thay # bằng url/route tương ứng --}}
                            <li><a href="#"><i class="fa fa-suitcase"></i> Hồ sơ</a></li>
                            <li><a href="#"><i class="fa fa-cog"></i> Cài đặt</a></li>

                            
                            <li>
                                <a href="{{ url('/logout') }}">
                                    <i class="fa fa-key"></i> Đăng xuất
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

            </div>
        </header>
        <!-- /Header -->

        <!-- Sidebar -->
        <aside>
            <div id="sidebar" class="nav-collapse">
                <div class="leftside-navigation">
                    <ul class="sidebar-menu" id="nav-accordion">
                        <li>
                            <a class="{{ request()->is('dashboard') ? 'active' : '' }}" href="{{ url('/dashboard') }}">
                                <i class="fa fa-dashboard"></i> <span>Tổng Quan</span>
                            </a>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;" class="{{ request()->is('manager-order') || request()->is('view-order/*') ? 'active' : '' }}">
                                <i class="fa fa-book"></i> <span>Quản lý đơn hàng</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{ url('/manager-order') }}">Danh sách đơn hàng</a></li>
                            </ul>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;" class="{{ request()->is('*-category-product*') ? 'active' : '' }}">
                                <i class="fa fa-list"></i> <span>Danh mục sản phẩm</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{ url('add-category-product') }}">Thêm danh mục</a></li>
                                <li><a href="{{ url('all-category-product') }}">Danh sách danh mục</a></li>
                            </ul>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;" class="{{ request()->is('*-brand-product*') ? 'active' : '' }}">
                                <i class="fa fa-tags"></i> <span>Thương hiệu</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{ url('add-brand-product') }}">Thêm thương hiệu</a></li>
                                <li><a href="{{ url('all-brand-product') }}">Danh sách thương hiệu</a></li>
                            </ul>
                        </li>

                        <li class="sub-menu">
                            <a href="javascript:;" class="{{ request()->is('*-product*') ? 'active' : '' }}">
                                <i class="fa fa-cube"></i> <span>Sản phẩm</span>
                            </a>
                            <ul class="sub">
                                <li><a href="{{ url('add-product') }}">Thêm sản phẩm</a></li>
                                <li><a href="{{ url('all-product') }}">Danh sách sản phẩm</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ url('/logout') }}">
                                <i class="fa fa-sign-out"></i> <span>Đăng xuất</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <!-- /Sidebar -->

        <!-- Main -->
        <section id="main-content">
            <section class="wrapper">
                @yield('admin_content')
            </section>

            <div class="footer">
                <div class="wthree-copyright">
                    <p>© 2021 Luxury</p>
                </div>
            </div>
        </section>
        <!-- /Main -->
    </section>

    {{-- JS (đúng thứ tự) --}}
    <script src="{{ asset('backend/js/jquery2.0.3.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>

    <script src="{{ asset('backend/js/jquery.dcjqaccordion.2.7.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ asset('backend/js/jquery.scrollTo.js') }}"></script>
    <script src="{{ asset('backend/js/scripts.js') }}"></script>

    <script src="{{ asset('backend/js/raphael-min.js') }}"></script>
    <script src="{{ asset('backend/js/morris.js') }}"></script>
    <script src="{{ asset('backend/js/monthly.js') }}"></script>

    <script src="{{ asset('backend/ckeditor/ckeditor.js') }}"></script>

    <script>
        // CSRF cho mọi Ajax
        (function() {
            var token = document.querySelector('meta[name="csrf-token"]');
            if (token && window.jQuery) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': token.getAttribute('content')
                    }
                });
            }
        })();

        // CKEditor: chỉ bật khi có textarea tương ứng
        if (document.getElementById('brand_product_desc')) {
            CKEDITOR.replace('brand_product_desc');
        }
        if (document.getElementById('category_product_desc')) {
            CKEDITOR.replace('category_product_desc');
        }

        // Calendar demo – chỉ chạy khi có thẻ #mycalendar / #mycalendar2
        $(window).on('load', function() {
            if ($('#mycalendar').length) {
                $('#mycalendar').monthly({
                    mode: 'event'
                });
            }
            if ($('#mycalendar2').length) {
                $('#mycalendar2').monthly({
                    mode: 'picker',
                    target: '#mytarget',
                    setWidth: '250px',
                    startHidden: true,
                    showTrigger: '#mytarget',
                    stylePast: true,
                    disablePast: true
                });
            }
        });

        // ====== JS hỗ trợ trang View Order (chỉ kích hoạt nếu có các selector tương ứng) ======
        $(function() {
            // Cập nhật số lượng từng dòng
            $(document).on('click', '.order_update_btn', function() {
                var order_product_id = $(this).data('product_id');
                var $qtyInput = $('.order_qty_' + order_product_id);
                var order_qty = $qtyInput.val();
                var order_code = $('.order_code').val();
                var product_quantity = $('.product_quantity_' + order_product_id).val();

                if (!order_product_id || !order_code) return;

                var q = parseInt(order_qty, 10) || 0;
                var max = parseInt(product_quantity, 10) || 0;

                if (q < 1) {
                    alert('Số lượng phải >= 1');
                    return;
                }
                if (q > max) {
                    alert('Số lượng mua vượt quá hàng trong kho!');
                    return;
                }

                $.post("{{ url('/update-qty') }}", {
                    order_product_id: order_product_id,
                    order_qty: order_qty,
                    order_code: order_code
                }).done(function() {
                    alert('Thay đổi hoàn tất!');
                    location.reload();
                }).fail(function(xhr) {
                    alert('Lỗi khi cập nhật số lượng: ' + (xhr.status || ''));
                });
            });

            // Cập nhật trạng thái đơn
            $(document).on('change', '.order_details', function() {
                var order_status = $(this).val();
                var order_id = $(this).children(':selected').attr('id');
                if (!order_id) return;

                var quantity = [];
                $('input[name="product_sales_quantity"]').each(function() {
                    quantity.push($(this).val());
                });

                var order_product_id = [];
                $('input[name="order_product_id"]').each(function() {
                    order_product_id.push($(this).val());
                });

                $.post("{{ url('/update-order') }}", {
                    order_status: order_status,
                    order_id: order_id,
                    quantity: quantity,
                    order_product_id: order_product_id
                }).done(function() {
                    alert('Cập nhật hoàn tất!');
                    location.reload();
                }).fail(function(xhr) {
                    alert('Lỗi khi cập nhật trạng thái: ' + (xhr.status || ''));
                });
            });
        });
    </script>

    {{-- View con có thể @push script riêng --}}
    @stack('scripts')
</body>

</html>