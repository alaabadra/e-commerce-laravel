<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\ProductAttribute;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // public function __construct($user_id)
    // {   
    //     
    // $user_id=auth()->user()?auth()->user()->id:null;
    // if($user_id!==null){

    // }
    // $user_id=auth()->user()->id();
    // }
    public function viewMyProfile(){

        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
            $dataThisUser=User::where(['user_id'=>$user_id])->first();
            return response()->json([
                'status'=>200,
                'message'=>$dataThisUser
            ]);
        }
        
    }
    public function editMyProfile(Request $req){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
$data=$req->all();
        $dataThisUser=User::where(['user_id'=>$user_id])->update(['name'=>$data['name'],'image'=>$data['image'],'email'=>$data['email']]);
        }

        

    }
    public function updateMyPassword(Request $req){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
$dataThisUser=User::where(['id'=>$user_id])->first();

            $data=$req->all();
            
            $oldPassDb=$dataThisUser->password;
             $oldPassReq= bcrypt($data['old_password']);




        if($oldPassDb==$oldPassReq){
            $newPassReq=bcrypt($data['new_password']);
            User::where('id',$id)->update(['password'=>$newPassReq]);
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
        }

        
        
          
    

    }

    public function changeMyImage(Request $req){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
$user=User::where(['id'=>$user_id])->first();
        $filePath="";
        if($req->has('image')){
            $filePath=uploadImage('users',$req->photo);
            $user->image=$filePath;
            $user->save();
            return response()->json([
                'status'=>200,
                'message'=>'updated your photo successfully'
            ]);
        }
        }

        
    }
    public function checkoutShipping(Request $req){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
            $data=$req->all();

            $deliveryThisUser=Delivery::where(['user_id'=>$user_id])->count();
            if($deliveryThisUser>0){
                $delivery=Delivery::where(['user_id'=>$user_id])->first();
                $delivery->email=$data['email_shipping'];
                $delivery->name=$data['name_shipping'];
                $delivery->pincode=$data['pincode_shipping'];
                $delivery->state=$data['state_shipping'];
                $delivery->address=$data['address_shipping'];
                $delivery->mobile=$data['mobile_shipping'];
                $delivery->country_name=$data['country_name'];
                $delivery->save();
                return response()->json([
                    'status'=>200,
                    'message'=>'delivery updated successfully'.$delivery->name
                ]);

            }else{
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
                    return response()->json([
                        'status'=>200,
                        'message'=>'delivery added successfully'.$newDelivery->name
                    ]);

            }
        }


            


    }



    public function getMyCart(){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
 $myCart= Cart::where(['user_id'=>$user_id])->first();//get cart this user
       $productsInMyCart= ProductAttribute::where(['cart_id'=>$myCart->id])->get();//get products that in this cart
        return response()->json([
            'status'=>200,
            'message'=>$productsInMyCart
        ]);
        }

      
    }

    public function getMyFavorits(){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
$myFavs= Favorite::where(['user_id'=>$user_id])->paginate(10);
        return response()->json([
            'status'=>200,
            'message'=>$myFavs
        ]);
        }

       
    }
    public function getMyReviewsOnProducts(){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){

        $myFavReviews= Favorite::where(['user_id'=>$user_id])->paginate(10);
        return response()->json([
            'status'=>200,
            'message'=>$myFavReviews
        ]);
        }

    }

    
    public function addMyReview(Request $req,$product_attr_id=null){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){

        $data=$req->all();
        $userReviewCount= Review::where(['user_id'=>$user_id,'product_attr_id'=>$product_attr_id])->count();
        if($userReviewCount==0){
                $newReview=new Review();
                $newReview->product_attr_id=$product_attr_id;
                $newReview->review_description=$data['review_description'];
                $newReview->user_id=$user_id;
                $newReview->review_rank=$data['review_rank'];
                $newReview->save();
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
          
        }

 
    }
    public function editMyReview(Request $req,$product_attr_id=null){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
 $data=$req->all();
        $userReview= Review::where(['user_id'=>$user_id,'product_attr_id'=>$product_attr_id
        ])->first();
        $userReview->review_description=$data['review_description'];
        $userReview->review_rank=$data['review_rank'];
        $userReview->save();
        return response()->json([
            'status'=>200,
            'message'=>'updated your review successfully'
        ]);
        }

       
    }
    public function deleteMyReview($rev_id=null){
        $deleteReview=Review::where(['id'=>$rev_id])->first();
        $deleteReview->delete();
        return response()->json([
            'status'=>200,
            'message'=>'deleted review succefully'
        ]);
        }

    public function getMyOrders(){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
$myOrders=Order::where(['user_id'=>$user_id])->get();
        return response()->json([
            'status'=>200,
            'message'=>$myOrders
        ]);
        }

        
    }
    public function AddToMyOrder($product_attr_id=null,Request $req){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
            $couponThisUser=Coupon::where(['user_id'=>$user_id])->first();
            if(empty($couponThisUser->coupon_code)){
                $routeAddMyCode='/user/users/add-my-code';
                return response()->json([
                    'status'=>400,
                    'message'=>'you must add your code before making your order, after that you can add your product into your order, from here'.$routeAddMyCode
                ]);
            }

        
        }

        $couponCodeThisUser= $couponThisUser->coupon_code;
        //get total  for all products in cart this user
        $cartForThisUser = Cart::where(['user_id'=>$user_id])->first();
        $productsInCartForThisUser = ProductAttribute::where(['cart_id'=>$cartForThisUser->cart_id])->get();
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
            
            
            
 
            $cartForThisUser = Cart::where(['user_id'=>$user_id])->first();
            $productsInCartForThisUser = ProductAttribute::where(['cart_id'=>$cartForThisUser->cart_id])->get();
            $sub_total=0;
            foreach($productsInCartForThisUser as $prod){
            //will store it in table OrdersProduct to store product in this order
            $orderId=  $neworder->id;
            DB::table('order_product_attributes')->insert(['order_id'=>$orderId,'product_attr_id'=>$prod->id]);
               
            ProductAttribute::where(['id'=>$prod->id])->update(['cart_id'=>0]);
              
            //in this step will the cart become is empty from these products
            }
            return response()->json([
                'status'=>200,
                'message'=>'added  your orders successfully'
            ]);       
    
}

