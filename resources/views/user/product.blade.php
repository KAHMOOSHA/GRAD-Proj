<div class="latest-products">
      <div class="container">
      @if(Session('msg'))
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>{{Session('msg')}}</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @endif
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Latest Products</h2>
              <a href="products.html">view all products <i class="fa fa-angle-right"></i></a>
            <form action="{{url('search')}}" method="get" class="form-inline" style="float: right; padding: 10px">
            @csrf
              <input class="form-conntrol" type="search" name="search" placeholder="search">
            <input type="submit" value="search" class="btn btn-success">
            </form>
           
            </div>
          </div>
          @foreach ($data as $product )
          <div class="col-md-4">
            <div class="product-item">
              <a href="#"><img height="350" width="140" src="/productimage/{{$product->image}}" alt=""></a>
              <div class="down-content">
                <a href="#"><h4>{{$product->title}}</h4></a>
                <h6>{{$product->price}}</h6>
                <p>{{$product->description}}</p>
                 
               <form action="{{url('addcart',$product->id)}}" method="post">
                 @csrf
                 <input type="number" value="1" min="1" class="form-control mb-3" style=" width: 80px" name="quantity">
                 <input class="btn btn-primary" type="submit" value="Add Cart">  
               </form>
              </div>
            </div>
          </div>
          @endforeach
@if (method_exists($data,'links'))
  

          <div class="d-flex justify-content-center">
                {!! $data->links() !!}
          </div>

          @endif

        </div>
      </div>
    </div>