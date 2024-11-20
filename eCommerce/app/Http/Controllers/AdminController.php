<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){
        if(session()->get('type') == 'Admin')
        {
            $customerId = session()->get('id');
            $user = DB::table('Users')->where('id',$customerId)->get();
            $today = Carbon::today();
            $formattedDate = $today->format('d-M-Y');
            return view('Dashboard.index',compact('user','formattedDate'));
        }
        return redirect()->back();
    }

    public function products()
    {
        if(session()->get('type') == 'Admin')
        {
        $products = Product::all();
        return view('Dashboard.products',compact('products'));
        }
        return redirect()->back();
    }

    public function AddNewProduct(Request $data)
    {
        if(session()->get('type') == 'Admin')
        {
        $product=new Product();
        $product->title=$data->input('title');
        $product->price=$data->input('price');
        $product->type=$data->input('type');
        $product->quantity=$data->input('quantity');
        $product->category=$data->input('category');
        $product->description=$data->input('description');
        $product->keywords=$data->input('keywords');
        $product->picture=$data->file('file')->getClientOriginalName();
        $data->file('file')->move('uploads/products/',$product->picture);
        $product->save();
        return redirect()->back()->with('success','Congratulation! New Product Listed Successfully');
     }
    return redirect()->back();
    }

    public function UpdateProduct(Request $data)
    {
        if(session()->get('type') == 'Admin')
        {
        $product= Product::find($data->input('id'));
        $product->title=$data->input('title');
        $product->price=$data->input('price');
        $product->type=$data->input('type');
        $product->quantity=$data->input('quantity');
        $product->category=$data->input('category');
        $product->description=$data->input('description');
        $product->keywords=$data->input('keywords');
        if($data->file('file') !=null)
        {
            $product->picture=$data->file('file')->getClientOriginalName();
            $data->file('file')->move('uploads/products/',$product->picture);
        }
        $product->save();
        return redirect()->back()->with('success','Product Updated Successfully');
     }
    return redirect()->back();
    }

    public function deleteProduct($id)
    {
        if(session()->get('type') == 'Admin')
        {
        $product=Product::find($id);
        $product->delete();
        return redirect()->back()->with('success','Product Deleted Successfully');
    }
    return redirect()->back();
    }

    public function profile()
    {
        if(session()->get('type') == 'Admin')
        {
            $user=User::find(session()->get('id'));
            return view('Dashboard.profile',compact('user'));
        }
        return redirect()->back();
    }

    public function customers()
    {
        if(session()->get('type') == 'Admin')
        {
            $customers=User::where('type','customer')->get();
            
            return view('Dashboard.customers',compact('customers'));
        }
        return redirect()->back();
    }

    public function changeUserStatus($status,$id)
    {
        if(session()->get('type') == 'Admin')
        {
            $user=User::find($id);
            $user->status=$status;
            $user->save();
            return redirect()->back()->with('success','User Status Updated Successfully.');

        }
        return redirect()->back();
    }

    public function orders()
    {
        if(session()->get('type') == 'Admin')
        {
           $orderItems=DB::table('order_items')
                          ->join('products','order_items.productId','products.id')
                          ->select('products.title','products.picture','order_items.*')
                          ->get();

           $orders=DB::table('users')
                       ->join('orders','orders.customerId','users.id')
                       ->select('orders.*','users.fullname','users.email','users.status as userStatus')
                       ->get();
            return view('Dashboard.orders',compact('orders','orderItems'));
        }
        return redirect()->back();
    }

    public function changeOrderStatus($status,$id)
    {
        if(session()->get('type') == 'Admin')
        {
            $user=Order::find($id);
            $user->status=$status;
            $user->save();
            return redirect()->back()->with('success','Order Status Updated Successfully.');

        }
        return redirect()->back();
    }
}