public function EditMyOrders($order_id=null,Request $req){
    
    $user_id=auth()->user()?auth()->user()->id:null;
    if($user_id!==null){
        $couponThisUser=Coupon::where(['user_id'=>$user_id])->first();
        //get total  for all products in cart this user
        $cartForThisUser = Cart::where(['user_id'=>$user_id])->first();
        $productsInCartForThisUser = ProductAttribute::where(['cart_id'=>$cartForThisUser->cart_id])->get();
        $sub_total=0;
        foreach($productsInCartForThisUser as $prod){
            $prodPrice=$prod->product_price;
            $prodQuantity=$prod->product_quantity;
           
            $sub_total=$sub_total+($prodPrice*$prodQuantity);
            
        }
        $tax=1.3;
        $total=$sub_total*$tax;
        $data=$req->all();
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
        
    return response()->json([
        'status'=>200,
        'message'=>'updated your orders successfully'
    ]); 
    }

              

}

public function viewAllMyOrdersReview(){
    
    $user_id=auth()->user()?auth()->user()->id:null;
    if($user_id!==null){
$allMyOrdersCount= Order::where(['user_id'=>$user_id])->count();
    if($allMyOrdersCount==0){
        return response()->json([
            'status'=>200,
            'message'=>'you have not any order until now'
        ]);
    }else{
      $allMyOrders= Order::where(['user_id'=>$user_id])->get();  
      return response()->json([
        'status'=>200,
        'message'=>$allMyOrders
    ]);
    }
    }

    
    
}
public function orderReviewDetails($order_id){
    $order=Order::where(['id'=>$order_id])->first();
    return response()->json([
        'status'=>200,
        'message'=>$order
    ]);
}
public function deleteOrder($order_id=null){
    $order=Order::where(['id'=>$order_id])->first();
    $order->delete();
    $orderProd=DB::table('order_product_attributes')->where(['order_id'=>$order_id]);
    $orderProd->delete();
    return response()->json([
        'status'=>200,
        'message'=>'deleted order successfully'
    ]);
}


public function addToMyCart($user_id,$product_atrr_id){//this prod_attr_id in db but will add into cart this user , which is col cart_id , and user_id for this product_attr is empty -> now will add this product_attr iton cart this user
    $myCart=  Cart::where(['user_id'=>$user_id])->first();
    ProductAttribute::where(['product_atrr_name'=>$product_atrr_id])->update(['cart_id'=>$myCart->id]);

}
public function deleteProductFromMyCart($user_id,$product_atrr_id){
    $myCart=  Cart::where(['user_id'=>$user_id])->first();
    ProductAttribute::where(['product_atrr_name'=>$product_atrr_id])->update(['cart_id'=>0]);
    return response()->json([
        'status'=>200,
        'message'=>'deleted product from your cart successfully'
    ]);
}


    public function addProductIntoMyFavorite($product_atrr_id){
        
        $user_id=auth()->user()?auth()->user()->id:null;
        if($user_id!==null){
  Favorite::insert(['product_atrr_id'=>$product_atrr_id,'user_id'=>$user_id]);
        return response()->json([
            'status'=>200,
            'message'=>'added product into your favorite successfully'
        ]);
        }
    }
    
    public function deleteProdFromMyFavourites($fav_id){
        Favorite::where(['id'=>$fav_id])->first();
        return response()->json([
            'status'=>200,
            'message'=>'deleted your favorite successfully'
        ]);
    }
}
