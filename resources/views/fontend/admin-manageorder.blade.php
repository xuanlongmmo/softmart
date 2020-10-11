@extends('fontend.layout.admin')
@section('content')
	<div class="span9">
		<div class="content">
			<div class="module message">
				<div style="display: flex" class="module-head">
					<h1>List Order</h1>	
				</div>
				<div class="module-option clearfix">
					<div class="pull-left">
						<div class="btn-group">
							<button class="btn">
								Filter</button>
							<button class="btn dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a href="{{ route('manageorder', ['status'=>'all']) }}">Tất cả</a></li>
								<li style="display: flex"><a href="{{ route('manageorder', ['status'=>'notcontactyet']) }}">Chưa liên hệ</a><b style="color: red">@if (isset($quantityNewOrder))
									({{number_format($quantityNewOrder)}})
								@endif</b></li>
								<li><a href="{{ route('manageorder', ['status'=>'wait']) }}">Đang chờ duyệt</a></li>
								<li style="display: flex"><a href="{{ route('manageorder', ['status'=>'approval']) }}">Đã Chốt</a><b style="color: red">@if (isset($quantityNewOrderCompleteSale) && $quantityNewOrderCompleteSale > 0)
									({{number_format($quantityNewOrderCompleteSale)}})
								@endif</b></li>
								<li><a href="{{ route('manageorder', ['status'=>'delivered']) }}">Thành công</a></li>
								<li><a href="{{ route('manageorder', ['status'=>'cancel']) }}">Đã hủy</a></li>
								<li class="divider"></li>
								<li><a href="#">Settings</a></li>
							</ul>
						</div>
					</div>
					<?php
						$checkprint = 0;
						foreach(Auth::user()->permission as $permission){
							if($permission->slug_name == 'in-bao-cao'){
								$checkprint = 1;
							}
						}
					?>
					@if ($checkprint == 1)
						<div class="pull-right">
							<form action="{{ route('printreportorder') }}" method="get">
								<button type="submit">Print the report</button>
							</form>
						</div>
					@endif
				</div>
				<div class="module-body table">
					<table class="table table-message">
						<thead>
							<tr class="heading">
								<td style="" class="cell-id">ID</td>
                                <td style="width: 200px;" class="cell-author hidden-phone hidden-tablet">Fullname</td>
                                <td style="width: 120px;" class="cell-phone">Phone</td>
								<td style="width: 150px;" class="cell-title">Total Money</td>
								<td style="width: 150px;" class="cell-quantity">Status</td>
								<td style="width: 170px;" class="cell-time">Update day</td>
								<td style="width: 170px;" class="cell-time">Fee for saler</td>
                                <td style="width: 100px;" class="cell-button"></td>
							</tr>
						</thead>
						<tbody>
							@if (!empty($data))
								@foreach ($data as $item)
									@if ($item->id_status==1)
										<tr class="unread">
									@else
										<tr class="read">
									@endif
										<td class="cell-id">{{ $item->id }}</td>
										<td class="cell-author hidden-phone hidden-tablet">{{ $item->fullname }}</td>
										<td class="cell-phone">{{ $item->phone }}</td>
										<td class="cell-title">{{ number_format($item->totalpay) }}</td>
										<td class="cell-quantity">
											@if ($item->id_status == 5)
												<span style="color: rgb(0, 174, 255)">{{ $item->status_order->status }}</span>
												<i style="color: chartreuse" class="fa fa-check" aria-hidden="true"></i>
											@else 
												<span>{{ $item->status_order->status }}</span>
											@endif    
										</td>
										<td class="cell-time">
											@if ($item->created_at!=null)
												{{Carbon\Carbon::parse($item->created_at)->format('H:i d-m-Y')}}
											@endif
										</td>
										<td class="cell-button">
											@if (isset($item->feeforsaler)&&!empty($item->feeforsaler))
												{{number_format($item->feeforsaler)}}
											@endif
										</td>
										<td class="cell-button">
											<a href="{{ route('detailorder', ['id'=>$item->id]) }}">Detail</a>
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
