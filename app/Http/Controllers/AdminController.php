<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catagory;
use App\Models\Product;
use App\Models\Order;
use PDF;
use Notification;
use App\Notifications\SentEmailNotification; 
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function view_catagory(){
        if(Auth::id())
        {
            $data = catagory::all();
            return view('admin.catagory',compact('data'));
        }
        else
        {
            return redirect('login');
        }
        
    }

    public function add_catagory(Request $request){
        if(Auth::id())
        {
            $data = new Catagory;
            $data->catagory_name=$request->catagory;
            $data->save();
            return redirect()->back()->with('message','Catagory Added Succesfully');
        }
        else
        {
            return redirect('login');
        }
       

    }

    public function delete_catagory($id){
        if(Auth::id())
        {
            $data= catagory::find($id);
            $data->delete();
            return redirect()->back()->with('delete_message','Catagory Deleted!');
        }
        else
        {
            return redirect('login');
        }
        

    }

    public function view_product(){
        if(Auth::id())
        {
            $catagory = catagory::all();
            return view('admin.product',compact('catagory'));
        }
        else
        {
            return redirect('login');
        }
        
    }

    public function add_product(Request $request){
        if(Auth::id())
        {
            $product = new Product;

            $product->title=$request->title;
            $product->description =$request->description ;
            $product->catagory=$request->catagory;
            $product->quantity=$request->quantity;
            $product->price=$request->price;
            $product->discount_price=$request->discount_price;
        //image add
            $image=$request->image;
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('product',$imagename);
            $product->image=$imagename;

            $product->save();
            return redirect()->back()->with('product_message','Product Added Successfully');
        }
        else
        {
            return redirect('login');
        }
        


    }

    public function show_product(){
        if(Auth::id())
        {
            $product= Product::all();
            return view('admin.show_product',compact('product'));
        }
        else
        {
            return redirect('login');
        }
        
    }

    public function delete_product($id){
        if(Auth::id())
        {
            $data= Product::find($id);
            $data->delete();
            return redirect()->back()->with('delete_product','Product Deleted!');
        }
        else
        {
            return redirect('login');
        }
       
    }

    public function edit_product($id){
        if(Auth::id())
        {
            $product= Product::find($id);
            $catagory = catagory::all();
            return view('admin.edit_product',compact('product','catagory'));
        }
        else
        {
            return redirect('login');
        }
        
        
    }
    
    public function edit_product_confirm(Request $request,$id){
        if(Auth::id())
        {
            $product= Product::find($id);

            $product->title=$request->title;
            $product->description =$request->description ;
            $product->catagory=$request->catagory;
            $product->quantity=$request->quantity;
            $product->price=$request->price;
            $product->discount_price=$request->discount_price;
        //image add
            $image=$request->image;
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('product',$imagename);
            $product->image=$imagename;
            $product->save();
            return redirect()->back()->with('product_update','Product Update Successfully');
        }
        else
        {
            return redirect('login');
        }
         


    }
    public function order(){
        if(Auth::id())
        {
            $order=Order::all();
            return view('admin.order',compact('order'));
        }
        else
        {
            return redirect('login');
        }
        
    }

    public function delivered($id){
        if(Auth::id())
        {
            $order=Order::find($id);
            $order->delivery_status='Delivered';
            $order->payment_status='Paid';
    
            $order->save();
             return redirect()->back();
        }
        else
        {
            return redirect('login');
        }
       

    }
    public function print_pdf($id)
    {
        if(Auth::id())
        {
            $order= Order::find($id);
            $pdf =PDF::loadView('admin.pdf',compact('order'));
            return $pdf->download('order_details.pdf');

        }
        else
        {
            return redirect('login');
        }
        
    }

    public function sent_email($id){
        if(Auth::id())
        {
            $order= Order::find($id);
            return view('admin.sent_email',compact('order'));
        }
        else
        {
            return redirect('login');
        }
        
    }

    public function sent_user_email(Request $request,$id){
        if(Auth::id())
        {
            $order=Order::find($id);

            $details= [
            'greeting' => $request->greeting,
            'firstline' => $request->firstline,
            'body' => $request->body,
            'button' => $request->button,
            'url' => $request->url,
            'lastline' => $request->lastline,
            ];
            Notification::send($order,new SentEmailNotification($details));

         return redirect()->back()->with('sent_mail_massage','Mail Send Successfully');
        }
        else
        {
            return redirect('login');
        }
         

    }

    public function search(Request $request){
        if(Auth::id())
        {
            $searchText= $request->search;

            $order= Order::where('name','LIKE',"%$searchText%")->orWhere('phone','LIKE',"%$searchText%")->orWhere('email','LIKE',"%$searchText%")->orWhere('product_title','LIKE',"%$searchText%")->get();

            return view('admin.order',compact('order'));
        }
        else
        {
            return redirect('login');
        }

        
    }
}
