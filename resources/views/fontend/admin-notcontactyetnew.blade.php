@extends('fontend.layout.admin')
@section('content')
	<div class="span9">
		<div class="content">
			<div class="module message">
				<div style="display: flex" class="module-head">
					<h1>Accept News</h1>	
				</div>
				<div class="module-body table">
					<table class="table table-message">
						<thead>
							<tr class="heading">
								<td style="" class="cell-id">ID</td>
								<td style="width: 600px;" class="cell-author hidden-phone hidden-tablet">Title</td>
								<td style="width: 150px;" class="cell-title">Category</td>
								<td style="width: 200px;" class="cell-time">Update day</td>
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
											<a href="{{ route('acceptnew', ['id'=>$item->id]) }}"><i class="fa fa-check" aria-hidden="true"></i></a>
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
