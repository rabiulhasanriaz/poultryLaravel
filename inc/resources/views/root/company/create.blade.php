@extends('root.layout.master')
@section('company','menu-open')
@section('company_class','active')
@section('company_register','active')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Company Create</h1>
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
      @include('root.layout.session_message')
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          
          <div class="col-md-6 offset-md-3">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Company Registration</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form  action="{{ route('root.company.store') }}" method="post" enctype="multipart/form-data">
                  @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Company Name <i class="text-danger">*</i></label>
                    <input type="text" class="form-control" value="{{ old('c_name') }}" name="c_name" style="background: black;" autocomplete="off" id="c_name" placeholder="Enter Company Name">
                    <small></small>
                    @error('c_name')
                        <p class="text-danger">{{ $errors->first('c_name') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Company Person</label>
                    <input type="text" class="form-control" value="{{ old('c_person') }}" name="c_person" style="background: black;" autocomplete="off"  placeholder="Enter Company Password">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Company Phone <i class="text-danger">*</i></label>
                    <input type="text" class="form-control" value="{{ old('c_phone') }}" name="c_phone" style="background: black;" autocomplete="off" id="contactNumber" placeholder="Enter Company Phone">
                    <small></small>
                    @error('c_phone')
                      <p class="text-danger">{{ $errors->first('c_phone') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Company Email</label>
                    <input type="email" class="form-control" value="{{ old('c_email') }}" name="c_email" style="background: black;" autocomplete="off" id="" placeholder="Enter Company Email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Company Address <i class="text-danger">*</i></label>
                    <input type="text" class="form-control" value="{{ old('c_address') }}" name="c_address" style="background: black;" autocomplete="off" id="c_address" placeholder="Enter Company Address">
                    <small></small>
                    @error('c_address')
                      <p class="text-danger">{{ $errors->first('c_address') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Company Password <i class="text-danger">*</i></label>
                    <input type="password" class="form-control" value="{{ old('c_password') }}" name="c_password" style="background: black;" autocomplete="off" id="c_password" placeholder="Enter Company Password">
                    <small></small>
                    @error('c_password')
                      <p class="text-danger">{{ $errors->first('c_password') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Company Logo</label>
                    <div class="input-group">
                      <input type="file" name="c_logo" class="form-control">
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