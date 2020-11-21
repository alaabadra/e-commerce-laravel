<?php

use Illuminate\Support\Facades\Route;



// Route::group(['namespace'=>'User'],function(){
//     //login,logout,reg
//     Route::group(['middleware'=>'re_user'],function(){
//         Route::get('login','LoginController@getLogin')->name('user.login');
//         Route::post('login','LoginController@loginPost')->name('user.post-login');
//         Route::get('reg','LoginController@reg')->name('user.reg');
//         Route::post('reg','LoginController@regPost')->name('user.post-reg');
//     });
//     Route::get('/logout', 'LoginController@logout')->name('user.logout');
//         Route::get('/', 'HomeController@index')->name('user.home');
//         ############################User######################################
//         Route::get('/view-my-profile', 'UserController@viewMyProfile')->name('user.user.view_my_profile');
//         Route::get('/edit-my-profile', 'UserController@editMyProfile')->name('user.user.edit_my_profile');
//         Route::get('/update-my-password', 'UserController@updateMyPassword')->name('user.user.update_my_password');
//         Route::get('/change-my-image', 'UserController@changeMyImage')->name('user.user.change_my_image');
//         Route::get('/checkout-shipping', 'UserController@checkoutShipping')->name('user.user.checkout_shipping');
//         Route::get('/checkout-billing', 'UserController@checkoutBilling')->name('user.user.checkout_billing');
//         Route::get('/get-my-cart', 'UserController@getMyCart')->name('user.user.get_my_cart');
//         Route::get('/add-to-my-cart', 'UserController@addToMyCart')->name('user.user.add_to_my_cart');
//         Route::get('/delete-product-from-my-cart', 'UserController@deleteProductFromMyCart')->name('user.user.delete_product_from_my_cart');
//         Route::get('/add-product-into-my-favorite', 'UserController@addProductIntoMyFavorite')->name('user.user.add_product_into_my_favorite');
//         Route::get('/delete-prod-from-my-favourites', 'UserController@deleteProdFromMyFavourites')->name('user.user.delete_prod_from_my_favourites');
//         Route::get('/get-my-favorits', 'UserController@getMyFavorits')->name('user.user.get_my_favorits');
//         Route::get('/get-my-reviews-on-products', 'UserController@getMyReviewsOnProducts')->name('user.user.get_my_reviews_on_products');
//         Route::post('/add-my-review', 'UserController@addMyReview')->name('user.user.add_my_review');
//         Route::post('/edit-my-review', 'UserController@editMyReview')->name('user.user.edit_my_review');
//         Route::post('/delete-my-review', 'UserController@deleteMyReview')->name('user.user.delete_my_review');
//         Route::post('/get-my-orders', 'UserController@getMyOrders')->name('user.user.get_my_orders');
//         Route::post('/add-to-my-orders', 'UserController@addToMyOrders')->name('user.user.add_to_my_orders');
//         Route::post('/edit-to-my-orders', 'UserController@editToMyOrders')->name('user.user.edit_to_my_orders');
//         Route::post('/view-all-my-orders-review', 'UserController@viewAllMyOrdersReview')->name('user.user.view_all_my_orders_review');
//         Route::post('/order-review-details', 'UserController@orderReviewDetails')->name('user.user.order_review_details');
//         Route::post('/delete-order', 'UserController@deleteOrder')->name('user.user.delete_order');
        
//         ############################home######################################
//         Route::get('/view-latest-products', 'HomeController@viewLatestProducts')->name('user.home.view_latest_products');
//         Route::get('/view-latest-categories', 'HomeController@viewLatestCategories')->name('user.home.view_latest_categories');
//         Route::get('/view-feature-products', 'HomeController@viewFeatureProducts')->name('user.home.view_feature_products');
//         Route::get('/view-popular-products', 'HomeController@viewPopularProducts')->name('user.home.view_popular_products');
        
        
//         ############################Carts######################################
//         Route::group(['prefix'=>'carts','namespace'=>'User'],function(){
            
//         });
//         ############################Categories######################################
//         Route::group(['prefix'=>'categories','namespace'=>'User'],function(){
//             //get
//             Route::get('/all-categories', 'CategoriesController@allCategories')->name('user.allCategories.get_all_categories');
//             Route::get('/get-main-categories', 'CategoriesController@getMainCategories')->name('user.categories.get_main_categories');
//             Route::get('/get-sub-categories', 'CategoriesController@getSubCategories')->name('user.categories.get_sub_categories');
//             Route::get('/get-sub-categories-for-main-category', 'CategoriesController@getSubCategoriesForMainCategory')->name('user.categories.get_sub_categories_for_main_category');
            
//             Route::get('/show-category/{categoryId}', 'CategoriesController@showCategory')->name('user.categories.show_category');
    
//         });
//         ############################Coupons######################################
//         Route::group(['prefix'=>'coupons','namespace'=>'User'],function(){
            
//         });

//         ############################Deliveries######################################
//         Route::group(['prefix'=>'deliveries','namespace'=>'User'],function(){
            
//         });
//         ############################favorites######################################
//         Route::group(['prefix'=>'favorites','namespace'=>'User'],function(){
            
//         });
//         ############################Newsletters######################################
//         Route::group(['prefix'=>'newsletters','namespace'=>'User'],function(){
            
//         });
//         ############################Orders######################################
//         Route::group(['prefix'=>'orders','namespace'=>'User'],function(){
            
//         });
//         ############################pincodes######################################
//         Route::group(['prefix'=>'pincodes','namespace'=>'User'],function(){
            
//         });
//         ############################products######################################
//         Route::group(['prefix'=>'products','namespace'=>'User'],function(){
//             Route::get('/get-all-products', 'ProductsController@getAllProducts')->name('user.products.get_all_products');
//             Route::get('/get-product-for-sub-categories', 'ProductsController@getProductForSubCategories')->name('user.products.get_product_for_sub_categories');
            
            
//             Route::get('/show-product/{productId}', 'ProductsController@showProduct')->name('user.product.show_product');
//             Route::get('/show-products-category/{productId}', 'ProductsController@showProductsCategory')->name('user.product.show_products_categories');
//         });

    


