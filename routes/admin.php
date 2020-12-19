<?php

use Illuminate\Support\Facades\Route;

define('PAGINATION_COUNT',6);

// Route::group(['middleware'=>'auth:admin','namespace'=>'Admin'],function(){
//     Route::get('/', 'DashboardController@index')->name('admin.dashboard.view');
// });

// Route::group(['namespace'=>'Admin'],function(){
//     //login,logout,reg
//     Route::group(['middleware'=>'re_admin'],function(){
//         Route::get('login','LoginController@getLoginAdmin')->name('admin.get-login');
//         Route::post('login','LoginController@postLoginAdmin')->name('admin.post-login');
//     });
    
//     Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');
// });
// Route::group(['namespace'=>'Admin'],function(){
// ############################Admins######################################
//     Route::group(['prefix'=>'admins'],function(){
//     Route::get('/view', 'AdminsController@index')->name('admin.admins.view');
//     Route::post('/store-admin-for-default-lang', 'AdminsController@storeAdminForDefaultLang')->name('admin.admin.store_admin_for_default_lang');
//     Route::post('/store-admin-for-any-lang', 'AdminsController@storeAdminForAnyLang')->name('admin.admin.store_admin_for_any_lang');
//     Route::post('/update-admin-for-default-lang/{id}', 'AdminsController@updateAdminForDefaultLang')->name('admin.admin.update_admin_for_default_lang');
//     Route::post('/update-admin-for-any-lang/{id}', 'AdminsController@updateAdminForAnyLang')->name('admin.admin.update_admin_for_any_lang');
//     Route::post('/update/{adminId}', 'AdminsController@update')->name('admin.admin.update')->where(['adminId'=> '[0-9]+']);
//     Route::post('/delete/{adminId}', 'AdminsController@destroy')->name('admin.admin.delete')->where(['adminId'=> '[0-9]+']);
//     Route::get('/show/{adminId}', 'AdminsController@show')->name('admin.admin.show')->where(['adminId'=> '[0-9]+']);
// });
// ############################Carts######################################
// Route::group(['prefix'=>'carts'],function(){
//     Route::get('/view', 'CartsController@index')->name('admin.carts.view');
//     Route::post('/store', 'CartsController@store')->name('admin.cart.store');
//     Route::post('/update/{cartId}', 'CartsController@update')->name('admin.cart.update')->where(['cartId'=> '[0-9]+']);
//     Route::post('/delete/{cartId}', 'CartsController@delete')->name('admin.cart.delete')->where(['cartId'=> '[0-9]+']);
//     Route::get('/show/{cartId}', 'CartsController@show')->name('admin.cart.show')->where(['cartId'=> '[0-9]+']);
// });


// ############################Categories######################################
// Route::group(['prefix'=>'categories'],function(){
//     //get
//     Route::get('/all-categories', 'CategoriesController@allCategories')->name('admin.allCategories.get_all_categories');
//     Route::get('/main-categories', 'CategoriesController@mainCategories')->name('admin.mainCategories.get_main_categories');
//     Route::get('/main-all-categories', 'CategoriesController@getAllMainCategories')->name('admin.mainCategories.get_all_main_categories');
//     Route::get('/sub-categories', 'CategoriesController@subCategories')->name('admin.subCategories.view');
//     Route::get('/get-for-create-main-category', 'CategoriesController@getForCreateMainCategories')->name('admin.get_for_create_main_category.view');
//     Route::get('/get-for-create-sub-category', 'CategoriesController@getForCreateSubCategories')->name('admin.get_for_create_sub_category.view');
//     Route::get('/show/{categoryId}', 'CategoriesController@show')->name('admin.categorie.show')->where(['categoryId'=> '[0-9]+']);

//     //store
//     Route::post('/store-default-main-category', 'CategoriesController@storeMainCategoryForDefaultLang')->name('admin.categorie.store_default_main_category');
//     Route::post('/store-any-main-category', 'CategoriesController@storeMainCategoryForAnyLang')->name('admin.categorie.store_any_main_category');
//     Route::post('/store-default-sub-category', 'CategoriesController@storeSubCategoryForDefaultLang')->name('admin.categorie.store_default_sub_category');
//     Route::post('/store-any-sub-category', 'CategoriesController@storeSubCategoryForAnyLang')->name('admin.categorie.store_any_sub_category');
//     //update
//     Route::post('/update-default-main-category/{categoryId}', 'CategoriesController@updateMainCategoryForDefaultLang')->name('admin.categorie.update_main_category_for_default_lang')->where(['categoryId'=> '[0-9]+']);
//     Route::post('/update-any-main-category/{categoryId}', 'CategoriesController@updateMainCategoryForAnyLang')->name('admin.categorie.update_main_category_for_any_lang')->where(['categoryId'=> '[0-9]+']);
//     Route::post('/update-default-sub-category/{categoryId}', 'CategoriesController@updateSubCategoryForDefaultLang')->name('admin.categorie.update_sub_category_for_default_lang')->where(['categoryId'=> '[0-9]+']);
//     Route::post('/update-any-sub-category/{categoryId}', 'CategoriesController@updateSubCategoryForAnyLang')->name('admin.categorie.update_sub_category_for_any_lang')->where(['categoryId'=> '[0-9]+']);
//     //delete
//     Route::post('/delete/{categoryId}', 'CategoriesController@delete')->name('admin.categorie.delete');
// });
// ############################Coupons######################################
// Route::group(['prefix'=>'couponcodes'],function(){
//     Route::get('/view', 'CouponcodesController@index')->name('admin.coupons.view');
//     Route::post('/store', 'CouponcodesController@store')->name('admin.coupon.store');
//     Route::post('/update/{id}', 'CouponcodesController@update')->name('admin.coupon.update')->where(['id'=> '[0-9]+']);
//     Route::post('/delete/{couponId}', 'CouponcodesController@delete')->name('admin.coupon.delete')->where(['couponId'=> '[0-9]+']);
//     Route::get('/show/{couponId}', 'CouponcodesController@show')->name('admin.coupon.show')->where(['couponId'=> '[0-9]+']);
// });

