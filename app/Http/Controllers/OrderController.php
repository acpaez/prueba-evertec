<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Request;

class OrderController extends Controller
{
    /**
     * @method index
     * method in charge of rendering the order creation view
     * @return render CreateOrder
     */
    public function index(){
        return Inertia::render('CreateOrder');
    }

     /**
     * @method listOrder
     * method in charge of rendering the orders list view
     * @return render ListOrders
     */
    public function listOrder(){
        return Inertia::render('ListOrders');
    }

    /**
     * @method listOrders
     * method in charge of listing the orders
     * @return collection Order
     */
    public function listOrders(){
        return Order::all();
    }

     /**
     * @method payOrder
     * method in charge of rendering the orders list view
     * @return render PayOrder
     */
    public function payOrder(){
        return Inertia::render('PayOrder');
    }

     /**
     * @method createOrder
     * method in charge of create order
     * @return jsonreponse status of creation
     */
    public function createOrder(Request $request){
        $order = new Order();
        $order->customer_name=$request->customer_name;
        $order->customer_email=$request->customer_email;
        $order->customer_mobile=$request->customer_phone;
        $order->customer_surname=$request->customer_surname;  
        $order->customer_identification_type=$request->customer_identification_type;  
        $order->customer_identification=$request->customer_identification;  
        $order->product_name=$request->product_name;     
        $order->product_price=$request->product_price;
        $order->product_quantity=$request->product_quantity;
        $order->total=$request->product_quantity * $request->product_price;
        $order->request_id=$request->request_id;
        $order->reference = 'REF_' . time();
        $order->status='CREATED';
        $order->save();

        return response()->json(["message" => "Orden creada correctamente", "status"=>200, "data" => $order] , 200);
    }
}