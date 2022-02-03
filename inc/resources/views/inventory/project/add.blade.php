@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('projects_class','menu-open')
    @section('project_add','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Group</li>
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
                <h3 class="card-title">Add Group</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('inventory.project.project-store') }}" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Project Name <i class="text-danger">*</i></label>
                    <input type="text" oninput="this.value = this.value.toUpperCase()" name="p_name" value="{{ old('p_name') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Product Group Name">
                    @error('p_name')
                        <p class="text-danger">{{ $errors->first('p_name') }}</p>
                    @enderror  
                </div>
                  
                  <div class="form-group">
                    <label>Customer <i class="text-danger">*</i></label>
                    <select class="form-control select2" name="c_id" style="width: 100%;">
                     <option value="">Select Customer</option>
                     @foreach ($customers as $item)
                         <option value="{{ $item->id }}" {{ old('c_id') == $item->id ? 'selected' : '' }}>{{ $item->cus_name }}</option>
                     @endforeach
                    </select>
                    @error('c_id')
                        <p class="text-danger">{{ $errors->first('c_id') }}</p>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Issue Date <i class="text-danger">*</i></label>
                    <input type="text" name="issue" data-date-format="yyyy-mm-dd" class="form-control" id="issue_date" autocomplete="off" placeholder="Enter Issue Date">
                    @error('issue')
                        <p class="text-danger">{{ $errors->first('issue') }}</p>
                    @enderror  
                </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
@section('custom_style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/datepicker/bootstrap-datepicker.min.css') }}">
@endsection
@section('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2();
});

$(document).ready(function(){

$( "#issue_date" ).datepicker({
       daysOfWeekHighlighted: "7",
        todayHighlight: true,
        autoclose: true,
     });

});
</script>
@endsection