@extends('fontend.base')
@section('content')
<form action="{{ route('completeorder') }}" method="post">
	@csrf
	<div class="payment-wrap container px-0">
		<div class="payment-form">
			<div class="step">
				<div class="billing-address">
					<div class="section-header">
						<p class="section-title">Địa chỉ nhận hàng</p>
						@if (!Auth::check())
							<p class="section-account">
								<span>Have account?</span>
								<a href="{{ route('login') }}">Signin</a>
							</p>
						@endif
					</div>
					<div class="section-content">
						<form>
							@if ($errors->has('fullname'))
								<i><strong>{{$errors->first('fullname')}}</strong></i>
							@endif
							<input type="text" name="fullname" class="form-control" id="name" placeholder="Fullname" @if (isset($data['fullname']))
								value="{{$data['fullname']}}"
							@endif required>
							@if ($errors->has('email'))
								<i><strong>{{$errors->first('email')}}</strong></i>
							@endif	
							<input type="email" name="email" class="form-control" id="email" placeholder="Email" @if (isset($data['email']))
								value="{{$data['email']}}"
							@endif required>
							@if ($errors->has('phone'))
								<i><strong>{{$errors->first('phone')}}</strong></i>
							@endif
							<input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" @if (isset($data['phone']))
								value="{{$data['phone']}}"
							@endif required>
							@if ($errors->has('address'))
								<i><strong>{{$errors->first('address')}}</strong></i>
							@endif
							<input type="text" name="address" class="form-control" id="address" placeholder="Address" @if (isset($data['address']))
								value="{{$data['address']}}"
							@endif required>
							@if (session()->has('emptyaddress'))
								<strong><i>{{session('emptyaddress')}}</i></strong>
							@endif
							<select name="province" onchange="return choosencity(this)" class="form-control">
								<option selected="" hidden="">Tỉnh/Thành phố</option>
								@foreach ($datatp as $item)
									<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
							<div id="districs">
								<select name="distric" id="" class="form-control">
									<option value="">---</option>
								</select>
							</div>
							<div id="wards">
								<select name="ward" id="" class="form-control">
									<option value="">---</option>
								</select>
							</div>
						</form>
					</div>
				</div>
	
				<div class="payment-method">
					<div class="section-header">
						<p class="section-title">Thanh toán</p>
						<p style="color: red">Chọn 1 trong 4 phương thức thanh toán</p>
					</div>
					<div class="payment-method-content">
						<div class="accordion" id="accordionExample">
							<div class="card">
								<div class="card-header" id="headingTwo">
									<div data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="custom-control custom-radio custom-control-inline">
										<input value="Thanh toán sau" type="radio" id="payment-method1" name="payment-method" class="custom-control-input" checked="checked">
										<label class="custom-control-label" for="payment-method1">Thanh toán sau</label>
									</div>
								</div>
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingOne">
									<div data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="custom-control custom-radio custom-control-inline">
										<input value="Chuyển khoản qua ngân hàng" type="radio" id="payment-method2" name="payment-method" class="custom-control-input">
										<label class="custom-control-label" for="payment-method2">Chuyển khoản qua Ngân Hàng</label>
									</div>
								</div>
	
								<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
									<div class="card-body"> <span style="color: red">*</span> Vui lòng chuyển tiền qua số tài khoản với nội dung là thanh toán đơn hàng <br> STK: {{ $datapay[0]->account_number }} <br> Ngân hàng: {{ $datapay[0]->bank_name }}<br> Tên công ty thụ hưởng: {{ $datapay[0]->company_name }}
									</div>
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingTwo">
									<div data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" class="custom-control custom-radio custom-control-inline">
										<input value="Thanh toán bằng Momo" type="radio" id="payment-method3" name="payment-method" class="custom-control-input">
										<label class="custom-control-label" for="payment-method3">Thanh toán bằng Momo</label>
									</div>
								</div>
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
								</div>
							</div>
							<div class="card">
								<div class="card-header" id="headingThree">
									<div data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree" class="custom-control custom-radio custom-control-inline">
										<input value="Thanh toán bằng VNPAY" type="radio" id="payment-method4" name="payment-method" class="custom-control-input">
										<label class="custom-control-label" for="payment-method4">Thanh toán VNPAY</label>
									</div>
								</div>
								<div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
								</div>
							</div>
						</div>
					</div>
					<div class="step-footer">
						<a class="step-footer-previous-link" href="{{ route('getcart') }}">Giỏ hàng</a>
						<button style="width: 150px;" name="button" type="submit" id="continue_button" class="step-footer-continue-btn btn">Thanh toán</button>
					</div>
				</div>
			</div>
		</div>
		<div class="cart-aside-wrap">
			<div class="cart-aside-content">
				<div class="cart-aside-product">
					<div class="payment-product-table">
						<?php
							//tong tien tat cac cac san pham
							$totalprice = 0;
							//bien check de kiem tra xem co san pham nao trong gio hang duoc giam gia hay khong
							$check = 0;
						?>
						@foreach ($dataproducts as $product)
							<div class="product">
								<div class="product-image">
									<a href="{{ route('ctsp', ['id'=>$product['id']]) }}"><img style="max-width: 65px" src="{{$product['link_image']}}"></a>
									<span class="product-thumbnail-quantity">{{session("fecart.{$product['id']}")}}</span>
								</div>
							<div class="product-info"><a href="{{ route('ctsp', ['id'=>$product['id']]) }}">{{$product['product_name']}}</a> @if ($product['sale_percent']>0)
								(-{{$product['sale_percent']}}%)
							@endif</div>
								{{-- tong tien 1 san pham = gia da giam * so luong --}}
								<div class="product-price">{{number_format((($product['price']/100) * (100-$product['sale_percent']))*session("fecart.{$product['id']}"))}} đ</div>
								@if ($product['sale_percent']>0)
									<?php
										$check = 1;
									?>
								@endif
							</div>
							{{-- tinh tong tien hang --}}
							<?php
								$totalprice += ($product['price']*session("fecart.{$product['id']}"));
							?>
						@endforeach
					</div>
				</div>
			</div>
			{{-- neu khong co san pham nao trong gio hang duoc giam gia thi cho phep su dung code --}}
			@if ($check == 0)
				@if (session('resultcheckcode'))
				<strong>{{session('resultcheckcode')}}</strong>
				@endif
				
				<div class="cart-aside-discount">
					<form style="display: flex" action="{{ route('checkcode') }}" method="get">
						@csrf
						<input class="form-control input-discount" type="text" name="serrie" placeholder="Nhập mã giảm giá" @if (session("serriecode"))
							value="{{session("serriecode")}}"
						@endif>
						<button style="width: 120px;" class="btn button-discount" type="submit">Áp mã</button>
						@if (session("checkcodesuccess")==='true')
							<div>
								<a href="{{ route('forgetcode') }}"><button style="width: fit-content" class="btn button-discount" type="button">Hủy</button></a>
							</div>
						@endif
					</form>
				</div>
			@else
				<strong>Mã giảm giá chỉ áp dụng với đơn hàng không có sản phẩm được giảm giá</strong>
			@endif
			<div class="calc-cash">
					<div class="calc-row">
						<span>Tổng tiền :</span>
						<span>{{number_format($totalprice)}} đ</span>
					</div>	
				</div>
				<div class="sum">
					
					@if (session('checkcodesuccess')==='true')
						<span>Tổng tiền sau khi áp dụng mã giảm giá : </span>
						<?php
							session()->flash('sale_percent2',session('sale_percent'));
							session()->flash('serries_code',session('serriecode'));
							$total = (($totalprice/100)*(100-session('sale_percent')));
						?>
					@else
						<span>Tổng tiền : </span>
						<?php
							$total = $totalprice;
						?>
					@endif
					{{session()->flash('totalpay',$total)}}
					<span class="price-sum">{{number_format($total)}} đ</span>
					<input type="text" style="display: none" readonly name="total" value="{{$total}}">
				</div>
			<div class="cart-aside-total">
				
			</div>
		</div>
	</div>
</form>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
	//sau khi chọn tỉnh, thành phố sẽ trả về quận, huyện
	function choosencity(e){
		$(document).ready(function(){
			idprovince = e.value;
			$.ajax({
				url:"{{route('getdistrics')}}",
				method:'GET',
				data:{
					idprovince:idprovince,
				},
				success: function(data){
					$("#districs").find("select").remove();
					$("#districs").append(data);
					$("#wards").find("select").remove();
					$("#wards").append("<select name='ward' class='form-control'><option value=''>---</option></select>");
				},
				error: function(error){
					alert('Something wrong!')
				}
			});
		});
	}

	//sau khi chọn xong quận huyện sẽ trả về phường,xã
	function choosendistric(e){
		$(document).ready(function(){
			iddistrict = e.value;
			$.ajax({
				url:"{{route('getwards')}}",
				method:'GET',
				data:{
					iddistrict:iddistrict,
				},
				success: function(data){
					$("#wards").find("select").remove();
					$("#wards").append(data);
				},
				error: function(error){
					alert('Something wrong!')
				}
			});
		});
	}

</script>
@endsection