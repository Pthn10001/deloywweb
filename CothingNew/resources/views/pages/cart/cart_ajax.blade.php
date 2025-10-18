@extends('layout')
@section('content')
					<div class="shopping_cart_area"style="width: 100%;">
						<div class="row">
							<div class="col-12">
								<div class="table_desc">
									<div class="cart_page table-responsive">
										<table style="width: 100%;" >
												<tr style="font-size: 18px; border-bottom: 1px solid;;">
													<th class="product_remove">Xóa</th>
													<th class="product_thumb">Hình ảnh </th>
													<th class="product_remove">Còn</th>
													<th class="product_name">Sản phẩm </th>
													<th class="product-price">Giá</th>
													<th class="product_quantity">Số lượng</th>
													<th class="product_total">Size</th>
													<th>Thành tiền</th>
												</tr>
											@if(Session()->get('cart'))
												<?php $total=0;?>
													<form action="{{url('/update-cart')}}" method="post">
														{{csrf_field()}}
														@foreach(Session()->get('cart') as $key =>$cart)
														<?php
														$price=(int)$cart["product_price"];
														$qty=(int)$cart["product_qty"];
														$suptotal=$price*$qty;
														$total+=$suptotal;
														?>
														<tbody>
														<tr>
														<td class="product_remove">
															<a class="cart_quantity_delete" href="{{url('/delete-cart/'.$cart['session_id'])}}"><i class="fa fa-trash-o"></i></a>
														</td>
														<td class="" >
															<a href=""><img src="{{asset('upload/product/'.$cart['product_image'])}}" width="96", height="86" alt="" /></a>
														</td>
														<td>
														{{$cart["product_tong"]}}
														</td>
														<td class="product_name">
															<a>{{$cart["product_name"]}}</a>
														</td>
														<td class="product-price">
															<a>{{$cart["product_price"]}}</a>
														</td>
														<td class="cart_quantity">
														<input class="cart_quantity" type="number" name="cart_qty[{{$cart['session_id']}}]" value="{{$cart['product_qty']}}" min="1" max="{{$cart['product_tong']}}" style="width: 60px;">
														</td>

														<td>
														<input name="cart_size[{{$cart['session_id']}}]" value="{{$cart['product_size']}}">
														</td>
														<td class="product_total">
															<p class="cart_total_price">
																{{number_format($suptotal,0,',','.')}}
															</p>
														</td>
													</tr>
														</tbody>
												@endforeach
													<tr>
														<td class="cart_submit">
														<button type="submit" value="Cập nhật" name="update_cart">Cập nhật</button>
														</td>
													</tr>
													<tr style="border: solid;">
														<td>
															<ul>
																<li>Thànhtiền: <span>{{$total}}</span></li>
																<li>Thuế: <span>0</span></li>
															</ul>
														</td>
														<td >
															<ul><li>Phí ship: <span>Free</span></li>
																<li>Tổng tiền: <span>{{$total}} </span></li>
															</ul>
														</td>
													</tr>
													</tr>
														<tr>
															<td class="checkout_btn">	<?php
																$customer_id=Session()->get('customer_id');
																	if($customer_id==NULL)	{
																	?>
																	<a class="cart_submit check_out" href="{{URL::to('/login-checkout')}}">Thanh toán</a>
																<?php
																	}else
																	{
																?>
																<a class=" check_out" href="{{URL::to('/checkout')}}">Thanh toán</a>
															</td>
															<td>
																<a class="btn btn-default check_out " href="{{URL::to('/login-checkout')}}">Xóa tất cả</a>
																<?php
																	}
																?>
															</td>
														</tr>
															</div>
														</td>
													</tr>
													@else
													<tr>
														@php
																echo" Bạn chưa thêm sản phẩm vào giỏ hàng";
														@endphp
													</tr>
												</form>
												@endif
										</table>
									</div>
								</div>
								</div>
						</div>
                     </div>

    @endsection
