<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\ProductAttribute;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use JWTAuth;
class UserController extends Controller
{


    public function __construct()
    {
        $this->middleware('CheckAuthUser:api');
    }

    public function viewMyProfile(){
        try{
             dd(auth()->guard('api')->user()->token);

            // $dataThisUser=User::where(['id'=>$user_id])->first();
            // return response()->json([
            //     'status'=>200,
            //     'message'=>$dataThisUser
            // ]);

    }catch(\Exception $ex){
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }

    public function editMyProfile(Request $req){
        try{

            $data=$req->all();
            DB::beginTransaction();
            $dataThisUser=User::where(['id'=>3])->update(['name'=>$data['name'],'image'=>$data['image'],'email'=>$data['email']]);
            DB::commit(); 
            return response()->json([
                'status'=>200,
                'message'=>'updated data user successfully'
            ]);

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    public function updateMyPassword(Request $req){
        try{

            $dataThisUser=User::where(['id'=>2])->first();
            $data=$req->all();
            $oldPassDb=$dataThisUser->password;
            dd(decrypt($oldPassDb));
            $oldPassReq= bcrypt($data['old_password']);
            if($oldPassDb==$oldPassReq){
                $newPassReq=bcrypt($data['new_password']);
                DB::beginTransaction();
                User::where('id',2)->update(['password'=>$newPassReq]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated your password successfully'
                ]);
                
            }else{
                return response()->json([
                    'status'=>200,
                    'message'=>'pls, write correct your old pass'
                ]);
            }

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }

    public function changeMyImage(Request $req){
        try{

            DB::beginTransaction();
            $user=User::where(['id'=>3])->first();
            $filePath="";
            if($req->has('image')){
                $filePath=uploadImage('users',$req->photo);
                $user->image=$filePath;
                $user->save();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated your photo successfully'
                ]);
            }

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    public function checkoutShipping(Request $req){
        try{

            $data=$req->all();
            $deliveryThisUser=Delivery::where(['id'=>3])->count();
            if($deliveryThisUser>0){
                DB::beginTransaction();
                $delivery=Delivery::where(['id'=>3])->first();
                $delivery->email=$data['email_shipping'];
                $delivery->name=$data['name_shipping'];
                $delivery->pincode=$data['pincode_shipping'];
                $delivery->state=$data['state_shipping'];
                $delivery->address=$data['address_shipping'];
                $delivery->mobile=$data['mobile_shipping'];
                $delivery->country_name=$data['country_name'];
                $delivery->save();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'delivery updated successfully'.$delivery->name
                    ]);

            }else{
                DB::beginTransaction();
                $newDelivery= new Delivery();
                $newDelivery->user_id=$user_id;
                $newDelivery->email=$data['email_shipping'];
                $newDelivery->name=$data['name_shipping'];
                $newDelivery->pincode=$data['pincode_shipping'];
                $newDelivery->state=$data['state_shipping'];
                $newDelivery->address=$data['address_shipping'];
                $newDelivery->mobile=$data['mobile_shipping'];
                $newDelivery->country_name=$data['country_name'];
                $newDelivery->save();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'delivery added successfully'.$newDelivery->name
                ]);

            }

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }

