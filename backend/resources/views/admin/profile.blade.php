@extends('layouts.simple.master')

@section('title', 'Admin Profile')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Admin Profile</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Profile</li>
                        <li class="breadcrumb-item active">Admin Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="container-fluid">
            <div class="alert alert-success">{{ session('status') }}</div>
        </div>
    @endif

    @if ($errors->any())
        <div class="container-fluid">
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="edit-profile">
            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">My Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="profile-title">
                                    <div class="d-flex">
                                        <div class="profile-img">
                                            @if ($logoUrl)
                                                <img src="{{ $logoUrl }}" alt="Profile" class="img-70 rounded-circle">
                                            @else
                                                <img src="{{ asset('assets/images/user/user.png') }}" alt="Profile" class="img-70 rounded-circle">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <h4 class="mb-1">{{ $admin->name }}</h4>
                                            <p>Administrator</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email Address</label>
                                <p class="f-light mb-0">{{ $admin->email }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Company</label>
                                <p class="f-light mb-0">{{ $admin->profile?->company_name ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone</label>
                                <p class="f-light mb-0">{{ $admin->profile?->phone_number ?? $admin->profile?->phone ?? '—' }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <p class="f-light mb-0">{{ $admin->profile?->address ?? '—' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Name<span>*</span></label>
                                            <input class="form-control" type="text" name="name" value="{{ old('name', $admin->name) }}">
                                            @error('name')
                                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Email address<span>*</span></label>
                                            <input class="form-control" type="email" name="email" value="{{ old('email', $admin->email) }}">
                                            @error('email')
                                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Profile Logo</label>
                                            <input class="form-control" type="file" name="logo" accept="image/*">
                                            @error('logo')
                                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
<div class="col-md-12">
                                        <div class="mb-2">
                                            <label class="form-label">Change Password <span class="text-muted">(optional — leave blank to keep current password)</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Current Password</label>
                                            <input class="form-control" type="password" name="current_password" autocomplete="current-password" placeholder="Required only when changing password">
                                            @error('current_password')
                                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">New Password</label>
                                            <input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="Leave blank to keep current">
                                            @error('password')
                                                <span class="text-danger"><strong>{{ $message }}</strong></span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Confirm New Password</label>
                                            <input class="form-control" type="password" name="password_confirmation" autocomplete="new-password" placeholder="Repeat new password">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end p-0 pt-3">
                                    <button class="btn btn-primary" type="submit">Update Profile</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->
@endsection
