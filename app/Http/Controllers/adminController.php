<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\validateproduct;
use App\Http\Requests\validatenew;
use App\Http\Requests\validatebranch;
use App\Http\Requests\createsubadmin;

use App\category_product;
use App\category_news;
use App\news;
use App\product;
use App\role_permission;
use Carbon\Carbon;
use App\sale;
use App\infor_website;
use App\group_user;
use App\inforcontact;
use App\order;
use App\order_detail;
use App\status_order;
use App\user_permission;
use App\User;
use App\review_product;
use App\section;
use App\section_content;
use App\comment_product;
use App\comment;
use App\policy;
use App\category_policy;

use Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

//khai bao request
use App\Http\Requests\profile;

class adminController extends Controller
{
    public function admin(Carbon $carbon){
        //thong ke doanh thu theo thang
        //khai bao bien doanh thu theo thang
        $revenue = 0;
        $revenueLastMonth = 0;
        $ordercomplete = 0;
        $ordercancel = 0;
        $orderofmonth = 0;
        $dbOrder = new order();
        $totalOrder = $dbOrder->whereBetween('created_at',[$carbon::now()->startOfMonth()->subMonth(1),$carbon::now()->endOfMonth()])->get();
        foreach($totalOrder as $order){
            //cat chuoi de lay thoi gian cua order
            $time = explode('-',$order->created_at);
            //neu thoi gian order nam trong thang hien tai thi cong vao doanh thu
            //time[1] la thang cua order
            $monthOfOrder = intval($time[1]);
            //dem tong so order trong thang nay
            if($monthOfOrder == $carbon::now()->format('m')){
                $orderofmonth += 1;
            }
            //tinh doanh thu thuc thang nay
            if($monthOfOrder == $carbon::now()->format('m') && $order->id_status == 5){
                $ordercomplete += 1;
                $revenue += $order->realrevenue;
            }
            //dem so order bi huy trong thang nay
            if($monthOfOrder == $carbon::now()->format('m') && $order->id_status == 4){
                $ordercancel += 1;
            }
            //tinh doanh thu thang truoc
            if($monthOfOrder == $carbon::now()->subMonth()->format('m') && $order->id_status == 5){
                $revenueLastMonth += $order->realrevenue;
            }
        }
        //tinh do trang truong doang thu thang nay so voi thang truoc
        if($revenueLastMonth > 0){
            $grow = (($revenue / $revenueLastMonth) -1) * 100;
            if($grow<=0){
                $grow = 0;
            }
        }else{
            $grow = 0;
        }

        //thong ke so nguoi dung moi dang ky trong thang
        $dbUser = new User();
        $totalUsers = $dbUser->whereBetween('created_at',[$carbon::now()->startOfMonth(),$carbon::now()->endOfMonth()])->count();

        if($orderofmonth!=0){
            $rateorder = array(
                // $orderofmonth
                "complete" => ($ordercomplete/($ordercomplete+$ordercancel))*100,
                'cancel' => ($ordercancel/($ordercomplete+$ordercancel))*100
            );
        }else{
            $rateorder = array(
                "complete" => 0,
                'cancel' => 0
            );
        }

        return view('fontend.admin-dashboard',['revenue'=>$revenue,'newUsers'=>$totalUsers,'grow'=>$grow,'rateorder'=>$rateorder]);
    }

    public function addproduct(){
        $category = new category_product();
        $listcategory = $category->get();
        return view('fontend.admin-addproduct',['listcategory'=>$listcategory]);
    }

    public function postaddproduct(validateproduct $request){
        $db = new product();
        $db->product_name = $request->nameproduct;
        //luu anh vao folder
        $imageName = time().'.'.$request->image->getClientOriginalExtension();
        $request->image->move(public_path('products'), $imageName);

        $imageName2 = time().'.'.$request->image2->getClientOriginalExtension();
        $request->image2->move(public_path('products'), $imageName2);

        $imageName3 = time().'.'.$request->image3->getClientOriginalExtension();
        $request->image3->move(public_path('products'), $imageName3);

        //lưu vào DB
        $db->link_image = "public/products/".$imageName;
        $db->link_image2 = "public/products/".$imageName2;
        $db->link_image3 = "public/products/".$imageName3;
        $db->price = $request->price;
        $db->sale_percent = $request->sale;
        $db->quantity = $request->quantity;
        $db->id_category = $request->id_category;
        $db->id_user = Auth::user()->id;
        $db->description = $request->description;
        $db->feeforsaler = $request->feesale;
        $db->save();
        echo "<script>alert('Thêm thành công!!');history.back();</script>";
    }

    public function product(){
        $db = new product();
        $ca = new category_product();
        $listca = $ca->get();
        if(isset($_GET['category'])&&!empty($_GET['category'])){
            $category = $_GET['category'];
            foreach($listca as $item){
                if($category == $item->slug_name){
                    $list = $db->where('status',1)->where('id_category',$item->id)->orderBy('created_at','DESC')->get();
                }
            }
        }else if(empty($_GET['category'])){
            $list = $db->where('status',1)->orderBy('created_at','DESC')->get();
        }
        return view('fontend.admin-product',['list'=>$list,'listca'=>$listca]);
    }

    public function searchproduct(){

        if(isset($_GET['q']) && !empty($_GET['q'])){
            $q = $_GET['q'];
        }else{
            $q = "noresult";
        }
        $db = new product();
        $ca = new category_product();
        $listca = $ca->get();
        if(isset($_GET['category'])&&!empty($_GET['category'])){
            $category = $_GET['category'];
            foreach($listca as $item){
                if($category == $item->slug_name){
                    $list = $db->where('id_category',$item->id)->orderBy('created_at','DESC')->get();
                }
            }
        }else if(empty($_GET['category'])){
            $list = $db->orderBy('created_at','DESC')->get();
        }
        $list = $db->where('id',$q)->orwhereRaw("product_name LIKE '%{$q}%' ")->get();;
        // Paginate(15)
        return view('fontend.admin-product',['list'=>$list,'listca'=>$listca]);
    }

    public function deleteproduct(){
        $id = $_GET['id'];
        $db = new product();
        $delete = $db->where('id',$id)->delete();
        return redirect()->back();
    }

    public function editproduct(){
        $id = $_GET['id'];
        $category = new category_product();
        $listcategory = $category->get();
        $db = new product();
        $product = $db->where('id',$id)->get();
        return view('fontend.admin-editproduct',['listcategory'=>$listcategory,'product'=>$product[0]]);
    }

    public function posteditproduct(validateproduct $request){
        $id = $_GET['id'];
        $db = new product();
        $db->where('id',$id)->update([
            'product_name' => $request->nameproduct,
            'link_image' => $request->linkimage,
            'price' => $request->price,
            'sale_percent' => $request->sale,
            'quantity' => $request->quantity,
            'id_category' => $request->id_category,
            'id_user' => Auth::user()->id,
            'status' => 0
            ]);
        echo "<script>alert('Sửa thành công!!');history.back();</script>";
        return redirect()->route('product');
    }

    public function manageorder(){
        //thong ke so tin nhan chua tra loi (tra ve cho header)
        $dbinforcontact = new inforcontact();
        $quantityMessageUnread = $dbinforcontact->where('status',0)->count();
        //neu khong ton tai tin nhan chua doc nao thi tra ve 0
        if($quantityMessageUnread<=0){
            $quantityMessageUnread = 0;
        }

            //biến để thông báo những order cần xử lí
            $totalChange = 0;
            //thong ke don hang moi
            $dborder = new order();
            $quantityNewOrder = $dborder->where('id_status',1)->count();
            if($quantityNewOrder<=0){
                $quantityNewOrder = 0;
            }
            $totalChange += $quantityNewOrder;

            //thống kê đơn hàng đã chốt đơn sale thành công nhưng chưa giao hàng
            $quantityNewOrderCompleteSale = $dborder->where('id_status',3)->count();
            if($quantityNewOrderCompleteSale<=0){
                $quantityNewOrderCompleteSale = 0;
            }
            $totalChange += $quantityNewOrderCompleteSale;
        $db = new order();
        if(isset($_GET['status'])&&!empty($_GET['status'])){
            $status = $_GET['status'];
            if($status == 'all'){
                $data = $db->orderBy('created_at','DESC')->get();
            }elseif($status == 'notcontactyet'){
                $data = $db->where('id_status',1)->orderBy('id','DESC')->get();
            }elseif($status == 'approval'){
                $data = $db->where('id_status',3)->orderBy('id','DESC')->get();
            }elseif($status == 'cancel'){
                $data = $db->where('id_status',4)->orderBy('id','DESC')->get();
            }elseif($status == 'wait'){
                $data = $db->where('id_status',2)->orderBy('id','DESC')->get();
            }elseif($status == 'delivered'){
                $data = $db->where('id_status',5)->orderBy('id','DESC')->get();
            }
        }elseif(empty($_GET['status'])){
            $data = $db->orderBy('id','DESC')->get();
        }

        //thong ke don hang moi
        $dborder = new order();
        $quantityNewOrder = $dborder->where('id_status',1)->count();
        if($quantityNewOrder<=0){
            $quantityNewOrder = 0;
        }

        //thống kê đơn hàng đã chốt đơn sale thành công nhưng chưa giao hàng
        $quantityNewOrderCompleteSale = $dborder->where('id_status',3)->count();
        return view('fontend.admin-manageorder',['data'=>$data,'quantityNewOrder'=>$quantityNewOrder,'quantityNewOrderCompleteSale'=>$quantityNewOrderCompleteSale]);
    }

