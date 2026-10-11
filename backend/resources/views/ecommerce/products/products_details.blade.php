@extends('layouts.simple.master')

@section('title', $product->name . ' - Product Details')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/owlcarousel.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ $product->name }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Ecommerce</li>
                        <li class="breadcrumb-item active">{{ $product->name }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid starts-->
    <div class="container-fluid">
        <div>
            <div class="row product-page-main p-0">
                <div class="col-xxl-4 col-md-6 box-col-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-slider owl-carousel owl-theme" id="sync1">
                                @forelse($product->images as $image)
                                    <div class="item">
                                        <figure class="zoom" onmousemove="zoom(event)"
                                            style="background-image: url({{ asset('storage/' . $image->image_path) }})">
                                            <img class="img-fluid" src="{{ asset('storage/' . $image->image_path) }}"
                                                alt="{{ $product->name }}">
                                        </figure>
                                    </div>
                                @empty
                                    <div class="item">
                                        <figure class="zoom" onmousemove="zoom(event)"
                                            style="background-image: url({{ asset('https://res.cloudinary.com/dqi7g7lky/image/upload/v1786526915/652668384_1535948488538751_5811485617926477701_n_1_suo9gv.jpg') }})">
                                            <img class="img-fluid" src="{{ asset('https://res.cloudinary.com/dqi7g7lky/image/upload/v1786526915/652668384_1535948488538751_5811485617926477701_n_1_suo9gv.jpg') }}"
                                                alt="{{ $product->name }}">
                                        </figure>
                                    </div>
                                @endforelse
                            </div>
                            <div class="owl-carousel owl-theme" id="sync2">
                                @forelse($product->images as $image)
                                    <div class="item"><img class="img-fluid"
                                            src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}"></div>
                                @empty
                                    <div class="item"><img class="img-fluid"
                                            src="{{ asset('https://res.cloudinary.com/dqi7g7lky/image/upload/v1786526915/652668384_1535948488538751_5811485617926477701_n_1_suo9gv.jpg') }}" alt="{{ $product->name }}"></div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-5 box-col-12 order-xxl-0 order-1 box-ord-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="product-page-details">
                                <h3>{{ $product->name }}</h3>
                            </div>
                            <div class="product-price">
                                @if($product->sale_price && $product->sale_price < $product->price)
                                    {{ number_format($product->sale_price, 2) }} <del>{{ number_format($product->price, 2) }}</del>
                                @else
                                    {{ number_format($product->price, 2) }}
                                @endif
                            </div>
                            <ul class="product-color">
                                @foreach($product->categories as $category)
                                    <li class="bg-primary"></li>
                                @endforeach
                            </ul>
                            <hr>
                            {!! $product->description ?: '<p>No description available.</p>' !!}
                            <div>
                                <table class="product-page-width">
                                    <tbody>
                                        <tr>
                                            <td> <b>SKU &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $product->sku ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Availability &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b>
                                            </td>
                                            <td class="txt-success f-w-700">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Category &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $product->categories->pluck('name')->implode(', ') ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Tags &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                                            <td>
                                                @if($product->tags->isNotEmpty())
                                                    @foreach($product->tags as $tag)
                                                        <span class="badge bg-primary me-1">{{ $tag->name }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-muted">No tags</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> <b>Price &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td> <b>Stock &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></td>
                                            <td>{{ $product->stock }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <hr>
                            <div class="row g-sm-3 g-1">
                                <div class="col-sm-4">
                                    <h6 class="product-title">Share</h6>
                                </div>
                                <div class="col-sm-8">
                                    <div class="product-icon">
                                        <ul class="product-social">
                                            <li class="d-inline-block"><a href="https://www.facebook.com/mictomonbespoketailor/"
                                                    target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                                            <li class="d-inline-block"><a href="https://in.pinterest.com/"
                                                    target="_blank"><i class="fa-brands fa-pinterest-p"></i></a></li>
                                            <li class="d-inline-block"><a href="https://twitter.com/" target="_blank"><i
                                                        class="fa-brands fa-x-twitter"></i></a></li>
                                            <li class="d-inline-block"><a href="https://www.instagram.com/mictomon_bespoke/"
                                                    target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                                            <li class="d-inline-block"><a href="https://rss.app/" target="_blank"><i
                                                        class="fa-solid fa-rss"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <hr>
                         
                            <hr>
                     
                        </div>
                    </div>
                </div>
                <div class="col-xxl-3 col-md-6 box-col-6">
                    <div class="card">
                        <div class="card-body"><!-- side-bar block start-->
                            <div class="filter-block">
                                <h5>Categories</h5>
                                <ul>
                                    @foreach($product->categories as $category)
                                        <li>{{ $category->name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="collection-filter-block">
                                <ul class="pro-services">
                                    <li>
                                        <div class="d-flex"><i data-feather="truck"></i>
                                            <div class="flex-grow-1">
                                                <h6>Free Shipping </h6><span>Free shipping world wide</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex"><i data-feather="clock"></i>
                                            <div class="flex-grow-1">
                                                <h6>24 X 7 Service </h6><span>Online service for new
                                                    customer</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex"><i data-feather="gift"></i>
                                            <div class="flex-grow-1">
                                                <h6>Festival Offer </h6><span>New online special
                                                    festival</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="d-flex"><i data-feather="credit-card"></i>
                                            <div class="flex-grow-1">
                                                <h6>Online Payment </h6><span>Country to popular belief.
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div><!-- side-bar block end-->
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="row product-page-main">
                <div class="col-sm-12">
                    <ul class="nav nav-tabs border-tab nav-primary mb-0" id="top-tab" role="tablist">
                        <li class="nav-item"><a class="nav-link active" id="top-home-tab" data-bs-toggle="tab"
                                href="#top-home" role="tab" aria-controls="top-home"
                                aria-selected="false">Description</a>
                            <div class="material-border"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="contact-top-tab" data-bs-toggle="tab"
                                href="#top-contact" role="tab" aria-controls="top-contact"
                                aria-selected="true">Additional Info</a>
                            <div class="material-border"></div>
                        </li>
                        <li class="nav-item"><a class="nav-link" id="brand-top-tab" data-bs-toggle="tab"
                                href="#top-brand" role="tab" aria-controls="top-brand" aria-selected="true">Write
                                Review</a>
                            <div class="material-border"></div>
                        </li>
                    </ul>
                    <div class="tab-content" id="top-tabContent">
                        <div class="tab-pane fade active show" id="top-home" role="tabpanel"
                            aria-labelledby="top-home-tab">
                            <div class="info-part">
                                {!! $product->description ?: '<p class="c-o-light">No description available.</p>' !!}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="top-contact" role="tabpanel" aria-labelledby="contact-top-tab">
                            <div class="info-part">
                                {!! $product->description ?: '<p class="c-o-light">No additional info available.</p>' !!}
                            </div>
                            <div class="product-info-table table-responsive custom-scrollbar">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">SKU</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Stock</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $product->sku ?? 'N/A' }}</th>
                                            <td>${{ number_format($product->price, 2) }}</td>
                                            <td>{{ $product->stock }}</td>
                                            <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="top-brand" role="tabpanel" aria-labelledby="brand-top-tab">
                            <div class="review-box">
                                <div class="row g-4">
                                    <div class="col-xl-6">
                                        <div class="product-rating-box">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="common-f-start mb-3">
                                                        <h5 class="main-product-rating">0.0<i
                                                                class="fa-solid fa-star"></i></h5>
                                                        <h6 class="ms-3 c-o-light">0 Overall Rating</h6>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="rating-box">
                                                        <ul>
                                                            <li>
                                                                <div class="rating-list">
                                                                    <h6>5<i class="fa-solid fa-star"></i>
                                                                    </h6>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 0%"></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="rating-list">
                                                                    <h6>4<i class="fa-solid fa-star"></i>
                                                                    </h6>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 0%"></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="rating-list">
                                                                    <h6>3<i class="fa-solid fa-star"></i>
                                                                    </h6>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 0%"></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="rating-list">
                                                                    <h6>2<i class="fa-solid fa-star"></i>
                                                                    </h6>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 0%"></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div class="rating-list">
                                                                    <h6>1 <i class="fa-solid fa-star"></i>
                                                                    </h6>
                                                                    <div class="progress">
                                                                        <div class="progress-bar" role="progressbar"
                                                                            style="width: 0%"></div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="review-title-2">
                                                    <h5>Review this product</h5>
                                                    <p>Let other customers know what you think</p><a
                                                        class="btn btn-primary" href="#!" data-bs-toggle="modal"
                                                        data-bs-target="#write-review-modal">Write a
                                                        Review</a>
                                                    <div class="modal fade" id="write-review-modal" tabindex="-1"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content category-popup custom-input">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Write a Review
                                                                    </h5><button class="btn-close" type="button"
                                                                        data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="product-review-rating">
                                                                        <span>Rating</span>
                                                                        <div class="product-rating main-star-rating">
                                                                            <div class="common-flex star-box">
                                                                                <i class="fa-solid fa-star active"></i><i
                                                                                    class="fa-solid fa-star active"></i><i
                                                                                    class="fa-solid fa-star active"></i><i
                                                                                    class="fa-solid fa-star active"></i><i
                                                                                    class="fa-solid fa-star"></i>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <form class="row g-3 needs-validation" novalidate="">
                                                                        <div class="col-md-12"><label class="form-label"
                                                                                for="validationCustom01">Name</label><input
                                                                                class="form-control"
                                                                                id="validationCustom01" type="text"
                                                                                placeholder="Enter your name"
                                                                                required="">
                                                                            <div class="invalid-feedback">
                                                                                Please enter a name.</div>
                                                                            <div class="valid-feedback">
                                                                                Looks good!</div>
                                                                        </div>
                                                                        <div class="col-12"> <label class="form-label"
                                                                                for="validationTextarea">Your
                                                                                Review</label>
                                                                            <textarea class="form-control" id="validationTextarea" placeholder="Enter your review" required=""></textarea>
                                                                            <div class="invalid-feedback">
                                                                                Please enter a review in the
                                                                                textarea.</div>
                                                                        </div>
                                                                        <div class="col-12"><button
                                                                                class="btn btn-primary"
                                                                                type="submit">Submit
                                                                                Review</button></div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="review-people">
                                            <ul class="review-list custom-scrollbar">
                                                <li>
                                                    <div class="people-box"><img class="img-fluid"
                                                            src="{{ asset('assets/images/dashboard-11/user/1.jpg') }}"
                                                            alt="">
                                                        <div class="people-comment">
                                                            <div class="people-name">
                                                                <div><a class="name" href="#!">Scarlet</a><span
                                                                        class="c-o-light">({{ $product->name }})</span></div>
                                                                <div class="product-rating">
                                                                    <div class="common-flex"><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i>
                                                                    </div>
                                                                </div>
                                                                <h6 class="text-content">03 Feb, 2024</h6>
                                                            </div>
                                                            <div class="reply">
                                                                <p>I adore this outfit! The print is
                                                                    stunning, and the fabric is incredibly
                                                                    smooth and flowing. It's ideal for a
                                                                    night out or summer weddings. Just be
                                                                    mindful that the straps are little
                                                                    adjustable, so you may need fashion tape
                                                                    for piece of mind if you're busty.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="people-box"><img class="img-fluid"
                                                            src="{{ asset('assets/images/dashboard-11/user/2.jpg') }}"
                                                            alt="">
                                                        <div class="people-comment">
                                                            <div class="people-name">
                                                                <div><a class="name" href="#!">Arya</a><span
                                                                        class="c-o-light">({{ $product->name }})</span>
                                                                </div>
                                                                <div class="product-rating">
                                                                    <div class="common-flex"><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star"></i>
                                                                    </div>
                                                                </div>
                                                                <h6 class="text-content">24 May, 2024</h6>
                                                            </div>
                                                            <div class="reply">
                                                                <p>This tee is a fantastic basic. For warmer
                                                                    days, the lightweight, breathable linen
                                                                    is ideal. You might want to go down if
                                                                    you like a more tailored look because
                                                                    the fit is a little boxy. All in all,
                                                                    this is a versatile shirt that I will
                                                                    wear often.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="people-box"><img class="img-fluid"
                                                            src="{{ asset('assets/images/dashboard-11/user/3.jpg') }}"
                                                            alt="">
                                                        <div class="people-comment">
                                                            <div class="people-name">
                                                                <div><a class="name" href="#!">Kyro</a><span
                                                                        class="c-o-light">({{ $product->name }})</span></div>
                                                                <div class="product-rating">
                                                                    <div class="common-flex"><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star"></i><i
                                                                            class="fa-solid fa-star"></i>
                                                                    </div>
                                                                </div>
                                                                <h6 class="text-content">30 Jun, 2024</h6>
                                                            </div>
                                                            <div class="reply">
                                                                <p>What a letdown this jacket is. In person,
                                                                    the wash is more rigid and dark than it
                                                                    appears in the photo, which is retro and
                                                                    stylish. I got a medium, but it seems
                                                                    more like a small. The size is also
                                                                    incorrect. Returning it in
                                                                    disappointment.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="people-box"><img class="img-fluid"
                                                            src="{{ asset('assets/images/dashboard-11/user/8.jpg') }}"
                                                            alt="">
                                                        <div class="people-comment">
                                                            <div class="people-name">
                                                                <div><a class="name" href="#!">Izabella</a><span
                                                                        class="c-o-light">({{ $product->name }})</span></div>
                                                                <div class="product-rating">
                                                                    <div class="common-flex"><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star fill"></i><i
                                                                            class="fa-solid fa-star"></i>
                                                                    </div>
                                                                </div>
                                                                <h6 class="text-content">18 Dec, 2024</h6>
                                                            </div>
                                                            <div class="reply">
                                                                <p>There is nothing but luxury about this
                                                                    jumper. It feels of excellent quality,
                                                                    and the cashmere is wonderfully warm and
                                                                    cuddly. It's a classic piece with a long
                                                                    lifespan. incredibly elegant and comfy,
                                                                    ideal for chilly days.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid Ends-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/touchspin_2/custom_touchspin.js') }}"></script>
    <script src="{{ asset('assets/js/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/js/ecommerce.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation-custom.js') }}"></script>
    <script src="{{ asset('assets/js/custom_zoom_magnifier.js') }}"></script>
@endsection
