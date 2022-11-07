<section class="product_section layout_padding">
         <div class="container">
            <div class="heading_container heading_center">
               <h2>
                  Our <span>products</span>
               </h2>
               <br>
               <div>
                  <form action="{{ url('product_search') }}" method="GET">
                     @csrf
                     <input type="text" name="search" placeholder="Search For Something" style="width: 500px">
                     <input type="submit" value="search">
                  </form>
               </div>
            </div>
            {{-- @if (session()->has('product_add_massage'))
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                {{ session()->get('product_add_massage') }}
            </div>
            @endif --}}
            <div class="row">
               @foreach ($product as $products)
                  
              
               <div class="col-sm-6 col-md-4 col-lg-4">
                  <div class="box">
                     <div class="option_container">
                        <div class="options">
                           <a href="{{ url('product_details',$products->id) }}" class="option1">
                           Product Details
                           </a>
                           <form action="{{ url('add_card',$products->id) }}" method="POST">
                              @csrf
                              <div>
                                 <div>
                                    <input type="number" value="1" min="1" name="quantity">
                                 </div>
                                 <div>
                                    <input type="submit" value="Add To Card">
                                 </div>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div class="img-box">
                        <img src="product/{{ $products->image }}" alt="">
                     </div>
                     <div class="detail-box">
                        <h5>
                           {{ $products->title }}
                        </h5>

                        @if ($products->discount_price!=null)
                         <h6 style="color: red">
                            ${{ $products->discount_price }}
                        </h6>
                        

                        <h6 style="text-decoration: line-through; color:blue">
                            ${{ $products->price }}
                        </h6>

                        @else
                        <h6 style="color: blue">
                            ${{ $products->price }}
                        </h6>  
                        @endif
                  

                     </div>
                  </div>
               </div>
                @endforeach
                <span style="margin-top: 10px">
                  {!! $product->withQueryString()->links('pagination::bootstrap-5') !!}
                </span>
         </div>
      </section>