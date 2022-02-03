@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('supplier','menu-open')
    @section('supplier_accounts_class','menu-open')
    @section('deposit_withdraw_class','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Supplier's Supplier's Deposit/Withdraw</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Deposit/Withdraw</li>
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
              <form action="{{ route('inventory.supplier.accounts.deposit-withdraw-store') }}" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-group">
                    <label for="">Supplier: <i class="text-danger">*</i></label>
                    <select class="form-control select2" name="s_name" onchange="loadAvailableBalanceOfSupplier()" id="supplier_id" style="width: 100%;">
                      <option value="">Select Supplier</option>
                      @foreach ($suppliers as $sup)
                          <option value="{{ $sup->id }}" {{ old('s_name') == $sup->id ? 'selected' : '' }}>{{ $sup->company_name }}</option>
                      @endforeach
                    </select>
                    @error('s_name')
                      <p class="text-danger">{{ $errors->first('s_name') }}</p>
                    @enderror
                  </div>
                  <div class="col-sm-12 supplier_balance_div"></div>
                  <div class="form-group">
                    <label for="">Transaction Date: <i class="text-danger">*</i></label>
                    <input type="text" name="s_t_date" value="{{ old('s_t_date') }}" data-date-format="yyyy-mm-dd" class="form-control" autocomplete="off" id="t_date" placeholder="Enter Transaction Date">
                    @error('s_t_date')
                      <p class="text-danger">{{ $errors->first('s_t_date') }}</p>
                    @enderror
                  </div>
                <div class="form-group">
                    <label for="">Transaction Type: <i class="text-danger">*</i></label>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="s_t_type" {{ old('s_t_type') == 2 ? 'checked' : '' }} id="inlineRadio1" value="2">
                      <label class="form-check-label" for="inlineRadio1">Credit</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="s_t_type" {{ old('s_t_type') == 3 ? 'checked' : '' }} id="inlineRadio2" value="3">
                      <label class="form-check-label" for="inlineRadio2">Debit</label>
                    </div>
                    @error('s_t_type')
                      <p class="text-danger">{{ $errors->first('s_t_type') }}</p>
                    @enderror
                </div>
                  <div class="form-group">
                    
                    <div class="row">
                      <div class="col-md-6">
                        <label for="">Amount <i class="text-danger">*</i></label>
                        <input type="text" name="s_amount" class="form-control" value="{{ old('s_amount') }}" id="" placeholder="Amount">
                        @error('s_amount')
                          <p class="text-danger">{{ $errors->first('s_amount') }}</p>
                        @enderror
                      </div>
                        <div class="col-md-6">
                          <label for="">Reference </label>
                          <input type="text" name="s_reference" class="form-control" value="{{ old('s_reference') }}" id="" placeholder="Reference">
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

function loadAvailableBalanceOfSupplier() {
    let supplier_id = $("#supplier_id").val();
  
    
    var requestUrl="{{route('inventory.supplier.accounts.supplier-balance-ajax')}}";
  
   var _token=$("#_token").val();

    $.ajax({  
      type: "GET",
      url: requestUrl,
      data: { supplier_id: supplier_id,_token:_token},
      success: function (result) {
       $(".supplier_balance_div").html(result);
      }
    });
  }
</script>
@endsection