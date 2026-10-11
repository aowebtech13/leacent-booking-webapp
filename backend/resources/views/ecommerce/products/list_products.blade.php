@extends('layouts.simple.master')

@section('title', 'Product List')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select.bootstrap5.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/range-slider.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3> Product List</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Ecommerce</li>
                        <li class="breadcrumb-item active">Product List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid starts-->
    <div class="container-fluid list-product-view product-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="row g-3">
                    <div class="col-md-3 col-sm-6">
                        <div class="product-sidebar">
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-no-border text-end">
                        <div class="card-header-right-icon"><a class="btn btn-primary f-w-500"
                                href="{{ route('admin.add_products') }}"><i class="fa fa-plus pe-2"></i>Add Products</a>
                        </div>
                    </div>
                    <div class="card-body px-0 pt-0">
                        <div class="list-product">
                            <div class="recent-table table-responsive custom-scrollbar product-list-table">
                                <table class="table" id="product-list-view">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th> <span class="c-o-light f-w-600">Product Name</span></th>
                                            <th> <span class="c-o-light f-w-600">SKU</span></th>
                                            <th> <span class="c-o-light f-w-600">Category</span></th>
                                            <th> <span class="c-o-light f-w-600">Price</span></th>
                                            <th> <span class="c-o-light f-w-600">Qty</span></th>
                                            <th> <span class="c-o-light f-w-600">Status</span></th>
                                            <th> <span class="c-o-light f-w-600">Rating</span></th>
                                            <th> <span class="c-o-light f-w-600">Action</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $product)
                                        <tr class="product-removes">
                                            <td></td>
                                            <td>
                                                <div class="product-names">
                                                    @php
                                                        $primaryImage = $product->images->first();
                                                        $imagePath = $primaryImage ? asset('storage/' . $primaryImage->image_path) : asset('https://res.cloudinary.com/dqi7g7lky/image/upload/v1786526915/652668384_1535948488538751_5811485617926477701_n_1_suo9gv.jpg');
                                                    @endphp
                                                    <div class="light-product-box"><img class="img-fluid"
                                                            src="{{ $imagePath }}"
                                                            alt="{{ $product->name }}"></div><a href="{{ route('admin.products_details', $product->id) }}">{{ $product->name }}</a>
                                                </div>
                                            </td>
                                            <td>
                                                <p class="c-o-light">{{ $product->sku ?? 'N/A' }}</p>
                                            </td>
                                            <td>
                                                <p class="c-o-light">{{ $product->categories->pluck('name')->implode(', ') ?? 'N/A' }}</p>
                                            </td>
                                            <td>
                                                <p class="c-o-light">{{ number_format($product->price, 2) }}</p>
                                            </td>
                                            <td>
                                                <p class="c-o-light">{{ $product->stock }}</p>
                                            </td>
                                            <td> <span class="badge badge-light-{{ $product->stock > 0 ? 'primary' : 'secondary' }}">{{ $product->stock > 0 ? 'In Stock' : 'Sold Out' }}</span>
                                            </td>
                                            <td>
                                                <div class="rating"><i class="fa-solid fa-star txt-warning"></i><i
                                                        class="fa-solid fa-star txt-warning"></i><i
                                                        class="fa-solid fa-star txt-warning"></i><i
                                                        class="fa-solid fa-star txt-warning"></i><i
                                                        class="fa-regular fa-star txt-warning"></i></div>
                                            </td>
                                            <td>
                                                <div class="product-action"><a class="square-white"
                                                        href="{{ route('admin.products.edit', $product->id) }}"> <svg>
                                                            <use
                                                                href="{{ asset('assets/svg/icon-sprite.svg#edit-content') }}">
                                                            </use>
                                                        </svg></a><a class="square-white trash-3" href="#!" data-url="{{ route('admin.products.destroy', $product->id) }}">
                                                        <svg>
                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#trash1') }}">
                                                            </use>
                                                        </svg></a></div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <p class="text-center">No products found.</p>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid Ends-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/dataTables.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/dataTables.select.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/select.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/datatable/datatables/datatable.custom.js') }}"></script>
    <script src="{{ asset('assets/js/range-slider/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('assets/js/range-slider/rangeslider-script.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/trash_popup.js') }}"></script>
    <script src="{{ asset('assets/js/common-color-selector.js') }}"></script>
@endsection
