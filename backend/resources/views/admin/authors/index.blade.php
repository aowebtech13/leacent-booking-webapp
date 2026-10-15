@extends('layouts.simple.master')

@section('title', 'Authors Management')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/jquery.dataTables.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Authors Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Authors</li>
                        <li class="breadcrumb-item active">Authors Management</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <!-- Authors List Card (Leacent Authors Design) -->
            <div class="col-md-5 xxl-3">
                <div class="p-3">
                    <h5>Leacent Authors</h5>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="GET" action="{{ route('admin.authors.index') }}" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search authors..." value="{{ request('search') }}">
                                <button class="btn btn-primary" type="submit"><i data-feather="search"></i></button>
                            </div>
                        </form>
                        <ul class="customer-list">
                            @forelse($authors as $author)
                            <li class="customer-list-item">
                                <span class="text-light-primary f-w-600 h-35 w-35 d-flex-center b-r-50 customer-list-avatar">
                                    {{ strtoupper(substr($author->name, 0, 1)) }}
                                </span>
                                <div class="customer-list-content">
                                    <h6 class="mb-0">{{ $author->name }}</h6>
                                    <small class="text-muted d-block">{{ $author->email ?? 'No email' }}</small>
                                    <small class="text-muted d-block">{{ $author->books_count }} book{{ $author->books_count != 1 ? 's' : '' }}</small>
                                </div>
                                <div>
                                    <a href="{{ route('admin.authors.edit', $author) }}" class="btn btn-info btn-sm" title="View/Edit"><i data-feather="eye"></i></a>
                                    <form action="{{ route('admin.authors.destroy', $author) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this author? Books linked to this author will have their author reference removed.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete"><i data-feather="trash-2"></i></button>
                                    </form>
                                </div>
                            </li>
                            @empty
                            <li class="customer-list-item text-center f-light py-3">No authors found.</li>
                            @endforelse
                        </ul>
                        <div class="mt-3">
                            {{ $authors->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add / Edit Author Form -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>{{ request()->routeIs('admin.authors.create') ? 'Add Author' : 'Edit Author' }}</h4>
                        <a href="{{ route('admin.authors.index') }}" class="btn btn-sm btn-secondary">Back to List</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ request()->routeIs('admin.authors.create') ? route('admin.authors.store') : route('admin.authors.update', $author) }}" method="POST" class="row g-3">
                            @csrf
                            @if(request()->routeIs('admin.authors.edit'))
                                @method('PUT')
                            @endif
                            <div class="col-md-6">
                                <label class="form-label">Author Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $author->name ?? '') }}" required>
                                @error('name') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Slug</label>
                                <input type="text" name="slug" class="form-control" value="{{ old('slug', $author->slug ?? '') }}" placeholder="Auto-generated from name">
                                @error('slug') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ old('email', $author->email ?? '') }}">
                                @error('email') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $author->phone ?? '') }}">
                                @error('phone') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Website</label>
                                <input type="url" name="website" class="form-control" value="{{ old('website', $author->website ?? '') }}">
                                @error('website') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Avatar URL</label>
                                <input type="text" name="avatar" class="form-control" value="{{ old('avatar', $author->avatar ?? '') }}">
                                @error('avatar') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Bio</label>
                                <textarea name="bio" class="form-control" rows="4">{{ old('bio', $author->bio ?? '') }}</textarea>
                                @error('bio') <span class="text-danger f-12">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-4">
                                <div class="form-check mt-5">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" {{ old('is_active', $author->is_active ?? true) ? 'checked' : '' }} id="is_active">
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr class="my-3">
                                <button type="submit" class="btn btn-primary">{{ request()->routeIs('admin.authors.create') ? 'Add Author' : 'Update Author' }}</button>
                            </div>
                        </form>
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
