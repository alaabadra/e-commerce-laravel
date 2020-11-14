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

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function(){
    Route::group(['prefix'=>'admins'],function(){
    Route::get('/view', 'AdminsController@index')->name('admin.admins.view');
    Route::get('/create', 'AdminsController@create')->name('admin.admin.create');
    Route::post('/store-admin-for-default-lang', 'AdminsController@storeAdminForDefaultLang')->name('admin.admin.store_admin_for_default_lang');
    Route::post('/store-admin-for-any-lang', 'AdminsController@storeAdminForAnyLang')->name('admin.admin.store_admin_for_any_lang');
    Route::post('/update-admin-for-default-lang/{id}', 'AdminsController@updateAdminForDefaultLang')->name('admin.admin.update_admin_for_default_lang');
    Route::post('/update-admin-for-any-lang/{id}', 'AdminsController@updateAdminForAnyLang')->name('admin.admin.update_admin_for_any_lang');
    Route::get('/edit/{adminId}', 'AdminsController@edit')->name('admin.admin.edit');
    Route::post('/update/{adminId}', 'AdminsController@update')->name('admin.admin.update');
    Route::post('/delete/{adminId}', 'AdminsController@destroy')->name('admin.admin.delete');
    Route::get('/show/{adminId}', 'AdminsController@show')->name('admin.admin.show');
});

Route::group(['prefix'=>'carts'],function(){
    Route::get('/view', 'CartsController@index')->name('admin.carts.view');
    Route::get('/create', 'CartsController@create')->name('admin.cart.create');
    Route::post('/store', 'CartsController@store')->name('admin.cart.store');
    Route::get('/edit/{cartId}', 'CartsController@edit')->name('admin.cart.edit');
    Route::post('/update/{cartId}', 'CartsController@update')->name('admin.cart.update');
    Route::post('/delete/{cartId}', 'CartsController@delete')->name('admin.cart.delete');
    Route::get('/show/{cartId}', 'CartsController@show')->name('admin.cart.show');
});


############################Categories######################################
Route::group(['prefix'=>'categories'],function(){
    //get
    Route::get('/all-categories', 'CategoriesController@allCategories')->name('admin.allCategories.get_all_categories');
    Route::get('/main-categories', 'CategoriesController@mainCategories')->name('admin.mainCategories.get_main_categories');
    Route::get('/main-all-categories', 'CategoriesController@getAllMainCategories')->name('admin.mainCategories.get_all_main_categories');
    Route::get('/sub-categories', 'CategoriesController@subCategories')->name('admin.subCategories.view');
    Route::get('/get-for-create-main-category', 'CategoriesController@getForCreateMainCategories')->name('admin.get_for_create_main_category.view');
    Route::get('/get-for-create-sub-category', 'CategoriesController@getForCreateSubCategories')->name('admin.get_for_create_sub_category.view');
    Route::get('/show/{categoryId}', 'CategoriesController@show')->name('admin.categorie.show');

    //store
    Route::post('/store-default-main-category', 'CategoriesController@storeMainCategoryForDefaultLang')->name('admin.categorie.store_default_main_category');
    Route::post('/store-any-main-category', 'CategoriesController@storeMainCategoryForAnyLang')->name('admin.categorie.store_any_main_category');
    Route::post('/store-default-sub-category', 'CategoriesController@storeSubCategoryForDefaultLang')->name('admin.categorie.store_default_sub_category');
    Route::post('/store-any-sub-category', 'CategoriesController@storeSubCategoryForAnyLang')->name('admin.categorie.store_any_sub_category');
    //update
    Route::post('/update-default-main-category/{categoryId}', 'CategoriesController@updateMainCategoryForDefaultLang')->name('admin.categorie.update_main_category_for_default_lang');
    Route::post('/update-any-main-category/{categoryId}', 'CategoriesController@updateMainCategoryForAnyLang')->name('admin.categorie.update_main_category_for_any_lang');
    Route::post('/update-default-sub-category/{categoryId}', 'CategoriesController@updateSubCategoryForDefaultLang')->name('admin.categorie.update_sub_category_for_default_lang');
    Route::post('/update-any-sub-category/{categoryId}', 'CategoriesController@updateSubCategoryForAnyLang')->name('admin.categorie.update_sub_category_for_any_lang');
    //delete
    Route::post('/delete/{categoryId}', 'CategoriesController@delete')->name('admin.categorie.delete');
});
############################Coupons######################################
Route::group(['prefix'=>'couponcodes'],function(){
    Route::get('/view', 'CouponcodesController@index')->name('admin.coupons.view');
    Route::post('/store', 'CouponcodesController@store')->name('admin.coupon.store');
    Route::post('/update/{id}', 'CouponcodesController@update')->name('admin.coupon.update');
    Route::post('/delete/{couponId}', 'CouponcodesController@delete')->name('admin.coupon.delete');
    Route::get('/show/{couponId}', 'CouponcodesController@show')->name('admin.coupon.show');
});

############################Deliveries######################################
Route::group(['prefix'=>'deliveries'],function(){
    Route::get('/view', 'DeliveriesController@index')->name('admin.deliveries.view');
    Route::get('/create', 'DeliveriesController@create')->name('admin.delivery.create');
    Route::post('/store', 'DeliveriesController@store')->name('admin.delivery.store');
    Route::get('/edit/{DeliveryId}', 'DeliveriesController@edit')->name('admin.delivery.edit');
    Route::post('/update/{DeliveryId}', 'DeliveriesController@update')->name('admin.delivery.update');
    Route::post('/delete/{DeliveryId}', 'DeliveriesController@delete')->name('admin.delivery.delete');
    Route::get('/show/{DeliveryId}', 'DeliveriesController@show')->name('admin.delivery.show');
});
############################favorites######################################
Route::group(['prefix'=>'favorites'],function(){
    Route::get('/view', 'FavoritesController@index')->name('admin.favorites.view');
    Route::get('/create', 'FavoritesController@create')->name('admin.favorite.create');
    Route::post('/store', 'FavoritesController@store')->name('admin.favorite.store');
    Route::get('/edit/{favoriteId}', 'FavoritesController@edit')->name('admin.favorite.edit');
    Route::post('/update/{favoriteId}', 'FavoritesController@update')->name('admin.favorite.update');
    Route::post('/delete/{favoriteId}', 'FavoritesController@delete')->name('admin.favorite.delete');
    Route::get('/show/{favoriteId}', 'FavoritesController@show')->name('admin.favorite.show');
});
############################Newsletters######################################
Route::group(['prefix'=>'newsletters'],function(){
    Route::get('/view', 'NewsletterSubscribersController@index')->name('admin.newsletters.view');
    Route::post('/store', 'NewsletterSubscribersController@store')->name('admin.newsletter.store');
    Route::post('/update/{newsletterId}', 'NewsletterSubscribersController@update')->name('admin.newsletter.update');
    Route::post('/delete/{newsletterId}', 'NewsletterSubscribersController@delete')->name('admin.newsletter.delete');
    Route::get('/show/{newsletterId}', 'NewsletterSubscribersController@show')->name('admin.newsletter.show');

});
############################Orders######################################
Route::group(['prefix'=>'orders'],function(){
    Route::get('/view', 'OrdersController@index')->name('admin.orders.view');
    Route::get('/create', 'OrdersController@create')->name('admin.order.create');
    Route::post('/store', 'OrdersController@store')->name('admin.order.store');
    Route::get('/edit/{orderId}', 'OrdersController@edit')->name('admin.order.edit');
    Route::post('/update/{orderId}', 'OrdersController@update')->name('admin.order.update');
    Route::post('/delete/{orderId}', 'OrdersController@delete')->name('admin.order.delete');
    Route::get('/show/{orderId}', 'OrdersController@show')->name('admin.order.show');
});
############################pincodes######################################
Route::group(['prefix'=>'pincodes'],function(){
    Route::get('/view', 'PincodesController@index')->name('admin.pincodes.view');
    Route::get('/create', 'PincodesController@create')->name('admin.pincode.create');
    Route::post('/store', 'PincodesController@store')->name('admin.pincode.store');
    Route::post('/update/{pincodeId}', 'PincodesController@update')->name('admin.pincode.update');
    Route::post('/delete/{pincodeId}', 'PincodesController@delete')->name('admin.pincode.delete');
    Route::get('/show/{pincodeId}', 'PincodesController@show')->name('admin.pincode.show');
});
############################products######################################
Route::group(['prefix'=>'products'],function(){
    Route::get('/view', 'ProductsController@index')->name('admin.products.view');
    Route::post('/store-product-for-default-lang', 'ProductsController@storeProductForDefaultLang')->name('admin.product.store_product_for_default_lang');
    Route::post('/store-product-for-any-lang', 'ProductsController@storeProductForAnyLang')->name('admin.product.store_product_for_any_lang');
    Route::post('/update-product-for-any-lang/{productId}', 'ProductsController@updateProductForAnyLang')->name('admin.product.update_product_for_any_lang');
    Route::post('/update-product-for-default-lang/{productId}', 'ProductsController@updateProductForDefaultLang')->name('admin.product.update_product_for_default_lang');
    Route::post('/delete/{productId}', 'ProductsController@delete')->name('admin.product.delete');
    Route::get('/show-product/{productId}', 'ProductsController@showProduct')->name('admin.product.show_product');
    Route::get('/show-products-category/{productId}', 'ProductsController@showProductsCategory')->name('admin.product.show_products_categories');
});
############################products-attributes######################################
Route::group(['prefix'=>'product-attributes'],function(){
    Route::get('/view', 'ProductAttributesController@index')->name('admin.product_attributes.view');
    Route::post('/store-product-attr-for-default-lang', 'ProductAttributesController@storeProductAttrForDefaultLang')->name('admin.product_attribute.store_product_attr_for_default_lang');
    Route::post('/store-product-attr-for-any-lang', 'ProductAttributesController@storeProductAttrForAnyLang')->name('admin.product_attribute.store_product_attr_for_any_lang');
    Route::post('/update-product-attr-for-default-lang/{id}', 'ProductAttributesController@updateProductAttrForDefaultLang')->name('admin.product_attribute.update_product_attr_for_default_lang');
    Route::post('/update-product-attr-for-any-lang/{id}', 'ProductAttributesController@updateProductAttrForAnyLang')->name('admin.product_attribute.update_product_attr_for_any_lang');
    Route::post('/delete/{productAttrId}', 'ProductAttributesController@delete')->name('admin.product_attribute.delete');
    Route::get('/show-product-attribute/{productAttrId}', 'ProductAttributesController@showProductAttribute')->name('admin.product_attribute.showProductAttribute');
    Route::get('/show-product-attributes/{productId}', 'ProductAttributesController@showProductAttributes')->name('admin.product_attribute.showProductAttributes');
    
});
    ############################languages######################################
    Route::group(['prefix'=>'languages'],function(){
        Route::get('/view', 'languagesController@index')->name('admin.languages.view');
        Route::get('/get-all-langs', 'languagesController@getAllLangs')->name('admin.language.get_all_langs');
        Route::get('/get-all-default-langs', 'languagesController@getAllDefaultLangs')->name('admin.language.get_all_langs');
        Route::post('/store', 'languagesController@store')->name('admin.language.store');
        Route::get('/dashboard/generate-default-lang', 'DashboardController@index')->name('admin.dashboard.generate_default_lang');
        
        Route::post('/update/{languageId}', 'languagesController@update')->name('admin.language.update');
        Route::post('/delete/{languageId}', 'languagesController@delete')->name('admin.language.delete');
        Route::get('/show/{languageId}', 'languagesController@show')->name('admin.language.show');
    });
############################similarProducts######################################
Route::group(['prefix'=>'similar-products'],function(){
    Route::get('/view', 'SimilarProductsController@index')->name('admin.similar_products.view');
    Route::post('/store-similar-product-for-default-lang/', 'SimilarProductsController@storeSimilarProductForDefaultLang')->name('admin.similar_product.store_similar_product_default_lang');
    Route::post('/store-similar-product-for-any-lang/', 'SimilarProductsController@storeSimilarProductForAnyLang')->name('admin.similar_product.store_similar_product_any_lang');
    Route::post('/update-similar-product-for-default-lang/{productId}', 'SimilarProductsController@updateSimilarProductForDefaultLang')->name('admin.similar_product.update_similar_product_default_lang');
    Route::post('/update-similar-product-for-any-lang/{productId}', 'SimilarProductsController@updateSimilarProductForAnyLang')->name('admin.similar_product.update_similar_product_any_lang');
    Route::post('/delete/{productId}', 'SimilarProductsController@delete')->name('admin.similar_product.delete');
    Route::get('/show-similar-product/{productId}', 'SimilarProductsController@showSimilarProduct')->name('admin.similar_product.show_similar_product');
    Route::get('/show-similar-products/{productId}', 'SimilarProductsController@showSimilarProducts')->name('admin.similar_product.show_similar_products');
});

############################users######################################
Route::group(['prefix'=>'users'],function(){
    Route::get('/view', 'UsersController@index')->name('admin.users.view');
    Route::post('/store-user-for-default-lang', 'UsersController@storeUserForDefaultLang')->name('admin.user.store_user_for_default_lang');
    Route::post('/store-user-for-any-lang', 'UsersController@storeUserForAnyLang')->name('admin.user.store_user_for_any_lang');
    Route::post('/update-user-for-default-lang/{id}', 'UsersController@updateUserForDefaultLang')->name('admin.user.update_user_for_default_lang');
    Route::post('/update-user-for-any-lang/{id}', 'UsersController@updateUserForAnyLang')->name('admin.user.update_user_for_any_lang');
    Route::post('/delete/{userId}', 'UsersController@delete')->name('admin.user.delete');
    Route::get('/show/{userId}', 'UsersController@show')->name('admin.user.show');
});

    ############################banners######################################
    Route::group(['prefix'=>'banners'],function(){
        Route::get('/view', 'BannersController@viewBanners')->name('admin.banners.view');
        Route::post('/store-banner-for-default-lang', 'BannersController@storeBannerForDefaultLang')->name('admin.banner.store_banner_for_default_lang');
        Route::post('/store-banner-for-any-lang', 'BannersController@storeBannerForAnyLang')->name('admin.banner.store_banner_for_any_lang');
        Route::post('/update-banner-for-default-lang/{id}', 'BannersController@updateBannerForDefaultLang')->name('admin.banner.update_banner_for_default_lang');
        Route::post('/update-banner-for-any-lang/{id}', 'BannersController@updateBannerForAnyLang')->name('admin.banner.update_banner_for_any_lang');
        Route::post('/delete/{userId}', 'BannersController@deleteBanner')->name('admin.banner.delete_banner');
        Route::get('/show/{userId}', 'BannersController@showBanner')->name('admin.banner.show');
    });

    ############################addvertisments######################################
    Route::group(['prefix'=>'addvertisments'],function(){
        Route::get('/view', 'AddvertismentsController@viewaddvertisments')->name('admin.addvertisments.view');
        Route::post('/store-addvertisment-for-default-lang', 'AddvertismentsController@storeaddvertismentForDefaultLang')->name('admin.addvertisment.store_addvertisment_for_default_lang');
        Route::post('/store-addvertisment-for-any-lang', 'AddvertismentsController@storeaddvertismentForAnyLang')->name('admin.addvertisment.store_addvertisment_for_any_lang');
        Route::post('/update-addvertisment-for-default-lang/{id}', 'AddvertismentsController@updateaddvertismentForDefaultLang')->name('admin.addvertisment.update_addvertisment_for_default_lang');
        Route::post('/update-addvertisment-for-any-lang/{id}', 'AddvertismentsController@updateaddvertismentForAnyLang')->name('admin.addvertisment.update_addvertisment_for_any_lang');
        Route::post('/delete/{userId}', 'AddvertismentsController@deleteaddvertisment')->name('admin.addvertisment.delete_addvertisment');
        Route::get('/show/{userId}', 'AddvertismentsController@showaddvertisment')->name('admin.addvertisment.show');
    });

Route::group(['middleware'=>'re_admin'],function(){
Route::get('login','LoginController@login')->name('admin.login');
Route::post('login','LoginController@loginPost');
});

Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');

});

