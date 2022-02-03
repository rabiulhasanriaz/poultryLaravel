@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
@extends('company.layout.master')
@section('inventory','menu-open')
@section('product_inventory_class','menu-open')
@section('sell_product_class','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sell Product Details</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sell Product Details</li>
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
                    Sell Product
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
                                {{ $pro_cus->cus_name }}({{ $pro_cus->inv_cus_com_name }})
                            </td>
                            
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $pro_cus->cus_address }}</td>
                            <th>Invoice No:</th>
                            {{-- @php($invoiceNo = App\Models\ProductInventory::getInvoice($pro_cus)) --}}
                            <td></td>
                        </tr>
                        <tr>
                            <th>Sold By</th>
                            
                            <td>{{ $pro_temps->first()->sold_by->name }}</td>
                            <th>Mobile</th>
                            <td>{{  $pro_cus->cus_mobile }}</td>
                        </tr>
                    </table>
                </div>
                  <table class="table">
                    <thead>
                    <tr>
                      <th class="text-center">SL</th>
                      <th class="text-left">Description</th>
                      
                      <th class="text-center">Sold Qty</th>
                      <th class="text-center">Unit Price</th>
                      <th class="text-center">Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php($sl=0)
                    @php($balance=0)
                    @php($total = 0)
                    @foreach ($pro_temps as $temp)
                    <tr>
                        <td class="text-center">{{ ++$sl }}</td>
                        <td class="text-left">
                          @if ($temp->deal_type == 5)
                              Service Charge
                          @else
                          {{ $temp->pro_warranty->pro_description }}({{ $temp->pro_name }})
                          @endif
                            <br>
                            <b>
                                {{ implode(', ', explode(',',$temp->slno)) }}
                            </b><br>
                            @if ($temp->deal_type == 5)
                            @else
                            @if ($temp->pro_warranty->pro_warranty == 0)
                            @else
                                <b>Warranty: </b>{{ $temp->pro_warranty->pro_warranty }}(Days)
                            @endif
                            @endif
                            
                        </td>
                        
                        <td class="text-center">{{ $temp->qty }}</td>
                        <td class="text-right">{{ number_format($temp->unit_price,2) }}</td>
                        <td class="text-right">{{ number_format(($temp->unit_price * $temp->qty),2) }}</td>
                    </tr>
                    @php($balance = $balance + ($temp->unit_price * $temp->qty))

                    @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right">Total Amount</td>
                            <td class="text-right">{{ number_format($balance,2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><span class="underline"><b>Discount</b></span></td>
                            
                            <td class="text-right"><span class="underline">{{ number_format($discount,2) }}</span></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right"><span class="underline"><b>Delivery Charges</b></span></td>
                            
                            <td class="text-right"><span class="underline">{{ number_format($delivery,2) }}</span></td>
                        </tr>
                        @php($total = ($balance +  $delivery) - $discount)
                        
                        <tr>
                            <td colspan="4" class="text-right"><span class="underline"><b>Net Payable Amount</b></span></td>
                            
                            <td class="text-right"><span class="underline">{{ number_format($total,2) }}</span></td>
                        </tr>
                        
                    </tfoot>
                  </table>
                  <table class="pull-right">
                    <tr>
                      <td>
                        <a href="{{ route('inventory.product-inventory.sale.sell-product') }}" class="btn btn-danger pull-right" style="margin-right: 5px;">Edit</a>
                      </td>
                      <td>
                        <form action="{{ route('inventory.product-inventory.sale.cart-submit') }}" method="post">
                        @csrf
                        <input type="hidden" name="project" value="{{ $project }}">
                        <input type="hidden" class="" name="customer" value="{{ $pro_cus->id }}">
                        <input type="hidden" class="" name="discount" value="{{ $discount }}">
                        <input type="hidden" class="" name="delivery" value="{{ $delivery }}">
                        <button type="submit" class="float-right btn btn-success">Print</button>
                      </form>
                      </td>
                    </tr>
                  </table>
                  
                  
                  

                  

                </div>
                <!-- /.box-body -->
              </div>
                
    </section>
    <!-- /.content -->
</div>
@endsection

