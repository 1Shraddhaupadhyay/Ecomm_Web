<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Mail\Testing;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;


class MainController extends Controller
{
    public function googleLogin()
    {
        return Socialite::driver('google')->redirect();
    }
    
    public function googleHandle()
    {
    
        try {
        $user = Socialite::driver('google')->user();

        $findUser = User::where('email', $user->email)->first();

        if (!$findUser) {
            $findUser = new User();
            $findUser->fullname = $user->name;
            $findUser->email = $user->email;
            $findUser->picture = $user->avatar;
            $findUser->password = bcrypt('12345Dummy'); // Use bcrypt for password hashing
            $findUser->type = 'Customer';
            $findUser->status = 'Active';
            $findUser->save();
        }

        session()->put('id', $findUser->id);
        session()->put('type', $findUser->type);

        return redirect('/');
        
    } catch (\Exception $e) {
        return redirect('/')->with('error', 'An error occurred during login.');
    }
}


    public function index()
    {
        $allProducts=Product::all();
        $newArrival=Product::where('type','new-arrivals')->get();
        $hotSale=Product::where('type','sale')->get();
        // dd($allProducts);
        return view('index',compact('allProducts','newArrival','hotSale'));
    }

    public function contect()
    {
        return view('contect');
    }
    public function about()
    {
        return view('about');
    }
    public function blogdetails()
    {
        return view('blogdetails');
    }
    public function shop()
    {
        return view('shop');
    }
    public function check()
    {
        return view('check');
    }

    public function profile()
    {
        if(session()->has('id'))
        {
            $user=User::find(session()->get('id'));
            return view('profile',compact('user'));
        }
        return redirect('login');  
    }

    public function updateUser(Request $data)
    {
        $user = User::find(session()->get('id'));
        $user->fullname=$data->input("fullname");
        $user->email=$data->input("email");
        $user->password=$data->input("password");

        if($data->file('file')!=null){
            $user->picture = $data->file('file')->getClientOriginalName(); // this code is use for in db save name
            $data->file('file')->move('uploads/profiles/', $user->picture);
        }
        if($user->save())
        {
            return redirect()->back()->with('success','Your Account is updated Succesfully!');
        }
    }

    public function singleProduct($id)
    {
        $product=Product::find($id);
        return view('singleProduct',compact('product'));
    }
    public function register()
    {
        return view('register');  
    }
    public function login()
    {
        return view('login');  
    }
    public function loginUser(Request $data)
    {
        $user=User::where('email',$data->input('email'))
                  ->where('password',$data->input('password'))
                  ->first();

                  if($user)
                  {
                    if($user->status =="Blocked"){
                        return redirect('login')->with('error','Your Id is Blocked! Please contact to Admin');
                    }
                    session()->put('id',$user->id); //if want to create session then use put
                    session()->put('type',$user->type);
                    if($user->type =='Customer')
                    {
                        return redirect('/');
                    }
                    else if($user->type =='Admin')
                    {
                        return redirect('/admin');
                    }
                }else
                  {
                    return redirect('login')->with('error','Email/password is incorrect.');
                   }
        return view('login');  
    }
    public function registerUser(Request $data)
    {
        $newUser = new User();
        $newUser->fullname=$data->input("fullname");
        $newUser->email=$data->input("email");
        $newUser->password=$data->input("password");

        if ($data->hasFile('file') && $data->file('file')->isValid()) {
            $newUser->picture = $data->file('file')->getClientOriginalName(); // this code is use for in db save name

            $data->file('file')->move('uploads/profiles/', $newUser->picture);
        }
        $newUser->type='Customer';

        if($newUser->save())
        {
            return redirect('login')->with('success','Your Account Created Succesfully!');
        }
    }
    
    public function logout()
    {
        session()->forget('id');
        session()->forget('type');
        return redirect('/login');
    }

    public function addToCart(Request $data)
    {
       if(session()->has('id'))
       {
        $item = new Cart();
        $item->quantity=$data->input('quantity');
        $item->productId=$data->input('id');
        $item->customerId=session()->get('id');
        $item->save();
        return redirect()->back()->with('success','Iten Added into cart!');
       }
       else
       {
        return redirect('login')->with('error','Info! Please Login to System');
       }
    }

    public function cart()
    {
        $cartItems=DB::table('products')->join('carts','carts.productId','products.id')
                                        ->select('products.title','products.quantity as pQuantity','products.price','products.picture','carts.*')
                                        ->where('carts.customerId',session()->get('id'))
                                        ->get();
        return view('cart',compact('cartItems'));
    }

    public function testMail()
    {
        $details=[
            'title' =>'Meeting',
            'message' =>'Hello, How are you welcome to our site',
        ];
        Mail::to("upiyush803@gmail.com")->send(new Testing($details));
        return redirect('/');

    }
    public function deleteCartItem($id)
    {
        $item=Cart::find($id);
        $item->delete();
        return redirect()->back()->with('success','Item has been deleted');
    }

    public function updateCart(Request $data)
    {
        if(session()->has('id'))
        {
         $item =Cart::find($data->input('id'));
         $item->quantity=$data->input('quantity');
         $item->save();
         return redirect()->back()->with('success','Success! Iten Quantity Updated!');
        }
        else
        {
         return redirect('login')->with('error','Info! Please Login to System');
        }

    }
    
    public function checkout(Request $data)
    {
    // Check if user is logged in
    if(session()->has('id'))
    {
        // Create a new order
        $order = new Order();
        $order->status = 'pending';
        $order->customerId = session()->get('id');
        $order->bill = $data->input('bill');
        $order->address = $data->input('address');
        $order->fullname = $data->input('fullname');
        $order->phone = $data->input('phone');
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
        return redirect()->back()->with('success', 'Your Order has been placed Successfully!');
    }
    else
    {
        return redirect('login')->with('error', 'Info! Please Login to System');
    }
}
    public function myOrders()
    {
        if(session()->has('id'))
        {
            // $customerId = session()->get('id');
            //$orderhistory = DB::table('Orders')->where('customerId',$customerId)->get()->toArray();
            $orderhistory = Order::where('customerId',session()->get('id'))->get();
            $items=DB::table('products')->join('order_items','order_items.productId','products.id')
            ->select('products.title','products.picture','order_items.*')
            ->get();
            return view('orders',compact('orderhistory','items'));
        }
        return redirect('login');  
    }  
}