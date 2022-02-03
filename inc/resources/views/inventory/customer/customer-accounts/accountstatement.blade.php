@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('customer_class','menu-open')
    @section('customer_account_class','menu-open')
    @section('list_account','active')
@elseif($user->user_type == 3)

@endif
@section('content')

  <div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Customer Account Statement</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Account Statement</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
      
      <!-- Main content -->
      <section class="content">
        @if ($errors->any())
          <div class="alert alert-danger">
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif
      @include('root.layout.session_message')
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              
              <!-- /.card -->
      
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Customer Account Statement</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example" class="display nowrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Sl.</th>
                              <th>Company</th>
                              <th>Name</th>
                              <th>Debit</th>
                              <th>Credit</th>
                              <th>Balance</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                        @php
                          $total_credit=0;
                          $total_debit=0;
                          $total_balance=0;
                          $debit = 0;
                          $credit = 0;
                          $balance = 0;
                        @endphp
                        @foreach ($customers as $cus)
                        @php
                          $debit = App\Models\ProductInventory::getCusDebitByID($cus->id);
                          $credit = App\Models\ProductInventory::getCusCreditByID($cus->id);
                          $total_credit += $credit;
                          $total_debit += $debit;
                          $total_balance += App\Models\ProductInventory::getCusBalanceByID($cus->id);
                          $balance = $balance + $credit - $debit;
                        @endphp
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $cus->cus_com_name }}</td>
                          <td>{{ $cus->cus_name }}</td>
                          <td class="text-right">{{ number_format($debit,2) }}</td>
                          <td class="text-right">{{ number_format($credit,2) }}</td>
                          <td class="text-right">{{ number_format($balance,2) }}</td>
                          <td>ABCD</td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
      </section>
  </div>

@endsection
@section('custom_style')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">

@endsection
@section('custom_script')
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    } );
} );
</script>




@endsection