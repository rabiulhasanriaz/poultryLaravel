@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('supplier','menu-open')
    @section('supplier_class','menu-open')
    @section('supplier_add_class','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Supplier</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Add Supplier</li>
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
                <h3 class="card-title">Add Supplier</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('inventory.supplier.sup.sup-store') }}" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="">Company Name <i class="text-danger">*</i></label>
                    <input type="text" name="c_name" value="{{ old('c_name') }}" class="form-control" id="" placeholder="Enter Company Name">
                    @error('c_name')
                      <p class="text-danger">{{ $errors->first('c_name') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Address <i class="text-danger">*</i></label>
                    <input type="text" name="s_address" value="{{ old('s_address') }}" class="form-control" id="" placeholder="Enter Address">
                    @error('s_address')
                      <p class="text-danger">{{ $errors->first('s_address') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Person Name <i class="text-danger">*</i></label>
                    <input type="text" name="s_person" value="{{ old('s_person') }}" class="form-control" id="" placeholder="Enter Person Name">
                    @error('s_person')
                      <p class="text-danger">{{ $errors->first('s_person') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Mobile <i class="text-danger">*</i></label>
                    <input type="text" name="s_mobile" value="{{ old('s_mobile') }}" class="form-control" id="" placeholder="Enter Mobile Number">
                    @error('s_mobile')
                      <p class="text-danger">{{ $errors->first('s_mobile') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Phone </label>
                    <input type="text" name="s_phone" value="{{ old('s_phone') }}" class="form-control" id="" placeholder="Enter Phone Number">
                  </div>
                  <div class="form-group">
                    <label for="">E-Mail </label>
                    <input type="text" name="s_email" value="{{ old('s_email') }}" class="form-control" id="" placeholder="Enter E-mail Address">
                  </div>
                  <div class="form-group">
                    <label for="">Website </label>
                    <input type="text" name="s_website" value="{{ old('s_website') }}" class="form-control" id="" placeholder="Enter Website Name">
                  </div>
                  <div class="form-group">
                    <label for="">Complain Number </label>
                    <input type="text" name="s_complain" value="{{ old('s_complain') }}" class="form-control" id="" placeholder="Enter Complain Number">
                  </div>
                  <div class="form-group">
                    <label for="">Supplier Type <i class="text-danger">*</i></label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" {{ old('s_type') == 1 ? 'checked' : '' }} name="s_type" id="inlineRadio1" value="1">
                      <label class="form-check-label" for="inlineRadio1">Regular</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" {{ old('s_type') == 2 ? 'checked' : '' }} name="s_type" id="inlineRadio2" value="2">
                      <label class="form-check-label" for="inlineRadio2">Irregular</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" {{ old('s_type') == 3 ? 'checked' : '' }} name="s_type" id="inlineRadio3" value="3">
                      <label class="form-check-label" for="inlineRadio3">Importer</label>
                    </div>
                    @error('s_type')
                      <p class="text-danger">{{ $errors->first('s_type') }}</p>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="">Open Due Balance </label>
                    <div class="row">
                      <div class="col-md-6">
                        <input type="text" name="s_due_bal" value="{{ old('s_due_bal') }}" class="form-control" id="" placeholder="Due Balance">
                        </div>
                        <div class="col-md-6">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" {{ old('s_bal_type') == 1 ? 'checked' : '' }} name="s_bal_type" id="inlineRadio1" value="1">
                            <label class="form-check-label" for="inlineRadio1">Debit</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" {{ old('s_bal_type') == 2 ? 'checked' : '' }} name="s_bal_type" id="inlineRadio2" value="2">
                            <label class="form-check-label" for="inlineRadio2">Credit</label>
                          </div>
                        </div>
                    </div>
                    
                  </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="float-right btn btn-primary">Submit</button>
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