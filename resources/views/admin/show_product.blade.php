<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   @include('admin.css')
   <style>
   .center{
   margin: auto;
    width: 50%;
    margin-top: 30px;
    text-align: center;
    border: 3px solid green;
   }
   .font_size{
    text-align: center;
    font-size: 40px;
   }
   .img_size{
    width: 150px;
    height: 150px;
   }
   .th_color{
    background-color: rgb(153, 6, 128);
   }
   .th_design{
    padding: 30px;
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

            @if (session()->has('delete_product'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('delete_product') }}
            </div>
            @endif

<h1 class="font_size">All Products</h1>
            <table class="center">
                <tr class="th_color">
                    <th class="th_design">Product Title</th>
                    <th class="th_design">Description</th>
                    <th class="th_design">Quantity</th>
                    <th class="th_design">Catagory</th>
                    <th class="th_design">Price</th>
                    <th class="th_design">Discount Price</th>
                    <th class="th_design">Product Image</th>
                    <th class="th_design">Delete</th>
                    <th class="th_design">Edit</th>

                </tr>
                @foreach ($product as $product)  
                <tr>
                    <td>{{ $product->title }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->catagory }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->discount_price }}</td>
                    <td>
                        <img src="/product/{{ $product->image }}" alt="" class="img_size">
                    </td>
                    <td>
                      <a class="btn btn-danger" onclick="return confirm('Are you sure to Delete data!')" href="{{ url('delete_product',$product->id ) }}">Delete</a>
                    </td>
                    <td>
                      <a class="btn btn-success" href="{{ url('edit_product',$product->id ) }}">Edit</a>
                    </td>
                </tr>
                @endforeach
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