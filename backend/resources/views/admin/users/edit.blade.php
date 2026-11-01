@extends('layouts.simple.master')

@section('title', 'Edit User')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/date-picker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/dropzone.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>Users Management</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                                    <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                </svg></a></li>
                        <li class="breadcrumb-item">Users</li>
                        <li class="breadcrumb-item active">Edit</li>
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
                        <form class="row g-3 custom-input" id="userForm" action="{{ route('admin.user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            @include('admin.user.fields')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid Ends-->

    <!-- Manual Points Credit -->
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Manual Points Credit</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Current Points Balance</label>
                                    <p class="mb-0 fs-5 text-primary">
                                        {{ $user->profile?->points_balance ?? 0 }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <form action="{{ route('admin.user.credit-points', $user->id) }}" method="POST">
                                    @csrf
                                    <div class="row g-3 align-items-end">
                                        <div class="col-md-5">
                                            <label for="credit_points" class="form-label">Points to add</label>
                                            <input type="number" name="points" id="credit_points" class="form-control" min="1" max="100000" required>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="credit_notes" class="form-label">Notes (optional)</label>
                                            <input type="text" name="notes" id="credit_notes" class="form-control" maxlength="2000" placeholder="e.g. Promotional bonus">
                                        </div>
                                        <div class="col-md-2">
                                            <button type="submit" class="btn btn-primary w-100">Credit</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- calendar js-->
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.en.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker/date-picker/datepicker.custom.js') }}"></script>
    <script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/bookmark/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom-validation/validation.js') }}"></script>
    <script>
        $(document).ready(function (){
            $('#country').on('change', function(){
                var idCountry = this.value;
                $("#state").html('');
                $.ajax({
                    url: "{{ route('admin.user.get-states') }}",
                    type: "GET",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $.each(result.states, function (key, value) {
                            $("#state").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#country_code').select2({
                templateResult: function(option) {
                    if (option.element && option.element.dataset.image) {
                        return $('<span><img src="' + option.element.dataset.image + '" width="20" height="15" /> ' + option.text + '</span>');
                    }
                    return  option.text;
                }
            });
        });
    </script>
@endsection
