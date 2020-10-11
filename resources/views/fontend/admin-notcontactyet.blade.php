@extends('fontend.layout.admin')
@section('content')
	<div class="span9">
		<div class="content">
			<div class="module message">
				<div style="display: flex" class="module-head">
					<h1>List Order</h1>
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
                                <td style="width: 100px;" class="cell-button"></td>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!empty($data))
                                @foreach ($data as $item)
                                    <tr @if ($item->id_status>2)
                                        class="read"
                                    @else
                                    class="unread"
                                    @endif >
                                        <td class="cell-id">{{ $item->id }}</td>
                                        <td class="cell-author hidden-phone hidden-tablet">{{ $item->fullname }}</td>
                                        <td class="cell-phone">{{ $item->phone }}</td>
                                        <td class="cell-title">{{ number_format($item->totalpay) }}</td>
                                        <td class="cell-quantity">@if ($item->id_status == 2 || $item->id_status == 1)
                                            Chưa liên hệ
                                        @else
                                            Đã liên hệ
                                        @endif</td>
                                        <td class="cell-time">
                                            @if ($item->created_at!=null)
                                                {{Carbon\Carbon::parse($item->created_at)->format('H:i d-m-Y')}}
                                            @endif
                                        </td>
                                        <td class="cell-button">
                                            <a href="{{ route('saledetailorder', ['id'=>$item->id]) }}">Detail</a>
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
