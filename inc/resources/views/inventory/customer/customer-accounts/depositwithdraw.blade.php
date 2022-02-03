@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('customer_class','menu-open')
    @section('customer_account_class','menu-open')
    @section('diposit-withdraw','active')
@elseif($user->user_type == 3)

@endif
@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Customer Deposite/Withdrow</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Deposite/Withdrow</li>
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
                <h3 class="card-title">Make Transaction</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('inventory.customer.account.deposit-withdraw-store') }}" method="post">
                @csrf
                <div class="card-body">

                  <div class="form-group">
                    <label>Customer <i class="text-danger">*</i></label>
                    <select class="form-control select2" name="c_name" style="width: 100%;" id="customer_id" onchange="loadAvailableBalanceOfCustomer()">
                      <option value="">Select Customer</option>
                      @foreach ($customers as $cus)
                          <option value="{{ $cus->id }}" {{ old('c_name') == $cus->id ? 'selected' : '' }}>{{ $cus->cus_name }}</option>
                      @endforeach
                    </select>
                    <div class="col-sm-12 customer_balance_div"></div>
                    @error('c_name')
                      <p class="text-danger">{{ $errors->first('c_name') }}</p>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="">Transaction Type: <i class="text-danger">*</i></label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="c_t_type" {{ old('c_t_type') == 2 ? 'checked' : '' }} id="inlineRadio1" value="2">
                      <label class="form-check-label" for="inlineRadio1">Credit</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="c_t_type" {{ old('c_t_type') == 3 ? 'checked' : '' }} id="inlineRadio2" value="3">
                      <label class="form-check-label" for="inlineRadio2">Debit</label>
                    </div>
                    @error('c_t_type')
                      <p class="text-danger">{{ $errors->first('c_t_type') }}</p>
                    @enderror
                  </div>

                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-4">
                        <label for="exampleInputEmail1">Transaction Date <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" data-date-format="yyyy-mm-dd" name="c_t_date" value="{{ old('c_t_date') }}" autocomplete="off" id="t_date" placeholder="Enter email">
                        @error('c_t_date')
                          <p class="text-danger">{{ $errors->first('c_t_date') }}</p>
                        @enderror
                      </div>
                      <div class="col-md-4">
                        <label for="exampleInputEmail1">Reference</label>
                        <input type="text" class="form-control" name="c_reference" value="{{ old('c_reference') }}" autocomplete="off" id="" placeholder="Enter Reference">
                      </div>
                      <div class="col-md-4">
                        <label for="exampleInputEmail1">Amount <i class="text-danger">*</i></label>
                        <input type="text" class="form-control" name="c_amount" value="{{ old('c_amount') }}" autocomplete="off" id="" placeholder="Enter Amount">
                        @error('c_amount')
                        <p class="text-danger">{{ $errors->first('c_amount') }}</p>
                      @enderror
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

$( "#t_date" ).datepicker({
       daysOfWeekHighlighted: "7",
        todayHighlight: true,
        autoclose: true,
     });

});

function loadAvailableBalanceOfCustomer() {
    let customer_id = $("#customer_id").val();
    var requestUrl="{{route('inventory.customer.account.customer-balance-ajax')}}";
    var _token = $("#_token").val();
    $.ajax({  
      type: "GET",
      url: requestUrl,
      data: { customer_id: customer_id,_token:_token},
      success: function (result) {
       $(".customer_balance_div").html(result);
      }
    });
  }
</script>
@endsection