@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('product_class','menu-open')
    @section('product_group_class','menu-open')
    @section('list_group','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Group List</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Group</li>
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
              <h3 class="card-title">Total Group List</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example" class="display nowrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>Seq.</th>
                          <th>Name</th>
                          <th>Created By</th>
                          <th>Updated By</th>
                          <th>Action</th>
                      </tr>
                  </thead>
                  <tbody>
                      @foreach ($groups as $item)
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $item->name }}</td>
                          <td>{{ $item->entryBy->name }}</td>
                          <td>{{ $item->updateBy->name }}</td>
                          <td><div class="btn-group">
                              <button type="button" class="btn btn-info">Action</button>
                              <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                              </button>
                              <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" onclick="groupUpdate('{{ $item->id }}')" href="#">Update</a>
                               
                                
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
  <div class="modal fade" id="groupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="groupData">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
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
<script>
  function groupUpdate(value) {
    $.ajax({
      type: "GET",
      url: "{{ route('inventory.product.group.group-ajax') }}",
      data: {value:value},
      success:function(result){
        $('#groupData').html(result);
        $('#groupModal').modal('show');
      }
      
    })
  }
</script>



@endsection