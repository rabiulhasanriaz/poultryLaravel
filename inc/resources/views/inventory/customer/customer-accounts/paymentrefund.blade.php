@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('customer_class','menu-open')
    @section('customer_account_class','menu-open')
    @section('payment_refund','active')
@elseif($user->user_type == 3)

@endif
@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Customer Payment Refund</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Payment Refund</li>
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
                    <h3 class="card-title">Payment Refund</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('inventory.customer.account.payment-refund-store') }}" method="post">
                    @csrf
                    <div class="card-body">
                      <div class="form-group">
                        <label for="">Customer: <i class="text-danger">*</i></label>
                        <select class="form-control select2" name="c_name" onchange="loadAvailableBalanceOfCustomer()" id="customer_id" style="width: 100%;">
                          <option value="">Select Customer</option>
                          @foreach ($customers as $cus)
                              <option value="{{ $cus->id }}" {{ old('c_name') == $cus->id ? 'selected' : '' }}>{{ $cus->cus_name }}</option>
                          @endforeach
                        </select>
                        @error('c_name')
                          <p class="text-danger">{{ $errors->first('c_name') }}</p>
                        @enderror
                        <div class="col-sm-12 customer_balance_div"></div>
                      </div>
                      
    
                      <div class="form-group">
                        <label for="">Payment Method: </label>
                        <select class="form-control select2" name="b_id" id="bank_id" onchange="loadAvailableBalanceOfBank()" style="width: 100%;">
                          <option value="">Select Method</option>
                          @foreach ($banks as $bank)
                              <option value="{{ $bank->id }}" {{ old('b_id') == $bank->id ? 'selected' : '' }}>
                                {{$bank->bank_info->bank_name }} ({{$bank->account_no}})
                            </option>
                          @endforeach
                        </select>
                        <div class="bank_balance_div"></div>
                      </div>
                      
                      <div class="form-group">
                        
                        <div class="row">
                          <div class="col-md-4">
                            <label for="">Transaction Date: <i class="text-danger">*</i> </label>
                            <input type="text" name="p_t_date" class="form-control" autocomplete="off" data-date-format="yyyy-mm-dd" value="{{ old('p_t_date') }}" id="t_date" placeholder="Date">
                            @error('p_t_date')
                                <p class="text-danger">{{ $errors->first('p_t_date') }}</p>
                            @enderror
                          </div>
                          <div class="col-md-4">
                            <label for="">Reference </label>
                            <input type="text" name="p_reference" class="form-control" value="{{ old('p_reference') }}" id="" placeholder="Reference">
                          </div>
                          <div class="col-md-4">
                            <label for="">Amount <i class="text-danger">*</i></label>
                            <input type="text" name="p_amount" class="form-control" value="{{ old('p_amount') }}" id="" placeholder="Amount">
                            @error('p_amount')
                              <p class="text-danger">{{ $errors->first('p_amount') }}</p>
                            @enderror
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

  function loadAvailableBalanceOfBank() {
    let bank_id = $("#bank_id").val();
    var requestUrl="{{route('inventory.customer.account.bank-balance-ajax')}}";
    var _token = $("#_token").val();
    $.ajax({  
      type: "GET",
      url: requestUrl,
      data: { bank_id: bank_id,_token:_token},
      success: function (result) {
       $(".bank_balance_div").html(result);
      }
    });
  }
</script>
@endsection