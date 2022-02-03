@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('accounts','menu-open')
    @section('bank_class','menu-open')
    @section('deposit_withdraw','active')
@elseif($user->user_type == 3)

@endif
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Deposit/Withdraw Bank Balance</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Deposit/Withdraw Bank Balance</li>
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
                    <h3 class="card-title">Deposit/Withdraw Bank Balance</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('inventory.accounts.bank.deposit-withdraw-store') }}" method="post">
                    @csrf
                    <div class="card-body">

                    <div class="form-group">
                        <label>Bank <i class="text-danger">*</i></label>
                        <select class="form-control select2" name="b_id" id="bank_id" onchange="loadAvailableBalanceOfBank()" style="width: 100%;">
                        <option value="">Select Bank</option>
                        @foreach ($banks as $item)
                            <option value="{{ $item->id }}" {{ old('b_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->bank_info->bank_name }} ({{ $item->account_name }})
                            </option>
                        @endforeach
                        </select>
                        @error('b_id')
                            <p class="text-danger">{{ $errors->first('b_id') }}</p>
                        @enderror
                        <div class="col-sm-12 bank_balance_div"></div>
                    </div>

                    <div class="form-gorup">
                        <label for="">Balance Type: <i class="text-danger">*</i></label>
                        <select name="b_type" id="" class="form-control">
                            <option value="">Select Balance Type</option>
                            <option value="6" {{ old('b_type') == 6 ? 'selected' : '' }}>Credit/Deposit</option>
                            <option value="7" {{ old('b_type') == 7 ? 'selected' : '' }}>Debit/Withdraw</option>
                        </select>
                        @error('b_type')
                            <p class="text-danger">{{ $errors->first('b_type') }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Transaction Date: <i class="text-danger">*</i></label>
                        <input type="text" name="t_date" autocomplete="off" data-date-format="yyyy-mm-dd" value="{{ old('t_date') }}" class="form-control" id="transactionDate" placeholder="Enter Transaction Date">
                        @error('t_date')
                            <p class="text-danger">{{ $errors->first('t_date') }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Reference:</label>
                        <input type="text" name="ref" value="{{ old('ref') }}" class="form-control" id="" placeholder="Enter Reference">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Amount: <i class="text-danger">*</i></label>
                        <input type="text" name="tr_amnt" value="{{ old('tr_amnt') }}" class="form-control" id="" placeholder="Enter Amount">
                        @error('tr_amnt')
                            <p class="text-danger">{{ $errors->first('tr_amnt') }}</p>
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
$( "#transactionDate" ).datepicker({
       daysOfWeekHighlighted: "7",
        todayHighlight: true,
        autoclose: true,
     });

     function loadAvailableBalanceOfBank() {
        let bank_id = $("#bank_id").val();
        var requestUrl="{{route('inventory.accounts.bank.ajax-load-bank-balance')}}";
        var _token = $("#_token").val();
        //$("#_token").val();
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