    public function searchorder(){

        if(isset($_GET['q']) && !empty($_GET['q'])){
            $q = $_GET['q'];
        }else{
            $q = "noresult";
        }
        $db = new order();
        $list = $db->where('id',$q)->orwhereRaw("fullname LIKE '%{$q}%' ")->orderBy('created_at','DESC')->get();;
        return view('fontend.admin-manageorder',['data'=>$list]);
    }

    public function detailorder(){
        $id = $_GET['id'];
        $dborder = new order();
        $dataorder = $dborder->where('id',$id)->get();
        $dborderproduct = new order_detail();
        $dataorderproduct = $dborderproduct->where('id_order',$id)->get();
        $dbsale = new sale();
        $temp = $dbsale->where('id_order',$id)->get();
        $dbuser = new User();
        if($temp->isEmpty()===false){
            //nếu đơn hàng đã được chọn người liên hệ thì sẽ trả về thông tin người đó trong đơn hàng
            $user = $dbuser->find($temp[0]->id_saler);
            return view('fontend.admin-detailorder',['dataorder'=>$dataorder[0],'dataorderproduct'=>$dataorderproduct,'checksale'=>$temp,'user'=>$user]);
        }else{
            //neu chua duoc phan cho saler nao lien lac, se lay ra cac saler de chon nguoi lien lac
            $users = $dbuser->where('id_group',5)->get();
            return view('fontend.admin-detailorder',['dataorder'=>$dataorder[0],'dataorderproduct'=>$dataorderproduct,'users'=>$users]);
        }
    }

    public function chooseSaler(Request $request){
        if(empty($request->get('id_order')) || empty($request->get('id_saler'))){
            return redirect()->back();
        }else{
            $id_order = $request->get('id_order');
            $id_saler = $request->get('id_saler');
            $db = new sale();
            $db->id_saler = $id_saler;
            $db->id_order = $id_order;
            $db->save();

            //thong bao don hang moi ve mail cho saler
            //lay ra mail cua saler duoc chi dinh
            $dbuser = new User();
            $mailSaler = $dbuser->where('id',$id_saler)->get('email');

            $content = 'Bạn có đơn hàng mới chưa liên hệ Mọi thông tin liên hệ xin gửi về: Email: sunshineweb.vn@gmail.com Phone: 0989735559';
            Mail::raw($content, function ($message) use($mailSaler) {
                $message->from('sunshineweb.vn@gmail.com', 'SoftMart');
                $message->to($mailSaler[0]->email,$mailSaler[0]->email);
                $message->subject('Đơn hàng mới chưa liên hệ');
            });

            //cap nhat trang thai don hang : da giao saler
            $dborder = new order();
            $dborder->where('id',$id_order)->update(['id_status'=>2]);
            echo "<script>alert('Chọn người liên hệ thành công !');window.location.href='".URL::previous()."'</script>";
        }
    }

    //task saler
    //route dành cho sale vào xem những đơn hàng của mình chưa liên lạc với khách
    public function notContactYet(){
        $id_saler  = Auth::user()->id;
        $db = new sale();
        $temp = $db->where('id_saler',$id_saler)->get();
        if($temp->isEmpty() === false){
            $IDs = "0";
            foreach($temp as $t){
                $IDs = $IDs . ','.$t->id_order;
            }
            $dborder = new order();
            $data = $dborder->whereRaw("id IN({$IDs})")->orderBy('created_at','DESC')->get();
            return view('fontend.admin-notcontactyet',['data'=>$data]);
        }else{
            return view('fontend.admin-notcontactyet');
        }
    }

    public function saleDetailOrder(){
        $id = $_GET['id'];
        $dborder = new order();
        $dataorder = $dborder->where('id',$id)->get();
        $dborderproduct = new order_detail();
        $dataorderproduct = $dborderproduct->where('id_order',$id)->get();
        $dbsale = new sale();
        $temp = $dbsale->where('id_order',$id)->get();
        $dbuser = new User();
        if($temp->isEmpty()===false){
            //nếu đơn hàng đã được chọn người liên hệ thì sẽ trả về thông tin người đó trong đơn hàng
            $user = $dbuser->find($temp[0]->id_saler);
            return view('fontend.sale-detailorder',['dataorder'=>$dataorder[0],'dataorderproduct'=>$dataorderproduct,'checksale'=>$temp,'user'=>$user]);
        }else{
            //neu chua duoc phan cho saler nao lien lac, se lay ra cac saler de chon nguoi lien lac
            $users = $dbuser->where('id_group',5)->get();
            return view('fontend.sale-detailorder',['dataorder'=>$dataorder[0],'dataorderproduct'=>$dataorderproduct,'users'=>$users]);
        }
    }

    //het task saler

    public function processorder(Request $request){
        $id = $request->id;
        $db = new order();
        $data = $db->where('id',$id)->get();
        //cap nhat trang thai don hang thanh da chot hoac da huy don hang
        if(isset($_POST['approval'])){
            //bao don hang saler chot thanh cong ve cho admin
            //lay ra email cua admin
            $dbuser = new User();
            $mailAdmin = $dbuser->where('id_group',6)->get('email');
            //gui email
            $content = 'Một đơn hàng mới đã chốt sale thành công. Mọi thông tin liên hệ xin gửi về: Email: sunshineweb.vn@gmail.com Phone: 0989735559';
            Mail::raw($content, function ($message) use($mailAdmin) {
                $message->from('sunshineweb.vn@gmail.com', 'SoftMart');
                $message->to($mailAdmin[0]->email,$mailAdmin[0]->email);
                $message->subject('Đơn hàng mới chốt thành công');
            });

            //bao don hang saler chot thanh cong cho ke toan
            //lay ra email cua ke toan
            $dbuser = new User();
            $mailAccountant = $dbuser->where('id_group',7)->get('email');
            //gui email
            $content = 'Một đơn hàng mới đã chốt sale thành công. Mọi thông tin liên hệ xin gửi về: Email: sunshineweb.vn@gmail.com Phone: 0989735559';
            Mail::raw($content, function ($message) use($mailAccountant) {
                $message->from('sunshineweb.vn@gmail.com', 'SoftMart');
                $message->to($mailAccountant[0]->email,$mailAccountant[0]->email);
                $message->subject('Đơn hàng mới chốt thành công');
            });

            //tinh tien hoa hong cho saler
            $dborderdetail = new order_detail();
            $dbproduct = new product();
            $feeforsaler = 0;
            $Order = $dborderdetail->where('id_order',$id)->get();
            foreach($Order as $row){
                $temp = $dbproduct->where('id',$row->id_product)->get();
                $percent = $temp[0]->feeforsaler;
                $price = (($temp[0]->price/100)*(100-$temp[0]->sale_percent));
                $quantity = $row->quantity;
                $feeforsaler += $percent*($price/100)*$quantity;
            }

            $thisOrder = $db->where('id',$id)->get();
            $totalPay = intval($thisOrder[0]->totalpay);
            $realRevenue = $totalPay - $feeforsaler;

            $update = $db->where('id',$id)->update([
                'id_status' => 3,
                'feeforsaler' => $feeforsaler,
                'realrevenue' => $realRevenue
            ]);
            $dbsale = new sale();
            $up = $dbsale->where('id_order',$id)->update([
                'status' => 1
            ]);
            $content = 'Xin chào '.$data[0]->fullname.'. Đơn hàng của bạn đã được duyệt thành công và sẽ được giao trong vòng 5-7 ngày tới. Cảm ơn bạn đã tin tưởng chúng tôi. Mọi thông tin liên hệ xin gửi về: Email: sunshineweb.vn@gmail.com Phone: 0989735559';
            Mail::raw($content, function ($message) use($data) {
                $message->from('sunshineweb.vn@gmail.com', 'SoftMart');
                $message->to($data[0]->email,$data[0]->fullname);
                $message->subject('Thư xác nhận đơn hàng');
            });
        }else if(isset($_POST['cancel'])){
            //Nếu bị hủy update lại số lượng
            $dborderdetail = new order_detail();
            $dbproduct = new product();
            $Order = $dborderdetail->where('id_order',$id)->get();
            
            foreach($Order as $row){
                $soldold = $dbproduct->where('id',$row->id_product)->get();
                $updatequantity = $dbproduct->where('id',$row->id_product)->update([
                    'sold' => $soldold[0]->sold - $row->quantity
                ]);
            }
            $update = $db->where('id',$id)->update([
                'id_status' => 4,
                'id_censor' => Auth::user()->id
            ]);
            $content = 'Xin chào '.$data[0]->fullname.'. Đơn hàng của bạn đã bị hủy do vi phạm chính sách mua hàng của SoftMart. Cảm ơn bạn đã tin tưởng chúng tôi. Mọi thông tin liên hệ xin gửi về: Email: sunshineweb.vn@gmail.com Phone: 0989735559';
            Mail::raw($content, function ($message) use($data) {
                $message->from('sunshineweb.vn@gmail.com', 'SoftMart');
                $message->to($data[0]->email,$data[0]->fullname);
                $message->subject('Thư báo đơn hàng bị hủy');
            });
        }else if(isset($_POST['success'])){
            $update = $db->where('id',$id)->update([
                'id_status' => 5,
                'id_censor' => Auth::user()->id
            ]);
            $content = 'Xin chào '.$data[0]->fullname.'. Thông báo đơn hàng thành công thông tin đơn hàng của bạn là .... Mọi thông tin liên hệ xin gửi về: Email: sunshineweb.vn@gmail.com Phone: 0989735559';
            Mail::raw($content, function ($message) use($data) {
                $message->from('sunshineweb.vn@gmail.com', 'SoftMart');
                $message->to($data[0]->email,$data[0]->fullname);
                $message->subject('Thư báo thông tin đơn hàng');
            });
        }
        return redirect()->back();
    }

