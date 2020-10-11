<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\category_product;
use App\category_news;
use App\category_policy;
use App\comment;
use App\product;
use App\news;
use App\policy;
use App\review_product;
use App\User;
use App\inforcontact;
use App\cart;
use App\comment_product;
use Illuminate\Support\Facades\Auth;
use Mail;
use App\banner;
use Carbon\Carbon;
use App\Http\Requests\profile;
use App\section;
use App\section_content;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    // Hàm xử lý index
    public function index()
    {
        $DetailProduct = \App\product::all()->take(12);
        $DetailProduct = \App\product::all()->where('status',1)->take(12);
        //lay ra id cua tat ca section duoc admin tao ra
        $categories = \App\category_product::all();
        $list = [];
        $i = 0;
        $count = 0;
        $dbSectionContent = new section_content();
        $sections = \App\section::all();
        foreach($sections as $section){
            //dua 6 san pham cua moi danh muc vao 1 mang
            $list[$i] = $dbSectionContent->where('id_section',$section->id)->get();
            $i++;
            //bien count de dem co bao nhieu danh muc section
            $count++;
        }

        //lay ra thong tin cua 6 bai viet
        $news = \App\news::all()->take(6);

        //lấy ra banner của trang index
        $banners = banner::all();
        return view('fontend.index',['DProduct'=>$DetailProduct,'list'=>$list,'quantitySection'=>$count,'listNameSection'=>$sections,'news'=>$news,'banners'=>$banners]);
    }

    //Chính sách
    public function policy()
    {
        $db = new policy();
        $datapolicy = $db->Paginate(3);
        $datacategory = category_policy::all();
        return view('fontend.policy',['datacategory'=>$datacategory,'datapolicy'=>$datapolicy]);
    }

    //Xem chính sách chi tiết
    public function detailpolicy()
    {
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = $_GET['id'];
            $datapolicy = policy::find($id);
            $datacategory = category_policy::all();
            return view('fontend.detail-policy',['datacategory'=>$datacategory,'datapolicy'=>$datapolicy]);
        }else{
            return redirect()->route('blog');
        }
    }


    //Tin tức
    public function blog()
    {
        $db = new news;
        $datanew = $db->where('status',1)->orderBy('created_at','DESC')->Paginate(3);
        $datacategory = category_news::all();
        return view('fontend.blog',['datacategory'=>$datacategory,'datanew'=>$datanew]);
    }

    public function searchpolicy()
    {
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $q = $_GET['q'];
        }else{
            $q = "noresult";
        }
        $db = new policy();
        $datapolicy = $db->where('id',$q)->orwhereRaw("title LIKE '%{$q}%' ")->orderBy('created_at','DESC')->Paginate(3);
        $datacategory = category_policy::all();
        return view('fontend.policy',['datacategory'=>$datacategory,'datapolicy'=>$datapolicy]);
    }

    public function detailcategorypolicy(Request $request){
        $path = $request->path();
        $split = explode('/',$path);
        $db = new policy();
        $datapolicy = $db->join('category_policy','category_policy.id','policy.id_category')->where('category_policy.slug_name',$split[1])->orderBy('created_at','DESC')->Paginate(3);
        $datacategory = category_policy::all();
        return view('fontend.category_policy',['datacategory'=>$datacategory,'datapolicy'=>$datapolicy]);
    }

    public function detailnew()
    {
        if(isset($_GET['id']) && !empty($_GET['id'])){
            $id = $_GET['id'];
            $datanew = news::find($id);
            $datacategory = category_news::all();
            if($datanew->status == 1){
                $db = new comment();
                $comment = $db->where('id_news',$id)->get();
                return view('fontend.detailnew',['datacategory'=>$datacategory,'datanew'=>$datanew,'datacomment'=>$comment]);
            }
            else{
                return redirect()->route('blog');
            }
        }else{
            return redirect()->route('blog');
        }
    }

    public function searchnew()
    {
        if(isset($_GET['q']) && !empty($_GET['q'])){
            $q = $_GET['q'];
        }else{
            $q = "noresult";
        }
        $db = new news();
        $datanew = $db->where('id',$q)->orwhereRaw("title LIKE '%{$q}%' ")->where('status',1)->orderBy('created_at','DESC')->Paginate(3);
        $datacategory = category_news::all();
        return view('fontend.blog',['datacategory'=>$datacategory,'datanew'=>$datanew]);
    }

    public function detailcategory(Request $request)
    {
        $path = $request->path();
        $split = explode('/',$path);
        $db = new news();
        $datanew = $db->join('category_news','category_news.id','news.id_category')->where('category_news.slug_name',$split[1])->where('status',1)->Paginate(3);
        $datacategory = category_news::all();
        return view('fontend.category_news',['datacategory'=>$datacategory,'datanew'=>$datanew]);
    }

    // Hàm xử lý ctsp
    public function ctsp()
    {
        if(isset($_GET['id'])&&!empty($_GET['id'])){
            $id = $_GET['id'];
            $db = new product();
            $product = $db->where('status',1)->where('id',$id)->get();
            $db = new review_product();
            $reviews = $db->join('users','users.id','review_product.id_user')->where('review_product.id_product','=',$id)->get();
            $check = 0;
            $checkreviewexist = 0;
            $dbcomment = new comment_product();
            $comments = $dbcomment->join('users','users.id','comment_product.id_user')->where('comment_product.id_product','=',$id)->select('comment_product.id','comment_product.id_product','comment_product.id_user','comment_product.comment','users.fullname','comment_product.created_at')->orderBy('id','DESC')->get();
            if(Auth::check()){
                $wishlist =  Auth::user()->wishlist;
                $arraylist = explode(',',$wishlist);
                foreach($arraylist as $item){
                    if($item==$id){
                        $check =1;
                    }
                }
                $checkoldreview = $db->where('id_product',$id)->where('id_user',Auth::user()->id)->count();
                if($checkoldreview>0){
                    $oldreview = $db->where('id_product',$id)->where('id_user',Auth::user()->id)->get();
                }
                if(!empty($oldreview)){
                    $checkreviewexist = 1;
                }
                if(!empty($product) && !empty($oldreview) && $checkreviewexist == 1){
                    return view('fontend.chi-tiet-sp',['data'=>$product,'reviews'=>$reviews,'check'=>$check,'checkreviewexist'=>$checkreviewexist,'oldreview'=>$oldreview,'comments'=>$comments]);
                }else{
                    if(!empty($product)){
                        return view('fontend.chi-tiet-sp',['data'=>$product[0],'reviews'=>$reviews,'check'=>$check,'checkreviewexist'=>$checkreviewexist,'comments'=>$comments]);
                    }else{
                        return redirect('/');
                    }
                }
            }else{
                return view('fontend.chi-tiet-sp',['data'=>$product[0],'reviews'=>$reviews,'check'=>$check,'checkreviewexist'=>$checkreviewexist,'comments'=>$comments]);
            }
        }else{
            return redirect('/');
        }
    }


    // Hàm xử lý index
    public function contact()
    {
        return view('fontend.contact');
    }
    
    public function sendinfor(Request $request)
    {
        $db = new inforcontact();
        $db->fullname = $request->fullname;
        $db->email = $request->email;
        $db->phone = $request->phone;
        $db->content = $request->content;
        $db->status = 0;
        $db->save();
        $data = [
            'name' => $request->fullname
        ];
        $clientmail = $request->email;
        $clientname = $request->fullname;
        Mail::send('fontend.mail', $data, function ($message) use($request) {
            $message->from('sunshineweb.vn@gmail.com', 'SoftMart');
            $message->to($request->email,$request->fullname);
            $message->subject('Thư xác nhận');
        });
        echo "<script>alert('Thông tin của bạn đã gửi thành công!!');history.back();</script>";
        return view('fontend.contact');

    }

    public function shop()
    {
        $db = new category_product();
        $categories = $db->all();
        $db2 = new product();
        //lay du lieu va phan trang
        $data = $db2->where('status',1)->Paginate(15);
        return view('fontend.shop',['data'=>$data,'categories'=>$categories]);
    }

    public function getProductWithCategory($slug_name){
        $categories = \App\category_product::all();
        $db = new category_product();
        $products = $db->join('product','product.id_category','category_product.id')->where('category_product.slug_name',$slug_name)->where('status',1)->Paginate(15);
        return view('fontend.category',['data'=>$products,'categories'=>$categories]);
    }

    public function search(){
        if(isset($_GET['q'])&&!empty($_GET['q'])){
            $q = $_GET['q'];
        }else{
            $q = "noresult";
        }
        $db2 = new product();
        //tim kiem theo id va ten san pham
        $result = $db2->where('status',1)->where('id',$q)->orwhereRaw("product_name LIKE '%{$q}%' ")->Paginate(15);
        $db = new category_product();
        $categories = $db->all();
        return view('fontend.search',['data'=>$result,'categories'=>$categories]);
    }

    public function search2(){
        $q = $_GET['q'];
        $db = new product();
        $data = $db->where('status',1)->where('id',$q)->orWhereRaw("product_name LIKE '%{$q}%'")->take(5)->get();
        return $data;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
