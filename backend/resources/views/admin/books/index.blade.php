@extends('layouts.simple.master')

@section('title', 'Books Management')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
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
                        <li class="breadcrumb-item">Books</li>
                        <li class="breadcrumb-item active">Books Management</li>
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>All Books</h4>
                        <a href="{{ route('admin.books.create') }}" class="btn btn-primary btn-sm">Add Book</a>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.books.index') }}">
                            <div class="row g-3 mb-3">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search title, author, isbn, category..." value="{{ request('search') }}">
                                </div>
                                <div class="col-md-2">
                                    <select name="is_active" class="form-select">
                                        <option value="">All Status</option>
                                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">Search</button>
                                </div>
                                <div class="col-md-2">
                                    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary w-100">Reset</a>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive custom-scrollbar">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cover</th>
                                        <th>Title</th>
                                        <th>Author</th>
                                        <th>ISBN</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($books as $book)
                                    <tr>
                                        <td>{{ $loop->iteration + ($books->currentPage() - 1) * $books->perPage() }}</td>
                                        <td>
                                            @if($book->cover_image_path)
                                                <img src="{{ Storage::disk('public')->url($book->cover_image_path) }}" width="40" height="50" class="rounded" alt="cover">
                                            @else
                                                <span class="bg-light-secondary rounded d-flex align-items-center justify-content-center" style="width:40px;height:50px;font-size:10px;">No Cover</span>
                                            @endif
                                        </td>
                                        <td>
                                            <h6 class="mb-0">{{ $book->title }}</h6>
                                            <small class="text-muted">{{ $book->slug }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $authorRel = $book->relationLoaded('author') ? $book->getRelation('author') : ($book->author_id ? $book->author : null);
                                                if (is_string($authorRel) || is_null($authorRel)) {
                                                    $authorRel = null;
                                                }
                                                $authorStr = $book->getAttribute('author');
                                                if (is_object($authorStr)) {
                                                    $authorStr = null;
                                                }
                                            @endphp
                                            @if($authorRel && is_object($authorRel) && isset($authorRel->name))
                                                <span class="badge bg-light-info">{{ $authorRel->name }}</span>
                                            @elseif(is_string($authorStr) && $authorStr)
                                                {{ $authorStr }}
                                            @elseif($book->author_id && $book->author && is_object($book->author) && isset($book->author->name))
                                                <span class="badge bg-light-info">{{ $book->author->name }}</span>
                                            @else
                                                <span class="text-muted f-light">No Author</span>
                                            @endif
                                        </td>
                                        <td>{{ $book->isbn ?? 'N/A' }}</td>
                                        <td>{{ $book->category ?? 'N/A' }}</td>
                                        <td class="f-w-600">${{ number_format($book->price, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $book->is_active ? 'success' : 'danger' }}-light text-{{ $book->is_active ? 'success' : 'danger' }}">
                                                {{ $book->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>{{ $book->created_at->format('d M, Y') }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-info btn-sm" title="View"><i data-feather="eye"></i></a>
                                            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-primary btn-sm" title="Edit"><i data-feather="edit"></i></a>
                                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i data-feather="trash-2"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="10" class="text-center f-light">No books found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $books->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/feather-icon/feather.min.js') }}"></script>
    <script>feather.replace();</script>
@endsection
