<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   @include('admin.css')
   <style>
    .title_deg{
        text-align: center;
        font-size: 25px;
        font-weight: bold;
        padding-bottom: 20px;
    }
    .table_deg{
        border: 2px solid rgb(173, 206, 25);
        width: 100%;
        margin: auto;
        
        text-align: center;
    }
    .img_deg{
        width: 100px;
        height: 100px;
    }
    .table_hader{
        background-color: rgb(154, 214, 49);
    }
   </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.sidebar')
      <!-- partial -->
      @include('admin.header')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <h1 class="title_deg">Order List</h1>

            <div style="padding-left:400px; padding-bottom:30px">
              <form action="{{ url('search') }}" method="get">
                @csrf
                <input style="color: black" type="text" name="search" placeholder="Search For Something">
                <input type="submit" value="Search" class="btn btn-outline-primary">
              </form>
            </div>

            <table class="table_deg">
                <tr class="table_hader">
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Title</th>
                    <th>Quantity</th>
                    
                    <th>Price</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Image</th>
                    <th>Delivered</th>
                    <th>Print PDF</th>
                    <th>Sent Email</th>
                    
                </tr>
                @forelse ($order as $order)

                <tr>
                    <td>{{ $order->name }}</td>
                    <td>{{ $order->email }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->product_title }}</td>
                    <td>{{ $order->quantity }}</td>
                    
                    <td>{{ $order->price }}</td>
                    <td>{{ $order->payment_status }}</td>
                    <td>{{ $order->delivery_status }}</td>
                    <td>
                        <img class="img_deg" src="/product/{{ $order->image }}" alt="">
                    </td>
                    <td>
                    @if ( $order->delivery_status=='processing')

                        <a onclick="return confirm('Are you sure this product is delivered!!')" href="{{ url('delivered',$order->id) }}" class="btn btn-primary">Delivered</a>

                        @else

                        <p style="color:blueviolet">Delivered</p>
                    
                    @endif
                    </td>
                    <td>
                      <a  class="btn btn-secondary" href="{{ url('print_pdf',$order->id) }}">Print PDF</a>
                    </td>
                    <td>
                      <a class="btn btn-info" href="{{ url('sent_email',$order->id) }}">Email</a>
                    </td>
                </tr>
                @empty
                <tr>
                  <td colspan="16">
                    No Data Found!
                  </td>
                </tr>
                 @endforelse
                 
            </table>
          </div>
        </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="admin/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    @include('admin.script')
    <!-- End custom js for this page -->
  </body>
</html>