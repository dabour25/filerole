@if(Session::has('user_created'))
    <div class="alert alert-success">{{session('user_created')}}</div>
@endif

@if(Session::has('user_deleted'))
    <div class="alert alert-success">{{session('user_deleted')}}</div>
@endif

@if(Session::has('user_updated'))
    <div class="alert alert-success">{{session('user_updated')}}</div>
@endif
@if(Session::has('user_type_created'))
    <div class="alert alert-success">{{session('user_type_created')}}</div>
@endif
@if(Session::has('user_change_password'))
    <div class="alert alert-success">{{session('user_change_password')}}</div>
@endif


@if(Session::has('danger'))
    <div class="alert alert-danger">{{session('danger')}}</div>
@endif