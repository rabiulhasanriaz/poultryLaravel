@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('accounts','menu-open')
    @section('bank_class','menu-open')
    @section('list_bank','active')
@elseif($user->user_type == 3)

@endif
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                <h1>Bank List</h1>
                </div>
                <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Bank List</li>
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
                    <h3 class="card-title">Bank List</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                    <table id="example" class="display nowrap" style="width:100%">
                        <thead>
                            <tr>
                                <th>SL</th>
                                <th>Bank Name</th>
                                <th>Branch Name</th>
                                <th>Account No</th>
                                <th>Debit</th>
                                <th>Credit</th>
                                <th>Balance</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $debit = 0;
                                $totalDebit = 0;
                                $credit = 0;
                                $totalCredit = 0;
                                $balance = 0;
                                $total = 0;
                            @endphp
                        
                            @foreach ($bank_infos as $item)
                            @php
                                $debit = App\Models\AccBankStatement::getTotalDebitByBankId($item->id);
                                $totalDebit += $debit;
                                $credit = App\Models\AccBankStatement::getTotalCreditByBankId($item->id);
                                $totalCredit += $credit;
                                $balance = App\Models\AccBankStatement::getAvailableBalanceByBankId($item->id);
                                $total = $total + $balance;
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->bank_info->bank_name }}</td>
                                <td>{{ $item->branch_name }}</td>
                                <td>{{ $item->account_no }}</td>
                                <td class="text-right">{{ number_format($debit,2) }}</td>
                                <td class="text-right">{{ number_format($credit,2) }}</td>
                                <td class="text-right">{{ number_format($balance,2) }}</td>
                                <td></td>
                            </tr>
                            @endforeach
                            {{-- @foreach ($users as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td><div class="btn-group">
                                    <button type="button" class="btn btn-info">Action</button>
                                    <button type="button" class="btn btn-info dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" onclick="userUpdate('{{ $item->id }}')" href="#">Update</a>
                                    
                                        
                                    </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach --}}
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