// ############################Deliveries######################################
// Route::group(['prefix'=>'deliveries'],function(){
//     Route::get('/view', 'DeliveriesController@index')->name('admin.deliveries.view');
//     Route::post('/store', 'DeliveriesController@store')->name('admin.delivery.store');
//     Route::post('/update/{deliveryId}', 'DeliveriesController@update')->name('admin.delivery.update')->where(['deliveryId'=> '[0-9]+']);
//     Route::post('/delete/{deliveryId}', 'DeliveriesController@delete')->name('admin.delivery.delete')->where(['deliveryId'=> '[0-9]+']);
//     Route::get('/show/{deliveryId}', 'DeliveriesController@show')->name('admin.delivery.show')->where(['deliveryId'=> '[0-9]+']);
// });
// ############################favorites######################################
// Route::group(['prefix'=>'favorites'],function(){
//     Route::get('/view', 'FavoritesController@index')->name('admin.favorites.view');
//     Route::post('/store', 'FavoritesController@store')->name('admin.favorite.store');
//     Route::post('/update/{favoriteId}', 'FavoritesController@update')->name('admin.favorite.update')->where(['favoriteId'=> '[0-9]+']);
//     Route::post('/delete/{favoriteId}', 'FavoritesController@delete')->name('admin.favorite.delete')->where(['favoriteId'=> '[0-9]+']);
//     Route::get('/show/{favoriteId}', 'FavoritesController@show')->name('admin.favorite.show')->where(['favoriteId'=> '[0-9]+']);
// });
// ############################Newsletters######################################
// Route::group(['prefix'=>'newsletters'],function(){
//     Route::get('/view', 'NewsletterSubscribersController@index')->name('admin.newsletters.view');
//     Route::post('/store', 'NewsletterSubscribersController@store')->name('admin.newsletter.store');
//     Route::post('/update/{newsletterId}', 'NewsletterSubscribersController@update')->name('admin.newsletter.update')->where(['newsletterId'=> '[0-9]+']);
//     Route::post('/delete/{newsletterId}', 'NewsletterSubscribersController@delete')->name('admin.newsletter.delete')->where(['newsletterId'=> '[0-9]+']);
//     Route::get('/show/{newsletterId}', 'NewsletterSubscribersController@show')->name('admin.newsletter.show')->where(['newsletterId'=> '[0-9]+']);

// });
// ############################Orders######################################
// Route::group(['prefix'=>'orders'],function(){
//     Route::get('/view', 'OrdersController@index')->name('admin.orders.view');
//     Route::post('/store', 'OrdersController@store')->name('admin.order.store');
//     Route::post('/update/{orderId}', 'OrdersController@update')->name('admin.order.update')->where(['orderId'=> '[0-9]+']);
//     Route::post('/delete/{orderId}', 'OrdersController@delete')->name('admin.order.delete')->where(['orderId'=> '[0-9]+']);
//     Route::get('/show/{orderId}', 'OrdersController@show')->name('admin.order.show')->where(['orderId'=> '[0-9]+']);
// });
// ############################pincodes######################################
// Route::group(['prefix'=>'pincodes'],function(){
//     Route::get('/view', 'PincodesController@index')->name('admin.pincodes.view');
//     Route::get('/create', 'PincodesController@create')->name('admin.pincode.create');
//     Route::post('/store', 'PincodesController@store')->name('admin.pincode.store');
//     Route::post('/update/{pincodeId}', 'PincodesController@update')->name('admin.pincode.update')->where(['pincodeId'=> '[0-9]+']);
//     Route::post('/delete/{pincodeId}', 'PincodesController@delete')->name('admin.pincode.delete')->where(['pincodeId'=> '[0-9]+']);
//     Route::get('/show/{pincodeId}', 'PincodesController@show')->name('admin.pincode.show')->where(['pincodeId'=> '[0-9]+']);
// });
// ############################products######################################
// Route::group(['prefix'=>'products'],function(){
//     Route::get('/view', 'ProductsController@index')->name('admin.products.view');
//     Route::post('/store-product-for-default-lang', 'ProductsController@storeProductForDefaultLang')->name('admin.product.store_product_for_default_lang');
//     Route::post('/store-product-for-any-lang', 'ProductsController@storeProductForAnyLang')->name('admin.product.store_product_for_any_lang');
//     Route::post('/update-product-for-any-lang/{productId}', 'ProductsController@updateProductForAnyLang')->name('admin.product.update_product_for_any_lang')->where(['productId'=> '[0-9]+']);
//     Route::post('/update-product-for-default-lang/{productId}', 'ProductsController@updateProductForDefaultLang')->name('admin.product.update_product_for_default_lang')->where(['productId'=> '[0-9]+']);
//     Route::post('/delete/{productId}', 'ProductsController@delete')->name('admin.product.delete')->where(['productId'=> '[0-9]+']);
//     Route::get('/show-product/{productId}', 'ProductsController@showProduct')->name('admin.product.show_product')->where(['productId'=> '[0-9]+']);
//     Route::get('/show-products-category/{productId}', 'ProductsController@showProductsCategory')->name('admin.product.show_products_categories')->where(['productId'=> '[0-9]+']);
// });



