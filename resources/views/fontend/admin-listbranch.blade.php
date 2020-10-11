@extends('fontend.layout.admin')
@section('content')
	<div class="span9">
		<div class="content">
			<div class="module message">
				<div class="module-head">
					<h3>
						List Branch</h3>
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
								<li><a href="">All</a></li>
							</ul>
						</div>
					</div>
					
				</div>
				<div class="module-body table">
					<table class="table table-message">
						<thead>
							<tr class="heading">
								<td class="cell-author hidden-phone hidden-tablet">
									Name Branch
								</td>
								<td class="cell-title">
									Address
								</td>
								<td class="cell-title">
									Phone
								</td>
								<td  class="cell-email">
									Email
                                </td>
                                <td  class="cell-icon hidden-phone hidden-tablet">
								</td>
							</tr>
						</thead>
						<tbody  style="margin-bottom: 20px">
							@foreach ($data as $item)
                                <tr class="">
                                    <td class="cell-author hidden-phone hidden-tablet">
                                        {{ $item->name_branch }}
                                    </td>
                                    <td style="width: 400px" class="cell-title">
                                        {{ $item->address }}
                                    </td>
                                    <td class="cell-title">
                                        {{ $item->phone }}
                                    </td>
                                    <td style="width: 200px;float: left"  class="cell-email">
                                        {{ $item->email }}
                                    </td>
                                    <td  class="cell-icon hidden-phone hidden-tablet">
                                        <a href="{{ route('editbranch', ['id'=>$item->id]) }}"><i style="font-size: 20px" class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
                                        @if ($item->id != 1)
                                            <i style="font-size: 20px;margin-left: 5px;color: rgb(7, 28, 214)" onclick="var result = confirm('Bạn có thực sự muốn xóa chi nhánh này?')
                                                if(result == true){
                                                    window.location.href = '{{ route('deletebranch', ['id'=>$item->id]) }}'
                                                }else{		
                                            }" class="fa fa-trash-o" aria-hidden="true">
                                            </i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
						</tbody>
					</table>
				</div>
				
			</div>
			<div style="background-color: white;margintop: 100px;width: 96%;text-align: center;min-height: 10px;align-content: center;border-radius: 10px" class="module-foot">
				<a href="{{ route('addbranch') }}"><i class="fas fa-plus" aria-hidden="true"></i></a>
			</div>
		</div>
		<!--/.content-->
	</div>
	<!--/.span9-->
@endsection
