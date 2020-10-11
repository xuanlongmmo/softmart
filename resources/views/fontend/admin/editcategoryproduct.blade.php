@extends('fontend.layout.admin')
@section('content')
    <div class="span9">
        <div>
            <form action="{{ route('savecategorynameproduct') }}" method="post">
                @csrf
                <label for="categoryname">Category Name</label>
                <input type="text" id="categoryname" name="categoryname" value="{{$category[0]->category_name}}">
                <input style="display: none" readonly id="idcategory" type="text" name="idcategory" value="{{$category[0]->id}}">
                <button style="margin-bottom: 10px" type="submit">Save Category Name</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <td>ID Product</td>
                    <td>Name Product</td>
                    <td>Image</td>
                </tr>
            </thead>
            <tbody>
                @if (!empty($products))
                    <?php
                        $arrProducts = [];
                        $i=0;
                        foreach ($products as $product) {
                            $arrProducts[$i] = $product->id;
                            $i++;
                        }
                    ?>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->product_name}}</td>
                            <td><img style="max-width: 90px;" src="{{ asset($product->link_image) }}" alt=""></td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <button id="addproduct" data-toggle="modal" data-target="#modalcategoryproduct" style="background-color: white;width: 100%;text-align: center;min-height: 30px;align-content: center;border-radius: 10px">
            <i class="fas fa-plus"></i>
        </button>
        <!-- Modal -->
        <div style="" class="modal fade" id="modalcategoryproduct" role="dialog">
            <div class="modal-dialog">
            
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Danh sách sản phẩm</h4>
                </div>
                <div class="modal-body">
                @if (!empty($products))
                    @foreach ($listProduct as $item)
                        @if (in_array($item->id,$arrProducts))
                            <div style="display: flex">
                                <input onchange="return changelist(this)" checked value="{{$item->id}}" type="checkbox" name="{{$item->id}}" id="{{$item->id}}">
                                &nbsp;
                                <span>{{$item->id}} - </span>
                                &nbsp;
                                <span>{{$item->product_name}}</span>
                                &nbsp;
                                <span> ({{$item->category_product->category_name}})</span>
                            </div>
                        @else
                            <div style="display: flex">
                                <input onchange="return changelist(this)" value="{{$item->id}}" type="checkbox" id="{{$item->id}}">
                                &nbsp;
                                <span>{{$item->id}} - </span>
                                &nbsp;
                                <span>{{$item->product_name}}</span>
                                &nbsp;
                                <span> ({{$item->category_product->category_name}})</span>
                            </div>
                        @endif
                    @endforeach
                @else
                    @foreach ($listProduct as $item)
                        <div style="display: flex">
                            <input type="checkbox" value="{{$item->id}}" id="{{$item->id}}">
                            &nbsp;
                            <span>{{$item->id}} - </span>
                            &nbsp;
                            <span>{{$item->product_name}}</span>
                        </div>
                    @endforeach
                @endif
                </div>
                <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
	<script>
		function changelist(e){
            idproduct = e.value;
            idcategory = document.getElementById('idcategory').value;
            
            if(e.checked){
                $.ajax({
                    url:"{{route('editchangeidcategoryproduct')}}",
                    method:'GET',
                    data:{
                        idproduct:idproduct,
                        idcategory:idcategory
                    },
                    success: function(data){
                        $("tbody").find("tr").remove();
					    $("tbody").append(data);
                    },
                    error: function(error){
                        alert('Something wrong!')
                    }
			    });
            }else{
                alert('Để cập nhật lại danh mục cho sản phẩm này hãy chỉnh sửa danh sách sản phẩm danh mục bạn muốn thêm vào')
            }
        }
	</script>
@endsection