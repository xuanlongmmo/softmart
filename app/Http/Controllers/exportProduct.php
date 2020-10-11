<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class exportProduct extends Controller  implements FromCollection, WithHeadings
{
    use Exportable;
    public function collection()
    {
        $products = \App\product::all();
        foreach ($products as $row) {
            $product[] = array(
                '0' => $row->id,
                '1' => $row->product_name,
                '2' => $row->price,
                '3' => $row->sale_percent,
                '4' => $row->category_product->category_name,
                '5' => $row->quantity,
                '6' => $row->sold,
                '7' => $row->created_at
            );
        }
        return (collect($product));
    }
    public function headings(): array
    {
        return [
            'Id',
            'Tên sản phẩm',
            'Giá',
            'Giảm giá',
            'Danh mục',
            'Số lượng',
            'Đã bán',
            'Ngày tạo'
        ];
    }
    public function export(){
        return Excel::download(new exportProduct(), 'product.xlsx');
   }
}
