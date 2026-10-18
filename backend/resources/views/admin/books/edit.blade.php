@extends('layouts.simple.master')

@section('title', 'Edit Book - {{ $book->title }}')

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
                        <li class="breadcrumb-item active">{{ $book->title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.books.update', $book) }}" method="POST" class="row g-3">
                            @csrf
                            @method('PUT')
                            <div class="col-md-6">
                                <label class="form-label">Book Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ old('title', $book->title) }}" required>
                                @error('title') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug', $book->slug) }}">
                                @error('slug') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Author (Select)</label>
                                <select name="author_id" class="form-select">
                                    <option value="">-- Select Author --</option>
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}" {{ old('author_id', $book->author_id) == $author->id ? 'selected' : '' }}>{{ $author->name }}</option>
                                    @endforeach
                                </select>
                                @error('author_id') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Author Name (Legacy String)</label>
                                <input type="text" name="author" class="form-control" value="{{ old('author', $book->getAttribute('author')) }}">
                                @error('author') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Publisher</label>
                                <input type="text" name="publisher" class="form-control" value="{{ old('publisher', $book->publisher) }}">
                                @error('publisher') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Category</label>
                                <input type="text" name="category" class="form-control" value="{{ old('category', $book->category) }}">
                                @error('category') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Language</label>
                                <input type="text" name="language" class="form-control" value="{{ old('language', $book->language) }}">
                                @error('language') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Format</label>
                                <input type="text" name="format" class="form-control" value="{{ old('format', $book->format) }}">
                                @error('format') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Publication Year</label>
                                <input type="number" name="publication_year" class="form-control" value="{{ old('publication_year', $book->publication_year) }}" min="1000" max="9999">
                                @error('publication_year') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Page Count</label>
                                <input type="number" name="page_count" class="form-control" value="{{ old('page_count', $book->page_count) }}" min="1">
                                @error('page_count') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Price ($)</label>
                                <input type="number" name="price" class="form-control" value="{{ old('price', $book->price) }}" min="0" step="0.01">
                                @error('price') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload PDF</label>
                                <input type="file" name="file" class="form-control" accept="application/pdf">
                                <small class="form-text text-muted">Leave empty to keep current file.</small>
                                @error('file') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ old('description', $book->description) }}</textarea>
                                @error('description') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mt-5">
                                    <input class="form-check-input" type="checkbox" name="is_premium" value="1" {{ old('is_premium', $book->is_premium) ? 'checked' : '' }} id="is_premium">
                                    <label class="form-check-label" for="is_premium">Premium Book</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mt-5">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $book->is_active) ? 'checked' : '' }} id="is_active">
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-check mt-5">
                                    <input class="form-check-input" type="checkbox" name="is_featured" value="1" {{ old('is_featured', $book->is_featured) ? 'checked' : '' }} id="is_featured">
                                    <label class="form-check-label" for="is_featured">Featured</label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tags</label>
                                <input type="text" name="tags" class="form-control" value="{{ old('tags', is_array($book->tags) ? implode(', ', $book->tags) : $book->tags) }}">
                                <small class="form-text text-muted">Comma separated tags.</small>
                                @error('tags') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-12">
                                <hr>
                                <button type="submit" class="btn btn-primary">Update Book</button>
                                <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">Back to List</a>
                                <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete Book</button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Book Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            @if($book->cover_image_path)
                                <img src="{{ Storage::disk('public')->url($book->cover_image_path) }}" width="160" height="220" class="rounded shadow" alt="cover">
                            @else
                                <div class="bg-light-secondary rounded d-flex align-items-center justify-content-center" style="width:160px;height:220px;font-size:14px;">No Cover</div>
                            @endif
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Title:</strong> {{ $book->title }}</li>
                            <li class="list-group-item"><strong>Slug:</strong> {{ $book->slug }}</li>
                            <li class="list-group-item"><strong>Author:</strong> @if($book->author){{ $book->author->name }}@elseif($book->getAttribute('author')){{ $book->getAttribute('author') }}@elseN/A@endif</li>
                            <li class="list-group-item"><strong>Publisher:</strong> {{ $book->publisher ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Category:</strong> {{ $book->category ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Language:</strong> {{ $book->language ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Format:</strong> {{ $book->format ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Price:</strong> ${{ number_format($book->price, 2) }}</li>
                            <li class="list-group-item"><strong>Pages:</strong> {{ $book->page_count ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Published:</strong> {{ $book->publication_year ?? 'N/A' }}</li>
                            <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-{{ $book->is_active ? 'success' : 'danger' }}">{{ $book->is_active ? 'Active' : 'Inactive' }}</span></li>
                            <li class="list-group-item"><strong>Premium:</strong> @if($book->is_premium)Yes@elseNo@endif</li>
                            <li class="list-group-item"><strong>Read Count:</strong> {{ $book->read_count }}</li>
                            <li class="list-group-item"><strong>Created:</strong> {{ $book->created_at->format('d M, Y h:i A') }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
