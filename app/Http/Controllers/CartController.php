<?php

namespace App\Http\Controllers;

use App\Http\Services\CartService;
use App\Models\CouponModel;
use App\Models\UserCustomerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(Request $request){
        $id = $request->id;
        $quantity = $request->quantity;
        $result = $this->cartService->create($id,$quantity);
        
        if($result === false){
            return redirect()->back();
        }
        // return redirect('/carts');
    }

    public function show(){
        $products = $this->cartService->getProduct();
        if(!empty(session('user_customer_id'))){
            $userCustomer = UserCustomerModel::where('user_customer_id',session('user_customer_id'))->first();
        }else{
            return redirect()->route('login');
        }
        return view('carts.list',[
            'title' =>'Giỏ hàng',
            'carts'=> Session::get('carts'),
            'products'=>$products,
            'userCustomer'=>$userCustomer,
        ]);
    }

    public function update(Request $request){
        $this->cartService->update($request);
        return redirect('/carts');
    }

    public function remove(Request $request){
        $this->cartService->remove($request);
        return redirect('/carts');
    }

    public function addCart(Request $request){
        $this->cartService->addCart($request);
        return redirect()->back();
    }

    // Coupon
    function Coupon(Request $request){
        $coupon = CouponModel::where('coupon_code',$request->coupon)->first();
        if(!empty(session('user_customer_id'))){
            if(!empty($coupon)){
                $userid = session('user_customer_id');
                $sessionCoupon = session('coupon',[]);
                if(isset($sessionCoupon[$userid])){
                    if( $sessionCoupon[$userid]['coupon_code'] == $request->coupon){
                        session()->flash('msgcode','Mã code chỉ được dùng một lần');
                    }else{
                        session()->forget('coupon');
                        $sessionCoupon[$userid] = [
                            'coupon_code'=>$coupon->coupon_code,
                            'coupon_quantity'=>$coupon->coupon_quantity,
                            'coupon_discount'=>$coupon->coupon_discount,
                        ];
                    }
                }else{
                    $sessionCoupon[$userid] = [
                        'coupon_code'=>$coupon->coupon_code,
                        'coupon_quantity'=>$coupon->coupon_quantity,
                        'coupon_discount'=>$coupon->coupon_discount,
                    ];
                }
                session()->put('coupon',$sessionCoupon);
    
                // session()->put('coupon_discount',$coupon->coupon_discount);
                // session()->put('coupon_quantity',$coupon->coupon_quantity);
                // session()->put('coupon_code',$coupon->coupon_code);
    
                return true;
            }else{
                // session()->forget('coupon_discount');
                // session()->forget('coupon_code');
                // session()->forget('coupon_quantity');
                session()->forget('coupon');
                return session()->flash('msg','Coupon không tồn tại');
            }
        }
    }
}
