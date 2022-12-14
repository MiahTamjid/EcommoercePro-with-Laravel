<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Product;
use App\Models\Card;
use App\Models\Order;
use Session;
use Stripe;
use App\Models\Comment;
use App\Models\Reply;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function redirect(){
        $usertype = Auth::user()->usertype;
        if($usertype=='1'){
            $total_prodect = Product::all()->count();
            $total_order = Order::all()->count();
            $total_user = User::all()->count();

            $order = Order::all();
            $total_revenue = 0;
            
            foreach($order as $order)
            {
                $total_revenue = $total_revenue + $order->price;
                
            }

            $total_delivery = Order::where('delivery_status','=','Delivered')->get()->count();
            $total_order_processing = Order::where('delivery_status','=','processing')->get()->count();

            return view('admin.home',compact('total_prodect','total_order','total_user','total_revenue','total_delivery','total_order_processing'));
        }else{
            $product = Product::paginate(10);
            $comment = comment::orderby('id','desc')->get();
            $reply = reply::all();
        return view('home.userpage',compact('product','comment','reply'));
        }
    }

    public function index(){
        $product = Product::paginate(10);
        $comment = comment::orderby('id','desc')->get();
        $reply = reply::all();
        return view('home.userpage',compact('product','comment','reply'));
    }
    public function product_details($id){
         $product = Product::find($id);
        return view('home.product_details',compact('product'));
    }

    public function add_card(Request $request,$id){
        if(Auth::id()){
            $user =Auth::user();
            $product = Product::find($id);
            $userid = $user->id;

            $product_exist_id = Card::where('product_id','=',$id)->where('user_id','=',$userid)->get('id')->first();

            if($product_exist_id)
            {
                $card = Card::find($product_exist_id)->first();
                $quantity = $card->quantity;
                $card->quantity=$quantity + $request->quantity;

                if($product->discount_price!=null)
            {
                $card->price= $product->discount_price * $card->quantity;;
            }
            else
            {
                $card->price= $product->price * $card->quantity;;
            }

                $card->save();
                Alert::success('Product Added Successfully','We have added product to the card');
                return redirect()->back();
            }
            else
            {
                $card = new Card;

            $card->name= $user->name;
            $card->email= $user->email;
            $card->phone= $user->phone;
            $card->address= $user->address;
            $card->user_id= $user->id;

            $card->product_title= $product->title;
            $card->image= $product->image;

            if($product->discount_price!=null)
            {
                $card->price= $product->discount_price * $request->quantity;;
            }
            else
            {
                $card->price= $product->price * $request->quantity;;
            }
            
            $card->product_id= $product->id;
            $card->quantity= $request->quantity;
            $card->save();
            
            return redirect()->back();
            }

            
        }
        else{
            return redirect('login');
        }
    }
    public function show_cart(){
        if(Auth::id())
        {
            $id=Auth::user()->id;
            $card= card::where('user_id','=',$id)->get();
            return view('home.show_cart',compact('card'));
        }
        else{
            return redirect('login');
        }
        
    }

    public function remove_card($id){
        $card = Card::find($id);
        $card->delete();
        Alert::warning('Product Remove Successfully','We have remove product to the card');
        return redirect()->back(); 
    }

    public function cash_order(){
        $user = Auth::user();
        $user_id = $user->id;

       $data= card::where('user_id','=',$user_id)->get();

       foreach($data as $data){
        $order = new Order;

        $order->name=$data->name;
        $order->email=$data->email;
        $order->phone=$data->phone;
        $order->address=$data->address;
        $order->user_id=$data->user_id;
        $order->product_title=$data->product_title;
        $order->quantity=$data->quantity;
        $order->price=$data->price;
        $order->image=$data->image;
        $order->product_id=$data->product_id;

        $order->payment_status='cash on delivery';
        $order->delivery_status='processing';
        $order->save();
        //move data for card table to order table
        $card_id=$data->id;
        $card=card::find($card_id);
        $card->delete();
       }
        return redirect()->back()->with('order_message','We have Received your Order. We will connect with you soon...');
    }

    public function stripe($totalprice){
        return view('home.stripe',compact('totalprice'));
    }

     public function stripePost(Request $request,$totalprice)
    {
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    
        Stripe\Charge::create ([
                "amount" => $totalprice * 100, //changeable
                "currency" => "usd",
                "source" => $request->stripeToken,
                "description" => "Thanks For Payment" 
        ]);

        $user = Auth::user();
        $user_id = $user->id;

       $data= card::where('user_id','=',$user_id)->get();

       foreach($data as $data){
        $order = new Order;

        $order->name=$data->name;
        $order->email=$data->email;
        $order->phone=$data->phone;
        $order->address=$data->address;
        $order->user_id=$data->user_id;
        $order->product_title=$data->product_title;
        $order->quantity=$data->quantity;
        $order->price=$data->price;
        $order->image=$data->image;
        $order->product_id=$data->product_id;

        $order->payment_status='Paid';
        $order->delivery_status='processing';
        $order->save();
        //move data for card table to order table
        $card_id=$data->id;
        $card=card::find($card_id);
        $card->delete();
       }
      
        Session::flash('success', 'Payment successful!');
              
        return back();
    }

    public function show_order(){
        if(Auth::id())
            {
            $id=Auth::user()->id;
            $order= Order::where('user_id','=',$id)->get();  
            return view('home.order',compact('order'));
            }
        else
            {
            return redirect('login');
            }

    }
    public function cancel_order($id){
        $order = Order::find($id);
        $order->delivery_status='You Canceled The Order';
        $order->save();
        return redirect()->back(); 

    }

    public function add_comment(Request $request)
    {
        if(Auth::id())
        {
            $comment = new comment;

            $comment->name=Auth::user()->name;
            $comment->user_id=Auth::user()->id;
            $comment->comment=$request->comment;

            $comment->save();
            return redirect()->back(); 
        }
    else
        {
        return redirect('login');
        }
     
    }

    public function add_reply(Request $request)
    {
        if(Auth::id())
        {
            $reply = new reply;

            $reply->name=Auth::user()->name;
            $reply->user_id=Auth::user()->id;
            $reply->comment_id=$request->commentId;
            $reply->reply=$request->reply;
            

            $reply->save();
            return redirect()->back(); 
        }
    else
        {
        return redirect('login');
        }
    }

    public function product_search(Request $request)
    {  
        $comment = comment::orderby('id','desc')->get();
        $reply = reply::all();
        $search_text=$request->search;
        $product= Product::where('title','LIKE',"%$search_text%")->orWhere('catagory','LIKE',"%$search_text%")->paginate(10);
        return view('home.userpage',compact('product','comment','reply'));
    }

    public function products(){
        $product = Product::paginate(10);
        $comment = comment::orderby('id','desc')->get();
        $reply = reply::all();
        return view('home.all_products',compact('product','comment','reply'));
    }

    public function search_products(Request $request)
    {  
        $comment = comment::orderby('id','desc')->get();
        $reply = reply::all();
        $search_text=$request->search;
        $product= Product::where('title','LIKE',"%$search_text%")->orWhere('catagory','LIKE',"%$search_text%")->paginate(10);
        return view('home.all_products',compact('product','comment','reply'));
    }
}