    public function getMyCart(){   
        try{     

            $myCart= Cart::where(['id'=>3])->first();//get cart this user
            if(!empty($myCart)){
               $productsInMyCart= ProductAttribute::where(['cart_id'=>$myCart->id])->get();//get products that in this cart
               if(!empty($productsInMyCart)){
                 return response()->json([
                    'status'=>200,
                    'message'=>$productsInMyCart
                ]);  
               }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is not exist any item in cart this user'
                ]);
               } 
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'this user havent cart '
                ]);
            }
           

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 

      
    }

    public function getMyFavorits(){
        try{

            $myFavs= Favorite::where(['id'=>3])->paginate(10);
            if(!empty($myFavs)){
               return response()->json([
                'status'=>200,
                'message'=>$myFavs
                ]); 
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'this user havent any favorite product'
                ]);
            }

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
       
    }
    public function getMyReviewsOnProducts(){
        try{

            $myReviews= Review::where(['id'=>3])->paginate(10);
            if(!empty($myReviews)){
                return response()->json([
                    'status'=>200,
                    'message'=>$myReviews
                ]);
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'this user havent reviews on any product'
                ]);
            }

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }

    
    public function addMyReview(Request $req,$product_attr_id=null){
        try{

            $data=$req->all();
            $userReviewCount= Review::where(['id'=>3,'product_attr_id'=>$product_attr_id])->count();
            if($userReviewCount==0){
                DB::beginTransaction();
                $newReview=new Review();
                $newReview->product_attr_id=$product_attr_id;
                $newReview->review_description=$data['review_description'];
                $newReview->user_id=$user_id;
                $newReview->review_rank=$data['review_rank'];
                $newReview->save();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'added your review successfully'
                ]);
            }else{
                $routeEditReview='users/reviews/edit-my-review/'.$product_attr_id;
                return response()->json([
                    'status'=>200,
                    'message'=>'you added review on this product , so now you can edit your review from here'.$routeEditReview
                ]);
            }
          


    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    public function editMyReview(Request $req,$product_attr_id){
        try{

            $data=$req->all();
            DB::beginTransaction();
            $userReview= Review::where(['id'=>3,'product_attr_id'=>$product_attr_id])->first();
            if(!empty($userReview)){
                $userReview->review_description=$data['review_description'];
                $userReview->review_rank=$data['review_rank'];
                $userReview->save();
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'updated your review successfully'
                ]); 
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is no data'
                ]);
            }

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 

       
    }
    public function deleteMyReview($rev_id=null){
        try{

            DB::beginTransaction();
            $deleteReview=Review::where(['id'=>$rev_id])->first();
            if(!empty($deleteReview)){
               $deleteReview->delete();
               DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'deleted review succefully'
                ]); 
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is no data'
                ]);
            }

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
        }

    public function getMyOrders(){
        try{

            $myOrders=Order::where(['id'=>3])->get();
            if(!empty($myOrders)){
               return response()->json([
                'status'=>200,
                'message'=>$myOrders
                ]); 
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is no data'
                ]);
            }


    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    public function AddToMyOrder($product_attr_id=null,Request $req){
        try{

            $couponThisUser=Coupon::where(['id'=>3])->first();
            if(!empty($couponThisUser)){
                if(empty($couponThisUser->coupon_code)){
                    $routeAddMyCode='/user/users/add-my-code';
                    return response()->json([
                        'status'=>400,
                        'message'=>'you must add your code before making your order, after that you can add your product into your order, from here'.$routeAddMyCode
                    ]);
                }
            $couponCodeThisUser= $couponThisUser->coupon_code;
           // get total  for all products in cart this user
            $cartForThisUser = Cart::where(['id'=>3])->first();
            if(!empty($cartForThisUser)){

                $productsInCartForThisUser = ProductAttribute::where(['cart_id'=>$cartForThisUser->cart_id])->get();
                if(!empty($productsInCartForThisUser)){

                    $sub_total=0;
                    foreach($productsInCartForThisUser as $prod){
                        $prodPrice=$prod->product_price;
                        $prodQuantity=$prod->product_quantity;
                       
                        $sub_total=$sub_total+($prodPrice*$prodQuantity);
                        
                    }
                    $tax=1.3;
                    $total=$sub_total*$tax;
            
                    
                    //now i had couponAmount for this user , so now can store in table order
                        $data=$req->all();
                        DB::beginTransaction();
                        $neworder=new Order;
                        $neworder->user_id=$user_id;
                        $neworder->cart_id=$cartForThisUser->cart_id;
                        $neworder->sub_total=$sub_total;
                        $neworder->tax=$tax;
                        $neworder->total=$total;
                        $neworder->coupon_code=$couponCodeThisUser;
                        $neworder->billing_email=$data['billing_email'];
                        $neworder->billing_name=$data['billing_name'];
                        $neworder->billing_address=$data['billing_address'];
                        $neworder->billing_phone=$data['billing_phone'];
                        $neworder->payment_method=$data['payment_method'];
                        $neworder->number_card=$data['number_card'];
                        $neworder->order_status=$data['order_status'];
                        $neworder->save();//now became order for this user
                        $sub_total=0;
                        foreach($productsInCartForThisUser as $prod){
                            //will store it in table OrdersProduct to store product in this order
                            $orderId=  $neworder->id;
                            DB::table('order_product_attributes')->insert(['order_id'=>$orderId,'product_attr_id'=>$prod->id]);
                            
                            ProductAttribute::where(['id'=>$prod->id])->update(['cart_id'=>0]);
                            DB::commit();
                          
                       // in this step will the cart become is empty from these products
                        }
                        return response()->json([
                            'status'=>200,
                            'message'=>'added  your orders successfully'
                        ]);      
                }else{
                    return response()->json([
                        'status'=>404,
                        'message'=>'there is no data'
                    ]);
                }
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is no data'
                ]);
            }
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is no data'
                ]);
            }

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    }    
}

public function EditMyOrders($order_id=null,Request $req){
    try{

        $couponThisUser=Coupon::where(['id'=>3])->first();
        if(!empty($couponThisUser)){

            //get total  for all products in cart this user
            $cartForThisUser = Cart::where(['id'=>3])->first();
            $productsInCartForThisUser = ProductAttribute::where(['cart_id'=>$cartForThisUser->cart_id])->get();
            if(!empty($productsInCartForThisUser)){

                $sub_total=0;
                foreach($productsInCartForThisUser as $prod){
                    $prodPrice=$prod->product_price;
                    $prodQuantity=$prod->product_quantity;
                   
                    $sub_total=$sub_total+($prodPrice*$prodQuantity);
                    
                }
                $tax=1.3;
                $total=$sub_total*$tax;
                $data=$req->all();
                DB::beginTransaction();
                $order=Order::where(['id'=>$order_id])->first();
                $order->user_id=$user_id;
                $order->sub_total=$sub_total;
                $order->tax=$tax;
                $order->total=$total;
                $order->coupon_code=$couponThisUser->coupon_code;
                $order->billing_email=$data['billing_email'];
                $order->billing_name=$data['billing_name'];
                $order->billing_address=$data['billing_address'];
                $order->billing_phone=$data['billing_phone'];
                $order->payment_method=$data['payment_method'];
                $order->number_card=$data['number_card'];
                $order->order_status=$data['order_status'];
                $order->save();//now became order for this user
                
                DB::commit();
                return response()->json([
                'status'=>200,
                'message'=>'updated your orders successfully'
            ]); 
        }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'there is no data'
                    ]);
                }
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
                ]);
        }

}catch(\Exception $ex){
    DB::rollback();
    return response()->json([
        'status'=>500,
        'message'=>'There is something wrong, please try again'
    ]);  
} 
              

}

