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
								Filter
							</button>
							<button class="btn dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a href="{{ route('listordercomplete', ['status'=>'currentmonth']) }}">Current month</a></li>
								<li><a href="{{ route('listordercomplete', ['status'=>'lastmonth']) }}">Last month</a></li>
							</ul>
						</div>
					</div>
					<div class="pull-right">
						<div class="btn-group">
							<button class="btn">
								Print the report
							</button>
							<button class="btn dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a href="{{ route('printreportforaccountant') }}">Current month</a></li>
								<li><a href="{{ route('printreportforaccountantlastmonth') }}">Last month</a></li>
							</ul>
						</div>
					</div>
				</div>
				
				<div class="module-body table">
					<table class="table table-message">
						<thead>
							<tr class="heading">
								<td style="" class="cell-id">ID</td>
                                <td style="width: 200px;" class="cell-author hidden-phone hidden-tablet">Fullname</td>
                                <td style="width: 120px;" class="cell-phone">Saler</td>
								<td style="width: 150px;" class="cell-title">Total Money</td>
								<td style="width: 150px;" class="cell-quantity">Status</td>
								<td style="width: 170px;" class="cell-time">Created day</td>
								<td style="width: 170px;" class="cell-time">Fee for Saler</td>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
								@if ($item->id_status==1)
									<tr class="unread">
								@else
									<tr class="read">
								@endif
									<td class="cell-id">{{ $item->id }}</td>
									<td class="cell-author hidden-phone hidden-tablet">{{ $item->fullname }}</td>
									<td class="cell-phone">{{ $item->id_user }}</td>
									<td class="cell-title">{{ number_format($item->totalpay) }}</td>
									<td class="cell-quantity">
										@if ($item->id_status == 5)
											<span style="color: rgb(0, 174, 255)">{{ $item->status_order->status }}</span>
											<i style="color: chartreuse" class="fa fa-check" aria-hidden="true"></i>
										@elseif($item->id_status == 6)
											<span style="color: black">{{ $item->status_order->status }}</span>
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
									<td class="cell-time">
										@if ($item->feeforsaler!=null)
											{{number_format($item->feeforsaler)}}
										@endif
									</td>
								</tr>
							@endforeach
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
