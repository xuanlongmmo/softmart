<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\order;
use App\status_order;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\URL;

class ReportOfAccountant extends Controller implements FromCollection, WithHeadings
{
    use Exportable;

    public function collection()
    {
        $dborder = new order();
        $orders = $dborder->where('id_status',5)->orderBy('id','DESC')->whereBetween('created_at',[Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth()])->get();
        if($orders->isEmpty() == false){
            $dbuser = new User();
            foreach ($orders as $row) {
                $saler = $dbuser->where('id',$row->id_user)->get();
                $censor = $dbuser->where('id',$row->id_censor)->get();
                if(isset($saler[0]->fullname)){
                    $nameOfsaler =  $saler[0]->fullname;
                }else{
                    $nameOfsaler = 'null';
                }
                if(isset($censor[0]->fullname)){
                    $nameOfCensor =  $censor[0]->fullname;
                }else{
                    $nameOfCensor = 'null';
                }
                if(isset($row->feeforsaler)&&!empty($row->feeforsaler)){
                    $feeforsaler = $row->feeforsaler;
                }else{
                    $feeforsaler = 0;
                }
                $order[] = array(
                    '0' => $row->id,
                    '1' => $row->fullname,
                    '2' => $row->email,
                    '3' => $row->phone,
                    '4' => $row->address,
                    '5' => number_format($row->totalpay),
                    '6' => number_format($row->sale_percent),
                    '7' => $nameOfsaler,
                    '9' => $nameOfCensor,
                    '10' => $row->created_at,
                    '11' => number_format($feeforsaler),
                    '12' => number_format($row->realrevenue)
                );
            }
            return (collect($order));
        }else{
            echo "<script>alert('Báo cáo doanh thu tháng này hiện rỗng !');window.location.href='".URL::previous()."'</script>";
        }
    }

    public function headings(): array
    {
        return [
            'id',
            'Tên Khách',
            'Email',
            'Số điện thoại',
            'Địa chỉ',
            'Tổng tiền',
            'Giảm giá',
            'Saler',
            'Người giao shipper',
            'Ngày tạo đơn hàng',
            'Tiền hoa hồng của saler',
            'Doanh thu thực'
        ];
    }

    public function export(){
        return Excel::download(new ReportOfAccountant(), 'orders.xlsx');
   }
}
