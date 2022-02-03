@extends('company.layout.master')
@section('customer','menu-open')
@section('customer_class','active')
@section('customer_register','active')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customer Create</h1>
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
                <h3 class="card-title">Customer Registration</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form  action="{{ route('company.customer.submit-customer') }}" method="post">
                  @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Customer Name <i class="text-danger">*</i></label>
                    <input type="text" class="form-control" value="{{ old('cus_name') }}" name="cus_name" style="background: black;" autocomplete="off" id="c_name" placeholder="Enter Customer Name" required>
                    <small></small>
                    @error('cus_name')
                        <p class="text-danger">{{ $errors->first('cus_name') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Company Name</label>
                    <input type="text" class="form-control" value="{{ old('com_name') }}" name="com_name" style="background: black;" autocomplete="off"  placeholder="Enter Company Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Customer Phone <i class="text-danger">*</i></label>
                    <input type="text" class="form-control" value="{{ old('cus_phone') }}" name="cus_phone" style="background: black;" autocomplete="off" id="contactNumber" placeholder="Enter Customer Phone" required>
                    <small></small>
                    @error('cus_phone')
                      <p class="text-danger">{{ $errors->first('cus_phone') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Customer Email</label>
                    <input type="email" class="form-control" value="{{ old('cus_email') }}" name="cus_email" style="background: black;" autocomplete="off" id="" placeholder="Enter Customer Email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Customer Address</label>
                    <input type="text" class="form-control" value="{{ old('cus_address') }}" name="cus_address" style="background: black;" autocomplete="off" id="c_address" placeholder="Enter Customer Address">
                    <small></small>
                    
                  </div>
                  <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                      <input type="radio" id="radioPrimary1" name="cus_type" value="1">
                      <label for="radioPrimary1">
                          Farm/খামারী
                      </label>
                    </div>
                    &nbsp;
                    <div class="icheck-primary d-inline">
                      <input type="radio" id="radioPrimary2" name="cus_type" value="2">
                      <label for="radioPrimary2">
                        Wholesaler/পাইকার
                      </label>
                    </div>
                    &nbsp;
                    <div class="icheck-primary d-inline">
                      <input type="radio" id="radioPrimary3" name="cus_type" value="3">
                      <label for="radioPrimary3">
                        Sub-dealer/সাব-ডিলার
                      </label>
                    </div>
                    @error('cus_type')
                        <p class="text-danger">{{ $errors->first('cus_type') }}</p>
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
       
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
    
@endsection
@section('custom_style')
   {{-- <script src="{{ asset('assets/validation/validate.js?v=1.2.1') }}"></script> --}}
   <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endsection
@section('custom_script')
    <script>
        $(document).ready(function() {
    $('#contactNumber').keyup(function() {
        var numbers = $(this).val();
        $(this).val(numbers.replace(/\D/, ''));
    });
});
    </script>
@endsection