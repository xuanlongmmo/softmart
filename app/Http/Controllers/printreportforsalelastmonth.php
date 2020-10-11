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

class printreportforsalelastmonth extends Controller implements FromCollection, WithHeadings
{
    use Exportable;
    //xuat bao cao tat ca cac order ra dang excel

    public function collection()
    {
        $dborder = new order();
        $end = Carbon::now()->startofMonth()->subMonth()->endOfMonth();
        $orders = $dborder->whereBetween('created_at',[Carbon::now()->startOfMonth()->subMonth(1),$end])->where('id_status',5)->get();
        if($orders->isEmpty() == false){
            $dbuser = new User();
            foreach ($orders as $row) {
                $saler = $dbuser->where('id',$row->id_user)->get();
                if(isset($row->feeforsaler)&&!empty($row->feeforsaler)){
                    $feeforsaler = $row->feeforsaler;
                }else{
                    $feeforsaler = 0;
                }
                $order[] = array(
                    '0' => $row->id,
                    '1' => $row->id_user,
                    '2' => $saler[0]->fullname,
                    '3' => number_format($feeforsaler)
                );
            }
            return (collect($order));
        }else{
            echo "<script>alert('Báo cáo doanh thu tháng trước hiện rỗng !');window.location.href='".URL::previous()."'</script>";
        }
    }

    public function headings(): array
    {
        return [
            'Id Order',
            'Id saler',
            'Tên saler',
            'Tiền hoa hồng'
        ];
    }

    public function export(){
        return Excel::download(new printreportforsalelastmonth(), 'orders.xlsx');
   }

}
