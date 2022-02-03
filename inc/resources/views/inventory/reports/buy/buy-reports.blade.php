@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
@extends('company.layout.master')
@section('inventory','menu-open')
@section('reports_class','menu-open')
@section('buy_reports','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Buy Report</h1>
              <form action="" method="get">
                <div class="form-row align-items-center">
                  <div class="col-sm-3 my-1">
                    <input type="text" class="form-control" name="start_date" autocomplete="off" data-date-format="yyyy-mm-dd" id="start_date" placeholder="Start Date">
                  </div>
                  <div class="col-sm-3 my-1">
                    <div class="input-group">
                      <input type="text" class="form-control" name="end_date" autocomplete="off" data-date-format="yyyy-mm-dd" id="end_date" placeholder="End Date">
                    </div>
                  </div>
                  <div class="col-auto my-1">
                    <button type="submit" name="searchbtn" class="btn btn-primary">Search</button>
                  </div>
                  <div class="col-auto my-1">
                    <button type="submit" class="btn btn-warning">Download</button>
                  </div>
                </div>
              </form>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Buy</li>
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
            <div class="col-12">
              
              <!-- /.card -->
      
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Sell Report</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example" class="display nowrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Seq.</th>
                              <th>Invoice No.</th>
                              <th>Issue Date</th>
                              <th>Supplier Name</th>
                              <th>Description</th>
                              <th>Amount</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($buy_reports as $item)
                          @php
                            $total = App\Models\ProductInventory::getTotalDebit($item->invoice_no);
                          @endphp
                          <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $item->invoice_no }}</td>
                              <td>{{ $item->issue_date }}</td>
                              <td>{{ $item->getSupplierInfo->company_name }}</td>
                              <td>{{ $item->tran_desc }}</td>
                              <td>{{ number_format($total,2) }}</td>
                              <td><div class="btn-group">
                                  <button type="button" class="btn btn-info btn-xs">Action</button>
                                  <button type="button" class="btn btn-info btn-xs dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                  </button>
                                  <div class="dropdown-menu" role="menu">
                                    <a class="dropdown-item" onclick="buy_reports('{{ $item->invoice_no }}')" href="#">Details</a>
                                   
                                    
                                  </div>
                                </div>
                              </td>
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
    

      <div class="modal fade" id="buyReports" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Invoice Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="buyModalDetails">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      
@endsection

@section('custom_style')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="{{ asset('assets/datepicker/bootstrap-datepicker.min.css') }}">
@endsection
@section('custom_script')
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="{{ asset('assets/datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        responsive: true
    } );
} );

$(document).ready(function(){
$( "#start_date" ).datepicker({
       daysOfWeekHighlighted: "7",
        todayHighlight: true,
        autoclose: true,
});

$( "#end_date" ).datepicker({
       daysOfWeekHighlighted: "7",
        todayHighlight: true,
        autoclose: true,
});

});

function buy_reports(buy_id) {

let url = "{{ route('inventory.reports.buy.buy-reports-ajax') }}";
var _token=$("#_token").val();
$.ajax({  
  type: "GET",
  url: url,
  data: { buy_id: buy_id,_token:_token},
  success: function (result) {
   $("#buyModalDetails").html(result);
   $("#buyReports").modal("show");
  }
});
}
</script>




@endsection