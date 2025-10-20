@extends('layout1')
@section('content')
				<!-- customer login start -->
				<div class="customer_login">
					<div class="row">
						<!--login area start-->
						<div class="col-lg-6 col-md-6">
							<div class="account_form">
								<h2>Đăng nhập vào tài khoản của bạn</h2>
								<?php
									$message = Session()->get('message');
									echo '<div style="color: red;text-align: center">',$message,'</div>';
									Session()->put('message',null);
								?>
								<form action="{{URL::to('/login-customer')}}" method="post">
								{{ csrf_field() }}
								<p>   
									<label>Email address  <span>*</span></label>
									<input type="email" name="email_accout" placeholder="Email" />
								</p> 
								<p>   
									<label>Passwords <span>*</span></label>
									<input type="text" name="password_accout" placeholder="Password" />
								</p>   	
									<div class="login_submit">
										<button type="submit" class="btn btn-default">Đăng nhập</button>
										<label for="remember">
												<input id="remember" type="checkbox" class="checkbox">
												Giữ cho tôi đăng nhập
											</label>
											<a href="#">Quên mật khẩu?</a>
									</div>
								</form>
								</div>    
						</div>
						<!--login area start-->

						<!--register area start-->
						<div class="col-lg-6 col-md-6">
							<div class="account_form register">
								<h2>Đăng ký!</h2>
								<form action="{{URL::to('/add-customer')}}" method="post">
									{{ csrf_field() }}
										<label>Name  <span>*</span></label>		
										<input type="text" name="customer_name" placeholder="Name"/>	
										<label>Email   <span>*</span></label>									
										<input type="email" name="customer_email" placeholder="Email Address"/>
										<label>Password  <span>*</span></label>																	
										<input type="password" name="customer_password" placeholder="Password"/>
										<label>Phone  <span>*</span></label>														   		
										<input type="text" name="customer_phone" placeholder="phone"/>
										<p></p>
										<div class="login_submit">
										<button type="submit" class="btn btn-default">Đăng kí</button>
										</div>
								</form>
									
							</div>    
						</div>
						<!--register area end-->
					</div>
				</div>
				<!-- customer login end -->
@endsection