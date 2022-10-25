<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
   @include('admin.css')
   <style>
    .div_center{
    text-align: center;
    padding-top: 40px;
    
}
.h2_font{
    font-size: 40px;
    padding-bottom: 40px;
}
.input_color{
    color: black;
}
label{
    display: inline-block;
    width: 200px;
}
.div_design{
    padding-bottom: 10px;
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

            <div  class="div_center">
               @if (session()->has('product_message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('product_message') }}
            </div>
            @endif
                <h1 class="h2_font">Add Product</h1>
                <form action="{{ url('add_product') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                <div class="div_design">
                <label for="">Product Title: </label>
                <input type="text" class="input_color" name="title" placeholder="Write a title" required>
                </div>
                <div class="div_design">
                <label for="">Product Description: </label>
                <input type="text" class="input_color" name="description" placeholder="Write a Description" required>
                </div>
                <div class="div_design">
                <label for="">Discount Price: </label>
                <input type="number" class="input_color" name="discount_price" placeholder="Write Discount Price">
                </div>
                <div class="div_design">
                <label for="">Product Price: </label>
                <input type="number" class="input_color" name="price" placeholder="Write a Price" required>
                </div>

                <div class="div_design">
                <label for="">Product Quantity: </label>
                <input type="number" min="0" class="input_color" name="quantity" placeholder="Write a Quantity" required>
                </div>
                
                <div class="div_design">
                <label for="">Product Catagory: </label>
                <select name="catagory" id="" class="input_color" required>
                    <option value="" selected>Add a catagory</option>
                    @foreach ($catagory as $catagory)
                     <option value="{{ $catagory->catagory_name }}">{{ $catagory->catagory_name }}</option> 
                    @endforeach
                    
                </select>
                </div class="div_design">
                <div>
                <label for="">Product image: </label>
                <input type="file" name="image" required>
                </div>
                <div class="div_design">
                <input type="submit" value="Add Product" class="btn btn-primary">
                </div>
            </div>
                </form>
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