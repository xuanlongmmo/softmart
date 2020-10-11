@extends('fontend.layout.admin')
@section('content')
	<div class="span9">
		<div class="content">
			<div class="module message">
				<div style="display: flex" class="module-head">
					<h1>List News</h1>	
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
								@foreach ($listca as $item)
									<li><a href="{{ route('listnew', ['category'=>$item->slug_name]) }}">{{ $item->news_name }}</a></li>
								@endforeach
								<li class="divider"></li>
								<li><a href="#">Settings</a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="module-body table">
					<table class="table table-message">
						<thead>
							<tr class="heading">
								{{-- <td class="cell-check">
									<input type="checkbox" class="inbox-checkbox">
								</td>
								<td class="cell-icon">
								</td> --}}
								<td style="" class="cell-id">ID</td>
								<td style="width: 600px;" class="cell-author hidden-phone hidden-tablet">Title</td>
								<td style="width: 150px;" class="cell-title">Category</td>
								<td style="width: 200px;" class="cell-time">Create day</td>
                                <td style="width: 100px;" class="cell-button"></td>
							</tr>
						</thead>
						<tbody>
							@if (!empty($listnew))
								@foreach ($listnew as $item)
									<tr class="unread">
										<td class="cell-id">{{ $item->id }}</td>
										<td class="cell-author hidden-phone hidden-tablet">{{ $item->title }}</td>
										<td class="cell-title">{{ $item->category_news->news_name }}</td>
										<td class="cell-time">
											@if ($item->created_at!=null)
												{{Carbon\Carbon::parse($item->created_at)->format('H:i d-m-Y')}}
											@endif
										</td>
										<td class="cell-button">
											@if ((Auth::user()->id_group == 2) || Auth::user()->id_group == 6)
												<i style="font-size: 20px;margin-left: 5px;color: rgb(7, 28, 214)" onclick="var result = confirm('Bạn có thực sự muốn xóa sản phẩm này?')
												if(result == true){
													window.location.href = '{{URL::to('admin/deletenew?id='.$item->id)}}'
												}else{
													
												}"class="fa fa-trash-o" aria-hidden="true"></i>
											@elseif (Auth::user()->id_group == 3)
											<a href="{{ route('editnew', ['id'=>$item->id]) }}"><i style="font-size: 20px" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
											@endif
										</td>
									</tr>
								@endforeach
							@endif
							{{-- <nav aria-label="Page navigation" style="text-align: center">
								<b>{{$list->links() }}</b>
							</nav> --}}
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
