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
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-6 offset-md-3">
            <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Add Product Details</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('inventory.product.product-store') }}" method="post">
                @csrf
                <div class="card-body">

                  <div class="form-group">
                    <label>Group</label>
                    <select class="form-control select2" style="width: 100%;" id="product_category">
                      <option value="">Please select the Group</option>
                      @foreach ($groups as $group)
                          <option value="{{ $group->id }}">{{ $group->name }}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group product_category_wrapper">
                    <label>Type Name <b class="text-danger">*</b></label>
                    <select class="form-control select2" style="width: 100%;" id="product_model">
                      <option value="">Select Type</option>

                    </select>
                    @error('type')
                        <p class="text-danger">{{ $errors->first('type') }}</p>
                    @enderror
                  </div>

                  <div class="form-group supplier_list">
                    <label>Supplier</label>
                    <div class="row">
                      <div class="col-md-10">
                        <select class="form-control select2" name="supplier[]" style="width: 100%;" id="select_div">
                          <option value="">Please select the Supplier</option>
                          @foreach($suppliers as $supplier)           
                            <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-md-2">
                        <button type="button" class="btn btn-success btn-sm add_new_supplier_btn"><big>+</big></button>                  
                      </div>
                    </div>
                    
                  </div>
                  
                  <div id="others-supplier"></div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Model <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="p_model" value="{{ old('p_model') }}" id="" placeholder="Enter Product Model">
                    @error('p_model')
                      <p class="text-danger">{{ $errors->first('p_model') }}</p>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Buy Price <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="p_b_price" value="{{ old('p_b_price') }}" id="" placeholder="Enter Buy Price">
                    @error('p_b_price')
                      <p class="text-danger">{{ $errors->first('p_b_price') }}</p>
                    @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Sell Price  <b class="text-danger">*</b></label>
                    <input type="text" class="form-control" name="p_s_price" value="{{ old('p_s_price') }}" id="" placeholder="Enter Cell Price">
                    @error('p_s_price')
                      <p class="text-danger">{{ $errors->first('p_s_price') }}</p>
                    @enderror
                  </div>

                  <div class="form-group clearfix">
                    <label for="exampleInputEmail1">Product Warranty</label>
                    <div class="icheck-primary d-inline">
                      <input type="radio" class="warranty_change" {{ old('cus_type') == 1 ? 'checked' : '' }} id="radioPrimary1" name="cus_type" value="1">
                      <label for="radioPrimary1">
                          Yes
                      </label>
                    </div>
                    &nbsp;
                    <div class="icheck-primary d-inline">
                      <input type="radio" class="warranty_change" {{ old('cus_type') == 2 ? 'checked' : '' }} id="radioPrimary2" name="cus_type" value="2" checked>
                      <label for="radioPrimary2">
                        No
                      </label>
                    </div>
                    <div class="warranty_input_wrapper" style="display:none;">
                        <div class="col-sm-6">
                          <input type="number" name="pro_warranty" autocomplete="off" value="{{ (old('pro_warranty') != '')? old('pro_warranty'):'0' }}" class="form-control" placeholder="Enter Product Warranty Detail" required>
                        </div>
                        <div class="col-sm-2">
                          (Days)
                        </div>
                      </div>
                      @error('cus_type')
                        <p class="text-danger">{{ $errors->first('cus_type') }}</p>
                      @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Product Description</label>
                    <input type="text" name="pro_desc" value="{{ old('pro_desc') }}" class="form-control" id="" placeholder="Enter Product Description">
                    @error('pro_desc')
                    <p class="text-danger">{{ $errors->first('pro_desc') }}</p>
                  @enderror
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1">Short Quantity</label>
                    <input type="text" name="pro_short" value="{{ (old('pro_short') == '')? '0':old('pro_short') }}" class="form-control" id="" placeholder="0">
                    <p>(0 Quantity will not appear on your Quantity List)</p>
                  </div>

                  

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="float-right btn btn-primary">Create</button>
                </div>
              </form>
            </div>
          

          </div>
          <!--/.col (left) -->
          <!-- right column -->
          
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
      <div class="hidden" id="supplier-list-container" style="display: none;">
        <div class="form-group supplier_list">
          <label for="inputEmail3" class="col-sm-2 control-label">Supplier
              <b class="text-danger" ></b>
          </label>
          <div class="col-sm-6 " id="select_div">
              <select name="supplier[]" class="form-control " id="" required>
                  <option value="">Select</option>   
                  @foreach ($suppliers as $supplier)
                      <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                  @endforeach                              
              </select>
              
          </div>
          <button type="button" onclick="remove_supplier(this)" class="btn btn-danger btn-sm remove_a_supplier_btn"><big>X</big></button>
        </div>
        
      </div>
    </section>
    <!-- /.content -->
</div>
@endsection
@section('custom_style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
@endsection
@section('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    $('.select2').select2();
});
$(".add_new_supplier_btn").click(function () {
  let new_supplier = $("#supplier-list-container").html();
  $("#others-supplier").append(new_supplier);
});

function remove_supplier(btn) {
  $(btn).parent().remove();
}
$(".warranty_change").change(function() {

if(this.value == 1){
  console.log("1");
  $(".warranty_input_wrapper").show();
} else {
  console.log("0");
  $(".warranty_input_wrapper").hide();
}
});

$(document).ready(function(){
    $('#product_category').on("change",function(){
      let grp_id = $("#product_category").val();
      let link = "{{ route('inventory.product.type-ajax') }}";
      $.ajax({
        type: "GET",
        url: link,
        data: { grp_id: grp_id},
        success: function (result) {
          $(".product_category_wrapper").html(result);
        }
      });
    });
  });

</script>
@endsection
