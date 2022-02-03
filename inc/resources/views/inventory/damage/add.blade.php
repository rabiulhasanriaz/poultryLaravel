@php
   $user = App\Models\User::where('user_type',Auth::user()->user_type)->first(); 
@endphp
@if ($user->user_type == 2)
    @extends('company.layout.master')
    @section('inventory','menu-open')
    @section('damage_class','menu-open')
    @section('damage_add','active')
@elseif($user->user_type == 3)

@endif
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Product Damage</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Product Damage</li>
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
                <h3 class="card-title">Add Damage</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{ route('inventory.damage.damage-add-store') }}" method="post">
                @csrf
                <div class="card-body">
                <div class="form-group">
                    <label>Group <i class="text-danger">*</i></label>
                    <select class="form-control select2" style="width: 100%;" id="product_category">
                        <option value="">Select Group</option>
                        @foreach ($pro_grp as $item)
                            <option value="{{ $item->id }}" {{ old('g_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                    
                </div>
                <div class="form-group product_category_wrapper">
                    <label>Type Name <b class="text-danger">*</b></label>
                    <select class="form-control select2" style="width: 100%;" id="product_model">
                      <option value="">Select Type</option>

                    </select>
                    
                </div>
                  <div class="form-group product_name_wrapper">
                    <label>Product Name <b class="text-danger">*</b></label>
                    <select class="form-control select2" name="product" style="width: 100%;" id="product_name">
                      <option value="">Select Product</option>

                    </select>
                    @error('product')
                        <p class="text-danger">{{ $errors->first('product') }}</p>
                    @enderror
                  </div>
                  
                    <div class="form-group">
                      <label for="exampleInputEmail1">Damage Quantity <i class="text-danger">*</i></label>
                      <input type="text" name="d_qty" value="{{ old('d_qty') }}" class="form-control" id="exampleInputEmail1" placeholder="Enter Damage Quantity">
                    </div>
                    @error('d_qty')
                          <p class="text-danger">{{ $errors->first('d_qty') }}</p>
                    @enderror
                  
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
@section('custom_style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('custom_script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
  $(document).ready(function() {
    $('.select2').select2();
});

$(document).ready(function(){
    $('#product_category').on("change",function(){
      let grp_id = $("#product_category").val();
      let link = "{{ route('inventory.damage.product-type-ajax') }}";
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

  function get_products(model_id){
      let link = "{{ route('inventory.damage.product-name-ajax') }}";
      $.ajax({
        type: "GET",
        url: link,
        data: { model_id: model_id},
        success: function (result) {
          $(".product_name_wrapper").html(result);
        }
      });
    }
</script>
@endsection