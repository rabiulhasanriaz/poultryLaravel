<form action="{{ route('root.company.company-update',$company->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="exampleInputEmail1">Name <i class="text-danger">*</i></label>
      <input type="text" class="form-control" name="c_name" value="{{ $company->name }}" id=""  placeholder="Enter Name">
    </div>
    <div class="form-group">
     <label for="exampleInputEmail1">Contact Person</label>
     <input type="text" class="form-control" name="c_person" id="" value="{{ $company->contact_person }}"  placeholder="Enter Person Name">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Phone <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="c_phone" id="" value="{{ $company->phone }}"  placeholder="Enter Phone">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email</label>
        <input type="text" class="form-control" name="c_email" id="" value="{{ $company->email }}"  placeholder="Enter Email">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Address <i class="text-danger">*</i></label>
        <input type="text" class="form-control" name="c_address" id="" value="{{ $company->address }}"  placeholder="Enter Address">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Password</label>
      <input type="password" class="form-control" name="c_password" id="" value="" placeholder="Password">
    </div>
    <div class="form-group">
        <input type="file" name="c_logo" class="form-control">
        <img src="{{ asset('assets/image/') }}/{{ $company->logo }}" style="height: 100px; width: 115px;">
    </div>
    <button type="submit" class="float-right btn btn-primary">Submit</button>
  </form>