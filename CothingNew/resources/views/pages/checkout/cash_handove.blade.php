@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Thanh toán giỏ hàngt</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="shopper-informations">
				<div class="row">
					
				
					


			<h4 style="margin-bottom: 42px; font-size: 30px;">Cảm ơn quý khách đã mua hàng</h4>
			<p>Hàng đang được giao </p>
            <img src="https://www.ntm.com.vn/content_ntm/upload/Image/nhat-thien-minh-hinh-thuc-giao-hang-mien-phi.jpg" alt="">
		</div>
	</section> <!--/#cart_items-->

@endsection