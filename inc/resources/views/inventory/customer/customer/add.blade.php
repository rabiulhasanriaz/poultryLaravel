@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('customer_class','menu-open')
    @section('customer_add_class','menu-open')
    @section('add_customer','active')
@elseif($user->user_type == 3)

@endif
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customer</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Customer</li>
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
                <h3 class="card-title">Add Customer</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('inventory.customer.cus.customer-store') }}" method="post">
                @csrf
                <div class="card-body">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Mobile <i class="text-danger">*</i></label>
                    <input type="text" name="c_mobile" value="{{ old('c_mobile') }}" class="form-control" id="" placeholder="Enter Customer Mobile Number">
                    @error('c_mobile')
                      <p class="text-danger">{{ $errors->first('c_mobile') }}</p>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Customer Name <i class="text-danger">*</i></label>
                    <input type="text" name="c_name" value="{{ old('c_name') }}" class="form-control" id="" placeholder="Enter Customer Name">
                    @error('c_name')
                      <p class="text-danger">{{ $errors->first('c_name') }}</p>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Company Name</label>
                    <input type="text" name="c_com_name" value="{{ old('c_com_name') }}" class="form-control" id="" placeholder="Enter Company Name">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input type="email" name="c_email" value="{{ old('c_email') }}" class="form-control" id="" placeholder="Enter Customer Email">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Address</label>
                    <input type="text" name="c_address" value="{{ old('c_address') }}" class="form-control" id="" placeholder="Enter Customer Address">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Website</label>
                    <input type="text" name="c_website" value="{{ old('c_website') }}" class="form-control" id="" placeholder="Enter Customer Website">
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1" class="control-label">Customer Type:</label>
                    <div class="col-sm-12">
                        <label class="radio-inline">
                            <input type="radio" name="c_type" value="1" {{ old('c_type') == 1 ? 'checked' : '' }}> Regular
                        </label>
                        <label class="radio-inline" style="padding: 0 30px;" {{ old('c_type') == 2 ? 'checked' : '' }}>
                            <input type="radio" name="c_type" value="2"> Irregular
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="c_type" value="3" {{ old('c_type') == 3 ? 'checked' : '' }}> Corporate
                        </label>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Customer Balance</label>
                    <div class="row">
                      <div class="col-sm-6">
                        <input type="text" name="c_balance" value="{{ old('c_balance') }}" class="form-control" placeholder="Enter Customer Balance">
                      </div>
                      <div class="col-sm-6">
                        <label class="radio-inline pr-4">
                            <input type="radio" name="c_bal_type" value="1" {{ old('c_bal_type') == 1 ? 'checked' : '' }}> Debit
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="c_bal_type" value="2" {{ old('c_bal_type') == 2 ? 'checked' : '' }}> Credit
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="float-right btn btn-primary">Create</button>
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