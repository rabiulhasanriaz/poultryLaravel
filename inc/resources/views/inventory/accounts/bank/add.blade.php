@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('accounts','menu-open')
    @section('bank_class','menu-open')
    @section('add_bank','active')
@elseif($user->user_type == 3)

@endif
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Add Bank</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Add Bank</li>
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
                    <h3 class="card-title">Add Bank</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('inventory.accounts.bank.add-bank-store') }}" method="post">
                    @csrf
                    <div class="card-body">

                    <div class="form-group">
                        <label>Bank Name <i class="text-danger">*</i></label>
                        <select class="form-control select2" name="b_name" style="width: 100%;">
                        <option value="">Select Bank</option>
                        @foreach ($banks as $item)
                            <option value="{{ $item->id }}" {{ old('b_name') == $item->id ? 'selected' : '' }}>{{ $item->bank_name }}</option>
                        @endforeach
                        </select>
                        @error('b_name')
                            <p class="text-danger">{{ $errors->first('b_name') }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Branch Name:<i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="br_name" value="{{ old('br_name') }}" id="" placeholder="Enter Branch Name">
                        @error('br_name')
                            <p class="text-danger">{{ $errors->first('br_name') }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Account Name:<i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="ac_name" value="{{ old('ac_name') }}" id="" placeholder="Enter Account Name">
                        @error('ac_name')
                            <p class="text-danger">{{ $errors->first('ac_name') }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Account No:<i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="ac_no" value="{{ old('ac_no') }}" id="" placeholder="Enter Account No">
                        @error('ac_no')
                            <p class="text-danger">{{ $errors->first('ac_no') }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Open Date:<i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="open_date" data-date-format="yyyy-mm-dd" value="{{ old('open_date') }}" id="accOpenDate" autocomplete="off">
                        @error('open_date')
                            <p class="text-danger">{{ $errors->first('open_date') }}</p>
                        @enderror
                    </div>



                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="float-right btn btn-primary">Submit</button>
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

$( "#accOpenDate" ).datepicker({
       daysOfWeekHighlighted: "7",
        todayHighlight: true,
        autoclose: true,
     });

});
</script>
@endsection