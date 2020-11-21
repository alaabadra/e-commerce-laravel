<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
##################################ADMIN Routes ###################################################

// Route::group(['prefix'=>'admin','namespace'=>'Admin','middleware'=>'CheckAuthAdmin:admin'],function(){
    Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::group(['prefix'=>'admins'],function(){
    Route::get('/view', 'AdminsController@index')->name('admin.admins.view');
    Route::post('/store', 'AdminsController@store')->name('admin.admin.store');
    Route::post('/update/{adminId}', 'AdminsController@update')->name('admin.admin.update')->where(['adminId'=> '[0-9]+']);
    Route::post('/delete/{adminId}', 'AdminsController@destroy')->name('admin.admin.delete')->where(['adminId'=> '[0-9]+']);
    Route::get('/show/{adminId}', 'AdminsController@show')->name('admin.admin.show')->where(['adminId'=> '[0-9]+']);
});

Route::group(['prefix'=>'carts'],function(){
    Route::get('/view', 'CartsController@index')->name('admin.carts.view');
    Route::post('/store', 'CartsController@store')->name('admin.cart.store');
    Route::post('/update/{cartId}', 'CartsController@update')->name('admin.cart.update')->where(['cartId'=> '[0-9]+']);
    Route::post('/delete/{cartId}', 'CartsController@delete')->name('admin.cart.delete')->where(['cartId'=> '[0-9]+']);
    Route::get('/show/{cartId}', 'CartsController@show')->name('admin.cart.show')->where(['cartId'=> '[0-9]+']);
});


############################Categories######################################
Route::group(['prefix'=>'categories'],function(){
    //get
    Route::get('/view', 'CategoriesController@allCategories')->name('admin.allCategories.get_all_categories');
    Route::get('/main-categories', 'CategoriesController@mainCategories')->name('admin.mainCategories.get_main_categories');
    Route::get('/main-all-categories', 'CategoriesController@getAllMainCategories')->name('admin.mainCategories.get_all_main_categories');
    Route::get('/sub-categories', 'CategoriesController@subCategories')->name('admin.subCategories.view');
    Route::get('/get-for-create-main-category', 'CategoriesController@getForCreateMainCategories')->name('admin.get_for_create_main_category.view');
    Route::get('/get-for-create-sub-category/{mainCategoryId}', 'CategoriesController@getForCreateSubCategories')->name('admin.get_for_create_sub_category.view');
    Route::get('/show/{categoryId}', 'CategoriesController@show')->name('admin.categorie.show')->where(['categoryId'=> '[0-9]+']);

    //store
    Route::post('/store-main-category', 'CategoriesController@storeMainCategory')->name('admin.categories.store_main_category');
    Route::post('/store-sub-category', 'CategoriesController@storeSubCategory')->name('admin.categories.store_sub_category');
    //update
    Route::post('/update-category/{categoryId}', 'CategoriesController@updateCategory')->name('admin.categories.update_category')->where(['categoryId'=> '[0-9]+']);
    //delete
    Route::post('/delete/{categoryId}', 'CategoriesController@delete')->name('admin.categorie.delete');
});
############################Coupons######################################
Route::group(['prefix'=>'couponcodes'],function(){
    Route::get('/view', 'CouponcodesController@index')->name('admin.coupons.view');
    Route::post('/store', 'CouponcodesController@store')->name('admin.coupon.store');
    Route::post('/update/{id}', 'CouponcodesController@update')->name('admin.coupon.update')->where(['id'=> '[0-9]+']);
    Route::post('/delete/{couponId}', 'CouponcodesController@delete')->name('admin.coupon.delete')->where(['couponId'=> '[0-9]+']);
    Route::get('/show/{couponId}', 'CouponcodesController@show')->name('admin.coupon.show')->where(['couponId'=> '[0-9]+']);
});

