@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('product_inventory_class','menu-open')
    @section('purchase_class','menu-open')
    @section('add_product_class','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Purchase Product</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Add Product</li>
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
                  <h3 class="card-title">Add Product</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('inventory.product-inventory.purchase.buy-temporary') }}" method="get">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="inputEmail4">Supplier <i class="text-danger">*</i></label>
                                <select class="form-control select2" name="supplier" style="width: 100%;" id="product_category">
                                    <option value="">Please select the Supplier</option>
                                    @foreach ($suppliers as $sup)
                                        <option value="{{ $sup->id }}" {{ old('supplier') == $sup->id ? 'selected' : '' }}>
                                            {{ $sup->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('supplier')
                                    <p class="text-danger">{{ $errors->first('supplier') }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Issue Date <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" autocomplete="off" data-date-format="yyyy-mm-dd" value="{{ old('issue_date') }}" name="issue_date" id="issue_date" placeholder="Issue Date">
                                @error('issue_date')
                                    <p class="text-danger">{{ $errors->first('issue_date') }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputPassword4">Memo No <i class="text-danger">*</i></label>
                                <input type="text" class="form-control" value="{{ old('memo') }}" name="memo" id="" placeholder="Memo No">
                                @error('memo')
                                    <p class="text-danger">{{ $errors->first('memo') }}</p>
                                @enderror
                            </div>
                        </div>
                    
                  <table id="example" class="display nowrap" style="width:100%">
                      <thead>
                          <tr>
                              <th>SL</th>
                              <th>Name</th>
                              <th>Type</th>
                              <th>A. S.</th>
                              <th>Exp. Date</th>
                              <th>Buy Price</th>
                              <th>Short</th>
                              <th>Remarks</th>
                              <th>Purchase</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($products as $pro)
                        <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $pro->pro_name }}</td>
                          <td>{{ $pro->typeName->name }}</td>
                          <td class="text-center">{{ $pro->available_qty }}</td>
                          <td>
                            <input type="text" autocomplete="off" data-date-format="yyyy-mm-dd" class="form-control exp_date" id="exp_date_{{ $pro->id }}" style="width: 100px;" placeholder="Expire Date">
                          </td>
                          <td>
                            <input type="text" class="form-control" id="pro_price_{{ $pro->id }}" style="width: 100px;" value="{{ $pro->buy_price }}">
                          </td>
                          <td class="text-right">
                            @if($pro->pro_warranty == 0)
                                <input type="text" autocomplete="off" class="form-control" name="short_qty" id="short_qty_{{ $pro->id }}" style="width: 70px;" placeholder="Qty">
                            @else
                                <input type="text" autocomplete="off" class="form-control" name="short_qty" style="width: 70px;" placeholder="N/A" readonly disabled>
                            @endif
                          </td>
                          <td>
                            <input type="text" name="remarks" autocomplete="off" class="form-control" id="short_remarks_{{ $pro->id }}" placeholder="Reason of short quatity..">
                          </td>
                          <td>
                            @if($pro->pro_warranty == 0)
                            <div class="form-row align-items-center">
                                <div class="col-auto">
                                    <input type="text" autocomplete="off" class="form-control" style="width: 50px;" id="pro_qty_{{ $pro->id }}" placeholder="Qty">
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success btn-xs" onclick="addtocart('{{ $pro->id }}')">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            @else
                            <div class="form-row align-items-center">
                                <div class="col-auto">
                                    <input type="text" class="form-control warranty" style="width: 50px;" placeholder="N/A" readonly disabled>
                                </div>
                                <div class="col-auto">
                                    <button type="button" class="btn btn-success btn-xs" onclick="addWarrentyProduct('{{ $pro->id }}')">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                  </table>
                </div>
                <div class="box-body">
                    <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-shopping-cart"></i>
                                Buy Invoice
                            </h3>
                            </div>  
                    <div class="col-sm-12">                
                                <div class="box shopping_cart"> 
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>Buy Qty</th>
                                                <th>Expire date</th>
                                                <th>Unit Price</th>
                                                <th>Amount</th>
                                                <th>Short</th>
                                                <th>Remarks</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="show-cart-conten">
                                            
                                        </tbody>
                                    </table>
                                </div>
                                

                                <div class="form-row align-items-center float-right">
                                    <div class="col-auto">
                                        <label for="inputEmail3" class="control-label">Total: </label>
                                    </div>
                                    <div class="col-auto">
                                      <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                      <div class="input-group mb-2">
                                        <input type="text" class="text-right form-control" disabled id="total_buy" placeholder="">
                                      </div>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-success btn-xs pull-right">Continue</button>
                                    </div>
                                  </div>
                        </div>
                        
              </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div>
    </form>
        <!-- /.container-fluid -->
      </section>
      @include('inventory.product-inventory.purchase.ajax.warranty-product-get-sl-no');
    </div>
@endsection
@section('custom_style')

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/datepicker/bootstrap-datepicker.min.css') }}">
<style>
    .form-control{
        height: 30px;
    }
    .table>tbody>tr>td{
        padding: 2px;
    }
    
</style>
@endsection
@section('custom_script')
{{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> --}}
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{ asset('assets/datepicker/bootstrap-datepicker.min.js') }}"></script>
<script>
    function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
        try {
            decimalCount = Math.abs(decimalCount);
            decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

            const negativeSign = amount < 0 ? "-" : "";

            let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
            let j = (i.length > 3) ? i.length % 3 : 0;

            return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
        } catch (e) {
            console.log(e)
        }
        }

    function total_buy_amount(){
        let amount = 0;
        $('.temp_cart').each(function(i, obj) {
            amount = amount + parseFloat(obj.innerText.split(',').join(''));
        });
        if (isNaN(amount)) {
            amount = 0;
        }

        $('#total_buy').val(formatMoney(amount));
    }

      $(document).ready(function() {
    $('.select2').select2();
});
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        pageLength : 5,
        
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true
    } );
} );

