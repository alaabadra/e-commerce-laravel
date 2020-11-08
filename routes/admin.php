<?php

use Illuminate\Support\Facades\Route;

define('PAGINATION_COUNT',6);

Route::group(['middleware'=>'auth:admin','namespace'=>'Admin'],function(){
    Route::get('/', 'DashboardController@index')->name('admin.dashboard.view');
});
    ############################Admins######################################

    Route::group(['prefix'=>'admins','namespace'=>'Admin'],function(){
        Route::get('/view', 'AdminsController@index')->name('admin.admins.view');
        Route::get('/create', 'AdminsController@create')->name('admin.admin.create');
        Route::post('/store', 'AdminsController@store')->name('admin.admin.store');
        Route::get('/edit/{adminId}', 'AdminsController@edit')->name('admin.admin.edit');
        Route::post('/update/{adminId}', 'AdminsController@update')->name('admin.admin.update');
        Route::post('/delete/{adminId}', 'AdminsController@delete')->name('admin.admin.delete');
        Route::get('/show/{adminId}', 'AdminsController@show')->name('admin.admin.show');
    });
    ############################Carts######################################
    Route::group(['prefix'=>'carts','namespace'=>'Admin'],function(){
        Route::get('/view', 'CartsController@index')->name('admin.carts.view');
        Route::get('/create', 'CartsController@create')->name('admin.cart.create');
        Route::post('/store', 'CartsController@store')->name('admin.cart.store');
        Route::get('/edit/{cartId}', 'CartsController@edit')->name('admin.cart.edit');
        Route::post('/update/{cartId}', 'CartsController@update')->name('admin.cart.update');
        Route::post('/delete/{cartId}', 'CartsController@delete')->name('admin.cart.delete');
        Route::get('/show/{cartId}', 'CartsController@show')->name('admin.cart.show');
    });
    ############################Categories######################################
    Route::group(['prefix'=>'categories','namespace'=>'Admin'],function(){
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
        Route::post('/updateMainCategoryForDefaultLang/{categoryId}', 'CategoriesController@updateMainCategoryForDefaultLang')->name('admin.categorie.update_main_category_for_default_lang');
        Route::post('/updateMainCategoryForAnyLang/{categoryId}', 'CategoriesController@updateMainCategoryForAnyLang')->name('admin.categorie.update_main_category_for_any_lang');
        Route::post('/updateSubCategoryForDefaultLang/{categoryId}', 'CategoriesController@updateSubCategoryForDefaultLang')->name('admin.categorie.update_sub_category_for_default_lang');
        Route::post('/updateSubCategoryForAnyLang/{categoryId}', 'CategoriesController@updateSubCategoryForAnyLang')->name('admin.categorie.update_sub_category_for_any_lang');
        //delete
        Route::post('/delete/{categoryId}', 'CategoriesController@delete')->name('admin.categorie.delete');
    });
    ############################Coupons######################################
    Route::group(['prefix'=>'coupons','namespace'=>'Admin'],function(){
        Route::get('/view', 'CouponcodesController@index')->name('admin.coupons.view');
        Route::post('/store-couponcode-for-any-lang', 'CouponcodesController@storeCouponcodeForAnyLang')->name('admin.coupon.store_couponcode_for_any_lang');
        Route::post('/store-couponcode-for-default-lang', 'CouponcodesController@storeCouponcodeForDefaultLang')->name('admin.coupon.store_couponcode_for_default_lang');
        Route::post('/update-couponcode-for-default-lang', 'CouponcodesController@updateCouponcodeForDefaultLang')->name('admin.coupon.update_couponcode_for_default_lang');
        Route::post('/update-couponcode-for-any-lang', 'CouponcodesController@updateCouponcodeForAnyLang')->name('admin.coupon.update_couponcode_for_any_lang');
        Route::post('/delete/{couponId}', 'CouponcodesController@delete')->name('admin.coupon.delete');
        Route::get('/show/{couponId}', 'CouponcodesController@show')->name('admin.coupon.show');
    });

    ############################Deliveries######################################
    Route::group(['prefix'=>'deliveries','namespace'=>'Admin'],function(){
        Route::get('/view', 'DeliveriesController@index')->name('admin.deliveries.view');
        Route::get('/create', 'DeliveriesController@create')->name('admin.delivery.create');
        Route::post('/store', 'DeliveriesController@store')->name('admin.delivery.store');
        Route::get('/edit/{DeliveryId}', 'DeliveriesController@edit')->name('admin.delivery.edit');
        Route::post('/update/{DeliveryId}', 'DeliveriesController@update')->name('admin.delivery.update');
        Route::post('/delete/{DeliveryId}', 'DeliveriesController@delete')->name('admin.delivery.delete');
        Route::get('/show/{DeliveryId}', 'DeliveriesController@show')->name('admin.delivery.show');
    });
    ############################favorites######################################
    Route::group(['prefix'=>'favorites','namespace'=>'Admin'],function(){
        Route::get('/view', 'FavoritesController@index')->name('admin.favorites.view');
        Route::get('/create', 'FavoritesController@create')->name('admin.favorite.create');
        Route::post('/store', 'FavoritesController@store')->name('admin.favorite.store');
        Route::get('/edit/{favoriteId}', 'FavoritesController@edit')->name('admin.favorite.edit');
        Route::post('/update/{favoriteId}', 'FavoritesController@update')->name('admin.favorite.update');
        Route::post('/delete/{favoriteId}', 'FavoritesController@delete')->name('admin.favorite.delete');
        Route::get('/show/{favoriteId}', 'FavoritesController@show')->name('admin.favorite.show');
    });
    ############################Newsletters######################################
    Route::group(['prefix'=>'newsletters','namespace'=>'Admin'],function(){
        Route::get('/view', 'NewslettersController@index')->name('admin.newsletters.view');
        Route::get('/create', 'NewslettersController@create')->name('admin.newsletter.create');
        Route::post('/store', 'NewslettersController@store')->name('admin.newsletter.store');
        Route::get('/edit/{newsletterId}', 'NewslettersController@edit')->name('admin.newsletter.edit');
        Route::post('/update/{newsletterId}', 'NewslettersController@update')->name('admin.newsletter.update');
        Route::post('/delete/{newsletterId}', 'NewslettersController@delete')->name('admin.newsletter.delete');
        Route::get('/show/{newsletterId}', 'NewslettersController@show')->name('admin.newsletter.show');
    });
    ############################Orders######################################
    Route::group(['prefix'=>'orders','namespace'=>'Admin'],function(){
        Route::get('/view', 'OrdersController@index')->name('admin.orders.view');
        Route::get('/create', 'OrdersController@create')->name('admin.order.create');
        Route::post('/store', 'OrdersController@store')->name('admin.order.store');
        Route::get('/edit/{orderId}', 'OrdersController@edit')->name('admin.order.edit');
        Route::post('/update/{orderId}', 'OrdersController@update')->name('admin.order.update');
        Route::post('/delete/{orderId}', 'OrdersController@delete')->name('admin.order.delete');
        Route::get('/show/{orderId}', 'OrdersController@show')->name('admin.order.show');
    });
    ############################pincodes######################################
    Route::group(['prefix'=>'pincodes','namespace'=>'Admin'],function(){
        Route::get('/view', 'PincodesController@index')->name('admin.pincodes.view');
        Route::get('/create', 'PincodesController@create')->name('admin.pincode.create');
        Route::post('/store', 'PincodesController@store')->name('admin.pincode.store');
        Route::get('/edit/{pincodeId}', 'PincodesController@edit')->name('admin.pincode.edit');
        Route::post('/update/{pincodeId}', 'PincodesController@update')->name('admin.pincode.update');
        Route::post('/delete/{pincodeId}', 'PincodesController@delete')->name('admin.pincode.delete');
        Route::get('/show/{pincodeId}', 'PincodesController@show')->name('admin.pincode.show');
    });
    ############################products######################################
    Route::group(['prefix'=>'products','namespace'=>'Admin'],function(){
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
    Route::group(['prefix'=>'product-attributes','namespace'=>'Admin'],function(){
        Route::get('/view', 'ProductAttributesController@index')->name('admin.product_attributes.view');
        Route::get('/create', 'ProductAttributesController@create')->name('admin.product_attribute.create');
        Route::post('/store-product-attr-for-default-lang', 'ProductAttributesController@storeProductAttrForDefaultLang')->name('admin.product_attribute.store_product_attr_for_default_lang');
        Route::post('/store-product-attr-for-any-lang', 'ProductAttributesController@storeProductAttrForAnyLang')->name('admin.product_attribute.store_product_attr_for_any_lang');
        Route::post('/update-product-attr-for-default-lang', 'ProductAttributesController@updateProductAttrForDefaultLang')->name('admin.product_attribute.update_product_attr_for_default_lang');
        Route::post('/update-product-attr-for-any-lang', 'ProductAttributesController@updateProductAttrForAnyLang')->name('admin.product_attribute.update_product_attr_for_any_lang');
        Route::post('/delete/{productAttrId}', 'ProductAttributesController@delete')->name('admin.product_attribute.delete');
        Route::get('/show-product-attribut/{productAttrId}', 'ProductAttributesController@showProductAttribute')->name('admin.product_attribute.showProductAttribute');
        Route::get('/show-product-attributes/{productId}', 'ProductAttributesController@showProductAttributes')->name('admin.product_attribute.showProductAttributes');
        
    });
        ############################languages######################################
        Route::group(['prefix'=>'languages','namespace'=>'Admin'],function(){
            Route::get('/view', 'languagesController@index')->name('admin.languages.view');
            Route::get('/get-all-langs', 'languagesController@getAllLangs')->name('admin.language.get_all_langs');
            Route::get('/get-all-default-langs', 'languagesController@getAllDefaultLangs')->name('admin.language.get_all_langs');
            Route::post('/store', 'languagesController@store')->name('admin.language.store');
            Route::post('admin/languages/store_default_lang', 'DashboardController@storeDefaultLanguages')->name('admin.language.store_default_lang');
            
            Route::post('/update/{languageId}', 'languagesController@update')->name('admin.language.update');
            Route::post('/delete/{languageId}', 'languagesController@delete')->name('admin.language.delete');
            Route::get('/show/{languageId}', 'languagesController@show')->name('admin.language.show');
        });
    ############################similarProducts######################################
    Route::group(['prefix'=>'similar-products','namespace'=>'Admin'],function(){
        Route::get('/view', 'SimilarProductsController@index')->name('admin.similar_products.view');
        Route::post('/store', 'SimilarProductsController@store')->name('admin.similar_product.store');
        Route::post('/update/{productId}', 'SimilarProductsController@update')->name('admin.similar_product.update');
        Route::post('/delete/{productId}', 'SimilarProductsController@delete')->name('admin.similar_product.delete');
        Route::get('/show-similar-product/{productId}', 'SimilarProductsController@showSimilarProduct')->name('admin.similar_product.show_similar_product');
        Route::get('/show-similar-products/{productId}', 'SimilarProductsController@showSimilarProducts')->name('admin.similar_product.show_similar_products');
    });

    ############################users######################################
    Route::group(['prefix'=>'users','namespace'=>'Admin'],function(){
        Route::get('/view', 'UsersController@index')->name('admin.users.view');
        Route::post('/store', 'UsersController@store')->name('admin.user.store');
        Route::post('/update/{userId}', 'UsersController@update')->name('admin.user.update');
        Route::post('/delete/{userId}', 'UsersController@delete')->name('admin.user.delete');
        Route::get('/show/{userId}', 'UsersController@show')->name('admin.user.show');
    });

        ############################banners######################################
        Route::group(['prefix'=>'banners','namespace'=>'Admin'],function(){
            Route::get('/view', 'BannersController@viewBanners')->name('admin.banners.view');
            Route::post('/store-banner-for-default-lang', 'BannersController@storeBannerForDefaultLang')->name('admin.banner.store_banner_for_default_lang');
            Route::post('/store-banner-for-any-lang', 'BannersController@storeBannerForAnyLang')->name('admin.banner.store_banner_for_any_lang');
            Route::post('/update-banner-for-default-lang', 'BannersController@updateBannerForDefaultLang')->name('admin.banner.update_banner_for_default_lang');
            Route::post('/update-banner-for-any-lang', 'BannersController@updateBannerForAnyLang')->name('admin.banner.update_banner_for_any_lang');
            Route::post('/delete/{userId}', 'BannersController@deleteBanner')->name('admin.banner.delete_banner');
            Route::get('/show/{userId}', 'BannersController@showBanner')->name('admin.banner.show');
        });

    
Route::group(['middleware'=>'re_admin','namespace'=>'Admin'],function(){
    Route::get('login','LoginController@login')->name('admin.login');
    Route::post('login','LoginController@loginPost');
});

Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');