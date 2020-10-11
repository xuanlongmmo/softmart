@extends('fontend.layout.admin')
@section('content')
	<div class="span9">
		<div class="content">
			<div class="module message">
				<div style="display: flex" class="module-head">
					<h1>List Product Not Accept Yet</h1>	
				</div>
				<div class="module-body table">
					<table class="table table-message">
						<thead>
							<tr class="heading">
								<td style="" class="cell-id">ID</td>
								<td style="width: 200px;" class="cell-author hidden-phone hidden-tablet">Product Name</td>
								<td style="width: 150px;" class="cell-title">Price</td>
								<td style="width: 150px;" class="cell-quantity">Inventory number</td>
								<td style="width: 200px;" class="cell-time">Update day</td>
                                <td style="width: 100px;" class="cell-button"></td>
							</tr>
						</thead>
						<tbody>
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
										<a href="{{ route('accept-editproduct', ['id'=>$item->id]) }}"><i style="font-size: 20px" <i class="fa fa-check" aria-hidden="true"></i></a>
								
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
