@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('projects_class','menu-open')
    @section('project_list','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Project Details</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Project</li>
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
                  <h3 class="card-title">{{ $project->name }}'s Invoice Details</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <table id="example" class="display nowrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>Seq.</th>
                              <th>Issue Date</th>
                              <th>Invoice</th>
                              <th>Debit</th>
                              <th>Credit</th>
                              <th>Amount</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($invoices as $item)
                          @php
                            
                          @endphp
                          <tr>
                              <td>{{ $loop->iteration }}</td>
                              <td>{{ $item->issue_date }}</td>
                              <td>{{ $item->invoice_no }}</td>
                              <td class="text-right">{{ number_format($item->totalDebit,2) }}</td>
                              <td class="text-right">{{ number_format($item->totalCredit,2) }}</td>
                              <td class="text-center">{{ number_format($item->totalAmount,2) }}</td>
                              <td>
                                  <a href="javascript:void(0);" onclick="invoice_reports('{{ $item->invoice_no }}')">
                                      View Details
                                  </a>
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
    

      <div class="modal fade" id="invoiceReports" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Invoice Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body" id="invoiceModalDetails">
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

function invoice_reports(invoice) {

let url = "{{ route('inventory.project.invoice-ajax') }}";
var _token=$("#_token").val();
$.ajax({  
  type: "GET",
  url: url,
  data: { invoice: invoice,_token:_token},
  success: function (result) {
   $("#invoiceModalDetails").html(result);
   $("#invoiceReports").modal("show");
  }
});
}
</script>




@endsection