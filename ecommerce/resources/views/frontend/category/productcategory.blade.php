@include('frontend.layouts.header')
<div class="container">
    <div class="row">
        <div class="col-sm-3">
            <div class="left-sidebar">
                <h2>Category</h2>
                <div class="panel-group category-products" id="accordian"><!--category-productsr-->
                    @foreach($categories as $categories)
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordian" href="#sportswear">
                                        <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                                        {{$categories->categories_name}}
                                    </a>
                                </h4>
                            </div>
                        </div>
                    @endforeach

                </div><!--/category-products-->

                <div class="brands_products"><!--brands_products-->
                    <h2>Brands</h2>
                        <div class="brands-name">
                            <ul class="nav nav-pills nav-stacked">
                                <li><a href="#">Town <span class="pull-right">(50)</span></a></li>

                            </ul>
                        </div>
                </div><!--/brands_products-->

                <div class="price-range"><!--price-range-->
                    <h2>Price Range</h2>
                    <div class="well text-center">
                        <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="600" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />
                        <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
                    </div>
                </div><!--/price-range-->

                <div class="shipping text-center"><!--shipping-->
                    <img src="{{asset('').'/public/frontend/images/home/shipping.jpg' }}" alt="" />
                </div><!--/shipping-->

            </div>
        </div>
<div class="category-tab"><!--category-tab-->
    <div class="col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tshirt" data-toggle="tab">All Category</a></li>

        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade active in" id="tshirt" >
            @foreach($product_category as $item)
            <div class="col-sm-3">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <img src="{{asset('').$item->products_image }}" alt="" />
                            <h2>{{$item->products_name}}</h2>
                            <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add To Cart</a>
                        </div>

                    </div>
                </div>
            </div>
@endforeach

        </div>


    </div>
</div><!--/category-tab-->
    </div>
</div>
@include('frontend.layouts.footer')