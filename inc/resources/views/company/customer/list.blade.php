@extends('company.layout.master')
@section('customer','menu-open')
@section('customer_class','active')
@section('customer_list','active')
@section('content')
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Customer List</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">List</li>
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
            <h3 class="card-title">Total Customer List</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>sl</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Type</th>
                <th>Action</th>
              </tr>
              </thead>
              <tbody>
              @foreach ($customers as $cus)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $cus->name }}</td>
                <td>{{ $cus->phone }}</td>
                <td>
                    @if ($cus->type == 1)
                        Farm/খামারী 
                    @elseif($cus->type == 2)
                        Wholesaler/পাইকার
                    @else
                        Sub-dealer/সাব-ডিলার
                    @endif
                </td>
                <td>
                  <div class="btn-group">
                    <button type="button" class="btn btn-default">Action</button>
                    <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown">
                      <span class="sr-only">Toggle Dropdown</span>
                    </button>
                    <div class="dropdown-menu" role="menu">
                      <a class="dropdown-item" onclick="customerUpdate('{{ $cus->id }}')" href="#">Update</a>
                      {{-- <div class="dropdown-divider"></div> --}}
                      
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

<div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Company Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="customerData">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- /.content -->
</div>
@endsection
@section('custom_style')
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">

@endsection
@section('custom_script')
<script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script>
    $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
<script>
  function customerUpdate(value){
    $.ajax({
      type: "GET",
      url: "{{ route('company.customer.customer-update-ajax') }}",
      data: {value:value},
      success:function(result){
        $('#customerData').html(result);
        $('#customerModal').modal('show');
      }
    });
  }
</script>
@endsection