    //ham xu ly khi nguoi dung dat cau hoi
    public function contact(){
        //khai bao bang lay trong database
        $db = new inforcontact();
        if(isset($_GET['status'])&&!empty($_GET['status'])){
            $status = $_GET['status'];
            if($status == 'unread'){
                $data = $db->where('status',0)->orderBy('id','DESC')->Paginate(20);
            }else{
                if($status == 'read'){
                    $data = $db->where('status',1)->orderBy('created_at','DESC')->Paginate(20);
                }else{
                    $data = $db->orderBy('id','DESC')->Paginate(20);
                }
            }
        }else{
            $data = $db->orderBy('id','DESC')->SimplePaginate(20);
        }
        return view('fontend.admin-contact',['data'=>$data]);
    }

    //bieu do thong ke
    public function chart(Carbon $carbon){

        //doanh thu 12 thang nam hien tai
        $revenue1 = 0;
        $revenue2 = 0;
        $revenue3 = 0;
        $revenue4 = 0;
        $revenue5 = 0;
        $revenue6 = 0;
        $revenue7 = 0;
        $revenue8 = 0;
        $revenue9 = 0;
        $revenue10 = 0;
        $revenue11 = 0;
        $revenue12 = 0;

        //doanh thu 12 thang nam truoc
        $revenueLastYear1 = 0;
        $revenueLastYear2 = 0;
        $revenueLastYear3 = 0;
        $revenueLastYear4 = 0;
        $revenueLastYear5 = 0;
        $revenueLastYear6 = 0;
        $revenueLastYear7 = 0;
        $revenueLastYear8 = 0;
        $revenueLastYear9 = 0;
        $revenueLastYear10 = 0;
        $revenueLastYear11 = 0;
        $revenueLastYear12 = 0;
        $lastYear = $carbon::now()->format('Y') - 1;

        $dbOrder = new order();
        $totalOrder = $dbOrder->where('id_status',5)->whereBetween('created_at',[$carbon::now()->startOfYear()->subYear(1),$carbon::now()->endOfYear()])->get();
        foreach($totalOrder as $order){
            //cat chuoi de lay thang cua order
            $date = explode('-',$order->created_at);
            $year = $date[0];
            //neu thoi gian order nam trong thang hien tai thi cong vao doanh thu
            if($date[1] == 1 && $year == $carbon::now()->format('Y')){
                $revenue1 += $order->realrevenue;
            }
            if($date[1] == 2 && $year == $carbon::now()->format('Y')){
                $revenue2 += $order->realrevenue;
            }
            if($date[1] == 3 && $year == $carbon::now()->format('Y')){
                $revenue3 += $order->realrevenue;
            }
            if($date[1] == 4 && $year == $carbon::now()->format('Y')){
                $revenue4 += $order->realrevenue;
            }
            if($date[1] == 5 && $year == $carbon::now()->format('Y')){
                $revenue5 += $order->realrevenue;
            }
            if($date[1] == 6 && $year == $carbon::now()->format('Y')){
                $revenue6 += $order->realrevenue;
            }
            if($date[1] == 7 && $year == $carbon::now()->format('Y')){
                $revenue7 += $order->realrevenue;
            }
            if($date[1] == 8 && $year == $carbon::now()->format('Y')){
                $revenue8 += $order->realrevenue;
            }
            if($date[1] == 9 && $year == $carbon::now()->format('Y')){
                $revenue9 += $order->realrevenue;
            }
            if($date[1] == 10 && $year == $carbon::now()->format('Y')){
                $revenue10 += $order->realrevenue;
            }
            if($date[1] == 11 && $year == $carbon::now()->format('Y')){
                $revenue11 += $order->realrevenue;
            }
            if($date[1] == 12 && $year == $carbon::now()->format('Y')){
                $revenue12 += $order->realrevenue;
            }

            //neu thoi gian nam trong nam truoc thi cong doanh thu vao thang do nam truoc
            if($date[1] == 1 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear1 += $order->realrevenue;
            }
            if($date[1] == 2 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear2 += $order->realrevenue;
            }
            if($date[1] == 3 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear3 += $order->realrevenue;
            }
            if($date[1] == 4 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear4 += $order->realrevenue;
            }
            if($date[1] == 5 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear5 += $order->realrevenue;
            }
            if($date[1] == 6 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear6 += $order->realrevenue;
            }
            if($date[1] == 7 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear7 += $order->realrevenue;
            }
            if($date[1] == 8 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear8 += $order->realrevenue;
            }
            if($date[1] == 9 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear9 += $order->realrevenue;
            }
            if($date[1] == 10 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear10 += $order->realrevenue;
            }
            if($date[1] == 11 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear11 += $order->realrevenue;
            }
            if($date[1] == 12 && $year == $carbon::now()->subYear(1)->format('Y')){
                $revenueLastYear12 += $order->realrevenue;
            }

        }
        $arrRevenue = [$revenue1,$revenue2,$revenue3,$revenue4,$revenue5,$revenue6,$revenue7,$revenue8,$revenue9,$revenue10,$revenue11,$revenue12];
        $arrRevenueLastYear = [$revenueLastYear1,$revenueLastYear2,$revenueLastYear3,$revenue4,$revenueLastYear5,$revenueLastYear6,$revenueLastYear7,$revenueLastYear8,$revenueLastYear9,$revenueLastYear10,$revenueLastYear11,$revenueLastYear12];

        return view('fontend.chart.admin-chart',['revenue'=>$arrRevenue,'currentYear'=>$carbon->year,'lastYear'=>$lastYear,'revenueLastYear'=>$arrRevenueLastYear]);
    }

    //bieu do thong ke doanh thu theo danh muc san pham trong năm nay
    public function chartcategories(){

        //nam hien tai
        $currentYear = date('Y');

        $arrKeys = [];
        $arrValues = [];
        $arrRevenue = [];
        $totalRevenue = 0;
        $i=1;
        $dbCategory = new category_product();
        $dbProduct = new product();
        $categories = $dbCategory->get();
        foreach($categories as $category){
            $arrKeys[$i] = $category->id;
            $arrValues[$i] = $category->category_name;
            $i++;
        }
        $hightestKey = max(array_keys($arrKeys));
        $dbOrderDetail = new order_detail();
        $dbOrder = new order();
        $orders = $dbOrderDetail->get();
        foreach($orders as $order){
            $checkCompleteOrder = $dbOrder->where('id',$order->id_order)->get();
            $time = explode('-',$checkCompleteOrder[0]->created_at);
            $yearOfThisOrder = $time[0];
            if($checkCompleteOrder[0]->id_status == 5 && $yearOfThisOrder == $currentYear){
                $quantityOfThisProduct = $order->quantity;
                $thisProduct = $dbProduct->where('id',$order->id_product)->get();
                $price = (($thisProduct[0]->price/100)*(100-$thisProduct[0]->sale_percent));
                for($j=1;$j<=$hightestKey;$j++){
                    if(!isset($arrRevenue[$j])){
                        $arrRevenue[$j] = 0;
                    }
                    if($thisProduct[0]->id_category == $j){
                        $arrRevenue[$j] += $price * $quantityOfThisProduct;
                    }
                }
                //tong doanh thu tat ca mat hang de tinh %
                $totalRevenue += ($quantityOfThisProduct * $price);
            }
        }
        return view('fontend.chart.admin-chartcategories',['revenue'=>$arrRevenue,'arrValues'=>$arrValues,'totalRevenue'=>$totalRevenue,'hightestKey'=>$hightestKey]);
    }

