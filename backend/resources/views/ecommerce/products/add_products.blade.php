@extends('layouts.simple.master')

@section('title', 'Add products')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/quill.snow.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/intltelinput.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/tagify.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select/bootstrap-select.min.css') }}">
    <style>
        .product-image-card {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            border: 2px solid #dee2e6;
            transition: all 0.3s ease;
        }
        .product-image-card:hover {
            border-color: #0d6efd;
        }
        .product-image-card img {
            transition: transform 0.3s ease;
        }
        .product-image-card:hover img {
            transform: scale(1.05);
        }
        .product-image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .product-image-card:hover .product-image-overlay {
            opacity: 1;
        }
        .product-image-card.removing {
            opacity: 0.5;
            border-color: #dc3545;
        }
        .new-image-preview {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
            border: 2px dashed #0d6efd;
            min-height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
        }
        .new-image-preview img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .new-image-preview .remove-preview {
            position: absolute;
            top: 5px;
            right: 5px;
        }
    </style>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Add Product</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Ecommerce</li>
                        <li class="breadcrumb-item active">Add Product</li>
                    </ol>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Product Form</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-xl-5 g-3">
                            <div class="col-xxl-3 col-xl-4 box-col-4e sidebar-left-wrapper">
                                <ul class="sidebar-left-icons nav nav-pills" id="add-product-pills-tab" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" id="detail-product-tab"
                                            data-bs-toggle="pill" href="#detail-product" role="tab"
                                            aria-controls="detail-product" aria-selected="false">
                                            <div class="nav-rounded">
                                                <div class="product-icons"><svg class="stroke-icon">
                                                        <use
                                                            href="{{ asset('assets/svg/icon-sprite.svg#product-detail') }}">
                                                        </use>
                                                    </svg></div>
                                            </div>
                                            <div class="product-tab-content">
                                                <h6>Add Product Details</h6>
                                                <p>Add product name & details</p>
                                            </div>
                                        </a></li>
                                    <li class="nav-item"> <a class="nav-link" id="gallery-product-tab" data-bs-toggle="pill"
                                            href="#gallery-product" role="tab" aria-controls="gallery-product"
                                            aria-selected="false">
                                            <div class="nav-rounded">
                                                <div class="product-icons"><svg class="stroke-icon">
                                                        <use
                                                            href="{{ asset('assets/svg/icon-sprite.svg#product-gallery') }}">
                                                        </use>
                                                    </svg></div>
                                            </div>
                                            <div class="product-tab-content">
                                                <h6>Product Gallery</h6>
                                                <p>Thumbnail & add product gallery</p>
                                            </div>
                                        </a></li>
                                    <li class="nav-item"> <a class="nav-link" id="category-product-tab"
                                            data-bs-toggle="pill" href="#category-product" role="tab"
                                            aria-controls="category-product" aria-selected="false">
                                            <div class="nav-rounded">
                                                <div class="product-icons"><svg class="stroke-icon">
                                                        <use
                                                            href="{{ asset('assets/svg/icon-sprite.svg#product-category') }}">
                                                        </use>
                                                    </svg></div>
                                            </div>
                                            <div class="product-tab-content">
                                                <h6>Product Categories</h6>
                                                <p>Add Book Category, status and tags</p>
                                            </div>
                                        </a></li>
                                    <li class="nav-item"><a class="nav-link" id="pricings-tab" data-bs-toggle="pill"
                                            href="#pricings" role="tab" aria-controls="pricings" aria-selected="false">
                                            <div class="nav-rounded">
                                                <div class="product-icons"><svg class="stroke-icon">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#pricing') }}">
                                                        </use>
                                                    </svg></div>
                                            </div>
                                            <div class="product-tab-content">
                                                <h6>Product Price & Discount</h6>
                                                <p>Add product basic price & discount</p>
                                            </div>
                                        </a></li>
                                    <li class="nav-item"><a class="nav-link" id="advance-product-tab"
                                            data-bs-toggle="pill" href="#advance-product" role="tab"
                                            aria-controls="advance-product" aria-selected="false">
                                            <div class="nav-rounded">
                                                <div class="product-icons"><svg class="stroke-icon">
                                                        <use href="{{ asset('assets/svg/icon-sprite.svg#advance') }}">
                                                        </use>
                                                    </svg></div>
                                            </div>
                                            <div class="product-tab-content">
                                                <h6>Additional Options</h6>
                                                <p>Inventory & SEO settings</p>
                                            </div>
                                        </a></li>
                                </ul>
                            </div>
                            <div class="col-xxl-9 col-xl-8 box-col-8 position-relative">
                                <form id="add-product-form" action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @if(isset($product))
                                        @method('PUT')
                                    @endif
                                    <div class="tab-content custom-input" id="add-product-pills-tabContent">
                                        <div class="tab-pane fade show active" id="detail-product" role="tabpanel"
                                            aria-labelledby="detail-product-tab">
                                            <div class="sidebar-body">
                                                <div class="row g-3 common-form">
                                                    <div class="col-12">
                                                        <label class="form-label" for="productSku">Product SKU</label>
                                                        <input class="form-control" id="productSku" type="text" name="sku" placeholder="Enter a number" value="{{ old('sku', $product->sku ?? '') }}">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label" for="productSlug">Product Slug</label>
                                                        <input class="form-control" id="productSlug" type="text" name="slug" placeholder="product-slug" value="{{ old('slug', $product->slug ?? '') }}">
                                                        <div class="form-text">Auto-generated from title if left empty.</div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label" for="validationProductTitle">Product Title</label>
                                                        <input class="form-control" id="validationProductTitle" type="text" name="name" placeholder="Title" value="{{ old('name', $product->name ?? '') }}">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="form-label">Product Description</label>
                                                        <div class="toolbar-box">
                                                            <div id="toolbar2">
                                                                <button class="ql-bold">Bold</button>
                                                                <button class="ql-italic">Italic</button>
                                                                <button class="ql-underline">underline</button>
                                                                <button class="ql-strike">Strike</button>
                                                                <button class="ql-list" value="ordered">List</button>
                                                                <button class="ql-list" value="bullet"></button>
                                                                <button class="ql-indent" value="-1"></button>
                                                                <button class="ql-indent" value="+1"></button>
                                                                <button class="ql-link"></button>
                                                            </div>
                                                            <div id="editor2"></div>
                                                            <textarea name="description" id="description-hidden" style="display:none;">{{ old('description', $product->description ?? '') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 product-buttons">
                                                        <button class="btn m-0" type="button" onclick="handleNextButtonClick('gallery-product-tab')">Next<svg>
                                                                <use href="{{ asset('assets/svg/icon-sprite.svg#front-arrow') }}"></use>
                                                            </svg></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="gallery-product" role="tabpanel"
                                            aria-labelledby="gallery-product-tab">
                                            <div class="sidebar-body common-form">
                                                @if(isset($product) && $product->images->isNotEmpty())
                                                    <div class="mb-4">
                                                        <p class="mb-3"><strong>Current Images</strong> <span class="c-o-light">&lpar;Click remove to delete, or upload new to replace&rpar;</span></p>
                                                        <div class="row g-3" id="existing-images">
                                                            @foreach($product->images->sortBy('sort_order') as $image)
                                                                <div class="col-md-3 col-sm-4" data-image-id="{{ $image->id }}">
                                                                    <div class="product-image-card position-relative">
                                                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image" class="img-fluid rounded" style="height: 150px; object-fit: cover; width: 100%;">
                                                                        <div class="product-image-overlay">
                                                                            <button type="button" class="btn btn-sm btn-danger remove-existing-image" data-image-id="{{ $image->id }}">
                                                                                <i class="fa fa-trash"></i> Remove
                                                                            </button>
                                                                        </div>
                                                                        <input type="hidden" name="existing_images[]" value="{{ $image->id }}" class="existing-image-input">
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="mb-3">
                                                    <p><strong>Add New Images</strong> <span class="c-o-light">&lpar;Select files to add or replace images&rpar;</span></p>
                                                </div>
                                                <div class="row g-3" id="new-image-uploads">
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="product-upload">
                                                            <p>Image 1 <span class="c-o-light">&lpar;Main&rpar;</span></p>
                                                            <input type="file" name="images[]" accept="image/*" class="form-control new-image-input">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="product-upload">
                                                            <p>Image 2</p>
                                                            <input type="file" name="images[]" accept="image/*" class="form-control new-image-input">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="product-upload">
                                                            <p>Image 3</p>
                                                            <input type="file" name="images[]" accept="image/*" class="form-control new-image-input">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 col-sm-4">
                                                        <div class="product-upload">
                                                            <p>Image 4</p>
                                                            <input type="file" name="images[]" accept="image/*" class="form-control new-image-input">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="product-buttons">
                                                    <button class="btn" type="button" onclick="handleNextButtonClick('detail-product-tab')"><svg>
                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#back-arrow') }}"></use>
                                                        </svg>Previous</button>
                                                    <button class="btn" type="button" onclick="handleNextButtonClick('category-product-tab')">Next<svg>
                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#front-arrow') }}"></use>
                                                        </svg></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="category-product" role="tabpanel"
                                            aria-labelledby="category-product-tab">
                                            <div class="sidebar-body common-form e-category">
                                                <div class="row g-3 common-form">
                                                    <div class="col-md">
                                                        <label class="form-label">Add Category</label>
                                                        <select class="selectpicker" multiple="" name="category_ids[]" aria-label="Default select example" data-live-search="true">
                                                            @foreach($categories as $category)
                                                                <option value="{{ $category->id }}" {{ (isset($product) && $product->categories->contains($category->id)) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div class="category-btn">
                                                            <a class="btn button-primary" href="#!" data-bs-toggle="modal" data-bs-target="#category-pill-modal">
                                                                <i class="me-2 fa fa-plus"></i>Create New Category
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <label class="form-label">Add Tag</label>
                                                        <select class="selectpicker" multiple="" name="tag_ids[]" aria-label="Select tags" data-live-search="true">
                                                            @foreach($tags as $tag)
                                                                <option value="{{ $tag->id }}" {{ (isset($product) && $product->tags->contains($tag->id)) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActiveSwitch" value="1" {{ (isset($product) && $product->is_active) || !isset($product) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="isActiveSwitch">Active Status</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 product-buttons">
                                                        <button class="btn" type="button" onclick="handleNextButtonClick('gallery-product-tab')"><svg>
                                                                <use href="{{ asset('assets/svg/icon-sprite.svg#back-arrow') }}"></use>
                                                            </svg>Previous</button>
                                                        <button class="btn" type="button" onclick="handleNextButtonClick('pricings-tab')">Next<svg>
                                                                <use href="{{ asset('assets/svg/icon-sprite.svg#front-arrow') }}"></use>
                                                            </svg></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="pricings" role="tabpanel"
                                            aria-labelledby="pricings-tab">
                                            <div class="sidebar-body">
                                                <div class="row g-3 common-form">
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="initialCost">Initial Price</label>
                                                        <input class="form-control" id="initialCost" type="number" name="cost_price" placeholder="Price" value="{{ old('cost_price', $product->cost_price ?? '') }}" step="0.01">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label class="form-label" for="sellingPrice">Selling Price</label>
                                                        <input class="form-control" id="sellingPrice" type="number" name="sale_price" placeholder="Price" value="{{ old('sale_price', $product->sale_price ?? '') }}" step="0.01">
                                                    </div>
                                                    <div class="col-12 product-buttons">
                                                        <button class="btn" type="button" onclick="handleNextButtonClick('category-product-tab')"><svg>
                                                                <use href="{{ asset('assets/svg/icon-sprite.svg#back-arrow') }}"></use>
                                                            </svg>Previous</button>
                                                        <button class="btn" type="button" onclick="handleNextButtonClick('advance-product-tab')">Next<svg>
                                                                <use href="{{ asset('assets/svg/icon-sprite.svg#front-arrow') }}"></use>
                                                            </svg></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="advance-product" role="tabpanel"
                                            aria-labelledby="advance-product-tab">
                                            <div class="sidebar-body advance-options">
                                                <ul class="nav nav-tabs border-tab mb-0" id="advance-option-tab"
                                                    role="tablist">
                                                    <li class="nav-item"><a class="nav-link active" id="manifest-option-tab"
                                                            data-bs-toggle="tab" href="#manifest-option" role="tab"
                                                            aria-controls="manifest-option" aria-selected="true">Inventory</a>
                                                    </li>
                                                    <li class="nav-item"><a class="nav-link" id="seo-option-tab"
                                                            data-bs-toggle="tab" href="#seo-option" role="tab"
                                                            aria-controls="seo-option" aria-selected="false">SEO
                                                            Tags</a></li>
                                                </ul>
                                                <div class="tab-content" id="advance-option-tabContent">
                                                    <div class="tab-pane fade show active" id="manifest-option"
                                                        role="tabpanel" aria-labelledby="manifest-option-tab">
                                                        <div class="meta-body">
                                                            <div class="common-form row g-3" id="advance-tab">
                                                                <div class="col-sm-6">
                                                                    <label class="form-label">Low Stock Level</label>
                                                                    <input class="form-control" type="number" name="low_stock_threshold" placeholder="Low stock threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? '5') }}">
                                                                </div>
                                                                <div class="col-xxl-4 col-sm-6">
                                                                    <label class="form-label" for="exampleFormControlInputa">Stock Quantity <span class="txt-danger">*</span></label>
                                                                    <input class="form-control" id="exampleFormControlInputa" type="number" name="quantity" placeholder="Quantity" value="{{ old('quantity', $product->stock ?? '') }}">
                                                                </div>
                                                                <div class="col-12">
                                                                    <label class="form-label">Video Links <span class="c-o-light">(one URL per line)</span></label>
                                                                    <textarea class="form-control" name="video_links" rows="3" placeholder="https://example.com/video1&#10;https://example.com/video2">{{ old('video_links', isset($product) && $product->videos->isNotEmpty() ? $product->videos->pluck('video_url')->implode("\n") : '') }}</textarea>
                                                                </div>
                                                                <div class="col-12 product-buttons">
                                                                    <button class="btn" type="button" onclick="handleNextButtonClick('pricings-tab')"><svg>
                                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#back-arrow') }}"></use>
                                                                        </svg>Previous</button>
                                                                    <button class="btn" type="button" onclick="handleNextButtonClick('seo-option-tab')">Next<svg>
                                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#front-arrow') }}"></use>
                                                                        </svg></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="seo-option" role="tabpanel"
                                                        aria-labelledby="seo-option-tab">
                                                        <div class="meta-body">
                                                            <div class="row g-3 common-form">
                                                                <div class="col-12 product-buttons">
                                                                    <button class="btn" type="button" onclick="handleNextButtonClick('manifest-option-tab')"><svg>
                                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#back-arrow') }}"></use>
                                                                        </svg>Previous</button>
                                                                    <button class="btn sweet-15" type="submit">Submit<svg>
                                                                            <use href="{{ asset('assets/svg/icon-sprite.svg#front-arrow') }}"></use>
                                                                        </svg></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Container-fluid Ends-->

    <!-- Category Creation Modal (moved outside main form) -->
    <div class="modal fade" id="category-pill-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content category-popup">
                <div class="modal-header">
                    <h5 class="modal-title" id="modaldashboard">Add Categories</h5>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-0 custom-input">
                    <div class="text-start">
                        <div class="p-20">
                            <form class="row g-3 needs-validation" novalidate="" id="create-category-form">
                                <div class="col-md-6">
                                    <label class="form-label" for="validationCategory">Category Name<span class="txt-danger">*</span></label>
                                    <input class="form-control" id="validationCategory" type="text" placeholder="Enter your category name" required="">
                                    <div class="invalid-feedback">Please choose a category name.</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="validationSlug">Slug<span class="txt-danger">*</span></label>
                                    <input class="form-control" id="validationSlug" type="text" placeholder="Enter slug" required="">
                                    <div class="invalid-feedback">Please choose a slug name.</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Parent Category<span class="txt-danger">*</span></label>
                                    <select class="form-select" aria-label="Select parent category">
                                        <option selected="">T-shirts</option>
                                        <option value="1">Purse</option>
                                        <option value="2">Cameras</option>
                                        <option value="3">Shoes</option>
                                        <option value="4">Handbags</option>
                                        <option value="5">Sleepers</option>
                                        <option value="6">Watches</option>
                                    </select>
                                    <div class="invalid-feedback">Please choose a parent category.</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Category Type<span class="txt-danger">*</span></label>
                                    <select class="form-select" aria-label="Select parent category">
                                        <option selected="">Electronic</option>
                                        <option value="1">Accessories</option>
                                        <option value="2">Footwear</option>
                                        <option value="3">Clothing</option>
                                        <option value="4">Furniture</option>
                                    </select>
                                    <div class="invalid-feedback">Please choose a category type.</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Category Status<span class="txt-danger">*</span></label>
                                    <select class="form-select" aria-label="Select parent category">
                                        <option selected="">Active</option>
                                        <option value="1">Inactive</option>
                                    </select>
                                    <div class="invalid-feedback">Please choose a category status.</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="validationDescription">Category Description</label>
                                    <textarea class="form-control" id="validationDescription" placeholder="Description here..." required=""></textarea>
                                    <div class="invalid-feedback">Please enter a category description.</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                            
                                <div class="col-lg-6">
                                    <label class="form-label" for="validationMetaTitle1">Meta Title<span class="txt-danger">*</span></label>
                                    <input class="form-control" id="validationMetaTitle1" type="text" placeholder="Enter meta title" required="">
                                    <div class="invalid-feedback">Please choose a meta title.</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-lg-6">
                                    <label class="form-label" for="validationKeywords">Meta Keywords<span class="txt-danger">*</span><span class="c-o-light">&nbsp;(In comma separated)</span></label>
                                    <input class="form-control" id="validationKeywords" type="text" placeholder="Enter meta keywords" required="">
                                    <div class="invalid-feedback">Please enter a meta keywords(In comma separated).</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Meta Description</label>
                                    <div class="toolbar-box">
                                        <div id="toolbar3">
                                            <button class="ql-bold">Bold</button>
                                            <button class="ql-italic">Italic</button>
                                            <button class="ql-underline">underline</button>
                                            <button class="ql-strike">Strike</button>
                                            <button class="ql-list" value="ordered">List</button>
                                            <button class="ql-list" value="bullet"></button>
                                            <button class="ql-indent" value="-1"></button>
                                            <button class="ql-indent" value="+1"></button>
                                            <button class="ql-link"></button>
                                        </div>
                                        <div id="editor3"></div>
                                    </div>
                                    <div class="invalid-feedback">Please enter a meta description</div>
                                    <div class="valid-feedback">Looks good!</div>
                                </div>
                                <div class="col-md-12 d-flex justify-content-end">
                                    <button class="btn button-light-primary" type="button" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary ms-2" type="submit">Create +</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/flat-pickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/flat-pickr/custom-flatpickr.js') }}"></script>
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2/intltelinput.min.js') }}"></script>
    <script src="{{ asset('assets/js/editors/quill.js') }}"></script>
    <script src="{{ asset('assets/js/custom-add-product.js') }}"></script>
    <script src="{{ asset('assets/js/tooltip-init.js') }}"></script>
    <script src="{{ asset('assets/js/modalpage/validation-modal.js') }}"></script>
    <script src="{{ asset('assets/js/select/bootstrap-select.min.js') }}"></script>
    <script>
        // Simple tab navigation without AJAX
        function handleNextButtonClick(nextTabId) {
            const nextTab = document.getElementById(nextTabId);
            if (nextTab) {
                const tab = new bootstrap.Tab(nextTab);
                tab.show();
            }
        }

        // Auto-generate slug from product name
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('validationProductTitle');
            const slugInput = document.getElementById('productSlug');

            if (nameInput && slugInput) {
                // Only auto-generate if slug is empty (for new products)
                if (!slugInput.value || slugInput.value === '') {
                    nameInput.addEventListener('input', function() {
                        if (!slugInput.value || slugInput.value === '') {
                            slugInput.value = nameInput.value
                                .toLowerCase()
                                .replace(/[^a-z0-9]+/g, '-')
                                .replace(/^-+|-+$/g, '');
                        }
                    });
                }
            }
        });
    </script>
@endsection
