<?php

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

use Illuminate\Support\Facades\Artisan;


Route::get('/welcome', function () {
            $title='حساب کاربری شما ساخته شد';
        $seo_title="سئو حساب کاربری شما ساخته شد";
        $seo_content="سئو حساب کاربری شما ساخته شد";
        return view('home',compact('title','seo_title','seo_content'));
});
Route::get('file/{id}','FileController@getfile')->name('UserDownloadFile')->middleware(['signed','auth']);
Route::get('files/{id}','FileController@getSignedUrl')->middleware('auth');





/***************** FrontController  ******************/
Route::get('/', 'Front\FrontController@index')->name('home');
Route::get('/search', 'Front\FrontController@shop');
Route::get('/search/brand/{brand}', 'Front\FrontController@brandshop');
Route::get('/search/{slug}', 'Front\FrontController@shop')->name('shop');

Route::get('/checkout', 'Front\FrontController@checkout');
Route::get('/cart', 'Front\FrontController@cart');
Route::get('/sendorder', 'Front\FrontController@sendorder');
Route::get('/confirmandsend', 'Front\FrontController@confirmandsend');
Route::post('/store-confirmandsend', 'Front\FrontController@confirmandsend_store');
Route::get('/orderResultInfo/{success}', 'Front\FrontController@orderResultInfo');
Route::get('/faq', 'Front\FrontController@faq');
Route::get('/privacy', 'Front\FrontController@privacy');
Route::get('/returnpolicy', 'Front\FrontController@returnpolicy');
Route::get('/guide', 'Front\FrontController@guide');
Route::get('/transferpolicy', 'Front\FrontController@transferpolicy');
Route::get('/blog', 'Front\FrontController@blog_index');
Route::get('/spacial', 'Front\FrontController@spacial');
Route::get('/blog/{slug}', 'Front\FrontController@blog');
Route::get('/post-search', 'Front\FrontController@blog_search')->name('post_search');
Route::get('/contact', 'Front\FrontController@contact');
Route::get('/product', 'Front\FrontController@product');
Route::get('/page/{slug}', 'Front\FrontController@page');
Route::group(['middleware' => 'admin'], function () {
    Route::get('/comment/{slug}', 'Front\FrontController@comment');
    Route::get('/comment/{slug}/{id}', 'Front\FrontController@comment');
});
Route::post('/comment-store/{id}', 'Front\FrontController@comment_store');
Route::post('/comment-edit/{slug}/{id}', 'Front\FrontController@comment_store');
Route::get('/product/{slug}', 'Front\FrontController@product');
Route::get('/about', 'Front\FrontController@about');
Route::post('/comment_post_store', 'Front\FrontController@comment_post')->name('comment_post_store');
Route::post('/contact_store', 'Front\FrontController@contact_store')->name('contact_store');


Route::post('/product-filter/doSearch-filter', 'Front\FrontController@doSearch')->name('shop.doSearch');
Route::post('/product-filter/doSearch-filterr', 'Front\FrontController@search_brand')->name('shop.doSearch_brand');
Route::post('/newslater-create', 'Front\FrontController@newslater_create')->name('index.newslater-create');

/***************** FrontController  ******************/
MenuBuilder::routes();






Route::get('/mytest', function () {
    return view('test');
});


