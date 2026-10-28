@extends('layouts.simple.master')

@section('title', 'Add Book')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Books Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">Books</a></li>
                        <li class="breadcrumb-item active">Add Book</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.books.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-6">
                                <label class="form-label">Book Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                                @error('title') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" placeholder="Auto-generated from title">
                                @error('slug') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Author (Select)</label>
                                <select name="author_id" class="form-select">
                                    <option value="">-- Select Author --</option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ old('author_id') == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                    @endforeach
                                </select>
                                @error('author_id') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
<div class="col-md-4">
                                <label class="form-label">Publisher</label>
                                <input type="text" name="publisher" class="form-control" value="{{ old('publisher') }}">
                                @error('publisher') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <input type="text" name="category" class="form-control" value="{{ old('category') }}" placeholder="e.g. Fiction">
                                @error('category') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
<div class="col-md-4">
                                <label class="form-label">Format</label>
                                <input type="text" name="format" class="form-control" value="{{ old('format', 'pdf') }}" placeholder="pdf, epub, audio">
                                @error('format') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Publication Year</label>
                                <input type="number" name="publication_year" class="form-control" value="{{ old('publication_year') }}" min="1000" max="9999">
                                @error('publication_year') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Page Count</label>
                                <input type="number" name="page_count" class="form-control" value="{{ old('page_count') }}" min="1">
                                @error('page_count') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
<div class="col-md-6">
                                <label class="form-label">Upload PDF <span class="text-danger">*</span></label>
                                <input type="file" name="file" class="form-control" accept="application/pdf" required>
                                @error('file') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Cover Image</label>
                                <input type="file" name="cover_image" class="form-control" accept="image/*">
                                <small class="form-text text-muted">Upload a featured cover image.</small>
                                @error('cover_image') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                                @error('description') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mt-5">
                                    <input class="form-check-input" type="checkbox" name="is_premium" value="1" {{ old('is_premium') ? 'checked' : '' }} id="is_premium">
                                    <label class="form-check-label" for="is_premium">Premium Book</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mt-5">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} id="is_active">
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
<div class="col-12">
                                <hr>
                                <button type="submit" class="btn btn-primary">Create Book</button>
                                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