################################USER Route ##############################################
 ############################Users######################################
 Route::group(['prefix'=>'user','namespace'=>'User'],function(){
    Route::group(['prefix'=>'users'],function(){
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

});

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

    Route::get('/show-category/{categoryId}', 'CategoriesController@showCategory')->name('user.categories.show_category');

    
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
   
   
    Route::get('/show-product/{productId}', 'ProductsController@showProduct')->name('user.product.show_product');
    Route::get('/show-products-category/{productId}', 'ProductsController@showProductsCategory')->name('user.product.show_products_categories');
});
############################products-attributes######################################
Route::group(['prefix'=>'product-attributes'],function(){
    Route::get('/get-product-attributes', 'ProductAttributesController@getProductAttributes')->name('user.product_attributes.get_product_attributes');

    Route::get('/show-product-attribut/{productAttrId}', 'ProductAttributesController@showProductAttribute')->name('user.product_attribute.showProductAttribute');
    Route::get('/show-product-attributes/{productId}', 'ProductAttributesController@showProductAttributes')->name('user.product_attribute.showProductAttributes');
    
});
    ############################languages######################################
    Route::group(['prefix'=>'languages'],function(){
       

    });
############################similarProducts######################################
Route::group(['prefix'=>'similar-products'],function(){
    
    Route::get('/show-similar-product/{productId}', 'SimilarProductsController@showSimilarProduct')->name('user.similar_product.show_similar_product');
    Route::get('/show-similar-products/{productId}', 'SimilarProductsController@showSimilarProducts')->name('user.similar_product.show_similar_products');
});

 });

