<form  action="{{ route('company.customer.customer-update',$customer->id) }}" method="post">
                  @csrf
                <div class="card-body">
                  <div class="form-group" style="margin-top: -25px;">
                    <label for="exampleInputEmail1">Customer Name <i class="text-danger">*</i></label>
                    <input type="text" class="form-control" value="{{ $customer->name }}" name="cus_name" style="background: black;" autocomplete="off" id="c_name" placeholder="Enter Customer Name" required>
                    
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Company Name</label>
                    <input type="text" class="form-control" value="{{ $customer->com_name }}" name="com_name" style="background: black;" autocomplete="off"  placeholder="Enter Company Name">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Customer Phone <i class="text-danger">*</i></label>
                    <input type="text" class="form-control" value="{{ $customer->phone }}" name="cus_phone" style="background: black;" autocomplete="off" id="contactNumber" placeholder="Enter Customer Phone" required>
                    
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Customer Email</label>
                    <input type="email" class="form-control" value="{{ $customer->email }}" name="cus_email" style="background: black;" autocomplete="off" id="" placeholder="Enter Customer Email">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Customer Address</label>
                    <input type="text" class="form-control" value="{{ $customer->address }}" name="cus_address" style="background: black;" autocomplete="off" id="c_address" placeholder="Enter Customer Address">
                    
                    
                  </div>
                  <div class="form-group clearfix">
                    <div class="icheck-primary d-inline">
                      <input type="radio" id="radioPrimary1" name="cus_type" value="1" {{ $customer->type == 1 ? 'checked' : '' }}>
                      <label for="radioPrimary1">
                          Farm/খামারী
                      </label>
                    </div>
                    &nbsp;
                    <div class="icheck-primary d-inline">
                      <input type="radio" id="radioPrimary2" name="cus_type" value="2" {{ $customer->type == 2 ? 'checked' : '' }}>
                      <label for="radioPrimary2">
                        Wholesaler/পাইকার
                      </label>
                    </div>
                    &nbsp;
                    <div class="icheck-primary d-inline">
                      <input type="radio" id="radioPrimary3" name="cus_type" value="3" {{ $customer->type == 3 ? 'checked' : '' }}>
                      <label for="radioPrimary3">
                        Sub-dealer/সাব-ডিলার
                      </label>
                    </div>
                    
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
              <style>
                  .form-group {
    margin-bottom: 0rem;
}
              </style>