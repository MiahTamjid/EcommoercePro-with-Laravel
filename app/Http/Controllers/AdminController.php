<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catagory;
use App\Models\Product;
use App\Models\Order;
use PDF;
use Notification;
use App\Notifications\SentEmailNotification; 

class AdminController extends Controller
{
    public function view_catagory(){
        $data = catagory::all();
        return view('admin.catagory',compact('data'));
    }

    public function add_catagory(Request $request){
        $data = new Catagory;
        $data->catagory_name=$request->catagory;
        $data->save();
        return redirect()->back()->with('message','Catagory Added Succesfully');

    }
    public function delete_catagory($id){
        $data= catagory::find($id);
        $data->delete();
        return redirect()->back()->with('delete_message','Catagory Deleted!');

    }

    public function view_product(){
        $catagory = catagory::all();
        return view('admin.product',compact('catagory'));
    }

    public function add_product(Request $request){
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

    public function show_product(){
        $product= Product::all();
        return view('admin.show_product',compact('product'));
    }

    public function delete_product($id){
        $data= Product::find($id);
        $data->delete();
        return redirect()->back()->with('delete_product','Product Deleted!');
    }

    public function edit_product($id){
        $product= Product::find($id);
        $catagory = catagory::all();
        return view('admin.edit_product',compact('product','catagory'));
        
    }
    
    public function edit_product_confirm(Request $request,$id){
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
    public function order(){
        $order=Order::all();
        return view('admin.order',compact('order'));
    }

    public function delivered($id){
        $order=Order::find($id);
        $order->delivery_status='Delivered';
        $order->payment_status='Paid';

        $order->save();
         return redirect()->back();

    }
    public function print_pdf($id)
    {
        $order= Order::find($id);
        $pdf =PDF::loadView('admin.pdf',compact('order'));
        return $pdf->download('order_details.pdf');

    }

    public function sent_email($id){
        $order= Order::find($id);
        return view('admin.sent_email',compact('order'));
    }

    public function sent_user_email(Request $request,$id){
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

    public function search(Request $request){

        $searchText= $request->search;

        $order= Order::where('name','LIKE',"%$searchText%")->orWhere('phone','LIKE',"%$searchText%")->orWhere('email','LIKE',"%$searchText%")->orWhere('product_title','LIKE',"%$searchText%")->get();

        return view('admin.order',compact('order'));
    }
}