// ############################users######################################
// Route::group(['prefix'=>'users'],function(){
//     Route::get('/view', 'UsersController@index')->name('admin.users.view');
//     Route::post('/store-user-for-default-lang', 'UsersController@storeUserForDefaultLang')->name('admin.user.store_user_for_default_lang');
//     Route::post('/store-user-for-any-lang', 'UsersController@storeUserForAnyLang')->name('admin.user.store_user_for_any_lang');
//     Route::post('/update-user-for-default-lang/{id}', 'UsersController@updateUserForDefaultLang')->name('admin.user.update_user_for_default_lang')->where(['id'=> '[0-9]+']);
//     Route::post('/update-user-for-any-lang/{id}', 'UsersController@updateUserForAnyLang')->name('admin.user.update_user_for_any_lang')->where(['id'=> '[0-9]+']);
//     Route::post('/delete/{userId}', 'UsersController@delete')->name('admin.user.delete')->where(['userId'=> '[0-9]+']);
//     Route::get('/show/{userId}', 'UsersController@show')->name('admin.user.show')->where(['userId'=> '[0-9]+']);
// });

//     ############################banners######################################
//     Route::group(['prefix'=>'banners'],function(){
//         Route::get('/view', 'BannersController@viewBanners')->name('admin.banners.view');
//         Route::post('/store-banner-for-default-lang', 'BannersController@storeBannerForDefaultLang')->name('admin.banner.store_banner_for_default_lang');
//         Route::post('/store-banner-for-any-lang', 'BannersController@storeBannerForAnyLang')->name('admin.banner.store_banner_for_any_lang');
//         Route::post('/update-banner-for-default-lang/{id}', 'BannersController@updateBannerForDefaultLang')->name('admin.banner.update_banner_for_default_lang')->where(['id'=> '[0-9]+']);
//         Route::post('/update-banner-for-any-lang/{id}', 'BannersController@updateBannerForAnyLang')->name('admin.banner.update_banner_for_any_lang')->where(['id'=> '[0-9]+']);
//         Route::post('/delete/{userId}', 'BannersController@deleteBanner')->name('admin.banner.delete_banner')->where(['userId'=> '[0-9]+']);
//         Route::get('/show/{userId}', 'BannersController@showBanner')->name('admin.banner.show')->where(['userId'=> '[0-9]+']);
//     });

//     ############################addvertisments######################################
//     Route::group(['prefix'=>'addvertisments'],function(){
//         Route::get('/view', 'AddvertismentsController@viewaddvertisments')->name('admin.addvertisments.view');
//         Route::post('/store-addvertisment-for-default-lang', 'AddvertismentsController@storeaddvertismentForDefaultLang')->name('admin.addvertisment.store_addvertisment_for_default_lang');
//         Route::post('/store-addvertisment-for-any-lang', 'AddvertismentsController@storeaddvertismentForAnyLang')->name('admin.addvertisment.store_addvertisment_for_any_lang');
//         Route::post('/update-addvertisment-for-default-lang/{id}', 'AddvertismentsController@updateaddvertismentForDefaultLang')->name('admin.addvertisment.update_addvertisment_for_default_lang')->where(['id'=> '[0-9]+']);
//         Route::post('/update-addvertisment-for-any-lang/{id}', 'AddvertismentsController@updateaddvertismentForAnyLang')->name('admin.addvertisment.update_addvertisment_for_any_lang')->where(['id'=> '[0-9]+']);
//         Route::post('/delete/{userId}', 'AddvertismentsController@deleteaddvertisment')->name('admin.addvertisment.delete_addvertisment')->where(['userId'=> '[0-9]+']);
//         Route::get('/show/{userId}', 'AddvertismentsController@showaddvertisment')->name('admin.addvertisment.show')->where(['userId'=> '[0-9]+']);
//     });

// });