public function viewAllMyOrdersReview(){
    try{

        $allMyOrdersCount= Order::where(['id'=>3])->count();
    if($allMyOrdersCount==0){
        return response()->json([
            'status'=>200,
            'message'=>'you have not any order until now'
        ]);
    }else{
        $allMyOrders= Order::where(['id'=>3])->get();  
        return response()->json([
            'status'=>200,
            'message'=>$allMyOrders
        ]);
    }

}catch(\Exception $ex){
    DB::rollback();
    return response()->json([
        'status'=>500,
        'message'=>'There is something wrong, please try again'
    ]);  
} 
    
    
}
public function orderReviewDetails($order_id){
    try{

    $order=Order::where(['id'=>$order_id])->first();
    if(!empty($order)){
     return response()->json([
        'status'=>200,
        'message'=>$order
    ]);   
    }else{
        return response()->json([
            'status'=>404,
            'message'=>'there is no data'
        ]);
    }

}catch(\Exception $ex){
    DB::rollback();
    return response()->json([
        'status'=>500,
        'message'=>'There is something wrong, please try again'
    ]);  
} 
}
public function deleteOrder($order_id=null){
    try{

    $order=Order::where(['id'=>$order_id])->first();
    if(!empty($order)){
        DB::beginTransaction();
        $order->delete();
        DB::commit();
        $orderProd=DB::table('order_product_attributes')->where(['order_id'=>$order_id]);
        $orderProd->delete();
        return response()->json([
            'status'=>200,
            'message'=>'deleted order successfully'
        ]);

}else{
    return response()->json([
        'status'=>401,
        'message'=>'you havent authorize to enter into this route'
    ]);
}
}catch(\Exception $ex){
    DB::rollback();
    return response()->json([
        'status'=>500,
        'message'=>'There is something wrong, please try again'
    ]);  
} 
}


public function addToMyCart($user_id,$product_atrr_id){//this prod_attr_id in db but will add into cart this user , which is col cart_id , and user_id for this product_attr is empty -> now will add this product_attr iton cart this user
   
   try{

        $myCart=  Cart::where(['id'=>3])->first();
        if(!empty($myCart)){
            DB::beginTransaction();
            ProductAttribute::where(['product_atrr_name'=>$product_atrr_id])->update(['cart_id'=>$myCart->id]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'added your cart successfully'
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
            ]);
        }

}catch(\Exception $ex){
    DB::rollback();
    return response()->json([
        'status'=>500,
        'message'=>'There is something wrong, please try again'
    ]);  
} 
}
public function deleteProductFromMyCart($user_id,$product_atrr_id){
    try{
        $myCart=  Cart::where(['id'=>3])->first();
        if(!empty($myCart)){
            DB::beginTransaction();
            ProductAttribute::where(['product_atrr_name'=>$product_atrr_id])->update(['cart_id'=>0]);
            DB::commit();
            return response()->json([
                'status'=>200,
                'message'=>'deleted product from your cart successfully'
            ]);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
            ]);
        }

}catch(\Exception $ex){
    DB::rollback();
    return response()->json([
        'status'=>500,
        'message'=>'There is something wrong, please try again'
    ]);  
} 
}


    public function addProductIntoMyFavorite($product_atrr_id){
        try{

            $user_id=auth()->user()?auth()->user()->id:null;
            if($user_id!==null){
                DB::beginTransaction();
                Favorite::insert(['product_atrr_id'=>$product_atrr_id,'user_id'=>$user_id]);
                DB::commit();
                return response()->json([
                    'status'=>200,
                    'message'=>'added product into your favorite successfully'
                ]);
            }

    }catch(\Exception $ex){
        DB::rollback();
        return response()->json([
            'status'=>500,
            'message'=>'There is something wrong, please try again'
        ]);  
    } 
    }
    
    public function deleteProdFromMyFavourites($fav_id){
        try{

        DB::beginTransaction();
        $fav=Favorite::where(['id'=>$fav_id])->delete();
        DB::commit();
        if(!empty($fav)){
          return response()->json([
            'status'=>200,
            'message'=>'deleted your favorite successfully'
            ]);  
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'there is no data'
            ]);
        }

}catch(\Exception $ex){
    DB::rollback();
    return response()->json([
        'status'=>500,
        'message'=>'There is something wrong, please try again'
    ]);  
} 
}
}
