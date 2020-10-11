@extends('fontend.layout.admin')
@section('content')
	<div class="span9">
		<div class="content">
			<div class="module message">
				<div class="module-head">
					<h3>
						List Users</h3>
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
								<li><a href="{{ route('listctv', ['type'=>'all']) }}">All</a></li>
								<li><a href="{{ route('listctv', ['type'=>'sale']) }}">sale</a></li>
                                <li><a href="{{ route('listctv', ['type'=>'collaboratorproduct']) }}">CTV Product</a></li>
                                <li><a href="{{ route('listctv', ['type'=>'collaboratorblog']) }}">CTV Blog</a></li>
							</ul>
						</div>
					</div>
					<div class="pull-right" style="display: flex">
						<div class="btn-group" style="margin-left: 10px">
							<button class="btn">
								Print the report
							</button>
							<button class="btn dropdown-toggle" data-toggle="dropdown">
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu">
								<li><a href="{{ route('printreportforsalethismonth') }}">Current month</a></li>
								<li><a href="{{ route('printreportforsalelastmonth') }}">Last month</a></li>
								<li><hr></li>
								<li><a href="printreportforsalethisweek">Current Week</a></li>
								<li><hr></li>
								<li><a href="printreportforsalethisyear">Current Year</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="module-body table">
					<table class="table table-message">
						<thead>
							<tr class="heading">
								<td class="cell-author hidden-phone hidden-tablet">
									Fullname
								</td>
								<td class="cell-title">
									Username
								</td>
								<td class="cell-title">
									Email
								</td>
								<td class="cell-icon hidden-phone hidden-tablet">
									Position
								</td>
								<td class="cell-time align-right">
									Date
								</td>
							</tr>
						</thead>
						<tbody>
							@if (!empty($data))
								@foreach ($data as $user)
									@if ($user->id_group == 3 || $user->id_group ==4 || $user->id_group ==5)
										<tr class="read">
											<td class="cell-author hidden-phone hidden-tablet">
												<a href="{{ route('profile', ['id'=>$user->id]) }}">{{$user->fullname}}</a>
											</td>
											<td class="cell-title">
												{{$user->username}}
											</td>
											<td class="cell-title">
												{{$user->email}}
											</td>
											<td class="cell-icon hidden-phone hidden-tablet">
												{{Ucwords($user->group_user->group_name)}}
											</td>
											<td class="cell-time align-right">
												{{date_format($user->created_at,'Y-m-d')}}
											</td>
										</tr>
									@endif
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
		<nav aria-label="Page navigation example" style="text-align: center">
			{{$data->links() }}
		</nav>
	</div>
	<!--/.span9-->
@endsection