$(document).ready(function(){
    getCartProduct();
$( "#issue_date" ).datepicker({
       daysOfWeekHighlighted: "7",
        todayHighlight: true,
        autoclose: true,
});

$( ".exp_date" ).datepicker({
       daysOfWeekHighlighted: "7",
        todayHighlight: true,
        autoclose: true,
});

});
</script>
<script>
    function addtocart(pro_det_id) {
        let pro_qty = parseFloat($("#pro_qty_"+pro_det_id).val());
        let short_qty = parseFloat($("#short_qty_"+pro_det_id).val());
        let pro_price = parseFloat($("#pro_price_"+pro_det_id).val());
        let remarks = $("#short_remarks_"+pro_det_id).val();
        let exp_date = $("#exp_date_"+pro_det_id).val();
        if(isNaN(pro_qty) || isNaN(pro_price)) {
            alert("quantity field can\'t be empty");
        } else if(pro_qty < 1) {
            alert("minimum quantity at least 1");
        } else {

            let route_url = "{{ route('inventory.product-inventory.purchase.add-to-cart') }}";
            $.ajax({
                type: "GET",
                url: route_url,
                data: { pro_id: pro_det_id, pro_qty: pro_qty, pro_price: pro_price, exp_date: exp_date, short_qty:short_qty , remarks:remarks},
                success: function (result) {
                    if(result.status == 400) {
                        alert("Stock has been cross it's limit");
                    } else {
                        getCartProduct();
                    }
                }
            });
        }
    }

    function getCartProduct() {
        let route_url = "{{ route('inventory.product-inventory.purchase.get-cart-content') }}";
        $.ajax({
            type: "GET",
            url: route_url,
            data: {},
            success: function (result) {
                $("#show-cart-conten").html(result);
                total_buy_amount();
            }
        });
    }

    function update_cart_quantity(content_id) {
        let pro_quantity = parseFloat($("#update_qty_"+content_id).val());
        if(pro_quantity < 1) {
            alert("Minimum Quantity is 1");
            return false;
        }
        let route_url = "{{ route('inventory.product-inventory.purchase.update-cart') }}";
        $.ajax({
            type: "GET",
            url: route_url,
            data: {content_id:content_id, pro_qty:pro_quantity},
            success: function (result) {
                getCartProduct();
            }
        });
    }

    function remove_cart(content_id) {
        let clickDel = confirm("Are you sure want to delete this?");
        if (clickDel == true) {
            
        }else{
            return false;
        }
        
        let route_url = "{{ route('inventory.product-inventory.purchase.remove-cart') }}";
        $.ajax({
            type: "GET",
            url: route_url,
            data: {content_id:content_id},
            success: function (result) {
                getCartProduct();
            }
        });
    }

    function addWarrentyProduct (pro_det_id) {
        let pro_price = parseFloat($("#pro_price_"+pro_det_id).val());
        let exp_date = $("#exp_date_"+pro_det_id).val();
        
        let route_url = "{{ route('inventory.product-inventory.purchase.add-to-cart-warrenty-product') }}";
        
        $.ajax({
            type: "GET",
            url: route_url,
            data: { pro_id: pro_det_id, pro_price: pro_price, exp_date: exp_date},
            success: function (result) {
                if(result.status == 404) {
                    alert("Invalid Warrenty Product");
                } else if(result.status == 406) {
                    alert("Invalid Warrenty Product");
                } else {
                    $("#warrenty_product_get_sl_no .modal-content").html(result);
                    $("#warrenty_product_get_sl_no").modal('show');
                }
            }
        });
        
    }

    function add_warrenty_pro_sl_no() {
        
    }

    function check_sl_no(value, pro_det_id) {
        
        let sl_no = value;
        if(sl_no == '') {
            alert("sl no is required");
            return false;
        }
        let route_url = "{{ route('inventory.product-inventory.purchase.add-warrenty-product-sl-no') }}";
        $.ajax({
            type: "GET",
            url: route_url,
            data: { pro_id: pro_det_id, sl_no: sl_no},
            success: function (result) {
                if(result.status == 404) {
                    alert("Invalid Warrenty Product");
                } else if(result.status == 402) {
                    alert("Already Added");
                } else {
                    $("#all-added-warrenty-product-id .show-added-list").html(result);
                    $("#pur_warrenty_pro_sl_no").val("");
                    getCartProduct();
                }
                
            }
        });
    }

    function remove_product_sl(product_id, sl_no) {

    let route_url = "{{ route('inventory.product-inventory.purchase.remove-warrenty-product-sl') }}";
    $.ajax({
        type: "GET",
        url: route_url,
        data: { pro_id: product_id, sl_no: sl_no},
        success: function (result) {
            if(result.status == 404) {
                alert("Invalid Warrenty Product");
            } else if(result.status == 406) {
                alert("Invalid Warrenty Product");
            } else {
                $("#all-added-warrenty-product-id .show-added-list").html(result);
                getCartProduct();
            }
        }
    });
    }
</script>




@endsection