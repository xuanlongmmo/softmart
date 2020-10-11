<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\banner;
use Illuminate\Support\Facades\URL;

class layoutController extends Controller
{
    // -------------------Quản lý dữ liệu động trong header và footer---------------------------

    public function managebanner(){
        $banners = banner::all();
        return view('fontend.admin.banner-inforcontact.managebanner',['banners'=>$banners]);
    }

    //mở form chỉnh sửa banner
    public function editbanner(){
        $idbanner = $_GET['id'];
        $banner = banner::find($idbanner);
        
        return view('fontend.admin.banner-inforcontact.editbanner',['banner'=>$banner]);
    }

    //thực hiện chỉnh sửa banner
    public function posteditbanner(Request $request){
        $dbBanner = new banner();
        if(!empty($request->newimage)){
            //luu anh vao folder
            $imageName = time().'.'.$request->newimage->getClientOriginalExtension();
            $request->newimage->move(public_path('banner'), $imageName);
            $dbBanner->where('id',$request->idbanner)->update(['link_image'=>"public/banner/".$imageName,'title'=>$request->title,'content'=>$request->content,'link'=>$request->link]);
        }else{
            $dbBanner->where('id',$request->idbanner)->update(['title'=>$request->title,'content'=>$request->content,'link'=>$request->link]);
        }
        echo "<script>alert('Cập nhật banner thành công !');window.location.href='".URL::previous()."'</script>";
    }
    //------------------------------------HẾT----------------------------------------------
}
