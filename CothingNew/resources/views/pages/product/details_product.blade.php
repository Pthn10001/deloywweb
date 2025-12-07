@extends('layout1')
@section('content')
    @foreach($detail_product as $key => $value)
        <div class="product_details">
            <div class="row">
                <div class="col-lg-5 col-md-6">
                    <div class="product_tab fix">
                        <div class="tab-content produc_tab_c">
                            <div class="tab-pane fade show active" id="p_tab1" role="tabpanel">
                                <div class="modal_img">
                                    <a href="#"><img src="{{ URL::to('upload/product/' . $value->product_image) }}" alt=""></a>
                                    <div class="img_icone">
                                        <img src="{{ URL::to('upload/product/' . $value->product_image) }}" alt="">
                                    </div>
                                    <div class="view_img">
                                        <a class="large_view" href="{{ URL::to('upload/product/' . $value->product_image) }}">
                                            <i class="fa fa-search-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- THÔNG TIN SẢN PHẨM --}}
                <div class="col-lg-7 col-md-6">
                    <div class="product_d_right">
                        <h1>{{ $value->product_name }}</h1>

                        <div class="product_desc">
                            <p>{{ $value->product_content }}</p>
                        </div>

                        <div class="content_price mb-15">
                            <span>{{ number_format($value->product_price) }}đ</span>

                            @if($value->product_quantity > 0)
                                <p><b>Tình trạng: </b> {{ $value->product_quantity }} sản phẩm</p>
                            @else
                                <p><b>Tình trạng:</b> Hết hàng</p>
                            @endif

                            <p><b>Danh mục:</b> {{ $value->category_name }}</p>
                            <p><b>Thương hiệu:</b> {{ $value->brand_name }}</p>
                        </div>

                        {{-- CHỌN SIZE + SỐ LƯỢNG --}}
                        <div class="box_quantity mb-20">
                            @if($value->product_quantity > 0)
                                <form>
                                    @csrf

                                    <input type="hidden" value="{{ $value->product_id }}"
                                        class="cart_product_id_{{ $value->product_id }}">
                                    <input type="hidden" value="{{ $value->product_name }}"
                                        class="cart_product_name_{{ $value->product_id }}">
                                    <input type="hidden" value="{{ $value->product_image }}"
                                        class="cart_product_image_{{ $value->product_id }}">
                                    <input type="hidden" value="{{ $value->product_price }}"
                                        class="cart_product_price_{{ $value->product_id }}">
                                    <input type="hidden" value="{{ $value->product_quantity }}"
                                        class="cart_product_quantity_{{ $value->product_id }}">

                                    <label style="font-size:20px;">Số lượng:</label>
                                    <input type="number" min="1" value="1" class="cart_product_qty_{{ $value->product_id }}"
                                        style="width:70px; margin-bottom:10px;">

                                    <br>
                                    <label style="font-size:20px;">Chọn size:</label><br>

                                    <label style="font-size:18px; margin-right:10px;">
                                        <input type="radio" name="size_{{ $value->product_id }}" value="S"
                                            class="cart_product_size"> S
                                    </label>

                                    <label style="font-size:18px; margin-right:10px;">
                                        <input type="radio" name="size_{{ $value->product_id }}" value="M"
                                            class="cart_product_size"> M
                                    </label>

                                    <label style="font-size:18px;">
                                        <input type="radio" name="size_{{ $value->product_id }}" value="L"
                                            class="cart_product_size"> L
                                    </label>



                                    <br><br>

                                    <button type="button" class="btn btn-primary add-to-cart" data-id="{{ $value->product_id }}">
                                        <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                    </button>
                                </form>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>

        {{-- SẢN PHẨM ĐỀ XUẤT --}}
        <div class="new_product_area product_page">
            <div class="row">
                <div class="col-12">
                    <div class="block_title">
                        <h3>CÁC ĐỀ MỤC ĐƯỢC ĐỀ XUẤT:</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="single_p_active owl-carousel">
                    @foreach($related as $rel)
                        <div class="col-lg-3">
                            <div class="single_product">
                                <div class="product_thumb">
                                    <a href="{{ URL::to('/chi-tet-san-pham/' . $rel->product_id) }}">
                                        <img src="{{ URL::to('upload/product/' . $rel->product_image) }}" alt="">
                                    </a>
                                    <div class="product_action">
                                        <a href="{{ URL::to('/chi-tet-san-pham/' . $rel->product_id) }}">
                                            <i class="fa fa-shopping-cart"></i> Thêm vào giỏ hàng
                                        </a>
                                    </div>
                                </div>
                                <div class="product_content">
                                    <span class="product_price">{{ number_format($rel->product_price) }}đ</span>
                                    <h3 class="product_title">
                                        <a href="{{ URL::to('/chi-tet-san-pham/' . $rel->product_id) }}">{{ $rel->product_name }}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    @endforeach
@endsection

{{-- ================================================
JS: CHỌN 1 SIZE + GỬI AJAX ĐÚNG FORMAT CŨ
================================================ --}}
@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {

            // CHỌN 1 SIZE
            document.querySelectorAll(".box_quantity").forEach(group => {
                const sizes = group.querySelectorAll(".cart_product_size");
                sizes.forEach(cb => {
                    cb.addEventListener("change", function () {
                        if (this.checked) {
                            sizes.forEach(other => {
                                if (other !== this) other.checked = false;
                            });
                        }
                    });
                });
            });

            // THÊM VÀO GIỎ HÀNG
            document.querySelectorAll(".add-to-cart").forEach(btn => {
                btn.addEventListener("click", function () {

                    const id = this.dataset.id;
                    const form = this.closest("form");
                    const size = form.querySelector(".cart_product_size:checked");

                    if (!size) {
                        alert("Vui lòng chọn size!");
                        return;
                    }

                    const data = {
                        cart_product_id: form.querySelector(`.cart_product_id_${id}`).value,
                        cart_product_name: form.querySelector(`.cart_product_name_${id}`).value,
                        cart_product_image: form.querySelector(`.cart_product_image_${id}`).value,
                        cart_product_price: form.querySelector(`.cart_product_price_${id}`).value,
                        cart_product_quantity: form.querySelector(`.cart_product_quantity_${id}`).value,
                        cart_product_qty: form.querySelector(`.cart_product_qty_${id}`).value,
                        cart_product_size: size.value,
                        _token: form.querySelector("[name=_token]").value
                    };

                    // AJAX
                    $.ajax({
                        url: "/add-cart-ajax",
                        method: "POST",
                        data: data,
                        success: function () {
                            alert("Đã thêm sản phẩm size " + size.value + " vào giỏ hàng!");
                        },
                        error: function (err) {
                            console.log(err);
                            alert("Lỗi thêm giỏ hàng!");
                        }
                    });

                });
            });

        });
    </script>
@endpush