    //xem chi tiet message cua nguoi dung gui
    public function detailmessage($id){

        $data = \App\inforcontact::find($id);
        return view('fontend.admin-detailmessage',['data'=>$data]);
    }

    //xu ly ham post cua detail message
    public function postdetailmessage($id,Request $request){
        $data = [];
        $content = $request->contentreply;
        Mail::raw($content, function ($message) use($request) {
            $message->from('sunshineweb.vn@gmail.com', 'SoftMart');
            $message->to($request->email,$request->fullname);
            $message->subject('Thư trả lời');
        });
        $db = new inforcontact();
        $db->where('id',$id)->update(['status'=>1]);
        return redirect('admin/contact');
    }

    //Show danh sach user
    public function getAllUsers(){
        $db = new User();
        $db2 = \App\group_user::all();
        //lay ra list user theo the loai neu co bien type tren URL
        if(isset($_GET['type'])&&!empty($_GET['type'])){
            //lay ra bien type de loc theo the loai
            $type = $_GET['type'];
           foreach($db2 as $item){
                if($item->group_name == $type){
                    $data = $db->where('id_group',$item->id)->Paginate(20);
                }elseif($type == 'all'){
                    $data = $db->Paginate(20);
                }
           }
        }else{
            //neu khong co bien type tren URL => show danh sach tat ca user
            $data = $db->Paginate(20);
        }
        return view('fontend.admin-listuser',['data'=>$data,'group_user'=>$db2]);
    }

    //xoa user
    public function deleteUser(){
        //khai bao bien check de kiem tra xem nguoi dung co quyen xoa user hay khong
        $check = 0;
        //duyet tat ca cac quyen cua nguoi dung hien tai
        foreach (Auth::user()->permission as $permission) {
            //neu nguoi dung co quyen xoa user
            if($permission->slug_name == 'xoa-nguoi-dung'){
                $check = 1;
                break;
            }
        }
        //thuc hien khi biet nguoi dung co quyen xoa user
        if($check == 1){
            if(isset($_GET['id'])&&!empty($_GET['id'])){
                $id = $_GET['id'];
                $db = new User();
                $db->where('id',$id)->delete();
                return redirect()->back();
            }
        }else{
            echo "<script>alert('Bạn không đủ thẩm quyền để làm điều này');history.back();</script>";
        }
    }