############################Deliveries######################################
Route::group(['prefix'=>'deliveries'],function(){
    Route::get('/all-deliveries', 'DeliveriesController@getAllDeliveries')->name('admin.users.all_deliveries');
    Route::get('/view', 'DeliveriesController@index')->name('admin.deliveries.view');
    Route::post('/store', 'DeliveriesController@store')->name('admin.delivery.store');
    Route::post('/update/{deliveryId}', 'DeliveriesController@update')->name('admin.delivery.update')->where(['deliveryId'=> '[0-9]+']);
    Route::post('/delete/{deliveryId}', 'DeliveriesController@delete')->name('admin.delivery.delete')->where(['deliveryId'=> '[0-9]+']);
    Route::get('/show/{deliveryId}', 'DeliveriesController@show')->name('admin.delivery.show')->where(['deliveryId'=> '[0-9]+']);
});
############################favorites######################################
Route::group(['prefix'=>'favorites'],function(){
    Route::get('/view', 'FavoritesController@index')->name('admin.favorites.view');
    Route::post('/store', 'FavoritesController@store')->name('admin.favorite.store');
    Route::post('/update/{favoriteId}', 'FavoritesController@update')->name('admin.favorite.update')->where(['favoriteId'=> '[0-9]+']);
    Route::post('/delete/{favoriteId}', 'FavoritesController@delete')->name('admin.favorite.delete')->where(['favoriteId'=> '[0-9]+']);
    Route::get('/show/{favoriteId}', 'FavoritesController@show')->name('admin.favorite.show')->where(['favoriteId'=> '[0-9]+']);
});
############################Newsletters######################################
Route::group(['prefix'=>'newsletters'],function(){
    Route::get('/view', 'NewsletterSubscribersController@index')->name('admin.newsletters.view');
    Route::post('/store', 'NewsletterSubscribersController@store')->name('admin.newsletter.store');
    Route::post('/update/{newsletterId}', 'NewsletterSubscribersController@update')->name('admin.newsletter.update')->where(['newsletterId'=> '[0-9]+']);
    Route::post('/delete/{newsletterId}', 'NewsletterSubscribersController@delete')->name('admin.newsletter.delete')->where(['newsletterId'=> '[0-9]+']);
    Route::get('/show/{newsletterId}', 'NewsletterSubscribersController@show')->name('admin.newsletter.show')->where(['newsletterId'=> '[0-9]+']);

});
############################Orders######################################
Route::group(['prefix'=>'orders'],function(){
    Route::get('/view', 'OrdersController@index')->name('admin.orders.view');
    Route::post('/store', 'OrdersController@store')->name('admin.order.store');
    Route::post('/update/{orderId}', 'OrdersController@update')->name('admin.order.update')->where(['orderId'=> '[0-9]+']);
    Route::post('/delete/{orderId}', 'OrdersController@delete')->name('admin.order.delete')->where(['orderId'=> '[0-9]+']);
    Route::get('/show/{orderId}', 'OrdersController@show')->name('admin.order.show')->where(['orderId'=> '[0-9]+']);
});
############################pincodes######################################
Route::group(['prefix'=>'pincodes'],function(){
    Route::get('/view', 'PincodesController@index')->name('admin.pincodes.view');
    Route::get('/create', 'PincodesController@create')->name('admin.pincode.create');
    Route::post('/store', 'PincodesController@store')->name('admin.pincode.store');
    Route::post('/update/{pincodeId}', 'PincodesController@update')->name('admin.pincode.update')->where(['pincodeId'=> '[0-9]+']);
    Route::post('/delete/{pincodeId}', 'PincodesController@delete')->name('admin.pincode.delete')->where(['pincodeId'=> '[0-9]+']);
    Route::get('/show/{pincodeId}', 'PincodesController@show')->name('admin.pincode.show')->where(['pincodeId'=> '[0-9]+']);
});
############################products######################################
Route::group(['prefix'=>'products'],function(){
    Route::get('/view', 'ProductsController@index')->name('admin.products.view');
    Route::post('/store', 'ProductsController@store')->name('admin.product.store');
    Route::post('/update/{productId}', 'ProductsController@update')->name('admin.product.update')->where(['productId'=> '[0-9]+']);
    Route::post('/delete/{productId}', 'ProductsController@delete')->name('admin.product.delete')->where(['productId'=> '[0-9]+']);
    Route::get('/show-product-data-by-code/{codeId}', 'ProductsController@showProductDataByCode')->name('admin.product.show_product')->where(['productId'=> '[0-9]+']);
    Route::get('/show/{productId}', 'ProductsController@showProduct')->name('admin.product.show_product')->where(['productId'=> '[0-9]+']);
    Route::get('/show-products-category/{productId}', 'ProductsController@showProductsCategory')->name('admin.product.show_products_categories')->where(['productId'=> '[0-9]+']);
    Route::get('/show-category-product/{productId}', 'ProductsController@showCategoryProduct')->name('admin.product.show_category_product')->where(['productId'=> '[0-9]+']);
});


