<!DOCTYPE html>
<html>
   <head>
      <!-- Basic -->
      <meta charset="utf-8" />
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <!-- Mobile Metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
      <!-- Site Metas -->
      <meta name="keywords" content="" />
      <meta name="description" content="" />
      <meta name="author" content="" />
      <link rel="shortcut icon" href="images/favicon.png" type="">
      <title>Famms - Fashion HTML Template</title>
      <!-- bootstrap core css -->
      <link rel="stylesheet" type="text/css" href="{{ asset('home/css/bootstrap.css') }}" />
      <!-- font awesome style -->
      <link href="{{ asset('home/css/font-awesome.min.css') }}" rel="stylesheet" />
      <!-- Custom styles for this template -->
      <link href="{{ asset('home/css/style.css') }}" rel="stylesheet" />
      <!-- responsive style -->
      <link href="{{ asset('home/css/responsive.css') }}" rel="stylesheet" />

      <style>
        .center{
            margin: auto;
            width: 40%;
            text-align: center;
            padding: 30px;

        }
        table,th,td{
            border: 1px solid black;
        }
        .th_deg{
            font-size: 30px;
            padding: 5px;
            background: rgb(35, 215, 250);
        }
        .img_deg{
            height: 150px;
            width: 150px;
        }
        .total_deg{
            font-size: 30px;
            padding: 40px;
        }
      </style>
   </head>
   <body>
      <div class="hero_area">
         <!-- header section strats -->
         @include('home.header')
         @if (session()->has('order_message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('order_message') }}
            </div>
            @endif
         <!-- end header section -->
      <div class="center">
        <table>
        <tr>
            <th class="th_deg">Product Title</th>
            <th class="th_deg">Product Quantity</th>
            <th class="th_deg">Price</th>
            <th class="th_deg">Image</th>
            <th class="th_deg">Action</th>
        </tr>
        <?php $totalprice=0; ?>
        @foreach ($card as $card)
            
        
        <tr>
            <td>{{ $card->product_title }}</td>
            <td>{{ $card->quantity }}</td>
            <td>{{ $card->price }}</td>
            <td><img src="/product/{{ $card->image }}" alt="" class="img_deg"></td>
            <td><a onclick="return confirm('Are you sure to remove this product?')" href="{{ url('remove_card',$card->id) }}" class="btn btn-danger">Remove Product</a></td>
        </tr>
        <?php $totalprice=$totalprice + $card->price ?>
        @endforeach
        </table>
        <div>
           <h1 class="total_deg"> Total Price: ${{ $totalprice }}</h1> 
        </div>

        <div>
            <h1 style="font-size: 25px; padding-bottom: 10px">Proceed to Order</h1>
            <a href="{{ url('cash_order') }}" class="btn btn-danger">Cash On Delivery</a>
             <a href="{{ url('stripe',$totalprice) }}" class="btn btn-danger">Pay Using Card</a>
        </div>
      </div>
    
      
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </div>
      <!-- jQery -->
      <script src="home/js/jquery-3.4.1.min.js"></script>
      <!-- popper js -->
      <script src="home/js/popper.min.js"></script>
      <!-- bootstrap js -->
      <script src="home/js/bootstrap.js"></script>
      <!-- custom js -->
      <script src="home/js/custom.js"></script>
   </body>
</html>