<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','HomeController@index')->name("index");

//Xem tin tức
Route::group(['prefix' => 'blog'], function() {
    Route::get('/', 'HomeController@blog')->name('blog');

    //Xem chi tiết tin tức
    Route::get('detailnew', 'HomeController@detailnew')->name('detailnew');
    Route::post('postcomment','userController@postcomment')->name('postcomment');
    Route::get('deletecomment', 'userController@deletecomment')->name('deletecomment');
    Route::get('editcomment', 'userController@editcomment')->name('editcomment');

    //Tìm tin tức
    Route::get('search', 'HomeController@searchnew')->name('searchnew2');
});

//Xem tin tức theo danh mục
Route::get('blog/{category}', 'HomeController@detailcategory')->name('detailcategory');

//Xem chính sách
Route::group(['prefix' => 'policy'], function() {
    Route::get('/', 'HomeController@policy')->name('policy');

    // Xem chi tiết tin tức
    Route::get('detailpolicy', 'HomeController@detailpolicy')->name('detailpolicy');

    //Tìm tin tức
    Route::get('search', 'HomeController@searchpolicy')->name('searchpolicy');
});

//Xem chính sách theo danh mục
Route::get('policy/{category}', 'HomeController@detailcategorypolicy')->name('detailcategorypolicy');

//tra ve chi tiet san pham
Route::get('ctsp', 'HomeController@ctsp')->name('ctsp');

//nguoi dung review san pham
Route::post('ctsp','userController@addreview')->name('addreview');

//nguoi dung sua review san pham cua minh
Route::post('editreview','userController@editreview')->name('editreview');

//nguoi dung them comment vao san pham
Route::post('addcomment','userController@addcomment')->name('addcomment');

//nguoi dung lien he voi nguoi quan tri
Route::get('contact', 'HomeController@contact')->name('contact');

Route::post('contact','HomeController@sendinfor')->name('sendinfor');


//dang nhap
Route::get('login', 'userController@login')->name('login');
Route::post('login','userController@check')->name('plogin');

//dang xuat
Route::get('logout','userController@logout')->name('logout');

Route::get('register', 'userController@register')->name('register');
Route::post('register','userController@pregister')->name('pregister');

Route::get('myorder', 'userController@myorder')->name('myorder');
Route::get('cancelorder', 'userController@cancelorder')->name('cancelorder');

Route::group(['prefix' => 'account','middleware'=>'accountMiddleware'], function () {
    //lay ra thong tin nguoi dung
    Route::get('/', 'userController@account')->name('account');

    //nguoi dung update thong tin cua minh
    Route::post('/','userController@updateAccount')->name('updateaccount');

    //thuc hien doi mat khau
    Route::post('changepassword','userController@changepassword')->name('changepassword');
});

//chinh sach
Route::get('policy', 'HomeController@policy')->name('policy');

//dang ky
Route::get('register', 'userController@register')->name('register');
Route::post('register','userController@pregister')->name('pregister');

//show tat ca san pham
Route::get('shop', 'HomeController@shop')->name('shop');

//tim kiem san pham
Route::get('search','HomeController@search')->name('search');

Route::get('search2','HomeController@search2')->name('search2');

//gio hang
Route::group(['prefix' => 'cart'], function () {
    //them san pham vao gio hang
    Route::get('addcart','userController@addCart')->name('addcart');

    //reset gio hang
    Route::get('resetcart','userController@resetCart')->name('resetcart');

    //giam san pham trong gio hang xuong theo id
    Route::get('updatecartdown','userController@updateCartDown')->name('updatecartdown');

    //tang san pham trong gio hang theo id
    // Route::get('updatecartup/{id}','userController@updateCartUp')->name('updatecartup');
    Route::get('updatecartup','userController@updateCartUp')->name('updatecartup');

    //cap nhat lai so luong san pham co trong gio hang
    Route::get('updatecountcartup','userController@updateCountCartUp')->name('updatecountcartup');

    //cap nhat lai so luong san pham co trong gio hang
    Route::get('updatecountcartdown','userController@updateCountCartDown')->name('updatecountcartdown');

    //xoa san pham theo id co trong gio hang
    Route::get('deletecart','userController@deleteCart')->name('deletecart');

    //cap nhat lai so luong gio hang khi delete 1 id trong gio hang
    Route::get('updateCountCart','userController@updateCountCart')->name('updateCountCart');

    //check code giam gia
    Route::get('checkcode','userController@checkcode')->name('checkcode');

    //xoa code khi khong muon su dung nua
    Route::get('forgetcode','userController@forgetcode')->name('forgetcode');
});

