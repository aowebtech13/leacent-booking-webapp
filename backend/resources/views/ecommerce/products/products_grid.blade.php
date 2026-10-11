@extends('layouts.simple.master')

@section('title', 'Product Grid')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/range-slider.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Product Grid</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Ecommerce</li>
                        <li class="breadcrumb-item active">Product Grid</li>
                    </ol>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid starts-->
    <div class="container-fluid product-wrapper">
        <div class="product-grid">
            <div class="feature-products">
                <div class="common-f-start justify-content-md-end mb-3"><a class="btn btn-primary f-w-500"
                        href="{{ route('admin.add_products') }}"><i class="fa fa-plus pe-2"></i>Add Products</a></div>
                <div class="row">
                    <div class="col-md-6 products-total">
                        <div class="square-product-setting d-inline-block"><a class="icon-grid grid-layout-view"
                                href="#" data-original-title="" title=""><i data-feather="grid"></i></a></div>
                        <div class="square-product-setting d-inline-block"><a class="icon-grid m-0 list-layout-view"
                                href="#" data-original-title="" title=""><i data-feather="list"></i></a></div>
                        <div class="grid-options d-inline-block">
                            <ul>
                                <li><a class="product-2-layout-view" href="#" data-original-title=""
                                        title=""><span class="line-grid line-grid-1 bg-primary"></span><span
                                            class="line-grid line-grid-2 bg-primary"></span></a></li>
                                <li><a class="product-3-layout-view" href="#" data-original-title=""
                                        title=""><span class="line-grid line-grid-3 bg-primary"></span><span
                                            class="line-grid line-grid-4 bg-primary"></span><span
                                            class="line-grid line-grid-5 bg-primary"></span></a></li>
                                <li><a class="product-4-layout-view" href="#" data-original-title=""
                                        title=""><span class="line-grid line-grid-6 bg-primary"></span><span
                                            class="line-grid line-grid-7 bg-primary"></span><span
                                            class="line-grid line-grid-8 bg-primary"></span><span
                                            class="line-grid line-grid-9 bg-primary"></span></a></li>
                                <li><a class="product-6-layout-view" href="#" data-original-title=""
                                        title=""><span class="line-grid line-grid-10 bg-primary"></span><span
                                            class="line-grid line-grid-11 bg-primary"></span><span
                                            class="line-grid line-grid-12 bg-primary"></span><span
                                            class="line-grid line-grid-13 bg-primary"></span><span
                                            class="line-grid line-grid-14 bg-primary"></span><span
                                            class="line-grid line-grid-15 bg-primary"></span></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end"><span class="f-w-600 m-r-5">Showing Products {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} Of {{ $products->total() }} Results</span>
                        <div class="d-inline-block dropdown-product"><select class="form-select"
                                aria-label="Default select example">
                                <option value="1">Featured</option>
                                <option value="2">Lowest Prices</option>
                                <option value="3">Highest Prices</option>
                            </select></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6">
                        <div class="product-sidebar">
                            <div class="filter-section">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-0 f-w-600">Filters<span class="pull-right"><i
                                                    class="fa fa-chevron-down toggle-data"></i></span></h6>
                                    </div>
                                    <div class="left-filter">
                                        <div class="card-body filter-cards-view animate-chk">
                                            <div class="product-filter">
                                                <h6 class="f-w-600">Category</h6>
                                                <div class="checkbox-animated mt-0"><label class="d-block"
                                                        for="edo-ani5"><input class="radio_animated" id="edo-ani5"
                                                            type="radio" data-original-title="" title="">Man
                                                        Shirt</label><label class="d-block" for="edo-ani6"><input
                                                            class="radio_animated" id="edo-ani6" type="radio"
                                                            data-original-title="" title="">Man
                                                        Jeans</label><label class="d-block" for="edo-ani7"><input
                                                            class="radio_animated" id="edo-ani7" type="radio"
                                                            data-original-title="" title="">Woman
                                                        Top</label><label class="d-block" for="edo-ani8"><input
                                                            class="radio_animated" id="edo-ani8" type="radio"
                                                            data-original-title="" title="">Woman
                                                        Jeans</label><label class="d-block" for="edo-ani9"><input
                                                            class="radio_animated" id="edo-ani9" type="radio"
                                                            data-original-title="" title="">Man
                                                        T-shirt</label></div>
                                            </div>
                                            <div class="product-filter">
                                                <h6 class="f-w-600">Brand</h6>
                                                <div class="checkbox-animated mt-0"><label class="d-block"
                                                        for="chk-ani"><input class="checkbox_animated" id="chk-ani"
                                                            type="checkbox" data-original-title="" title="">
                                                        Levi's</label><label class="d-block" for="chk-ani1"><input
                                                            class="checkbox_animated" id="chk-ani1" type="checkbox"
                                                            data-original-title="" title="">Diesel</label><label
                                                        class="d-block" for="chk-ani2"><input class="checkbox_animated"
                                                            id="chk-ani2" type="checkbox" data-original-title=""
                                                            title="">Lee</label><label class="d-block"
                                                        for="chk-ani3"><input class="checkbox_animated" id="chk-ani3"
                                                            type="checkbox" data-original-title=""
                                                            title="">Hudson</label><label class="d-block"
                                                        for="chk-ani4"><input class="checkbox_animated" id="chk-ani4"
                                                            type="checkbox" data-original-title=""
                                                            title="">Denizen</label><label class="d-block"
                                                        for="chk-ani5"><input class="checkbox_animated" id="chk-ani5"
                                                            type="checkbox" data-original-title=""
                                                            title="">Spykar</label>
                                                </div>
                                            </div>
                                            <div class="product-filter slider-product">
                                                <h6 class="f-w-600">Colors</h6>
                                                <div class="color-selector">
                                                    <ul>
                                                        <li class="white"></li>
                                                        <li class="black"></li>
                                                        <li class="orange"></li>
                                                        <li class="green"></li>
                                                        <li class="pink"></li>
                                                        <li class="yellow"></li>
                                                        <li class="blue"></li>
                                                        <li class="red"></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-filter pb-0 product-range">
                                                <h6 class="f-w-600">Price</h6><input id="u-range-03" type="text">
                                            </div>
                                            <div class="product-filter">
                                                <h6 class="f-w-600">Discount</h6>
                                                <div class="checkbox-animated mt-0">
                                                    <div class="form-check"><input class="checkbox_animated"
                                                            id="chk-ani6" type="checkbox" data-original-title=""
                                                            title=""><label class="form-check-label"
                                                            for="chk-ani6"> <span class="name">upto 5%</span><span
                                                                class="number">(06)</span></label></div>
                                                    <div class="form-check"><input class="checkbox_animated"
                                                            id="chk-ani7" type="checkbox" data-original-title=""
                                                            title=""><label class="form-check-label"
                                                            for="chk-ani7"><span class="name">5% - 10%</span><span
                                                                class="number">(12)</span></label></div>
                                                    <div class="form-check"><input class="checkbox_animated"
                                                            id="chk-ani8" type="checkbox" data-original-title=""
                                                            title=""><label class="form-check-label"
                                                            for="chk-ani8"><span class="name">10% - 15%</span><span
                                                                class="number">(20)</span></label></div>
                                                    <div class="form-check"><input class="checkbox_animated"
                                                            id="chk-ani9" type="checkbox" data-original-title=""
                                                            title=""><label class="form-check-label"
                                                            for="chk-ani9"><span class="name"> 15% - 25%</span><span
                                                                class="number">(22)</span></label></div>
                                                    <div class="form-check"><input class="checkbox_animated"
                                                            id="chk-ani10" type="checkbox" data-original-title=""
                                                            title=""><label class="form-check-label"
                                                            for="chk-ani10"><span class="name">More than 25%</span><span
                                                                class="number">(24)</span></label></div>
                                                </div>
                                            </div>
                                            <div class="product-filter">
                                                <h6 class="f-w-600">Rating</h6>
                                                <div class="checkbox-animated mt-0 product-rate">
                                                    <div class="form-check"><input class="checkbox_animated"
                                                            id="chk-ani11" type="checkbox" data-original-title=""
                                                            title=""><label class="form-check-label"
                                                            for="chk-ani11"><span class="common-flex"><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-solid fa-star fill"></i></span><span
                                                                class="number">(5 Star)</span></label></div>
                                                    <div class="form-check"><input class="checkbox_animated"
                                                            id="chk-ani12" type="checkbox" data-original-title=""
                                                            title=""><label class="form-check-label"
                                                            for="chk-ani12"><span class="common-flex"><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-regular fa-star fill"></i></span><span
                                                                class="number">(4 Star)</span></label></div>
                                                    <div class="form-check"><input class="checkbox_animated"
                                                            id="chk-ani13" type="checkbox" data-original-title=""
                                                            title=""><label class="form-check-label"
                                                            for="chk-ani13"><span class="common-flex"><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-regular fa-star fill"></i><i
                                                                    class="fa-regular fa-star fill"></i></span><span
                                                                class="number">(3 Star)</span></label></div>
                                                    <div class="form-check"><input class="checkbox_animated"
                                                            id="chk-ani14" type="checkbox" data-original-title=""
                                                            title=""><label class="form-check-label"
                                                            for="chk-ani14"><span class="common-flex"><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-regular fa-star fill"></i><i
                                                                    class="fa-regular fa-star fill"></i><i
                                                                    class="fa-regular fa-star fill"></i></span><span
                                                                class="number">(2 Star)</span></label></div>
                                                    <div class="form-check"><input class="checkbox_animated"
                                                            id="chk-ani15" type="checkbox" data-original-title=""
                                                            title=""><label class="form-check-label"
                                                            for="chk-ani15"><span class="common-flex"><i
                                                                    class="fa-solid fa-star fill"></i><i
                                                                    class="fa-regular fa-star fill"></i><i
                                                                    class="fa-regular fa-star fill"></i><i
                                                                    class="fa-regular fa-star fill"></i><i
                                                                    class="fa-regular fa-star fill"></i></span><span
                                                                class="number">(1 Star)</span></label></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-12">
                        <form>
                            <div class="form-group m-0"><input class="form-control" type="search"
                                    placeholder="Search.." data-original-title="" title=""><i
                                    class="fa fa-search"></i></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="product-wrapper-grid">
                <div class="row">
                    @forelse($products as $product)
                        @php
                            $primaryImage = $product->images->first();
                            $imagePath = $primaryImage ? asset('storage/' . $primaryImage->image_path) : asset('https://res.cloudinary.com/dqi7g7lky/image/upload/v1786526915/652668384_1535948488538751_5811485617926477701_n_1_suo9gv.jpg');
                            $hasSale = $product->sale_price && $product->sale_price < $product->price;
                            $discountPercent = $hasSale ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
                        @endphp
                        <div class="col-xxl-3 col-md-4 col-sm-6 box-col-4">
                            <div class="card">
                                <div class="product-box">
                                    <div class="product-img">
                                        @if($hasSale)
                                            <div class="ribbon ribbon-success ribbon-right">{{ $discountPercent }}%</div>
                                        @endif
                                        <img class="img-fluid" src="{{ $imagePath }}" alt="{{ $product->name }}">
                                        <div class="product-hover"></div>
                                    </div>
                                    <div class="modal fade" id="productModal{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="productModal{{ $product->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="product-box row">
                                                        <div class="product-img col-lg-6">
                                                            <img class="img-fluid" src="{{ $imagePath }}" alt="{{ $product->name }}">
                                                        </div>
                                                        <div class="col-lg-6 text-start">
                                                            <div class="product-details">
                                                                <h4>{{ $product->name }}</h4>
                                                                <div class="product-price">
                                                                    @if($hasSale)
                                                                        {{ number_format($product->sale_price, 2) }}<del>{{ number_format($product->price, 2) }}</del>
                                                                    @else
                                                                        {{ number_format($product->price, 2) }}
                                                                    @endif
                                                                </div>
                                                                <div class="product-view">
                                                                    <h6 class="f-w-500">Product Details</h6>
                                                                    {!! $product->description ?: '<p class="mb-0">No description available.</p>' !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product-details">
                                    <div class="rating">
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-solid fa-star"></i>
                                        <i class="fa-regular fa-star"></i>
                                    </div>
                                    <a href="{{ route('admin.products_details', $product->id) }}">
                                        <h4>{{ $product->name }}</h4>
                                    </a>
                                    <p>{{ $product->description ? \Illuminate\Support\Str::limit(strip_tags($product->description), 50) : 'No description' }}</p>
                                    <div class="product-price">
                                        @if($hasSale)
                                            {{ number_format($product->sale_price, 2) }} <del>{{ number_format($product->price, 2) }}</del>
                                        @else
                                            {{ number_format($product->price, 2) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="text-center">No products found.</p>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($products->hasPages())
                    <div class="row">
                        <div class="col-12">
                            <div class="pagination-wrapper">
                                {{ $products->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div><!-- Container-fluid Ends-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/range-slider/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/js/range-slider/rangeslider-script.js') }}"></script>
    <script src="{{ asset('assets/js/touchspin_2/custom_touchspin.js') }}"></script>
    <script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
    <script src="{{ asset('assets/js/product-tab.js') }}"></script>
    <script src="{{ asset('assets/js/common-color-selector.js') }}"></script>
@endsection
