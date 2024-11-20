<?php

namespace App\Http\Controllers;
use Session;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class StripePaymentController extends Controller
{
     /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe(Request $data)
    {
        $bill=$data->input('bill');
        $fullname=$data->input('fullname');
        $phone=$data->input('phone');
        $address=$data->input('address');
        return view('stripe',compact('bill','fullname','phone','address'));
    }
    
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request) //data send karwa rahi hai
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Charge::create ([
                "amount" => $request->input('bill') * 100,
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "New Order Payment Received Successfully." 
        ]);
      
        Session::flash('success', 'Payment successful!');

        if(session()->has('id'))
    {
        // Create a new order
        $order = new Order();
        $order->status = 'Paid';
        $order->customerId = session()->get('id');
        $order->bill = $request->input('bill');
        $order->address = $request->input('address');
        $order->fullname = $request->input('fullname');
        $order->phone = $request->input('phone');

        // Save the order to the database
        if($order->save())
        {
            // Retrieve all items in the cart for the current user
            $carts = Cart::where('customerId', session()->get('id'))->get();

            // Process each item in the cart
            foreach($carts as $item)
            {
                // Find the product related to the cart item
                $product = Product::find($item->productId);

                // Create a new order item
                $orderItem = new OrderItem();
                $orderItem->productId = $item->productId;
                $orderItem->quantity = $item->quantity;
                $orderItem->price = $product->price;
                $orderItem->orderId = $order->id; // Assign the order ID
                // Save the order item to the database
                $orderItem->save();

                // You may also choose to delete the cart item after processing
                $item->delete();
            }
            // Alternatively, you can keep the cart items for reference
            // Cart::where('customerId', session()->get('id'))->delete();
        }
            return redirect('/cart')->with('success','Your Order has been placed Successfully !');
            }
              
        return back();
    }

}
