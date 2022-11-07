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
      <!-- javascript cdn link -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   </head>
   <body>
      @include('sweetalert::alert')
      <div class="hero_area">
         
         <!-- header section strats -->
         @include('home.header')
         <!-- end header section -->
         <!-- slider section -->
         @include('home.slider')
         <!-- end slider section -->
      </div>

      <!-- why section -->
      @include('home.why')
      <!-- end why section -->
      
      <!-- arrival section -->
      @include('home.new_arival')
      <!-- end arrival section -->
      
      <!-- product section -->
      @include('home.product')
      <!-- end product section -->
      <!-- comments section -->
      <div style="text-align: center; padding-bottom:30px">
         <h1 style="font-size: 30px; text-align:center; padding-top:20px; padding-bottom:20px;"> 
            Comments
         </h1>

         <form action="{{ url('add_comment') }}" method="POST">
            @csrf
         <textarea style="height: 150px; width:600px;" placeholder="Write Something Comments.." name="comment"></textarea>
         <input type="submit" class="btn btn-primary" value="Comment">
      </form>
      </div>
      
         
     
      <div style="padding-left: 300px;">
         <h1 style="font-size: 20px; padding-bottom:20px">All Comments</h1>

       @foreach ($comment as $comment)
          
       
      <div>
         <b style="color: blue">{{ $comment->name }}</b>
         <p>{{ $comment->comment }}</p>
         <a href="javascript::void(0)" onclick="reply(this)" style="color: rgb(23, 174, 172)" data-Commentid="{{ $comment->id }}">Reply</a>
      </div>
      @foreach ($reply as $rep)
         @if ($rep->comment_id==$comment->id)
            
        
      
      <div style="padding-left: 3%; padding-bottom:10px; ">
         <b>{{ $rep->name }}</b>
         <p>{{ $rep->reply }}</p>
         <a href="javascript::void(0)" onclick="reply(this)" style="color: rgb(23, 174, 172)" data-Commentid="{{ $comment->id }}">Reply</a>
      </div>
      @endif
      @endforeach
   
      @endforeach 
      <!-- Reply Textbox -->
      <div style="display: none" class="replyDiv">
         <form action="{{ url('add_reply') }}" method="POST">
            @csrf
         <input type="text" name="commentId" id="commentId" hidden>
         <textarea name="reply" id="" cols="30" rows="1" placeholder="Write Something Here.."></textarea>
         <br>
         <button class="btn btn-warning" type="submit">Reply</button>
         <a href="javascript::void(0)" class="btn" onclick="reply_close(this)">Close</a>
      </form>
      </div>
      
   </div>
   
      <!-- end comments section -->
      <!-- subscribe section -->
      @include('home.subscribe')
      <!-- end subscribe section -->
      <!-- client section -->
     @include('home.client')
      <!-- end client section -->
      <!-- footer start -->
      @include('home.footer')
      <!-- footer end -->
      <div class="cpy_">
         <p class="mx-auto">© 2021 All Rights Reserved By <a href="https://html.design/">Free Html Templates</a><br>
         
            Distributed By <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
         
         </p>
      </div>

      <script>
         function reply(caller){
            document.getElementById('commentId').value=$(caller).attr('data-Commentid');
            $('.replyDiv').insertAfter($(caller));
            $('.replyDiv').show();
         }
         function reply_close(caller){
            
            $('.replyDiv').hide();
         }
      </script>

   <script>
   document.addEventListener("DOMContentLoaded", function (event) {
       var scrollpos = sessionStorage.getItem('scrollpos');
       if (scrollpos) {
           window.scrollTo(0, scrollpos);
           sessionStorage.removeItem('scrollpos');
       }
   });

   window.addEventListener("beforeunload", function (e) {
       sessionStorage.setItem('scrollpos', window.scrollY);
   });
   </script>
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