    //show profile cua tai khoan
    public function getProfile(){
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            //lay ra cac group_user
            $permission = \App\permission::all();
            $group_user = \App\group_user::all();

            $dbper= new user_permission();
            $user_permission = $dbper->where('id_user',$_GET['id'])->get();

            $id = $_GET['id'];
            $db = new User();
            $data = $db->findOrFail($id);
            return view('fontend.admin-profile',['user_permission'=>$user_permission,'permission'=>$permission,'data'=>$data,'group_user'=>$group_user]);
        }else{
            return redirect('admin');
        }
    }

    public function updateProfile(Request $request){
        $check = 0;
        foreach(Auth::user()->permission as $permission){
            if($permission->slug_name == 'sua-nguoi-dung'){
                $check = 1;
                break;
            }
        }
        //neu nguoi dung co quyen update user
        if($check == 1){
                       
            if(isset($_GET['id'])&&!empty($_GET['id'])){
                $id = $_GET['id'];
                $db = new User();
                $db->where('id',$id)->update(['fullname'=>$request->fullname,'phone'=>$request->phone,'address'=>$request->address]);

                //Update lại quyền
                $dbrole = new user_permission();
                $delete = $dbrole->where('id_user',$_GET['id'])->delete();
                
                if(!empty($request->permission)){
                    foreach($request->permission as $i){
                        $dbrole = new user_permission();
                        $dbrole->id_user = $_GET['id'];
                        $dbrole->id_permission = $i;
                        $dbrole->save();
                    } 
                }
                
                return redirect()->back();
            }else{
                return redirect('admin');
            }
        }else{
            echo "<script>alert('Bạn không đủ thẩm quyền để làm điều này');history.back();</script>";
        }
    }


    //admin tim kiem nguoi dung trong muc quan li user
    public function searchUser(){
        if(isset($_GET['q'])&&!empty($_GET['q'])){
            //thong ke so tin nhan chua tra loi (tra ve cho header)
            $dbinforcontact = new inforcontact();
            $quantityMessageUnread = $dbinforcontact->where('status',0)->count();
            //neu khong ton tai tin nhan chua doc nao thi tra ve 0
            if($quantityMessageUnread<=0){
                $quantityMessageUnread = 0;
            }

            //biến để thông báo những order cần xử lí
            $totalChange = 0;
            //thong ke don hang moi
            $dborder = new order();
            $quantityNewOrder = $dborder->where('id_status',1)->count();
            if($quantityNewOrder<=0){
                $quantityNewOrder = 0;
            }
            $totalChange += $quantityNewOrder;

            //thống kê đơn hàng đã chốt đơn sale thành công nhưng chưa giao hàng
            $quantityNewOrderCompleteSale = $dborder->where('id_status',3)->count();
            if($quantityNewOrderCompleteSale<=0){
                $quantityNewOrderCompleteSale = 0;
            }
            $totalChange += $quantityNewOrderCompleteSale;

            //tim kiem theo request
            $q = $_GET['q'];
            $db = new User();
            $data = $db->where('id',$q)->orWhereRaw("username LIKE '%{$q}%'")->orWhereRaw("email LIKE '%{$q}%'")->Paginate(20);
            return view('fontend.admin-listuser',['data'=>$data]);
        }else{
            return redirect()->route('showlistuser');
        }
    }

    //admin tim kiem nguoi dung dat cau hoi trong phan contact
    public function searchMessage(){
        if(isset($_GET['q'])&&!empty($_GET['q'])){
             

            //tim kiem theo request
            $q = $_GET['q'];
            $db = new inforcontact();
            $data = $db->whereRaw("fullname LIKE '%{$q}%'")->orWhereRaw("email LIKE '%{$q}%'")->Paginate(20);
            return view('fontend.admin-contact',['data'=>$data]);
        }
    }

    public function listnew(){
        $db = new news();
        $listcategory = \App\category_news::all();
        $listnew = $db->where('id_user',Auth::user()->id)->orderBy('created_at','DESC')->get();
        return view('fontend.admin-listnew',['listnew'=>$listnew,'listca'=>$listcategory]);
    }

    //trả vè chỉ những danh sách sản phẩm của cộng tác viên đó viết
    public function listproduct(){
        $db = new product();
        $ca = new category_product();
        $listca = $ca->get();
        $list = $db->where('id_user',Auth::user()->id)->orderBy('created_at','DESC')->get();
        return view('fontend.admin-product',['list'=>$list,'listca'=>$listca]);
    }

    public function addnew(){
        $listcategory = \App\category_news::all();
        return view('fontend.admin-addnew',['listcategory'=>$listcategory]);
    }

    public function postaddnew(Request $request){
        //luu anh vao folder
        $imageName = time().'.'.$request->titleimage->getClientOriginalExtension();
        $request->titleimage->move(public_path('blogs'), $imageName);
        $db = new news();
        $db->title = $request->title;
        $db->link_image = "public/blogs/".$imageName;
        $db->id_user = Auth::user()->id;
        $db->id_category = $request->id_category;
        $db->content = $request->content;
        $db->save();
        echo "<script>alert('Thêm tin thành công');history.back();</script>";
    }

    public function deletenew(){
        $db = new news();
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $delete = $db->where('id',$id)->delete();
            return redirect()->back();
        }
    }

    public function editnew(){
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $db = new news();
            $id = $_GET['id'];
            $listcategory = \App\category_news::all();
            $new = $db->where('id',$id)->get();
            return view('fontend.admin-editnew',['listcategory'=>$listcategory,'new'=>$new[0]]);
        }else{
            return redirect()->back();
        }
    }

    public function posteditnew(validatenew $request){
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $db = new news();
            $id = $_GET['id'];
            if(isset($_POST['editnew'])){
                $db->where('id',$id)->update([
                    'title' => $request->title,
                    'link_image' => $request->linkimage,
                    'id_user' => Auth::user()->id,
                    'id_category' => $request->id_category,
                    'content' => $request->content
                    ]);
                echo "<script>alert('Sửa thành công!!');history.back();</script>";
            }
        }
    }

    //Task ke toan
    public function listctv(){
        //lay danh sach cong tac vien hoac loc ra danh sach cong tac vien san pham hoac cong tac vien bai viet
        $db = new User();
        //lay ra list user theo the loai neu co bien type tren URL
        if(isset($_GET['type'])&&!empty($_GET['type'])){
            //lay ra bien type de loc theo the loai
            $type = $_GET['type'];
            //loai ctv san pham
            if($type == 'collaboratorproduct'){
                $data = $db->where('id_group',3)->Paginate(20);
            }else{
                //loai ctv blog
                if($type == 'collaboratorblog'){
                    $data = $db->where('id_group',4)->Paginate(20);
                }else{
                    //loai saler
                    if($type == 'sale'){
                        $data = $db->where('id_group',5)->Paginate(20);
                    }else{
                        $data = $db->where('id_group',3)->orWhere('id_group',4)->orWhere('id_group',5)->Paginate(20);
                    }
                }
            }
        }else{
            //neu khong co bien type tren URL => show danh sach tat ca user
            $data = $db->where('id_group',3)->orWhere('id_group',4)->orWhere('id_group',5)->Paginate(20);
        }
        return view('fontend.accountant-listuser',['data'=>$data]);
    }

    //xem danh sach nhung don hang chot sale thanh cong
    public function listOrderComplete(Carbon $carbon){
        //lay ra cac don hang da chot thanh cong cho ke toan trong thang nay va thang truoc
        $db = new order();
        $currentYear = date('Y');
        $previousYear = date('Y');
        $d = date('m');
        if($d == 1){
            $lastMonth = 12;
            $previousYear = $currentYear - 1;
        }else{
            $lastMonth = $d - 1;
        }
        if(isset($_GET['status'])&&!empty($_GET['status'])){
            $status = $_GET['status'];
            if($status == 'currentmonth'){
                $data = $db->orderBy('created_at','DESC')->where('id_status',3)->orWhere('id_status',5)->whereMonth('created_at',$d)->whereYear('created_at',$currentYear)->Paginate(20);
            }else{
                if($status == 'lastmonth'){
                    $data = $db->orderBy('created_at','DESC')->where('id_status',3)->orWhere('id_status',5)->whereMonth('created_at',$lastMonth)->whereYear('created_at',$previousYear)->Paginate(20);
                }else{
                    $data = $db->orderBy('created_at','DESC')->where('id_status',3)->orWhere('id_status',5)->whereMonth('created_at',$d)->whereYear('created_at',$currentYear)->Paginate(20);
                }
            }
        }else{
            $data = $db->orderBy('created_at','DESC')->where('id_status',3)->orWhere('id_status',5)->whereMonth('created_at',$d)->whereYear('created_at',$currentYear)->Paginate(20);
        }
        return view('fontend.accountant-listordercomplete',['data'=>$data]);
    }

    public function searchOfAccountant(){
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $q = $_GET['q'];
        }else{
            $q = 'noresult';
        }
        $db = new order();
        $data = $db->where('id',$q)->orWhereRaw("fullname LIKE '%{$q}%'")->where('id_status',5)->orderBy('id','DESC')->take(20)->get();
        return view('fontend.accountant-listordercomplete',['data'=>$data]);
    }

    //ke toan tim kiem danh sach user thuoc cong tac vien
    public function accountantsearchuser(){
        if(isset($_GET['q'])&&!empty($_GET['q'])){
            $q = $_GET['q'];
        }else{
            $q = 'noresult';
        }
        $db = new User();
        $data = $db->whereRaw("id = '{$q}' OR fullname LIKE '%{$q}%' OR email LIKE '%{$q}%'")->Paginate(20);
        return view('fontend.accountant-listuser',['data'=>$data]);
    }
    //het task ke toan

    //tash danh cho nguoi kiem duyet
    public function listNotAcceptYet(){
        $db = new product();
        $ca = new category_product();
        $listca = $ca->get();
        if(isset($_GET['category'])&&!empty($_GET['category'])){
            $category = $_GET['category'];
            foreach($listca as $item){
                if($category == $item->slug_name){
                    $list = $db->where('id_category',$item->id)->where('status',0)->orderBy('created_at','DESC')->Paginate(20);
                }
            }
        }else if(empty($_GET['category'])){
            $list = $db->orderBy('created_at','DESC')->where('status',0)->Paginate(20);
        }
        // Paginate(15)
        return view('fontend.censor-allproduct',['list'=>$list,'listca'=>$listca]);
    }

    public function accepteditproduct(){
        $id = $_GET['id'];
        $category = new category_product();
        $listcategory = $category->get();
        $db = new product();
        $product = $db->where('id',$id)->get();
        return view('fontend.censor-editproduct',['listcategory'=>$listcategory,'product'=>$product[0]]);
    }

    public function acceptposteditproduct(){
        $id = $_GET['id'];
        $db = new product();
        $db->where('id',$id)->update([
            'status' => 1
            ]);
        echo "<script>alert('Duyệt thành công!!');history.back();</script>";
        return redirect()->route('listnotacceptyetproduct');
    }


    public function listNotAcceptYetNew(){
        $db = new news();
        $listnew = $db->where('status',0)->orderBy('created_at','DESC')->get();
        return view('fontend.admin-notcontactyetnew',['listnew'=>$listnew]);
    }

    public function acceptnews(){
        $listcategory = \App\category_news::all();
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = $_GET['id'];
            $db = new news();
            $new = $db->where('id',$id)->get();
            if($new[0]->status == 0){
                return view('fontend.censor-acceptnew',['new'=>$new[0],'listcategory'=>$listcategory]);
            }else{
                return redirect()->route('listnotacceptyetnew');
            }
            return view('fontend.censor-acceptnew',['new'=>$new[0],'listcategory'=>$listcategory]);
        }else{
            return redirect()->route('listnotacceptyetnew');
        }
    }

    public function postacceptnews(){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = $_GET['id'];
            if(isset($_POST['accept'])){
                $db = new news();
                $update = $db->where('id',$id)->update([
                    'status' => 1
                ]);
                echo "<script>alert('Duyệt thành công!!');history.back();</script>";
                return redirect()->route('listnotacceptyetnew');
            }
        }
    }
    //het task danh cho nguoi kiem duyet

    //bieu do thang ke theo tuan
    public function chartweekly(Carbon $carbon){

        //thong ke doanh thu
        $db = new order();
        //doanh thu theo thu trong tuan
        $revenueMonday = $revenueTuesday = $revenueWesnesday = $revenueThursday = $revenueFriday = $revenueSaturday = $revenueSunday = 0;
        //tong doanh thu trong tuan
        $totalRevenueThisWeek = 0;
        $totalOrder = $db->where('id_status',5)->whereBetween('created_at',[$carbon::now()->startOfWeek(),$carbon::now()->endOfWeek()])->get();

        foreach($totalOrder as $order){
            //neu thoi gian order nam trong tuan hien tai , thang hien tai, nam hien tai
            if($order->created_at->dayOfWeek == 1){
                $revenueMonday += $order->realrevenue;
                $totalRevenueThisWeek += $order->realrevenue;
            }
            if($order->created_at->dayOfWeek == 2){
                $revenueTuesday += $order->realrevenue;
                $totalRevenueThisWeek += $order->realrevenue;
            }
            if($order->created_at->dayOfWeek == 3){
                $revenueWesnesday += $order->realrevenue;
                $totalRevenueThisWeek += $order->realrevenue;
            }
            if($order->created_at->dayOfWeek == 4){
                $revenueThursday += $order->realrevenue;
                $totalRevenueThisWeek += $order->realrevenue;
            }
            if($order->created_at->dayOfWeek == 5){
                $revenueFriday += $order->realrevenue;
                $totalRevenueThisWeek += $order->realrevenue;
            }
            if($order->created_at->dayOfWeek == 6){
                $revenueSaturday += $order->realrevenue;
                $totalRevenueThisWeek += $order->realrevenue;
            }
            if($order->created_at->dayOfWeek == 0){
                $revenueSunday += $order->realrevenue;
                $totalRevenueThisWeek += $order->realrevenue;
            }
        }
        $arrValue = [$revenueMonday,$revenueTuesday,$revenueWesnesday,$revenueThursday,$revenueFriday,$revenueSaturday,$revenueSunday];
        return view('fontend.chart.admin-chartweekly',['revenue'=>$arrValue,'total'=>$totalRevenueThisWeek]);
    }

    //bieu do thong ke doanh thu theo thang
    public function chartmonthly(Carbon $carbon){

        //thong ke doanh thu
        //lay ra so ngay trong thang hien tai
        $quantityDayOfThisMonth =  $carbon::now()->daysInMonth;
        $db = new order();
        //khai bao mang doanh thu theo ngay
        $revenue = [];
        //tong doanh thu trong thang
        $totalRevenueThisMonth = 0;
        $totalOrder = $db->where('id_status',5)->whereBetween('created_at',[$carbon::now()->startOfMonth(),$carbon::now()->endOfMonth()])->get();
        for($i=1;$i<=$quantityDayOfThisMonth;$i++){
            $revenue[$i] = 0;
            foreach($totalOrder as $order){
                $time = explode('-',$order->created_at);
                $dayOfOrder = intval($time[2]);
                //neu don hang nam trong thang hien tai va nam hien tai
                if($dayOfOrder == $i){
                    $revenue[$i] += $order->realrevenue;
                    $totalRevenueThisMonth += $order->realrevenue;
                }
            }
        }
        return view('fontend.chart.admin-chartmonthly',['revenue'=>$revenue,'totalRevenue'=>$totalRevenueThisMonth]);
    }

    public function createsubadmin(){
        $permission = \App\permission::all();
        $group_user = \App\group_user::all();
        $dbper= new user_permission();
        return view('fontend.admin-createsubadmin',['permission'=>$permission,'group_user'=>$group_user]);
    }

    public function postsubadmin(createsubadmin $request){
        $dbuser = new User();
        $maxuser = $dbuser->whereRaw("id=(SELECT MAX(id) FROM users)")->get();
        $maxid = $maxuser[0]->id + 1;
        $dbuser->id = $maxid;
        $dbuser->username = $request->username;
        $dbuser->fullname = $request->fullname;
        $dbuser->email = $request->email;
        $dbuser->phone = $request->phone;
        $dbuser->address = $request->address;
        $dbuser->id_group = $request->position;
        $dbuser->password = bcrypt($request->password);
        $dbuser->save();
        if(!empty($request->permission)){
            foreach($request->permission as $i){
                $dbuser_per = new user_permission();
                $dbuser_per->id_user = $maxid;
                $dbuser_per->id_permission = $i;
                $dbuser_per->save();
            }
        }
        $content = 'Xin chào '.$request->fullname.'. Bạn đã được admin website SoftMart tạo một tài khoản subadmin với thông tin tài khoản là Username: '.$request->username.' và Password: '.$request->password.'. Mọi thông tin liên hệ xin gửi về: Email: sunshineweb.vn@gmail.com Phone: 0989735559';
        Mail::raw($content, function ($message) use($request) {
            $message->from('sunshineweb.vn@gmail.com', 'SoftMart');
            $message->to($request->email,$request->fullname);
            $message->subject('Thông báo tạo tài khoản');
        });

        $db = new User();
        $db2 = \App\group_user::all();
        //lay ra list user theo the loai neu co bien type tren URL
        if(isset($_GET['type'])&&!empty($_GET['type'])){
            //lay ra bien type de loc theo the loai
            $type = $_GET['type'];
           foreach($db2 as $item){
                if($item->group_name == $type){
                    $data = $db->where('id_group',$item->id)->Paginate(20);
                }elseif($type == 'all'){
                    $data = $db->Paginate(20);
                }
           }
        }else{
            //neu khong co bien type tren URL => show danh sach tat ca user
            $data = $db->Paginate(20);
        }
        return view('fontend.admin-listuser',['data'=>$data]);
    }

    public function listbranch(){
        $infor = \App\infor_website::All();
        return view('fontend.admin-listbranch',['data'=>$infor]);
    }

    public function editbranch(){
        if(isset($_GET['id']) && !empty($_GET['id']) ){
            $id = $_GET['id'];
            $db = new infor_website();
            $infor = $db->where('id',$id)->get();
            return view('fontend.admin-editbranch',['data'=>$infor]);
        }else{
            return redirect()->back();
        }
    }
    public function posteditbranch(validatebranch $request){
        $infor = new infor_website();
        if($request->id==1){
            $update = $infor->where('id',$request->id)->update([
                'name_branch' => $request->name,
                'hotline' => $request->hotline,
                'email' => $request->email,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'address' => $request->address,
                'phone' => $request->phone,
                'facebook' => $request->facebook,
                'about' => $request->about,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name,
                'company_name' => $request->company_name
            ]);
        }else{
            $update = $infor->where('id',$request->id)->update([
                'name_branch' => $request->name,
                'hotline' => $request->hotline,
                'email' => $request->email,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'address' => $request->address,
                'phone' => $request->phone,
                'facebook' => $request->facebook
            ]);
        }
        echo "<script>alert('Cập nhật thành công !');window.location.href='".URL::route('listbranch')."'</script>";
    }

    public function addbranch(){
        return view('fontend.admin-addbranch');
    }

    public function postaddbranch(validatebranch $request){
        $infor = new infor_website();
        $infor->name_branch = $request->name;
        $infor->hotline = $request->hotline;
        $infor->email = $request->email;
        $infor->instagram = $request->instagram;
        $infor->twitter = $request->twitter;
        $infor->address = $request->address;
        $infor->phone = $request->phone;
        $infor->facebook = $request->facebook;
        $infor->save();
        echo "<script>alert('Thêm thành công !');window.location.href='".URL::route('listbranch')."'</script>";
    }

    public function deletebranch(){
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $infor = new infor_website();
            $delete = $infor->where('id',$id)->delete();
            
        }
        return redirect()->route('listbranch');  
    }

    //-------------------------------------quan li section-------------------------------------
    //admin quản lí các section show ra trang chủ
    public function managesection(){

        //lay ra toan bo cac section co trong db
        $dbSection = new section();
        $sections = $dbSection->get();
        
        //lấy ra danh sách tất cả sản phẩm có thể thêm vào section
        $dbProduct = new product();
        $listProduct = $dbProduct->get();
        
        return view('fontend.admin.managesection',['sections'=>$sections,'listProduct'=>$listProduct]);
    }

    //admin mở form edit section
    public function editsection(){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id_section = $_GET['id'];
            $dbSection = new section();
            $dbSectionContent = new section_content();

            //lấy ra thông tin tổng quát của section cần chỉnh sửa
            $section = $dbSection->where('id',$id_section)->get();
            //lấy ra thông tin các sản phẩm có trong section cần chỉnh sửa
            $products = $dbSectionContent->where('id_section',$id_section)->orderBy('id_product','DESC')->get();
            //lấy ra danh sách tất cả sản phẩm có thể thêm vào section
            $dbProduct = new product();
            $listProduct = $dbProduct->get();
            return view('fontend.admin.editsection',['section'=>$section,'products'=>$products,'listProduct'=>$listProduct]);
        }else{
            return redirect()->route('admin');
        }
    }

    //admin them san pham vao list section

    public function addtosection(){
        $idproduct = $_GET['id'];
        $idsection = $_GET['idsection'];
        $dbSectionContent = new section_content();
        $dbSectionContent->id_section = $idsection;
        $dbSectionContent->id_product = $idproduct;
        $dbSectionContent->save();

        //lay ra toan bo cac section co trong db
        $dbSection = new section();
        $sections = $dbSection->get();
        
        //lấy ra danh sách tất cả sản phẩm có thể thêm vào section
        $dbProduct = new product();
        $listProduct = $dbProduct->get();
        
        return view('fontend.admin.ajaxmanagesection',['sections'=>$sections,'listProduct'=>$listProduct]);
    }

    //xoa san pham khoi danh sach trong section
    public function deletetosection(){
        $idproduct = $_GET['id'];
        $idsection = $_GET['idsection'];
        $dbSectionContent = new section_content();
        $dbSectionContent->where('id_section',$idsection)->where('id_product',$idproduct)->delete();
        
        //lay ra toan bo cac section co trong db
        $dbSection = new section();
        $sections = $dbSection->get();
        
        //lấy ra danh sách tất cả sản phẩm có thể thêm vào section
        $dbProduct = new product();
        $listProduct = $dbProduct->get();
        
        return view('fontend.admin.ajaxmanagesection',['sections'=>$sections,'listProduct'=>$listProduct]);
    }

    //admin thuc hien sua doi title cua section dang chinh sua
    public function savetitle(Request $request){
        $dbSection = new section();
        $dbSection->where('id',$request->idsection)->update(['title'=>$request->titlesection]);
        echo "<script>alert('Cập nhật tên section thành công !');window.location.href='".URL::previous()."'</script>";
    }

    //admin tao them section moi
    public function addsection(){
        //lay ra id section lon nhat
        $dbSection = new section();
        $maxSection = $dbSection->whereRaw("id = (SELECT MAX(id) FROM section)")->get();
        $maxID = intval($maxSection[0]->id);
        $IDNewSection = $maxID + 1;

        //tao section moi
        $dbSection->id = $IDNewSection;
        // $dbSection->title = $_GET['title'];
        // $dbSection->save();

        return $IDNewSection;
    }

    //admin xoa 1 list section
    public function deletelistsection(){
        $idsection = $_GET['id'];
        $dbSection = new section();
        $dbSectionContent = new section_content();
        //thuc hien xoa khoi database
        $dbSection->where('id',$idsection)->delete();
        $dbSectionContent->where('id_section',$idsection)->delete();
        return redirect()->back();
    }

    //them san pham vao list san pham cua section trong editsection.blade.php
    public function editaddtosection(){
        $idproduct = $_GET['id'];
        $idsection = $_GET['idsection'];
        $dbSectionContent = new section_content();
        $dbSectionContent->id_section = $idsection;
        $dbSectionContent->id_product = $idproduct;
        $dbSectionContent->save();

        //lấy ra thông tin tổng quát của section cần chỉnh sửa
        $dbSection = new section();
        $section = $dbSection->where('id',$idsection)->get();
        //lấy ra thông tin các sản phẩm có trong section cần chỉnh sửa
        $products = $dbSectionContent->where('id_section',$idsection)->orderBy('id_product','DESC')->get();
        return view('fontend.admin.ajaxeditsection',['section'=>$section,'products'=>$products]);
    }

    //xoa san pham khoi list san pham cua section trong editsection.blade.php 
    public function editdeletetosection(){
        $idproduct = $_GET['id'];
        $idsection = $_GET['idsection'];
        $dbSectionContent = new section_content();
        $dbSectionContent->where('id_section',$idsection)->where('id_product',$idproduct)->delete();

        //lấy ra thông tin tổng quát của section cần chỉnh sửa
        $dbSection = new section();
        $section = $dbSection->where('id',$idsection)->get();
        //lấy ra thông tin các sản phẩm có trong section cần chỉnh sửa
        $products = $dbSectionContent->where('id_section',$idsection)->orderBy('id_product','DESC')->get();
        return view('fontend.admin.ajaxeditsection',['section'=>$section,'products'=>$products]);
    }
    // --------------------------hết quản lí section--------------------------------------


    // ------------------------------Quản lí danh mục sản phẩm-------------------------------
    //admin mo form quan li danh muc san pham
    public function manageCategoriesProduct(){

        $dbCategories = new category_product();
        $categories = $dbCategories->get();

        //lấy ra danh sách tất cả sản phẩm có thể thêm vào section
        $dbProduct = new product();
        $listProduct = $dbProduct->get();
        return view('fontend.admin.managecategoriesproduct',['categories'=>$categories,'listProduct'=>$listProduct]);
    }

    //admin xoa 1 danh muc (category) san pham
    public function deletecategoryproduct(){
        $idcategory = $_GET['id'];
        //xoa tat ca san pham thuoc danh muc do
        $dbProduct = new product();
        $dbProduct->where('id_category',$idcategory)->delete();

        //sau khi xoa ta ca san pham thuoc danh muc do thi xoa danh muc
        $dbCategory = new category_product();
        $dbCategory->where('id',$idcategory)->delete();
        return redirect()->back();
    }

    //admin tao them 1 danh muc san pham moi
    public function addnewcategoryproduct(){
        if(isset($_GET['strid'])){
            //chuỗi chứa id các sản phẩm để thêm vào danh mục sản phẩm
            $strid = $_GET['strid'];
            //tên danh mục
            $category_name = $_GET['category_name'];

            //lay ra id danh muc lon nhat
            $dbCategory = new category_product();
            $maxCategory = $dbCategory->whereRaw("id = (SELECT MAX(id) FROM category_product)")->get();
            $maxID = intval($maxCategory[0]->id);
            $IDNewCategory = $maxID + 1;

            //tao danh muc moi
            $dbCategory->id = $IDNewCategory;
            $dbCategory->category_name = $category_name;
            $dbCategory->slug_name = Str::slug($category_name,'-');
            $dbCategory->save();

            //cập nhật id danh mục cho các sản phẩm có trong danh sách
            $dbProduct = new product();
            $dbProduct->whereRaw("id IN({$strid})")->update(['id_category'=>$IDNewCategory]);

        }else{
            //tên danh mục
            $category_name = $_GET['category_name'];

            //lay ra id danh muc lon nhat
            $dbCategory = new category_product();
            $maxCategory = $dbCategory->whereRaw("id = (SELECT MAX(id) FROM category_product)")->get();
            $maxID = intval($maxCategory[0]->id);
            $IDNewCategory = $maxID + 1;

            //tao danh muc moi
            $dbCategory->id = $IDNewCategory;
            $dbCategory->category_name = $category_name;
            $dbCategory->slug_name = Str::slug($category_name,'-');
            $dbCategory->save();
        }

        //ajax trả về view
        $dbCategories = new category_product();
        $categories = $dbCategories->get();
        return view('fontend.admin.ajaxmanagecategoriesproduct',['categories'=>$categories]);  
    }

    //admin mo form chinh sua 1 danh muc san pham muon chinh sua
    public function editcategoryproduct(){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id_category = $_GET['id'];
            $dbCategory = new category_product();

            //lấy ra thông tin tổng quát của category cần chỉnh sửa
            $category = $dbCategory->where('id',$id_category)->get();
            //lấy ra thông tin các sản phẩm có trong danh muc cần chỉnh sửa
            $dbProduct = new product();
            $products = $dbProduct->where('id_category',$id_category)->orderBy('id','DESC')->get();
            //lấy ra danh sách tất cả sản phẩm có thể thêm vào danh muc san pham
            $listProduct = $dbProduct->get();
            return view('fontend.admin.editcategoryproduct',['category'=>$category,'products'=>$products,'listProduct'=>$listProduct]);
        }else{
            return redirect()->route('admin');
        }
    }

    //cap nhat lai id_category cua san pham trong editcategoryproduct.blade.php
    public function editchangeidcategoryproduct(){
        $dbProduct = new product();
        $idcategory = $_GET['idcategory'];
        $idproduct = $_GET['idproduct'];
        //thuc hien cap nhat id_category cho san pham do
        $dbProduct->where('id',$idproduct)->update(['id_category'=>$idcategory]);
        
        $products = $dbProduct->where('id_category',$idcategory)->orderBy('id','DESC')->get();
        return view('fontend.admin.ajaxeditcategoryproduct',['products'=>$products]);
    }

    //admin thuc hien chinh sua ten cua danh muc san pham
    public function savecategorynameproduct(Request $request){
        $idcategory = $request->idcategory;
        $newname = $request->categoryname;
        $dbCategory = new category_product();
        $dbCategory->where('id',$idcategory)->update(['category_name'=>$newname]);
        echo "<script>alert('Cập nhật tên danh mục thành công !');window.location.href='".URL::previous()."'</script>";
    }
    // ----------------------------hết quản lý danh mục sản phẩm--------------------------



    // -----------------------------Quản lý danh mục bài viết---------------------------------
        //admin mo form quan li danh muc bài viết
        public function managecategoriesblog(){
            $dbCategories = new category_news();
            $categories = $dbCategories->get();

            $dbNews = new news();
            $listNews = $dbNews->get();
            return view('fontend.admin.managecategoriesblog',['categories'=>$categories,'listNews'=>$listNews]);
        }
    
        //admin xoa 1 danh muc (category) bài viết
        public function deletecategoryblog(){
            $idcategory = $_GET['id'];
            //xoa tat ca bài viết thuoc danh muc do
            $dbBlog = new news();
            $dbBlog->where('id_category',$idcategory)->delete();
    
            //sau khi xoa ta ca bài viết thuoc danh muc do thi xoa danh muc
            $dbCategory = new category_news();
            $dbCategory->where('id',$idcategory)->delete();
            return redirect()->back();
        }
    
        //admin tao them 1 danh muc bài viết moi
        public function addnewcategoryblog(){
            //tên danh mục
            $category_name = $_GET['category_name'];

            //lay ra id danh muc lon nhat
            $dbCategory = new category_news();
            $maxCategory = $dbCategory->whereRaw("id = (SELECT MAX(id) FROM category_news)")->get();
            $maxID = intval($maxCategory[0]->id);
            $IDNewCategory = $maxID + 1;

            //tao danh muc moi
            $dbCategory->id = $IDNewCategory;
            $dbCategory->news_name = $category_name;
            $dbCategory->slug_name = Str::slug($category_name,'-');
            $dbCategory->save();

            if(isset($_GET['strid'])){
                //chuỗi chứa id các sản phẩm để thêm vào danh mục tin tức
                $strid = $_GET['strid'];
                //cập nhật id danh mục cho các sản phẩm có trong danh sách
                $dbNews = new news();
                $dbNews->whereRaw("id IN({$strid})")->update(['id_category'=>$IDNewCategory]);
            }

            //ajax trả về view
            $dbCategories = new category_news();
            $categories = $dbCategories->get();
            return view('fontend.admin.ajaxmanagecategoriesblog',['categories'=>$categories]);
        }
    
        //admin mo form chinh sua 1 danh muc bài viết muon chinh sua
        public function editcategoryblog(){
            if(isset($_GET['id']) && !empty($_GET['id'])){
                $id_category = $_GET['id'];
                $dbCategory = new category_news();
    
                //lấy ra thông tin tổng quát của section cần chỉnh sửa
                $category = $dbCategory->where('id',$id_category)->get();
                //lấy ra thông tin các sản phẩm có trong danh muc cần chỉnh sửa
                $dbNews = new news();
                $news = $dbNews->where('id_category',$id_category)->orderBy('id','DESC')->get();
                //lấy ra danh sách tất cả Bài viết có thể thêm vào danh mục
                $listNews = $dbNews->where('status',1)->get();
                return view('fontend.admin.editcategoryblog',['category'=>$category,'news'=>$news,'listNews'=>$listNews]);
            }else{
                return redirect()->route('admin');
            }
        }

        //cập nhật lại id_category của bài viết trong editcategoryblog.blade.php
        public function editchangeidcategoryblog(){
            $dbNews = new news();
            $idcategory = $_GET['idcategory'];
            $idnews = $_GET['idnews'];
            //thuc hien cap nhat id_category cho san pham do
            $dbNews->where('id',$idnews)->update(['id_category'=>$idcategory]);

            $news = $dbNews->where('id_category',$idcategory)->orderBy('id','DESC')->get();
            return view('fontend.admin.ajaxeditcategoryblog',['news'=>$news]);
        }
    
        //admin thuc hien chinh sua ten cua danh muc bài viết
        public function savecategorynameblog(Request $request){
            $idcategory = $request->idcategory;
            $newname = $request->categoryname;
            $dbCategory = new category_product();
            $dbCategory->where('id',$idcategory)->update(['category_name'=>$newname]);
            echo "<script>alert('Cập nhật tên danh mục thành công !');window.location.href='".URL::previous()."'</script>";
        }
    // --------------------------------hết Quản lý danh mục bài viết------------------------------


    //----------------------------Quản lí review và comment---------------------------

        //mở trang quản lí tất cả review
        public function managereviewproduct(){
            $reviews = review_product::orderBy('id','DESC')->get();
            return view('fontend.admin.comment-review.managereview',['reviews'=>$reviews]);
        }

        //thực hiện xóa review
        public function deletereview(){
            $id = $_GET['id'];
            $dbReview = new review_product();
            $dbReview->where('id',$id)->delete();

            //ajax trả về view quản lí review
            $reviews = review_product::orderBy('id','DESC')->get();
            return view('fontend.admin.comment-review.ajaxmanagereview',['reviews'=>$reviews]);
        }

        //quản lý comment sản phẩm
        public function managecommentproduct(){
            $comments = comment_product::all();
            return view('fontend.admin.comment-review.managecommentproduct',['comments'=>$comments]);
        }

        //xóa comment sản phẩm
        public function deletecommentproduct(){
            $id = $_GET['id'];
            $dbCommentProduct = new comment_product();
            $dbCommentProduct->where('id',$id)->delete();

            $comments = comment_product::all();
            return view('fontend.admin.comment-review.ajaxmanagecommentproduct',['comments'=>$comments]);
        }

        //quản lý comment bài viết
        public function managecommentblog(){
            $comments = comment::all();
            return view('fontend.admin.comment-review.managecommentblog',['comments'=>$comments]);
        }

        //xóa comment bài viết
        public function deletecommentblog(){
            $id = $_GET['id'];
            $dbCommentBlog = new comment();
            $dbCommentBlog->where('id',$id)->delete();

            $comments = comment::all();
            return view('fontend.admin.comment-review.ajaxmanagecommentblog',['comments'=>$comments]);
        }
    //----------------------------------hết-----------------------------------------

    // --------------------------------Quản lý chính sách-----------------------------------

    public function managepolicy(){
        $categories = category_policy::all();
        //lấy ra danh sách tất cả sản phẩm có thể thêm vào section

        $dbPolicy = new policy();
        $listPostPolicy = $dbPolicy->get();
        return view('fontend.admin.policy.managepolicy',['categories'=>$categories,'listPostPolicy'=>$listPostPolicy]);
    }

    //admin tao them 1 danh muc bài viết moi
    public function addnewcategorypolicy(){
        //tên danh mục
        $category_name = $_GET['category_name'];

        //lay ra id danh muc lon nhat
        $dbCategory = new category_policy();
        $maxCategory = $dbCategory->whereRaw("id = (SELECT MAX(id) FROM category_policy)")->get();
        $maxID = intval($maxCategory[0]->id);
        $IDNewCategory = $maxID + 1;

        //tao danh muc moi
        $dbCategory->id = $IDNewCategory;
        $dbCategory->category_name = $category_name;
        $dbCategory->slug_name = Str::slug($category_name,'-');
        $dbCategory->save();

        if(isset($_GET['strid'])){
            //chuỗi chứa id các sản phẩm để thêm vào danh mục tin tức
            $strid = $_GET['strid'];
            //cập nhật id danh mục cho các sản phẩm có trong danh sách
            $dbNews = new news();
            $dbNews->whereRaw("id IN({$strid})")->update(['id_category'=>$IDNewCategory]);
        }

        //ajax trả về view
        $categories = category_policy::all();
        return view('fontend.admin.policy.ajaxmanagepolicy',['categories'=>$categories]);
    }

    //xóa danh mục
    public function deletecategorypolicy(){
        $idcategory = $_GET['id'];
        //xoa tat ca bài viết thuoc danh muc do
        $dbPolicy = new policy();
        $dbPolicy->where('id_category',$idcategory)->delete();

        //sau khi xoa ta ca bài viết thuoc danh muc do thi xoa danh muc
        $dbCategory = new category_policy();
        $dbCategory->where('id',$idcategory)->delete();
        return redirect()->back();
    }

    //mở form chỉnh sửa danh mục chính sách
    public function editcategorypolicy(){
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id_category = $_GET['id'];
            $dbCategory = new category_policy();

            //lấy ra thông tin tổng quát của section cần chỉnh sửa
            $category = $dbCategory->where('id',$id_category)->get();
            //lấy ra thông tin các sản phẩm có trong danh muc cần chỉnh sửa
            $dbPolicy = new policy();
            $posts = $dbPolicy->where('id_category',$id_category)->orderBy('id','DESC')->get();
            //lấy ra danh sách tất cả Bài viết có thể thêm vào danh mục
            $listPosts = $dbPolicy->get();
            return view('fontend.admin.policy.editcategorypolicy',['category'=>$category,'posts'=>$posts,'listPosts'=>$listPosts]);
        }else{
            return redirect()->route('admin');
        }
    }

    //admin thuc hien chinh sua ten cua danh muc
    public function savecategorynamepolicy(Request $request){
        $idcategory = $request->idcategory;
        $newname = $request->categoryname;
        $dbCategory = new category_policy();
        $dbCategory->where('id',$idcategory)->update(['category_name'=>$newname]);
        echo "<script>alert('Cập nhật tên danh mục thành công !');window.location.href='".URL::previous()."'</script>";
    }
    //--------------------------------- hết -------------------------------------------------

    //cập nhật lại id_category của bài viết
    public function editchangeidcategorypolicy(){
        $dbPolicy = new policy();
        $idcategory = $_GET['idcategory'];
        $idnews = $_GET['idnews'];
        //thuc hien cap nhat id_category cho san pham do
        $dbPolicy->where('id',$idnews)->update(['id_category'=>$idcategory]);

        $posts = $dbPolicy->where('id_category',$idcategory)->orderBy('id','DESC')->get();
        return view('fontend.admin.policy.ajaxeditcategorypolicy',['posts'=>$posts]);
    }

    //mở form thêm bài viết chính sách
    public function addnewpolicy(){
        $listcategory = category_policy::all();
        return view('fontend.admin.policy.addnew',['listcategory'=>$listcategory]);
    }

    //thực hiện thêm bài viết chính sách
    public function postaddnewpolicy(Request $request){
        //luu anh vao folder
        $imageName = time().'.'.$request->titleimage->getClientOriginalExtension();
        $request->titleimage->move(public_path('blogs'), $imageName);
        $db = new news();
        $db->title = $request->title;
        $db->link_image = "public/blogs/".$imageName;
        $db->id_user = Auth::user()->id;
        $db->id_category = $request->id_category;
        $db->content = $request->content;
        $db->save();
        echo "<script>alert('Thêm chính sách thành công');history.back();</script>";
    }

}

