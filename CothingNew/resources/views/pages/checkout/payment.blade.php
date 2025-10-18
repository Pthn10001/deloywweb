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




				</div>
			</div>
			<div class="review-payment">
				<h2>Xem lại giỏ hàng</h2>
				<div class="table-responsive cart_info">
				<?php
				use Gloudemans\Shoppingcart\Facades\Cart;
				$content=Cart::content();
					// echo '<pre>';
					// print_r($content);
					// echo '</pre>';
				?>
				<table class="table table-condensed" style="width: 86%;">
					<thead>
						<tr class="cart_menu">
							<td class="image">Hình ảnh </td>
							<td class="image">Sản phẩm </td>
							<td class="price">Giá</td>
							<td class="quantity">Số lượng</td>
							<td class="total">Tổng quan</td>
							<td></td>
						</tr>
					</thead>
					<tbody>
						@foreach($content as $key => $v_content)
						<tr>
							<td class="cart_product">
								<a href=""><img src="{{URL::to('upload/product/'.$v_content->options->image)}}" width="50" alt="" /></a>
							</td>
							<td class="cart_description">
								<h4><a href="">{{$v_content->name}}</a></h4>
								<p>Size:{{$v_content->weight}}</p>
							</td>
							<td class="cart_price">
								<p>{{number_format($v_content->price).'đ'}}</p>
							</td>
							<td class="cart_quantity">
								<div class="cart_quantity_button">
										<form action="{{URL::to('/update-cart')}}" method="post">
											{{csrf_field()}}
											<input class="cart_quantity_input" type="number" name="quantyti" value="{{$v_content->qty}}"size="2" style="width: 60px;">
											<input type="hidden" name="rowId_cart" value="{{$v_content->rowId}}"/>
											<input type="submit" value="Cập nhật" name="update_cart" style="font-size: 16px;background-color: #20B2AA;">

										</form>
								</div>
							</td>
							<td class="cart_total">
								<p class="cart_total_price">
									<?php
										$subbtotal=$v_content->price * floatval($v_content->qty);
										echo number_format($subbtotal).'đ';
									?>
								</p>
							</td>
							<td class="cart_delete">
								<a class="cart_quantity_delete" href="{{URL::to('/delete-cart/'.$v_content->rowId)}}"><i class="fa fa-times"></i></a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			</div>


			<h4 style="margin-bottom: 42px; font-size: 30px;">Chọn hình thức thanh toán</h4>
			<form action="{{URL::to('/order')}}" method="post">
			{{ csrf_field() }}
				<div class="payment-options">
					<span>
						<label><input name="payment_option" value="1" type="checkbox"> Thanh toán thẻ bằng tín dụng</label>
					</span>
					<span>
						<label><input name="payment_option" value="2" type="checkbox"> Thanh toán bằng tiền mặt</label>
					</span>
					<span>
						<label><input name="payment_option" value="3" type="checkbox"> Thanh toán bằng creditcard</label>
					</span>
					<input type="submit"  value="Thanh toán" name="send_oder_detail" class="btn btn-primary"></button>
				</div>
			</form>
		</div>
	</section> <!--/#cart_items-->

@endsection
