@extends('company.layout.master')
@section('user','menu-open')
@section('user_class','active')
@section('user_register','active')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User Create</h1>
          </div>
          {{-- @include('reseller.partials.all_error_messages') --}}
		      
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create</li>
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
                <h3 class="card-title">User Registration</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form  action="{{ route('company.user.user-submit') }}" method="post" enctype="multipart/form-data">
                  @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Name <i class="text-danger">*</i></label>
                    <input type="text" class="form-control" value="{{ old('u_name') }}" name="u_name" style="background: black;" autocomplete="off" id="c_name" placeholder="Enter User Name">
                    <small></small>
                    @error('u_name')
                        <p class="text-danger">{{ $errors->first('u_name') }}</p>
                    @enderror
                  </div>
                  {{-- <div class="form-group">
                    <label for="exampleInputPassword1">Company Person</label>
                    <input type="text" class="form-control" value="{{ old('c_person') }}" name="c_person" style="background: black;" autocomplete="off"  placeholder="Enter Company Password">
                  </div> --}}
                  <div class="form-group">
                    <label for="exampleInputPassword1"> Phone <i class="text-danger">*</i></label>
                    <input type="text" class="form-control" value="{{ old('u_phone') }}" name="u_phone" style="background: black;" autocomplete="off" id="contactNumber" placeholder="Enter User Phone">
                    <small></small>
                    @error('u_phone')
                      <p class="text-danger">{{ $errors->first('u_phone') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Email</label>
                    <input type="email" class="form-control" value="{{ old('u_email') }}" name="u_email" style="background: black;" autocomplete="off" id="" placeholder="Enter Company Email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Address</label>
                    <input type="text" class="form-control" value="{{ old('u_address') }}" name="u_address" style="background: black;" autocomplete="off" id="c_address" placeholder="Enter User Address">
                    <small></small>
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1"> Password <i class="text-danger">*</i></label>
                    <input type="password" class="form-control" value="{{ old('u_password') }}" name="u_password" style="background: black;" autocomplete="off" id="c_password" placeholder="Enter User Password">
                    <small></small>
                    @error('u_password')
                      <p class="text-danger">{{ $errors->first('u_password') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile"> Image </label>
                    <div class="input-group">
                      <input type="file" name="u_logo" class="form-control">
                    </div>
                    
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
       
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
    
@endsection
@section('custom_script')
   {{-- <script src="{{ asset('assets/validation/validate.js?v=1.2.1') }}"></script> --}}
   <script>
    $(document).ready(function() {
$('#contactNumber').keyup(function() {
    var numbers = $(this).val();
    $(this).val(numbers.replace(/\D/, ''));
});
});
</script>
@endsection