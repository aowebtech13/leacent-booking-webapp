@extends('layouts.simple.master')

@section('title', 'Categories Management')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/select2.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/nestable-style.css') }}">
@endsection

@section('main_content')
<div class="container-fluid">
  <div class="page-title">
      <div class="row">
          <div class="col-sm-6">
              <h3>Categories Management</h3>
          </div>
          <div class="col-sm-6">
              <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"> <svg class="stroke-icon">
                              <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                          </svg></a></li>
                  <li class="breadcrumb-item active">Categories</li>
              </ol>
          </div>
      </div>
  </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-xxl-12">
            <div class="card height-equal">
                <div class="card-header categories-edit">
                    <h4>Categories</h4>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">{{ __('Add Category') }}</a>
                </div>
                <div class="card-body">
                    @include('admin.categories.list', ['categories' => $categories])
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/select2/select2-custom.js') }}"></script>
<script src="{{ asset('assets/js/nestable/jquery.nestable.min.js')}}"></script>
<script src="{{ asset('assets/js/bookmark/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/custom-validation/validation.js') }}"></script>
<script>
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    function updateToDatabase() {
      idString = $('.dd').nestable('toArray', {
        attribute: 'data-id'
      });
      var orderIndex = [];
      $('#nestable3 li').each(function(index) {
        orderIndex.push({
          id: $(this).attr('data-id'),
          order: index
        })
      });
      var mergedArray = Object.values(Object.groupBy([...orderIndex, ...idString],
        ({
          id
        }) => id)).map(e => e.reduce((acc, cur) => ({
        ...acc,
        ...cur
      })));

      $.ajax({
        url: '{{ route("admin.categories.update.orders") }}',
        method: 'POST',
        data: {
          categories: mergedArray
        },
        success: function() {
          //
        }
      })
    }

    $('.dd').nestable({
      maxDepth: 12
    }).on('change', updateToDatabase);
  })
</script>
@endsection
