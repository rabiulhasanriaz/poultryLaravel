@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('product_class','menu-open')
    @section('product_add_class','menu-open')
    @section('add_class','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        @include('company.layout.session_message')
            <section class="content-header">
                  <h1>
                    Buy Product
                  </h1>
                </section>
                <div class="box">
                        <div class="box-header">
                          <h3 class="box-title">Product Invoice</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                                <div class="box-header text-center">
                                    <h3 class="box-title invoice"><b>Invoice</b></h3>
                                </div>
                        <div class="col-sm-12">
                            <table class="table table-striped table-responsive">
                                <tr>
                                    <th>Customer Name</th>
                                    <td>
                                        {{ $pro_sup->person }}({{ $pro_sup->company_name }})
                                    </td>
                                    <th style="float: right;">Invoice No:</th>
                                    <td>{{ $invoice }}</td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td>{{ $pro_sup->address }}</td>
                                    <th>Mobile</th>
                                    <td>{{ $pro_sup->mobile }}</td>
                                </tr>
                                <tr>
                                    <th>Bought By</th>
                                    <td>{{ $pro_temps->first()->sold_by->name }}</td>
                                </tr>
                            </table>
                        </div>
                          <table class="table">
                            <thead>
                            <tr>
                              <th class="text-center">SL</th>
                              <th class="text-left">Description</th>
                              <th class="text-center">Bought Qty</th>
                              <th class="text-center">Short Qty</th>
                              <th class="text-center">Remarks</th>
                              <th class="text-center">Unit Price</th>
                              <th class="text-center">Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($sl=0)
                            @php($balance=0)
                            @foreach ($pro_temps as $temp)
                            <tr>
                                <td class="text-center">{{ ++$sl }}</td>
                                <td class="text-left">
                                    {{ $temp->pro_name }}
                                    <br>
                                    <b>
                                        {{ implode(', ', explode(',',$temp->slno)) }}<br>
                                    </b>
                                    @if ($temp->pro_warranty->pro_warranty == 0)
                                     <b>No Warranty</b> 
                                    @else
                                    {{ $temp->pro_warranty->pro_warranty }}(Days)
                                    @endif
                                </td>
                                <td class="text-center">{{ $temp->qty }}</td>
                                <td class="text-center">{{ $temp->short_qty }}</td>
                                <td class="text-center">{{ $temp->short_remarks }}</td>
                                <td class="text-right">{{ number_format($temp->unit_price,2) }}</td>
                                <td class="text-right">{{ number_format(($temp->unit_price * $temp->qty),2) }}</td>
                            </tr>
                            @php($balance = $balance + ($temp->unit_price * $temp->qty))

                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="5" class="text-right">Total Amount</td>
                                    <td></td>
                                    <td class="text-right">{{ number_format($balance,2) }}</td>
                                </tr>
                                {{-- <tr>
                                    <td colspan="4" class="text-right">Add Vat</td>
                                    <td></td>
                                    <td class="text-right"></td>
                                </tr> --}}
                                {{-- <tr>
                                    <td colspan="4" class="text-right">Less Discount</td>
                                    <td></td>
                                    <td class="text-right"></td>
                                </tr> --}}
                                {{-- <tr>
                                    <td colspan="4" class="text-right">Add Installation/Service Charges</td>
                                    <td></td>
                                    <td class="text-right"></td>
                                </tr> --}}
                                <tr>
                                    <td colspan="5" class="text-right"><span class="underline"><b>Net Payable Amount</b></span></td>
                                    <td></td>
                                    <td class="text-right"><span class="underline">{{ number_format($balance,2) }}</span></td>
                                </tr>
                                {{-- <tr>
                                    <td colspan="4" class="text-right"><b>Received Amount</b></td>
                                    <td></td>
                                    <td class="text-right"></td>
                                </tr> --}}
                                {{-- <tr>
                                    <td colspan="4" class="text-right"><span class="underline underline--dotted"><b>Previous Deu Amount</b></span></td>
                                    <td></td>
                                    <td class="text-right"></td>
                                </tr> --}}
                                {{-- <tr>
                                    <td colspan="4" class="text-right"><b>Current Deu Amount</b></td>
                                    <td></td>
                                    <td class="text-right"></td>
                                </tr> --}}
                            </tfoot>
                          </table>
                          <form action="{{ route('inventory.product-inventory.purchase.cart-submit') }}" method="post">
                            @csrf
                          <input type="hidden" class="" name="supplier" value="{{ $pro_sup->id }}">
                          <input type="hidden" class="" name="issue_date" value="{{ request()->issue_date }}">
                          <input type="hidden" class="" name="memo" value="{{ request()->memo }}">

                          <button type="submit" class="btn btn-success float-right">Confirm</button>
                          <form>

                          <a href="{{ route('inventory.product-inventory.purchase.add-product') }}" class="btn btn-danger " style="margin-right: 5px;">Edit</a>

                        </div>
                        <!-- /.box-body -->
                      </div>
                     </section>
    <!-- /.content -->
</div>
@endsection

