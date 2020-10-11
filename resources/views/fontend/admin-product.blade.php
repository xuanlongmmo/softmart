@extends('fontend.layout.admin')
@section('content')
	<div class="span9">
		<div class="content">
			<div class="module message">
				<div style="display: flex" class="module-head">
					<h1>List Product</h1>	
				</div>
				<div  class="module-option clearfix">
					<div style="display: flex" class="pull-left">
						<?php
							$checkshow = 0;
							foreach(Auth::user()->permission as $permission){
								if($permission->slug_name == 'xem-danh-sach-san-pham'){
									$checkshow = 1;
								}
							}
						?>
						@if ($checkshow == 1)
							<div class="btn-group">
								<button class="btn">
									Filter</button>
								<button class="btn dropdown-toggle" data-toggle="dropdown">
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
									@foreach ($listca as $item)
										<li><a href="{{ route('product', ['category'=>$item->slug_name]) }}">{{ $item->category_name }}</a></li>
									@endforeach
								</ul>
							</div>
						@endif
						<div>
							<form style="margin-left: 670px" action="{{ route('exportlistproduct') }}">
								@csrf
								<input type="submit" name="export" value="Xuất Excel">
							</form>
						</div>
					</div>
				</div>
				<div class="module-body table">
					<table id='tblistproduct' class="table table-message">
						<thead>
							<tr class="heading">
								<td style="" class="cell-id">ID</td>
								<td style="width: 200px;" class="cell-author hidden-phone hidden-tablet">Product Name</td>
								<td style="width: 150px;" class="cell-title">Price</td>
								<td style="width: 150px;" class="cell-quantity">Inventory number</td>
								<td style="width: 200px;" class="cell-time">Update day</td>
                                <td style="width: 100px;" class="cell-button">Action</td>
							</tr>
						</thead>
						<tbody>
							@if (!empty($list))
								@foreach ($list as $item)
									<tr class="unread">
										<td class="cell-id">{{ $item->id }}</td>
										<td class="cell-author hidden-phone hidden-tablet">{{ $item->product_name }}</td>
										<td class="cell-title">{{ number_format($item->price) }}</td>
										<td class="cell-quantity">{{ $item->quantity - $item->sold }}</td>
										<td class="cell-time">
											@if ($item->updated_at!=null)
												{{Carbon\Carbon::parse($item->updated_at)->format('H:i d-m-Y')}}
											@endif
										</td>
										<td class="cell-button">
											<?php
												$checkedit = 0;
												$checkdelete = 0;
												foreach(Auth::user()->permission as $permission){
													if($permission->slug_name == 'sua-san-pham'){
														$checkedit = 1;
													}
													if($permission->slug_name == 'xoa-san-pham'){
														$checkdelete = 1;
													}
												}
											?>
											@if ($checkdelete == 1)
												<i style="font-size: 20px;margin-left: 5px;color: rgb(7, 28, 214)" onclick="var result = confirm('Bạn có thực sự muốn xóa sản phẩm này?')
													if(result == true){
														window.location.href = '{{URL::to('admin/deleteproduct?id='.$item->id)}}'
													}else{		
												}"class="fa fa-trash-o" aria-hidden="true"></i>
											@endif
											@if ($checkedit == 1)
											<a href="{{ route('editproduct', ['id'=>$item->id]) }}"><i style="font-size: 20px" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
											@endif
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>		
				</div>
				<div class="module-foot">
				</div>
			</div>
		</div>
		<!--/.content-->
	</div>
	<!--/.span9-->
@endsection