############################users######################################
Route::group(['prefix'=>'users'],function(){
    Route::get('/all-users', 'UsersController@getAllUsers')->name('admin.users.all_users');
    Route::get('/view', 'UsersController@index')->name('admin.users.view');
    Route::post('/store', 'UsersController@store')->name('admin.user.store');
    Route::post('/update/{id}', 'UsersController@update')->name('admin.user.update')->where(['id'=> '[0-9]+']);
    Route::post('/delete/{userId}', 'UsersController@delete')->name('admin.user.delete')->where(['userId'=> '[0-9]+']);
    Route::get('/show/{userId}', 'UsersController@show')->name('admin.user.show')->where(['userId'=> '[0-9]+']);
});

    ############################banners######################################
    Route::group(['prefix'=>'banners'],function(){
        Route::get('/view', 'BannersController@viewBanners')->name('admin.banners.view');
        Route::post('/store', 'BannersController@store')->name('admin.banner.store');
        Route::post('/update/{id}', 'BannersController@update')->name('admin.banner.update')->where(['id'=> '[0-9]+']);
        Route::post('/delete/{id}', 'BannersController@deleteBanner')->name('admin.banner.delete_banner')->where(['id'=> '[0-9]+']);
        Route::get('/show/{id}', 'BannersController@showBanner')->name('admin.banner.show')->where(['id'=> '[0-9]+']);
    });

    ############################addvertisments######################################
    Route::group(['prefix'=>'addvertisments'],function(){
        Route::get('/view', 'AddvertismentsController@viewaddvertisments')->name('admin.addvertisments.view');
        Route::post('/store', 'AddvertismentsController@store')->name('admin.addvertisment.store');
        Route::post('/update/{id}', 'AddvertismentsController@update')->name('admin.addvertisment.update')->where(['id'=> '[0-9]+']);
        Route::post('/delete/{id}', 'AddvertismentsController@deleteaddvertisment')->name('admin.addvertisment.delete_addvertisment')->where(['id'=> '[0-9]+']);
        Route::get('/show/{id}', 'AddvertismentsController@showaddvertisment')->name('admin.addvertisment.show')->where(['id'=> '[0-9]+']);
    });

        ############################contractors######################################
        Route::group(['prefix'=>'contractors'],function(){
            Route::get('/view', 'ContractorsController@index')->name('admin.contractors.view');
            Route::post('/store', 'ContractorsController@store')->name('admin.contractor.store');
            Route::post('/update/{id}', 'ContractorsController@update')->name('admin.contractor.update')->where(['id'=> '[0-9]+']);
            Route::post('/delete/{id}', 'ContractorsController@destroy')->name('admin.contractor.delete_contractor')->where(['id'=> '[0-9]+']);
            Route::get('/show/{id}', 'ContractorsController@showcontractor')->name('admin.contractor.show')->where(['id'=> '[0-9]+']);
        });
    
    
    
        Route::get('login','LoginController@getLoginAdmin');
        Route::post('login','LoginController@loginA')->name('admin.post-login');
        
        Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');
        
});
################################USER Route ##############################################
 ############################Users######################################

 Route::group(['prefix'=>'user','namespace'=>'User'],function(){
        Route::get('login','LoginController@getLogin')->name('user.login');
        Route::post('login','LoginController@loginU')->name('user.post-login');
        Route::get('reg','LoginController@reg')->name('user.reg');
        Route::post('reg','LoginController@regPost')->name('user.post-reg');
        Route::post('/user/confirm/{code}','LoginController@confirmAccount')->name('user.confirm-account');
    
    Route::get('/logout', 'LoginController@logout')->name('user.logout');
    
############################Users######################################
Route::get('/view-my-profile', 'UserController@viewMyProfile')->name('user.user.view_my_profile');
Route::get('/edit-my-profile', 'UserController@editMyProfile')->name('user.user.edit_my_profile');
Route::get('/update-my-password', 'UserController@updateMyPassword')->name('user.user.update_my_password');
Route::get('/change-my-image', 'UserController@changeMyImage')->name('user.user.change_my_image');
Route::get('/checkout-shipping', 'UserController@checkoutShipping')->name('user.user.checkout_shipping');
Route::get('/checkout-billing', 'UserController@checkoutBilling')->name('user.user.checkout_billing');
Route::get('/get-my-cart', 'UserController@getMyCart')->name('user.user.get_my_cart');
Route::get('/add-to-my-cart', 'UserController@addToMyCart')->name('user.user.add_to_my_cart');
Route::get('/delete-product-from-my-cart', 'UserController@deleteProductFromMyCart')->name('user.user.delete_product_from_my_cart');
Route::get('/add-product-into-my-favorite', 'UserController@addProductIntoMyFavorite')->name('user.user.add_product_into_my_favorite');
Route::get('/delete-prod-from-my-favourites', 'UserController@deleteProdFromMyFavourites')->name('user.user.delete_prod_from_my_favourites');
Route::get('/get-my-favorits', 'UserController@getMyFavorits')->name('user.user.get_my_favorits');
Route::get('/get-my-reviews-on-products', 'UserController@getMyReviewsOnProducts')->name('user.user.get_my_reviews_on_products');
Route::post('/add-my-review', 'UserController@addMyReview')->name('user.user.add_my_review');
Route::post('/edit-my-review', 'UserController@editMyReview')->name('user.user.edit_my_review');
Route::post('/delete-my-review', 'UserController@deleteMyReview')->name('user.user.delete_my_review');
Route::post('/get-my-orders', 'UserController@getMyOrders')->name('user.user.get_my_orders');
Route::post('/add-to-my-orders', 'UserController@addToMyOrders')->name('user.user.add_to_my_orders');
Route::post('/edit-to-my-orders', 'UserController@editToMyOrders')->name('user.user.edit_to_my_orders');
Route::post('/view-all-my-orders-review', 'UserController@viewAllMyOrdersReview')->name('user.user.view_all_my_orders_review');
Route::post('/order-review-details', 'UserController@orderReviewDetails')->name('user.user.order_review_details');
Route::post('/delete-order', 'UserController@deleteOrder')->name('user.user.delete_order');

    Route::post('/search-products', 'HomeController@searchProducts')->name('user.home.search_products');
    Route::post('/search-categories', 'HomeController@searchCategories')->name('user.home.search_categories');
    Route::post('/search-users', 'HomeController@searchUsers')->name('user.home.search_users');
    Route::post('/search-admins', 'HomeController@searchAdmins')->name('user.home.search_admins');
    Route::get('/view-latest-products', 'HomeController@viewLatestProducts')->name('user.home.view_latest_products');
    Route::get('/view-latest-categories', 'HomeController@viewLatestCategories')->name('user.home.view_latest_categories');
    Route::get('/view-feature-products', 'HomeController@viewFeatureProducts')->name('user.home.view_feature_products');
    Route::get('/view-popular-products', 'HomeController@viewPopularProducts')->name('user.home.view_popular_products');

############################Carts######################################
Route::group(['prefix'=>'carts'],function(){

});
############################Categories######################################
Route::group(['prefix'=>'categories'],function(){
    //get
    Route::get('/all-categories', 'CategoriesController@allCategories')->name('user.allCategories.get_all_categories');
    Route::get('/get-main-categories', 'CategoriesController@getMainCategories')->name('user.categories.get_main_categories');
    Route::get('/get-sub-categories', 'CategoriesController@getSubCategories')->name('user.categories.get_sub_categories');
    Route::get('/get-sub-categories-for-main-category', 'CategoriesController@getSubCategoriesForMainCategory')->name('user.categories.get_sub_categories_for_main_category');

    Route::get('/show-category/{categoryId}', 'CategoriesController@showCategory')->name('user.categories.show_category')->where(['categoryId'=> '[0-9]+']);

    
});
############################Coupons######################################
Route::group(['prefix'=>'coupons'],function(){

});

############################Deliveries######################################
Route::group(['prefix'=>'deliveries'],function(){

});
############################favorites######################################
Route::group(['prefix'=>'favorites'],function(){

});
############################Newsletters######################################
Route::group(['prefix'=>'newsletters'],function(){

});
############################Orders######################################
Route::group(['prefix'=>'orders'],function(){

});
############################pincodes######################################
Route::group(['prefix'=>'pincodes'],function(){

});
############################products######################################
Route::group(['prefix'=>'products'],function(){
    Route::get('/get-all-products', 'ProductsController@getAllProducts')->name('user.products.get_all_products');
    Route::get('/get-product-for-sub-categories', 'ProductsController@getProductForSubCategories')->name('user.products.get_product_for_sub_categories');
   
   
    Route::get('/show-product/{productId}', 'ProductsController@showProduct')->name('user.product.show_product')->where(['productId'=> '[0-9]+']);
    Route::get('/show-products-category/{productId}', 'ProductsController@showProductsCategory')->name('user.product.show_products_categories')->where(['productId'=> '[0-9]+']);
});



});
