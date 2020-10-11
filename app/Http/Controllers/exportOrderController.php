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

class exportOrderController extends Controller implements FromCollection, WithHeadings
{
    use Exportable;
    //xuat bao cao tat ca cac order ra dang excel

    public function collection()
    {
        $currentYear = date('Y');
        $dborder = new order();
        $orders = $dborder->whereYear('created_at',$currentYear)->get();
        if($orders->isEmpty() == false){
            $dbstatus = new status_order();
            $dbuser = new User();
            foreach ($orders as $row) {
                $status = $dbstatus->where('id',$row->id_status)->get();
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
                $nameStatus = $status[0]->status;
                
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
                    '8' => $nameStatus,
                    '9' => $nameOfCensor,
                    '10' => $row->created_at,
                    '11' => number_format($feeforsaler),
                    '12' => number_format($row->realrevenue)
                );
            }
            return (collect($order));
        }else{
            echo "<script>alert('Báo cáo doanh thu năm nay hiện rỗng !');window.location.href='".URL::previous()."'</script>";
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
            'Trạng thái',
            'Người giao shipper',
            'Ngày tạo đơn hàng',
            'Tiền hoa hồng của saler',
            'Doanh thu thực'
        ];
    }

    public function export(){
        return Excel::download(new exportOrderController(), 'orders.xlsx');
   }

}