Route::get('/printp/{id}', function ($id) {
    $pack = App\Package::findorfail($id);
    $user = App\User::findorfail(Auth::id());
    return view('printp', compact(['pack']));
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
Route::post('/get_user_reference','AdminAjaxController@get_user_reference')->name('get_user_reference');
//************************************* start Front Site **********************************************


Route::resource('/basket', 'Front\FrontBasketesController');
Route::delete('/basket/delete/{id}', 'Front\FrontAjaxsController@deleteItem')->name('ajax.delete');
Route::post('/basket/minus', 'Front\FrontAjaxsController@minusProductCount')->name('ajax.minus');
Route::post('/basket/add', 'Front\FrontAjaxsController@addProductCount')->name('ajax.add');
Route::post('/commentStore', 'Front\FrontAjaxsController@commentStore')->name('ajax.commentStore');
Route::post('/view-set_view_post','Front\FrontAjaxsController@set_view_post')->name('view.set_view_post');
Route::post('/view-set_view_product','Front\FrontAjaxsController@set_view_product')->name('view.set_view_product');
Route::post('/profile-add_favorite','Front\FrontAjaxsController@add_favorite')->name('panel.add_favorite');
Route::post('/profile-add_remove_favorite','Front\FrontAjaxsController@add_remove_favorite')->name('panel.add_remove_favorite');
Route::post('/profile-delete_favorite','Front\FrontAjaxsController@delete_favorite')->name('panel.delete_favorite');
Route::post('/all-search','Front\FrontAjaxsController@search')->name('search.search');
Route::post('/checkdiscountcode','Front\FrontAjaxsController@checkdiscountcode')->name('code.checkdiscountcode');
Route::post('/cart/check_count_product', 'Front\FrontAjaxsController@check_count_product')->name('cart.check_count_product');
Route::post('/pro/request-quantity', 'Front\FrontAjaxsController@request_quantity')->name('product.request-quantity');
Route::post('/index/search', 'Front\FrontAjaxsController@search_input')->name('search.input');

Route::get('admin/payment', 'Admin\AdminPaymentController@send')->name('payment.send');
Route::get('admin/paymentBack', 'Admin\AdminPaymentController@back')->name('payment.paymentBack');

//************************************* start Front Site **********************************************

Route::group(['middleware' => 'admin'], function (){

        Route::get('admin/stats', 'lastloginuser@stats')->name('stats');
        Route::get('admin/lastlogin', 'lastloginuser@index')->name('lastlogin');

        /***************** AdminB *****************/
        Route::get('admin/orders-product/export', 'Admin\AdminOrdersController@report')->name('orders.report');
        Route::get('admin/users/export', 'Admin\AdminUsersController@report')->name('users.report');
        Route::resource('admin/orders-product', 'Admin\AdminOrdersController');
        Route::resource('admin/orders-reservation', 'Admin\AdminOrderReservationController');
        Route::resource('admin/orders-download', 'Admin\AdminDownloadsController');
        Route::get('admin/views/deleteAllViews', 'Admin\AdminDashboardController@delete_views')->name('views.delete_all');
        Route::resource('admin/dashboard', 'Admin\AdminDashboardController');
        Route::resource('admin/pages', 'Admin\AdminPagesController');
        Route::resource('admin/Sending-agent', 'Admin\AdminSendingAgentController');
        Route::resource('admin/messages', 'Admin\AdminMessagesController');

        Route::resource('admin/user-s', 'Admin\AdminUsersController');
        Route::resource('admin/admins', 'Admin\AdminAdminsController');
        Route::resource('admin/attribute', 'Admin\AdminAttributesController');
        Route::resource('admin/categories', 'Admin\AdminCategoriesController');
        Route::resource('admin/PostCategory', 'Admin\AdminPostCategoriesController');
        Route::resource('admin/comment-product', 'Admin\AdminCommentProductController');
        Route::resource('admin/comment-post', 'Admin\AdminCommentPostController');
        Route::resource('admin/settings', 'Admin\AdminSettingsController');
        Route::resource('admin/sliders', 'Admin\AdminSlidersController');
        Route::resource('admin/banners', 'Admin\AdminBannersController');
        Route::resource('admin/brands', 'Admin\AdminBrandsController');
        //Route::resource('admin/menus', 'Admin\AdminMenusController');
        Route::resource('admin/clubs', 'Admin\AdminClubsController');
        Route::resource('admin/news', 'Admin\AdminNewsController');
        Route::resource('admin/alerts', 'Admin\AdminAlertsController');
        Route::resource('admin/discountcodes', 'Admin\AdminDiscountcodesController');
        Route::resource('admin/special', 'Admin\AdminSpecialsController');
        Route::resource('admin/faq', 'Admin\AdminFaqController');
        Route::resource('admin/complain', 'Admin\AdminComplainController');
        Route::resource('admin/contact', 'Admin\AdminContactController');
        Route::resource('admin/about', 'Admin\AdminAboutController');
        Route::resource('admin/returnpolicy', 'Admin\AdminReturnpolicyController');
        Route::resource('admin/guide', 'Admin\AdminGuideController');
        Route::resource('admin/privacy', 'Admin\AdminPrivacyController');
        Route::resource('admin/transferpolicy', 'Admin\AdminTransferpolicyController');
        Route::get('admin/RequestQuantity', 'Admin\AdminRequestQuantityController@index')->name('RequestQuantity.index');



        Route::get('admin/calculation', 'Admin\AdminCalculationController@calculation');


        //************************************* Admin Site **********************************************
        Route::get('admin/products/deletegalleryproduct/{id}', 'Admin\AdminProductsController@deletegalleryproduct')->name('gallery.delete');
        Route::get('admin/products/deletefileproduct/{id}', 'Admin\AdminProductsController@deletefileproduct')->name('fileDownload.delete');
        Route::get('admin/products/deletevideoproduct/{id}', 'Admin\AdminProductsController@deletevideoproduct')->name('videoproduct.delete');

        Route::get('admin/product/attributes/{slug}', 'Admin\AdminProductsController@attributes');
        Route::post('admin/product/attribute_create', 'Admin\AdminProductsController@attribute_create')->name('attribute_create');
        Route::get('admin/product/add-excel', 'Admin\AdminProductsController@excel')->name('product.add-excel');
        Route::post('admin/product/add-excel', 'Admin\AdminProductsController@store_excel')->name('product.store.excel');
        Route::resource('admin/products', 'Admin\AdminProductsController');

        Route::resource('admin/posts', 'Admin\AdminPostsController');
        Route::resource('admin/Proposal-image', 'Admin\AdminProposalImageController');
        Route::resource('admin/profile', 'Admin\AdminProfilesController');

        //************************************* Admin Site **********************************************

        /***************** AdminB *****************/


        /***************** ajax B *****************/
        Route::post('/getoffcode', 'AdminAjaxController@getoffcode');
        Route::post('/commentminiproduct', 'AdminAjaxController@commentminiproduct');
        Route::post('/setlike', 'AdminAjaxController@setlike');
        Route::post('/setdislike', 'AdminAjaxController@setdislike');
        Route::post('/checkbag', 'AjaxController@checkbag')->name('checkbag');
        Route::post('/number_format_price', 'AdminAjaxController@number_format_price')->name('number_format_price');
        Route::post('/check_return_code_wallet', 'AdminAjaxController@check_return_code_wallet')->name('check_return_code_wallet');
        Route::post('/refresh_price_wallet', 'AjaxController@refresh_price_wallet')->name('refresh_price_wallet');
        Route::post('/Money_transfer_wallet', 'AdminAjaxController@Money_transfer_wallet')->name('Money_transfer_wallet');
        Route::post('/selfupdateuser', 'AdminAjaxController@selfupdateuser')->name('selfupdateuser');
        Route::post('/uploadimageprofile', 'AdminAjaxController@uploadimageprofile')->name('uploadimageprofile');
        Route::post('/Change_status_user', 'AdminAjaxController@Change_status_user')->name('Change_status_user');
        Route::post('/Change_status_user_wallet', 'AdminAjaxController@Change_status_user_wallet')->name('Change_status_user_wallet');
        Route::post('/Change_status_user_sendmoney', 'AdminAjaxController@Change_status_user_sendmoney')->name('Change_status_user_sendmoney');
        Route::post('/Change_status_user_seller', 'AdminAjaxController@Change_status_user_seller')->name('Change_status_user_seller');
        Route::post('/Change_documents_user', 'AdminAjaxController@Change_documents_user')->name('Change_documents_user');
        Route::post('/Change_documents_status_user', 'AdminAjaxController@Change_documents_status_user')->name('Change_documents_status_user');
        Route::post('/getstate', 'AdminAjaxController@getstate');
        Route::post('/admin/admins/Change_user_isadmin', 'AdminAjaxController@Change_user_isadmin')->name('Change_user_isadmin');
        Route::post('/admin/alerts/alert_status', 'AdminAjaxController@alert_status')->name('alert_status');
        Route::post('/admin/alerts/alert_remove', 'AdminAjaxController@alert_remove')->name('alert_remove');
        Route::post('/admin/alerts/special_remove', 'AdminAjaxController@special_remove')->name('special_remove');
        Route::post('/admin/delete-message', 'AdminAjaxController@delete_message')->name('message.delete_message');
        Route::post('/admin/change-status-message', 'AdminAjaxController@change_status_message')->name('message.change_status');
        Route::post('/admin/delete_post', 'AdminAjaxController@delete_post')->name('post.delete_post');
        Route::post('/admin/delete_posts', 'AdminAjaxController@delete_posts')->name('post.delete_posts');
        Route::post('/admin/delete_page', 'AdminAjaxController@delete_page')->name('pages.delete_page');
        Route::post('/admin/delete_pages', 'AdminAjaxController@delete_pages')->name('pages.delete_pages');
        Route::post('/admin/delete_faqs', 'AdminAjaxController@delete_faqs')->name('faq.delete_faqs');
        Route::post('/admin/delete_faq', 'AdminAjaxController@delete_faq')->name('faq.delete_faq');

        Route::post('/admin/delete-Proposal-images', 'AdminAjaxController@delete_Proposal_images')->name('tool.delete_Proposal_images');
        Route::post('/admin/delete-Proposal-image', 'AdminAjaxController@delete_Proposal_image')->name('tool.delete_Proposal_image');

        Route::post('/admin/delete_attribute', 'AdminAjaxController@delete_attribute')->name('product.delete_attribute');
        Route::post('/admin/delete_attributes', 'AdminAjaxController@delete_attributes')->name('product.delete_attributes');
        Route::post('/admin/delete_attributes_val', 'AdminAjaxController@delete_attributes_val')->name('product.delete_attributes_val');
        Route::post('/admin/delete_post_category', 'AdminAjaxController@delete_post_category')->name('post.delete_post_category');
        Route::post('/admin/delete_posts_Categories', 'AdminAjaxController@delete_posts_Categories')->name('post.delete_posts_Categories');
        Route::post('/admin/delete_product_Category', 'AdminAjaxController@delete_product_Category')->name('post.delete_product_Category');
        Route::post('/admin/delete_products_Categories', 'AdminAjaxController@delete_products_Categories')->name('post.delete_products_Categories');
        Route::post('/admin/delete_product', 'AdminAjaxController@delete_product')->name('post.delete_product');
        Route::post('/admin/delete_products', 'AdminAjaxController@delete_products')->name('post.delete_products');
        Route::post('/admin/admins/service-comment-ajax', 'AdminAjaxController@service_comment_ajax')->name('service-comment-ajax');
        Route::post('/admin/admins/service-comment-ajax-delete', 'AdminAjaxController@service_comment_ajax_delete')->name('service-comment-ajax-delete');
        Route::post('/admin/admins/product-comment-ajax', 'AdminAjaxController@product_comment_ajax')->name('product-comment-ajax');
        Route::post('/admin/admins/product-comment-ajax-delete', 'AdminAjaxController@product_comment_ajax_delete')->name('product-comment-ajax-delete');
        Route::post('/admin/admins/change_price_monys_user', 'AdminAjaxController@change_price_monys_user')->name('change_price_monys_user');
        Route::post('/admin/complain/details', 'AdminAjaxController@complain_details')->name('complain.complain-details');
        Route::post('/admin/complain/details/save', 'AdminAjaxController@complain_save_details')->name('complain.complain-save-details');
        Route::post('/admin/product/comment-product-details', 'AdminAjaxController@comment_product_details')->name('product.comment-product-details');
        Route::post('/admin/product-details-details/save', 'AdminAjaxController@product_save_details')->name('product.comment-product-details-details');
        Route::post('/admin/post/comment-post-details', 'AdminAjaxController@comment_post_details')->name('post.comment-post-details');
        Route::post('/admin/post-details-details/save', 'AdminAjaxController@post_save_details')->name('post.comment-post-details-details');
        Route::post('/admin/post/delete-comments-post', 'AdminAjaxController@delete_comments_post')->name('comment.delete-comments-post');
        Route::post('/admin/delete-comment-post', 'AdminAjaxController@delete_comment_post')->name('comment.delete-comment-post');
        Route::post('/admin/product/delete-comments-product', 'AdminAjaxController@delete_comments_product')->name('comment.delete-comments-product');
        Route::post('/admin/delete-comment-product', 'AdminAjaxController@delete_comment_product')->name('comment.delete-comment-product');
        Route::post('/admin/delete_complain', 'AdminAjaxController@delete_complain')->name('complain.delete_complain');
        Route::post('/admin/delete_complains', 'AdminAjaxController@delete_complains')->name('complain.delete_complains');

        Route::post('/admin/delete_contact', 'AdminAjaxController@delete_contact')->name('contact.delete_contact');
        Route::post('/admin/delete_contacts', 'AdminAjaxController@delete_contacts')->name('contact.delete_contacts');

        Route::post('/admin/RequestQuantity', 'AdminAjaxController@RequestQuantity')->name('RequestQuantity.delete_RequestQuantity');
        Route::post('/admin/RequestQuantities', 'AdminAjaxController@RequestQuantities')->name('RequestQuantity.delete_RequestQuantities');

        Route::post('/admin/delete_clubs', 'AdminAjaxController@delete_clubs')->name('club.delete_clubs');
        Route::post('/admin/delete_club', 'AdminAjaxController@delete_club')->name('club.delete_club');

        Route::post('/admin/delete_discountcodes', 'AdminAjaxController@delete_discountcodes')->name('code.delete_discountcodes');
        Route::post('/admin/delete_discountcode', 'AdminAjaxController@delete_discountcode')->name('code.delete_discountcode');

        Route::post('/admin/user/delete_user', 'AdminAjaxController@delete_user')->name('user.delete_user');
        Route::post('/admin/user/delete_users', 'AdminAjaxController@delete_users')->name('user.delete_users');
        Route::post('/admin/user/send_users', 'AdminAjaxController@send_users_sms')->name('user.send_users_sms');

        Route::post('/admin/special/delete_special', 'AdminAjaxController@delete_special')->name('special.delete_special');

        Route::post('/admin/news/delete_news', 'AdminAjaxController@delete_news')->name('news.delete_news');
        Route::post('/admin/news/change_status_news', 'AdminAjaxController@change_status_news')->name('news.change_status_news');

        Route::post('/admin/slider/delete_image_slider', 'AdminAjaxController@delete_image_slider')->name('slider.delete_image_slider');
        Route::post('/admin/slider/set_link_slider', 'AdminAjaxController@set_link_slider')->name('slider.set_link_slider');
        Route::post('/admin/slider/set_Text_slider', 'AdminAjaxController@set_Text_slider')->name('slider.set_Text_slider');
        Route::post('/admin/slider/set_Title_slider', 'AdminAjaxController@set_Title_slider')->name('slider.set_Title_slider');
        Route::post('/admin/slider/set_position_slider', 'AdminAjaxController@set_position_slider')->name('slider.set_position_slider');
        Route::post('/admin/slider/set_alt_slider', 'AdminAjaxController@set_alt_slider')->name('slider.set_alt_slider');
        Route::post('/admin/slider/set_status_slider', 'AdminAjaxController@set_status_slider')->name('slider.set_status_slider');

        Route::post('/admin/orders/set_send_status', 'AdminAjaxController@set_send_status')->name('orders.set_send_status');
        Route::post('/admin/orders/set_day_status', 'AdminAjaxController@set_day_status')->name('orders.set_day_status');

        Route::post('/admin/slider/delete_image_banner', 'AdminAjaxController@delete_image_banner')->name('banner.delete_image_banner');
        Route::post('/admin/slider/set_link_banner', 'AdminAjaxController@set_link_banner')->name('banner.set_link_banner');
        Route::post('/admin/slider/set_Title_banner', 'AdminAjaxController@set_Title_banner')->name('banner.set_Title_banner');
        Route::post('/admin/slider/set_Text_banner', 'AdminAjaxController@set_Text_banner')->name('banner.set_Text_banner');
        Route::post('/admin/slider/set_alt_banner', 'AdminAjaxController@set_alt_banner')->name('banner.set_alt_banner');
        Route::post('/admin/slider/set_status_banner', 'AdminAjaxController@set_status_banner')->name('banner.set_status_banner');
        Route::post('/admin/slider/set_position_banner', 'AdminAjaxController@set_position_banner')->name('banner.set_position_banner');

        Route::post('/admin/brand/delete_image_brand', 'AdminAjaxController@delete_image_brand')->name('brand.delete_image_brand');
        Route::post('/admin/brand/set_link_brand', 'AdminAjaxController@set_link_brand')->name('brand.set_link_brand');
        Route::post('/admin/brand/set_title_brand', 'AdminAjaxController@set_title_brand')->name('brand.set_title_brand');
        Route::post('/admin/brand/set_alt_brand', 'AdminAjaxController@set_alt_brand')->name('brand.set_alt_brand');
        Route::post('/admin/brand/set_status_brand', 'AdminAjaxController@set_status_brand')->name('brand.set_status_brand');

        /***************** ajax B *****************/


//    Route::get('admin/dashboard', 'Admin\AdminDashboardUserController@index')->name('dashboard.index');


    /********** Run php artisan in Host **********/
    Route::get('/rs/{namecontroller}', 'phpArtisan@rs'); // ساخت کنترلر ریسورس در مسیر اصلی
// example : http://site-url.com/rs/name

    Route::get('/rsp/{namecontroller}/{path}', 'phpArtisan@rsp'); // ساخت کنترلر ریسورس در پوشه دلخواه
// example : http://site-url.com/rsp/name/path

    Route::get('/ctrl/{namecontroller}', 'phpArtisan@ctrl'); // ساخت کنترلر در مسیر اصلی
// example : http://site-url.com/ctrl/name

    Route::get('/rq/{namecontroller}', 'phpArtisan@rq'); // ساخت رکوئست در مسیر اصلی
// example : http://site-url.com/rq/name

    Route::get('/ctrlp/{namecontroller}/{path}', 'phpArtisan@ctrlp'); // ساخت کنترلر در پوشه دلخواه
// example : http://site-url.com/ctrlp/name/path

    Route::get('/mdl/{namecontroller}', 'phpArtisan@mdl'); //ساخت مدل
// example : http://site-url.com/mdl/name

    Route::get('/mg/{namecontroller}', 'phpArtisan@mg'); // ساخت مایگریشن
// example : http://site-url.com/mg/name

    Route::get('/runmg', 'phpArtisan@runmg'); // اجرای مایگریشن
// example : http://site-url.com/runmg
    /********** Run php artisan in Host **********/


});

Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('verifire', 'User\UserRegisterController@verifire')->name('verifire');
Route::post('verifire_code', 'User\UserRegisterController@verifire_code')->name('verifire_code');
Route::post('password/reset', 'User\UserRegisterController@verifire_password')->name('verifire_password');
Route::get('/password/verify', 'User\UserRegisterController@verifire_code_password')->name('verifire_code_password');
Route::get('password/pass', 'User\UserRegisterController@verifire_code_password_code')->name('verifire_code_password_code');
Route::post('password/pass', 'User\UserRegisterController@verifire_code_password_code')->name('verifire_code_password_code');
Route::post('reset_password', 'User\UserRegisterController@reset_password')->name('reset_password');






//------------------------------Ajax----------------------------
Route::post('/Again_code','AjaxController@Again_code')->name('Again_code');



Route::post('order-verify', 'OrderController@verify');
Route::get('payment-verify', 'PaymentController@verify')->name('payment.verify');








/*Route::get('/admin/j', function () {
    $users=App\Tree::all();
    return view('j',compact(['users']));
});*/



/***************** Shopping Cart  ******************/
Route::post('/addcart', 'ShoppingCartController@addcart');
Route::post('/removecart', 'ShoppingCartController@removecart');
Route::post('/updatecart', 'ShoppingCartController@updatecart');
//Route::get('/cart', 'ShoppingCartController@cart');
/***************** Shopping Cart  ******************/

Route::prefix('api')->group(function (){
    Route::get('/products/{slug}', 'Front\FrontController@apiGetProducts');
    Route::get('/doSearch/{slug}', 'Front\FrontController@search');
    Route::get('/filter-product/{slug}/{sort}/{paginate}/{attributes}', 'Front\FrontController@apiGetFilterProduct');
});

Route::group(['middleware' => 'admin'], function () {
    /***************** PanelFrontController  ******************/
    Route::get('/profile', 'Front\PanelController@index');
    Route::post('/comment_product_store', 'Front\FrontController@comment_product')->name('comment_product_store');
    Route::get('/profile/messages', 'Front\PanelController@messages');
    Route::get('/profile/comments', 'Front\PanelController@comments');
    Route::post('/profile/comments/removeComments', 'Front\FrontAjaxsController@remove_Comments')->name('comments.removeComments');
    Route::get('/profile/address', 'Front\PanelController@address');
    Route::post('/profile/saveaddresse', 'Front\PanelController@saveaddresse');
    Route::post('/profile/get_info_address', 'Front\FrontAjaxsController@get_info_address')->name('address.get_info_address');
    Route::post('/profile/selectDefaultAddress', 'Front\FrontAjaxsController@selectDefault_Address')->name('address.selectDefaultAddress');
    Route::post('/profile/removeAddress', 'Front\FrontAjaxsController@remove_Address')->name('address.removeAddress');
    Route::get('/profile/invitefriends', 'Front\PanelController@invitefriends');
    Route::get('/profile/bankcard', 'Front\PanelController@bankcard');
    Route::post('/profile/store-bankcard', 'Front\PanelController@bankcard_store');
    Route::get('/profile/complain', 'Front\PanelController@complain');
    Route::post('/profile/Store-complain', 'Front\PanelController@complain_store');
    Route::get('/profile/orders', 'Front\PanelController@orders');
    Route::get('/profile/orders/{id}', 'Front\PanelController@orders_show');
    Route::get('/profile/orders/{id}/invoice', 'Front\PanelController@orders_show_invoice');
    Route::get('/profile/favorites', 'Front\PanelController@favorites');
    Route::get('/profile/profile', 'Front\PanelController@profile');
    Route::post('/profile/edit_profile', 'Front\PanelController@edit_profile')->name('profile.edit_profile');
});
/***************** PanelFrontController  ******************/


Route::resource('MobileVerifiedt', 'Auth\MobileVerifiedtController');
Route::resource('register-new-user-set-email', 'Auth\SetEmailController');
Route::post('/verify_phone_number', 'Auth\MobileVerifiedtController@verify_phone_number')->name('MobileVerifiedt.verify_phone_number');
Route::get('/verify-phone-number', 'Front\FrontController@verify_phone_number')->name('verify-phone-number');
Route::get('/register-new-user', 'Front\FrontController@register_user_setEmail');
//Route::get('/privacy',\App\Http\Controllers\Front\FrontController::class);
/*======================Front=======================*/


/*======================FrontAjax=======================*/
Route::post('verify_phone_number_code', 'Front\FrontAjaxsController@verify_phone_number_code')->name('MobileVerifiedt.verify_phone_number_code');