//xem gio hang
Route::get('checkout','userController@getCart')->name('getcart');


Route::group(['prefix' => 'wishlist'], function() {
    Route::get('/','userController@wishlist')->name('wishlist');

    //view wishlist ajax
    Route::get('ajaxwishlist','userController@ajaxwishlist')->name('ajaxwishlist');

    //thêm sản phẩm vào danh sách yêu thích
    Route::get('addwishlist','userController@addwishlist')->name('addwishlist');

    //Xóa sản phẩm khỏi danh sách yêu thích
    Route::get('deletewishlist','userController@deletewishlist')->name('deletewishlist');
});

//Xem danh sách sản phẩm yêu thích
Route::get('wishlist','userController@wishlist')->name('wishlist');

//lấy ra các quận huyện
Route::get('getdistrics','userController@getdistrics')->name('getdistrics');

//lấy ra các phường xã
Route::get('getwards','userController@getwards')->name('getwards');

//mua ngay
Route::get('buynow','userController@buynow')->name('buynow');

//thanh toan
Route::get('payment','userController@payment')->name('payment');

Route::post('payment','userController@postPayment')->name('completeorder');

Route::get('shop/{slug_name}','HomeController@getProductWithCategory')->name('getproductwithcategory');


Route::group(['prefix' => 'admin','middleware'=>'adminMiddleware'], function() {
    Route::get('/', 'adminController@admin')->name('admin');

    Route::get('addproduct','adminController@addproduct')->name('addproduct')->middleware('productMiddleware');
    Route::post('addproduct','adminController@postaddproduct')->name('addproduct')->middleware('productMiddleware');

    Route::get('product','adminController@product')->name('product')->middleware('productMiddleware');
    Route::get('searchproduct','adminController@searchproduct')->name('searchproduct')->middleware('productMiddleware');

    Route::get('exportlistproduct','exportProduct@export')->name("exportlistproduct")->middleware('productMiddleware');

    Route::get('deleteproduct','adminController@deleteproduct')->name('deleteproduct')->middleware('productMiddleware');

    Route::get('editproduct','adminController@editproduct')->name('editproduct')->middleware('productMiddleware');
    Route::post('editproduct','adminController@posteditproduct')->name('editproduct')->middleware('productMiddleware');

    Route::get('addnew','adminController@addnew')->name('addnew')->middleware('addBlogMiddleware');
    Route::post('addnew','adminController@postaddnew')->name('addnew')->middleware('addBlogMiddleware');

    Route::get('listnew','adminController@listnew')->name('listnew')->middleware('showListBlogMiddleware');
    Route::get('searchnew','adminController@searchnew')->name('searchnew')->middleware('showListBlogMiddleware');

    Route::get('deletenew','adminController@deletenew')->name('deletenew');

    Route::get('editnew','adminController@editnew')->name('editnew');
    Route::post('editnew','adminController@posteditnew')->name('editnew');

    Route::get('manageorder','adminController@manageorder')->name('manageorder')->middleware('orderMiddleware');
    Route::get('searchorder','adminController@searchorder')->name('searchorder')->middleware('orderMiddleware');;

    // Route::get('manageorder','adminController@manageorder')->name('manageorder')->middleware('orderMiddleware');

    Route::get('detailorder','adminController@detailorder')->name('detailorder')->middleware('orderMiddleware');

    Route::get('choosesaler','adminController@chooseSaler')->name('choosesaler')->middleware('orderMiddleware');

    //task saler
    Route::get('notcontactyet','adminController@notContactYet')->name('notcontactyet');

    Route::post('processorder','adminController@processorder')->name('processorder');
    Route::get('sale-detailorder','adminController@saleDetailOrder')->name('saledetailorder');

    //het task saler

    //task censor

    Route::get('acceptproduct','adminController@listNotAcceptYet')->name('listnotacceptyetproduct')->middleware('acceptMiddleware');

    Route::get('accepteditproduct','adminController@accepteditproduct')->name('accept-editproduct')->middleware('acceptMiddleware');
    Route::post('accepteditproduct','adminController@acceptposteditproduct')->name('accept-editproduct')->middleware('acceptMiddleware');

    Route::get('listacceptnew','adminController@listNotAcceptYetNew')->name('listnotacceptyetnew')->middleware('acceptMiddleware');

    Route::get('acceptnew','adminController@acceptnews')->name('acceptnew')->middleware('acceptMiddleware');
    Route::post('acceptnew','adminController@postacceptnews')->name('acceptnew')->middleware('acceptMiddleware');
    //het task censor

    Route::post('processorder','adminController@processorder')->name('processorder');

    //show danh sach tat ca cau hoi cua khach
    Route::get('contact','adminController@contact')->name('admin-contact');

    //bieu do thong ke doanh so nam truoc va nam nay
    Route::get('chart','adminController@chart')->name('admin-chart')->middleware('revenueMiddleware');
    //bieu do thong ke doanh thu theo tuan
    Route::get('chartweekly','adminController@chartweekly')->name('chartweekly')->middleware('revenueMiddleware');
    //bieu do thong ke doanh thu theo thang
    Route::get('chartmonthly','adminController@chartmonthly')->name('chartmonthly')->middleware('revenueMiddleware');
    //bieu do thong ke theo danh muc san pham
    Route::get('chartcategories','adminController@chartcategories')->name('chartcategories')->middleware('revenueMiddleware');

    //chi tiet cau hoi cua khach va form reply
    Route::get('detailmessage/{id}','adminController@detailmessage')->name("detailmessage");

    //chi tiet cau hoi cua khach va from reply
    Route::post('detailmessage/{id}','adminController@postdetailmessage')->name("postdetailmessage")->middleware('messageMiddleware');

    //show danh sach user
    Route::get('listuser','adminController@getAllUsers')->name("showlistuser")->middleware('userMiddleware');
    
    Route::get('exportlistuser','exportController@export')->name("exportlistuser")->middleware('userMiddleware');
    
    //xoa user
    Route::get('deleteuser','adminController@deleteUser')->name("deleteuser")->middleware('userMiddleware');

    //show profile cua 1 tai khoan
    Route::get('profile','adminController@getProfile')->name("profile")->middleware('manageUserMiddleware');

    //xu ly ham post khi update profile
    Route::post('profile','adminController@updateProfile')->name("updateprofile")->middleware('manageUserMiddleware');

    //admin tim kiem nguoi dung
    Route::get('searchuser','adminController@searchUser')->name("adminsearchuser")->middleware('manageUserMiddleware');

    //admin tim kiem nguoi dung trong route message(cau hoi tu nguoi dung)
    Route::get('searchmessage','adminController@searchMessage')->name("adminsearchcontact");

    //Task ke toan
    //show list tat ca cong tac vien
    Route::get('listcollaborator','adminController@listctv')->name('listctv')->middleware('accountantMiddleware');

    Route::get('listordercomplete','adminController@listOrderComplete')->name('listordercomplete')->middleware('accountantMiddleware');
    
    //ke toan tim don hang da thanh cong theo id hoac ten khach hang
    Route::get('searchordercomplete','adminController@searchOfAccountant')->name('searchordercomplete')->middleware('accountantMiddleware');
    
    //ke toan tim kiem cac user nam trong list cong tac vien
    Route::get('accountantsearchuser','adminController@accountantsearchuser')->name('accountantsearchuser')->middleware('accountantMiddleware');

    //het task ke toan

    //xuat bao cao sang dang excel cho admin
    Route::get('printreportorder','exportOrderController@export')->name('printreportorder')->middleware('accountantMiddleware');

    //xuat bao cao don hang cho ke toan thang hien tai
    Route::get('printreportforaccountant','ReportOfAccountant@export')->name('printreportforaccountant')->middleware('accountantMiddleware');

    //xuat bao cao don hang cho ke toan thang truoc
    Route::get('printreportforaccountantlastmonth','ReportOfAccountantLastMonth@export')->name('printreportforaccountantlastmonth')->middleware('accountantMiddleware');

    //xuất báo cáo hoa hồng cho saler thang hien tai
    Route::get('printreportforsalethismonth','printreportforsalethismonth@export')->name('printreportforsalethismonth')->middleware('accountantMiddleware');

    //xuất báo cáo hoa hồng cho saler thang hien tai
    Route::get('printreportforsalelastmonth','printreportforsalelastmonth@export')->name('printreportforsalelastmonth')->middleware('accountantMiddleware');

    //xuất báo cáo hoa hồng cho saler trong tuần này
    Route::get('printreportforsalethisweek','printreportforsalethisweek@export')->name('printreportforsalethisweek')->middleware('accountantMiddleware');

    //xuất báo cáo hoa hồng cho saler trong năm nay
    Route::get('printreportforsalethisyear','printreportforsalethisyear@export')->name('printreportforsalethisyear')->middleware('accountantMiddleware');

    Route::get('createsubadmin','adminController@createsubadmin')->name('createsubadmin')->middleware('userMiddleware');
    Route::post('createsubadmin','adminController@postsubadmin')->name('createsubadmin')->middleware('userMiddleware');

    Route::get('listbranch','adminController@listbranch')->name('listbranch')->middleware('userMiddleware');

    Route::get('editbranch','adminController@editbranch')->name('editbranch')->middleware('userMiddleware');
    Route::post('editbranch','adminController@posteditbranch')->name('editbranch')->middleware('userMiddleware');

    Route::get('addbranch','adminController@addbranch')->name('addbranch')->middleware('userMiddleware');
    Route::post('addbranch','adminController@postaddbranch')->name('addbranch')->middleware('userMiddleware');

    Route::get('deletebranch','adminController@deletebranch')->name('deletebranch')->middleware('userMiddleware');
    //-----------------------section-----------------------------------------------
    //admin quản lí section show ra index
    Route::get('managesection','adminController@managesection')->name('managesection');

    //admin luu tieu de section
    Route::post('managesection','adminController@savetitle')->name('savetitle');

    //admin mở form edit section
    Route::get('editsection','adminController@editsection')->name('editsection');

    //admin them san pham vao list section
    Route::get('addtosection','adminController@addtosection')->name('addtosection');

    //admin xoa san pham khoi list section
    Route::get('deletetosection','adminController@deletetosection')->name('deletetosection');

    //admin tao them section moi
    Route::get('addsection','adminController@addsection')->name('addsection');

    //admin xoa section
    Route::get('deletelistsection','adminController@deletelistsection')->name('deletelistsection');

    //them san pham vao danh sach san pham cua section trong editsection.blade.php 
    Route::get('editaddtosection','adminController@editaddtosection')->name('editaddtosection');

    //xóa san pham khoi danh sach san pham cua section trong editsection.blade.php 
    Route::get('editdeletetosection','adminController@editdeletetosection')->name('editdeletetosection');
    
    //cập nhật id_category của sản phẩm trong editcategoryproduct.blade.php 
    Route::get('editchangeidcategoryproduct','adminController@editchangeidcategoryproduct')->name('editchangeidcategoryproduct');

    //cập nhật id_category của bài viết trong editcategoryblog.blade.php 
    Route::get('editchangeidcategoryblog','adminController@editchangeidcategoryblog')->name('editchangeidcategoryblog');
    
    //cập nhật id_category của bài viết trong editcategorypolicy.blade.php
    Route::get('editchangeidcategorypolicy','adminController@editchangeidcategorypolicy')->name('editchangeidcategorypolicy');
    
    // -----------------------------------------------------------------------------------------

    // ---------------------------------Quan ly Categories product-----------------------------------------
    //admin mo form quan li categories san pham
    Route::get('managecategoriesproduct','adminController@manageCategoriesProduct')->name('manageCategoriesProduct');

    //admin xoa 1 danh muc san pham
    Route::get('deletecategoryproduct','adminController@deletecategoryproduct')->name('deletecategoryproduct');

    //admin tao them 1 danh muc san pham moi
    Route::get('addnewcategoryproduct','adminController@addnewcategoryproduct')->name('addnewcategoryproduct');

    //admin mo form chinh sua category product muon chinh sua
    Route::get('editcategoryproduct','adminController@editcategoryproduct')->name('editcategoryproduct');

    //admin doi id_category cua san pham
    Route::get('changeidcategoryproduct','adminController@changeidcategoryproduct')->name('changeidcategoryproduct');
    
    Route::POST('savecategorynameproduct','adminController@savecategorynameproduct')->name('savecategorynameproduct');
    
    // -----------------------------------------------------------------------------------------

    // ---------------------------------Quan ly Categories blog-----------------------------------------
    //admin mo form quan li categories bài viết
    Route::get('managecategoriesblog','adminController@managecategoriesblog')->name('managecategoriesblog');

    //admin xoa 1 danh muc bài viết
    Route::get('deletecategoryblog','adminController@deletecategoryblog')->name('deletecategoryblog');

    //admin tao them 1 danh muc bài viết moi
    Route::get('addnewcategoryblog','adminController@addnewcategoryblog')->name('addnewcategoryblog');

    //admin mo form chinh sua category blog muon chinh sua
    Route::get('editcategoryblog','adminController@editcategoryblog')->name('editcategoryblog');

    //admin doi id_category cua bài viết
    Route::get('changeidcategoryblog','adminController@changeidcategoryblog')->name('changeidcategoryblog');
    
    //lưu tên mới của danh mục
    Route::POST('savecategorynameblog','adminController@savecategorynameblog')->name('savecategorynameblog');
    
    // -----------------------------------------------------------------------------------------

    // ---------------------------quản lý các dữ liệu động trong header và footer-------------------
    //show ra tất cả banner 
    Route::get('managebanner','layoutController@managebanner')->name('managebanner');

    //mở form chỉnh sửa banner
    Route::get('editbanner','layoutController@editbanner')->name('editbanner');

    //thực hiện chỉnh sửa banner
    Route::post('editbanner','layoutController@posteditbanner')->name('posteditbanner');

    // ----------------------------------------------------------------------------------------

    //quản lí review sản phẩm
    Route::get('managereviewproduct','adminController@managereviewproduct')->name('managereviewproduct');

    //xóa review
    Route::get('deletereview','adminController@deletereview')->name('deletereview');

    //quản lý comment sản phẩm
    Route::get('managecommentproduct','adminController@managecommentproduct')->name('managecommentproduct');

    //xóa comment sản phẩm
    Route::get('deletecommentproduct','adminController@deletecommentproduct')->name('deletecommentproduct');

    //quản lý comment bài viết
    Route::get('managecommentblog','adminController@managecommentblog')->name('managecommentblog');

    //xóa comment bài viết
    Route::get('deletecommentblog','adminController@deletecommentblog')->name('deletecommentblog');

    //quản lí danh mục chính sách
    Route::get('managepolicy','adminController@managepolicy')->name('managepolicy');

    //thêm mới danh mục policy
    Route::get('addnewcategorypolicy','adminController@addnewcategorypolicy')->name('addnewcategorypolicy');

    //xóa danh mục chính sách
    Route::get('deletecategorypolicy','adminController@deletecategorypolicy')->name('deletecategorypolicy');

    //mờ form chỉnh sửa danh mục chính sách
    Route::get('editcategorypolicy','adminController@editcategorypolicy')->name('editcategorypolicy');

    //lưu tên mới của danh mục
    Route::POST('savecategorynamepolicy','adminController@savecategorynamepolicy')->name('savecategorynamepolicy');

    //thêm bài viết cho chính sách
    Route::get('addnewpolicy','adminController@addnewpolicy')->name('addnewpolicy');

    //thực hiện thêm bài viết chính sách mới
    Route::post('postaddnewpolicy','adminController@postaddnewpolicy')->name('postaddnewpolicy');
});
Route::get('/redirect', 'Auth\LoginController@redirectToProvider')->name('logingg');
Route::get('/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/auth/redirect/{provider}', 'Auth\LoginController@redirect');
Route::get('/callback/{provider}', 'Auth\LoginController@callback');

Route::get('resetpass', 'userController@resetpass')->name('resetpass');
Route::post('resetpass', 'userController@postmail')->name('resetpass');

Route::post('postcode', 'userController@postcode')->name('postcode');
Route::post('postpass', 'userController@postpass')->name('postpass');
