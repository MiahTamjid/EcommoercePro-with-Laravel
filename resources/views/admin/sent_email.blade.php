<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="/public">
    <!-- Required meta tags -->
   @include('admin.css')
   <style>
    label{
      display: inline-block;
      width: 200px;
      font-size: 15px;
      font-weight: bold;
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

            @if (session()->has('sent_mail_massage'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('sent_mail_massage') }}
            </div>
            @endif

            <h1 style="text-align:center; font-size:25px">Sent Email to {{ $order->email }}</h1>
            <form action="{{ url('sent_user_email',$order->id) }}" method="POST">

              @csrf

              <div style="padding-left: 35%; padding-top:30px">
              <label for="">Email Greeting: </label>
              <input style="color: black;" type="text" name="greeting">
            </div>

            <div style="padding-left: 35%; padding-top:30px">
              <label for="">Email Firstline: </label>
              <input style="color: black;" type="text" name="firstline">
            </div>

            <div style="padding-left: 35%; padding-top:30px">
              <label for="">Email Body: </label>
              <input style="color: black;" type="text" name="body">
            </div>
            <div style="padding-left: 35%; padding-top:30px">
              <label for="">Email Button Name: </label>
              <input style="color: black;" type="text" name="button">
            </div>
            <div style="padding-left: 35%; padding-top:30px">
              <label for="">Email Url: </label>
              <input style="color: black;" type="text" name="url">
            </div>
            <div style="padding-left: 35%; padding-top:30px">
              <label for="">Email Last Line: </label>
              <input style="color: black;" type="text" name="lastline">
            </div>
            <div style="padding-left: 35%; padding-top:30px">
              
              <input type="submit" value="Sent Mail" class="btn btn-primary">
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