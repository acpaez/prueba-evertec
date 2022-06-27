<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\OrderTrait;
use App\Models\Order;
use Dnetix\Redirection\PlacetoPay;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    use OrderTrait;

     /**
     * @method createNewPaymentRequest
     * method in charge of connecting to the placetopay gateway and creating the payment request
     * @return url request processing url
     */
    public function createNewPaymentRequest(Request $request)
    {

        $placetopay = new PlacetoPay([
            'login' => config('placetopay.login'),
            'tranKey' => config('placetopay.trankey'),
            'baseUrl' => config('placetopay.url_base'),
            'timeout' => config('placetopay.timeout')
        ]);

        $order = $this->getOrder($request->id);
        $request_order = $this->request($order, $request->ip());

        $response = $placetopay->request($request_order);


        if ($response->isSuccessful()) {
            // STORE THE $response->requestId() and $response->processUrl() on your DB associated with the payment order
            // Redirect the client to the processUrl or display it on the JS extension
            $order = Order::find($request->id);
            $order->request_id = $response->requestId();
            $order->save();

            return $response->processUrl();
            //return $response->status()->status();
        } else {
            // There was some error so check the message and log it
            $response->status();
        }
    }

    /**
     * @method statusPayment
     * method in charge of verifying the status of the payment request
     * @return colelction order
     */
    public function statusPayment(Request $request){
        $placetopay = new PlacetoPay([
            'login' => config('placetopay.login'),
            'tranKey' => config('placetopay.trankey'),
            'baseUrl' => config('placetopay.url_base'),
            'timeout' => config('placetopay.timeout')
        ]);

        $order = Order::where('reference', $request->reference)->first();

        $response = $placetopay->query($order->request_id);

        $order->status = $response->status()->status();
        $order->save();

        return $order;
    }

     /**
     * @method request
     * method in charge of creating the request with the necessary data so that the gateway generates the payment request
     * @return colelction order
     */
    public function request($order, $ip)
    {
        $customer =  [
            'name' => $order->customer_name,
            'surname' => $order->customer_surname,
            'email' => $order->customer_email,
            'documentType' => $order->customer_identification_type,
            'document' => $order->customer_identification,
            'mobile' => $order->customer_phone,
            'address' => [
                'street' => 'calle 26',
                'country' => 'CO',
            ]
        ];

        $request = [
            'locale' => 'es_CO',
            'buyer' => $customer,
            'payment' => [
                'reference' => $order->reference,
                'description' => 'Testing payment',
                'amount' => [
                    'details' => [
                        [
                            'kind' => $order->product_name,
                            'amount' => $order->product_quantity
                        ]
                    ],
                    'currency' => 'USD',
                    'total' => $order->total,
                ],
                'allowPartial' => false,
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://127.0.0.1:8000/pay-order?reference=' . $order->reference,
            'ipAddress' => $ip,
            "userAgent" => "PlacetoPay Sandbox",
            'cancelUrl' => '',
            'skipResult' => false,
            'noBuyerFill' => false,
            'captureAddress' => false,
            'paymentMethod' => null,
        ];

        return $request;
    }
}
