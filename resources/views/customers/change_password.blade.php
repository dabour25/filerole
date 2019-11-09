<form method="post" action="{{url('admin/customers/change-password')}}" enctype="multipart/form-data" id="password">
    <input type="hidden" name="id" value="{{ $id }}">
    {{csrf_field()}}
    <div class="form-group">
        <label class="control-label">{{ __('strings.New_password') }}</label> <strong class="text-danger">*</strong>
        <input type="password" class="form-control" name="password" id="password">
    </div>
    <div class="form-group">
        <label class="control-label">{{ __('strings.Confirm_new_password') }}</label> <strong class="text-danger">*</strong>
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
    </div>

</form>