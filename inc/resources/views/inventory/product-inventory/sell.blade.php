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
  <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Sell</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Sell</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    
    <!-- Main content -->
    <section class="content">
    @include('root.layout.session_message')
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            
            <!-- /.card -->
            <form action="{{ route('inventory.product-inventory.sale.sell-temp-invoice') }}" method="get">
                @csrf
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Sell Product</h3>
              </div>
              <!-- /.card-header -->
              
              <div class="card-body">
                
                
                <div class="form-row">
                  <div class="form-group col-md-3">
                      <label for="inputEmail4">Customer <i class="text-danger">*</i></label>
                      <select class="form-control select2" name="customer" id="project_category" style="width: 100%;">
                        <option value="">Please select the Customer</option>
                            @foreach ($customers as $cus)
                                <option value="{{ $cus->id }}" {{ old('customer') == $cus->id ? 'selected' : '' }}>
                                  {{ $cus->cus_name }}({{ $cus->cus_mobile }})
                                </option>
                            @endforeach
                      </select>
                      @error('customer')
                          <p class="text-danger">{{ $errors->first('customer') }}</p>
                      @enderror
                  </div>

                  <div class="form-group col-md-3">
                    <label for="inputEmail4">Projects <i class="text-danger">*</i></label>
                    <select class="form-control select2 project_category_wrapper" name="project" style="width: 100%;">
                      <option value="">Please select the Project</option>
                          
                    </select>
                    @error('project')
                        <p class="text-danger">{{ $errors->first('project') }}</p>
                    @enderror
                </div>
                  {{-- <div class="form-group">
                    <label>Minimal</label>
                    <select class="form-control select2" style="width: 100%;">
                      <option value="">Please select the Group</option>
                        @foreach ($groups as $grp)
                            <option value="{{ $grp->id }}">{{ $grp->name }}</option>
                        @endforeach
                    </select>
                  </div> --}}
                  <div class="form-group col-md-3">
                      <label for="inputPassword4">Group <i class="text-danger">*</i></label>
                      <select class="form-control select2" name="group" id="product_category" style="width: 100%;">
                        <option value="">Please select the Group</option>
                          @foreach ($groups as $grp)
                              <option value="{{ $grp->id }}" {{ old('group') == $grp->id ? 'selected' : '' }}>
                                {{ $grp->name }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                  <div class="form-group col-md-3">
                      <label for="inputPassword4">Type <i class="text-danger">*</i></label>
                      <select class="form-control select2 product_category_wrapper" name="type" style="width: 100%;" id="product_model">
                        <option value="">Please select the Type</option>
                        
                    </select>
                    @error('type')
                      <p class="text-danger">{{ $errors->first('type') }}</p>
                    @enderror
                  </div>
                  
                    <button type="button" id="pro_search" style="" class="btn btn-xs btn-info">Search</button>
              </div>
            
              </div>
              <div class="card-body">
            
                <div class="col-sm-12 product_wrapper">
                        <table id="sell_product_list_table" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Name</th>
                                    <th>Desiption</th>
                                    <th>A. Stock</th>
                                    <th>Price</th>
                                    <th style="width: 110px; text-align: center;">Sell</th>
                                </tr>
                                </thead>
                                <tbody id="product_table_body">
                                @php($sl=0)
                                @foreach ($sell_pro as $sell)
                                    <tr>
                                        <td class="text-center">{{ ++$sl }}</td>
                                        <td>{{ $sell->pro_name }}</td>
                                        <td>
                                            {{ $sell->pro_description }}
                                            ({{ $sell->typeName->name }})
                                        </td>
                                        <td align="center">{{ $sell->available_qty }}</td>
                                        <td class="text-center"><input type="text" autocomplete="off" class="form-control" id="pro_price_{{ $sell->id }}" style="width: 100px;" value="{{ $sell->sell_price }}"></td>
                                        <td class="text-center">
                                            @if($sell->pro_warranty == 0)
                                            <div class="form-row align-items-center">
                                              <div class="col-auto">
                                                <input type="text" autocomplete="off" class="form-control" style="width: 50px;" id="pro_qty_{{ $sell->id }}" placeholder="Qty">
                                              </div>
                                              <div class="col-auto">
                                                <button type="button" class="btn btn-success btn-sm" onclick="addtocart('{{ $sell->id }}')">
                                                  <i class="fa fa-plus"></i>
                                              </button>
                                              </div>
                                            </div>
                                            @else
                                            <div class="form-row align-items-center">
                                              <div class="col-auto">
                                                <input type="text" autocomplete="off" class="form-control" style="width: 50px;" placeholder="N/A" disabled>
                                              </div>
                                              <div class="col-auto">
                                                <button type="button" class="btn btn-success btn-sm" onclick="addWarrentyProduct('{{ $sell->id }}')">
                                                  <i class="fa fa-plus"></i>
                                                </button>
                                              </div>
                                            </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            
                                <tfoot>
                                <tr>
                                    <td class="text-center service">#</td>
                                    <td colspan="3" class="text-right service">
                                        <b>Service Charges & Qty : </b>
                                    </td>
                                    <td class="text-center service" >
                                      <div class="form-group" style="margin-bottom: 0px;">
                                        <div class="col-sm-3">
                                        <input type="text" id="service" autocomplete="off" style="width:100px;" name="service" class="form-control" placeholder="Service">
                                        </div>
                                      </div>
                                      </td>
                                    <td class="text-center service">
                                      <div class="form-row align-items-center">
                                        <div class="col-auto ">
                                          <input type="text" id="qty" autocomplete="off" style="width:50px;" name="service" class="form-control" placeholder="Qty">
                                        </div>
                                        <div class="col-auto">
                                          <button type="button" class="btn btn-success btn-sm" onclick="addServiceCharges()">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                        </div>
                                      </div>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        {{-- <div class="col-sm-12">
                        <table class="table table-bordered table-striped" style="width: auto; float: right; margin-right: 30px;">
                            <tbody>
                                <tr>
                                    <td style="padding-top:5px;"><b>Service Charges & Qty : </b></td>
                                    <td>
                                        <div class="form-group" style="margin-bottom: 0px;">
                                            <div class="col-sm-3 product_category_wrapper">
                                                <input type="text" id="service" autocomplete="off" style="width:200px;" name="service" class="form-control" placeholder="Service">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group" style="margin-bottom: 0px;">
                                            <div class="col-sm-3 product_category_wrapper">
                                                <input type="text" id="qty" autocomplete="off" style="width:200px;" name="service" class="form-control" placeholder="Qty">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-sm" onclick="addServiceCharges()">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </div> --}}
    
                      </div>

              <div class="card-body">

                <div class="col-sm-12">
                        <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-shopping-cart"></i>
                                    Sales Invoice
                                </h3>
                                </div>   
                            <div class="box shopping_cart">
                                    
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl</th>
                                            <th>Description</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                            <th style="width:140px;">Amount</th>
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
                                  <input type="text" class="text-right" disabled autocomplete="off" value="" class="form-control" id="total_sell">
                                </div>
                              </div>
                              <div class="col-auto">
                                  <button class="btn btn-success btn-xs pull-right">Continue</button>
                              </div>
                            </div>
                            
                            {{-- <div class="form-group" style="float: right;">
                                <label for="inputEmail3" class="col-sm-2 control-label">Total: </label>
                                <div class="col-sm-6">
                                    <input type="text" class="text-right" disabled autocomplete="off" value="" class="form-control" id="total_sell">
                                </div>
                            <button class="btn btn-success btn-sm pull-right">Continue</button>
                            </div> --}}
                            
                            
                        </form>    
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
    
      <!-- /.container-fluid -->
    </section>
    @include('inventory.product-inventory.ajax.warranty-product-get-sl-no');
  </div>
@endsection
@section('custom_style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}"> --}}
{{-- <link rel="stylesheet" href="{{asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}"> --}}
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.2.8/css/rowReorder.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<style>
  .form-control{
        height: 30px;
    }
</style>
@endsection
@section('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
{{-- <script src="{{asset('assets/plugins/select2/js/select2.full.min.js')}}"></script> --}}
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.8/js/dataTables.rowReorder.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
    $(document).ready(function() {
    @if(session()->has('print_invoice'))
        let route = "{!! route('inventory.product-inventory.sale.sell-print', session()->get('print_invoice')) !!}?print=1";
        window.open(route, '_blank');
    @endif


    var table = $('#sell_product_list_table').DataTable( {
        pageLength : 5,
        responsive: true
    } );
} );
</script>
<script>
$('.select2').select2()
</script>
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


    function total_sell_amount(){
        let amount = 0;
        $('.temp_cart').each(function(i, obj) {
            amount = amount + parseFloat(obj.innerText.split(',').join(''));
        });
        let discount = parseFloat($(".temp_cart_discount").val());
        let delivery = parseFloat($(".temp_cart_delivery").val());
        if (isNaN(discount)) {
           discount = 0;
        }
        if (isNaN(delivery)) {
            delivery = 0;
        }
        amount = amount + delivery - discount;
        $('#total_sell').val(formatMoney(amount));
    }

  $(document).ready(function(){

    getCartProduct();
      $('#product_category').on("change",function(){
      let grp_id = $("#product_category").val();
      let link = "{{ route('inventory.product-inventory.sale.type-submit-ajax') }}";
      $.ajax({
          type: "GET",
          url: link,
          data: { grp_id: grp_id},
          success: function (result) {
          $(".product_category_wrapper").html(result);
          }
      });
      });

      $('#project_category').on("change",function(){
      let cus_id = $("#project_category").val();
      let link = "{{ route('inventory.product-inventory.sale.project-ajax') }}";
      $.ajax({
          type: "GET",
          url: link,
          data: { cus_id: cus_id},
          success: function (result) {
          $(".project_category_wrapper").html(result);
          }
      });
      });

      $('#pro_search').on("click",function(){
          let type_id = $("#product_model").val();
          let link = "{{ route('inventory.product-inventory.sale.pro-search-ajax') }}";
          $.ajax({
              type: "GET",
              url: link,
              data: { type_id: type_id},
              success: function (result) {
              $(".product_wrapper").html(result);
              }
          });
      });
  });

  function addtocart(pro_det_id) {
        let pro_qty = parseFloat($("#pro_qty_"+pro_det_id).val());
        let pro_price = parseFloat($("#pro_price_"+pro_det_id).val());
        let service = parseInt($("#service").val());
        let qty = parseFloat($("#qty").val());
        if(isNaN(pro_qty) || isNaN(pro_price)) {
            alert("quantity field can\'t be empty");
        } else if(pro_qty < 1) {
            alert("minimum quantity at least 1");
        } else {

            let route_url = "{{ route('inventory.product-inventory.sale.add-to-cart') }}";
            $.ajax({
                type: "GET",
                url: route_url,
                data: { pro_id: pro_det_id, pro_qty: pro_qty, pro_price: pro_price},
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

    function addServiceCharges() {
        let service = parseInt($("#service").val());
        let qty = parseFloat($("#qty").val());
        if(isNaN(qty) || isNaN(service)) {
            alert("quantity field can\'t be empty");
        } else if(qty < 1) {
            alert("minimum quantity at least 1");
        } else {

            let route_url = "{{ route('inventory.product-inventory.sale.sell-service-charge') }}";
            $.ajax({
                type: "GET",
                url: route_url,
                data: { qty: qty, service: service},
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
        let route_url = "{{ route('inventory.product-inventory.sale.get-cart') }}";
        $.ajax({
            type: "GET",
            url: route_url,
            data: {},
            success: function (result) {
                
                $("#show-cart-conten").html(result);
                total_sell_amount();
            }
        });
    }

    function update_cart_quantity(content_id) {
        let pro_quantity = parseFloat($("#update_qty_"+content_id).val());
        if(pro_quantity < 1) {
            alert("Minimum Quantity is 1");
            return false;
        }
        let route_url = "{{ route('inventory.product-inventory.sale.update-cart') }}";
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
        let route_url = "{{ route('inventory.product-inventory.sale.remove-cart') }}";
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
        
        let route_url = "{{ route('inventory.product-inventory.sale.add-to-cart-warranty-product') }}";
        $.ajax({
            type: "GET",
            url: route_url,
            data: { pro_id: pro_det_id, pro_price: pro_price},
            success: function (result) {
                // console.log(result);
                // return false;
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

    function check_sl_no(value, pro_det_id) {
        let sl_no = value;
        let route_url = "{{ route('inventory.product-inventory.sale.add-warranty-product-sl-no') }}";
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
                    $("#all-added-warrenty-product-id ul").html(result);
                    $("#w_product_sl_scan_inp").val("");
                    getCartProduct();
                }
            }
        });
    }

    function remove_product_sl(product_id, sl_no) {

    let route_url = "{{ route('inventory.product-inventory.sale.remove-warranty-product-sl') }}";
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
                $("#all-added-warrenty-product-id ul").html(result);
                getCartProduct();
            }
        }
    });
    }
</script>
@endsection
