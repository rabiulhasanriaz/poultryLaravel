<form  action="{{ route('company.user.user-update',$user->id) }}" method="post" enctype="multipart/form-data">
    @csrf
  <div class="card-body">
    <div class="form-group" style="margin-top: -25px;">
      <label for="exampleInputEmail1">Name <i class="text-danger">*</i></label>
      <input type="text" class="form-control" value="{{ $user->name }}" name="u_name" autocomplete="off" id="c_name" placeholder="Enter User Name">
      <small></small>
    </div>
    {{-- <div class="form-group">
      <label for="exampleInputPassword1">Company Person</label>
      <input type="text" class="form-control" value="{{ old('c_person') }}" name="c_person" style="background: black;" autocomplete="off"  placeholder="Enter Company Password">
    </div> --}}
    <div class="form-group">
      <label for="exampleInputPassword1"> Phone <i class="text-danger">*</i></label>
      <input type="text" class="form-control" value="{{ $user->phone }}" name="u_phone"  autocomplete="off" id="contactNumber" placeholder="Enter User Phone">
      <small></small>
     
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Email</label>
      <input type="email" class="form-control" value="{{ $user->email }}" name="u_email"  autocomplete="off" id="" placeholder="Enter Company Email">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Address</label>
      <input type="text" class="form-control" value="{{ $user->address }}" name="u_address"  autocomplete="off" id="c_address" placeholder="Enter User Address">
      <small></small>
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1"> Password <i class="text-danger">*</i></label>
      <input type="password" class="form-control" value="" name="u_password" autocomplete="off" id="c_password" placeholder="Enter User Password">
      <small></small>
    </div>
    <div class="form-group">
      <label for="exampleInputFile"> Image </label>
      
        <input type="file" name="u_logo" class="form-control">
        <img src="{{ asset('assets/user-image/') }}/{{ $user->logo }}" style="height: 100px; width: 115px;">
      
      
    </div>
    
  </div>
  <!-- /.card-body -->

  <div class="card-footer">
    <button type="submit" class="float-right btn btn-primary">Submit</button>
  </div>
</form>
<style>
    .form-group {
margin-bottom: 0rem;
}
</style>