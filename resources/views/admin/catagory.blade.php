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
.table_center{
    margin: auto;
    width: 50%;
    margin-top: 30px;
    text-align: center;
    border: 3px solid green;
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

            @if (session()->has('message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('message') }}
            </div>
            @endif
            @if (session()->has('delete_message'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('delete_message') }}
            </div>
            @endif

            <div class="div_center">
                <h2 class="h2_font">Add Catagory</h2>
                <form action="{{ url('/add_catagory') }}" method="POST">
                    @csrf
                    <input type="text" name="catagory" placeholder="Write Catagory Name" class="input_color">
                    <input type="submit" name="submit" value="Add Catagory" class="btn btn-primary" >
                </form>
            </div>
                    <table class="table_center">
                        <tr>
                            <td>Catagory Name</td>
                            <td>Action</td>
                        </tr>
                        @foreach ( $data as $data )
                            
                        
                        <tr>
                            <td>{{ $data->catagory_name }}</td>
                            <td><a onclick="return confirm('Are you sure to Delete data!')" href="{{ url('delete_catagory',$data->id) }}" class="btn btn-danger">Delete</a></td>
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