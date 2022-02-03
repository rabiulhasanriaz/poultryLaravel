@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('product_class','menu-open')
    @section('product_type_class','menu-open')
    @section('add_type_class','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Type</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Type</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      @include('company.layout.session_message')
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6 offset-md-3">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Product Type</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('inventory.product.type.store-type') }}" method="post">
                @csrf
                <div class="card-body">

                  <div class="form-group">
                    <label>Group <i class="text-danger">*</i></label>
                    <select class="form-control select2" name="g_id" style="width: 100%;">
                     <option value="">Select Group</option>
                     @foreach ($groups as $item)
                         <option value="{{ $item->id }}" {{ old('g_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                     @endforeach
                    </select>
                    @error('g_id')
                        <p class="text-danger">{{ $errors->first('g_id') }}</p>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Type Name <i class="text-danger">*</i></label>
                    <input type="text" name="t_name" class="form-control" value="{{ old('t_name') }}" id="exampleInputEmail1" placeholder="Enter email">
                    @error('t_name')
                      <p class="text-danger">{{ $errors->first('t_name') }}</p>
                    @enderror
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Create</button>
                </div>
              </form>
            </div>
          

          </div>
          <!--/.col (left) -->
          <!-- right column -->
          
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection
@section('custom_style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2();
});
</script>
@endsection