@if(Session::has('role_created'))
    <div class="alert alert-success">{{session('role_created')}}</div>
@endif

@if(Session::has('role_deleted'))
    <div class="alert alert-success">{{session('role_deleted')}}</div>
@endif

@if(Session::has('role_updated'))
    <div class="alert alert-success">{{session('role_updated')}}</div>
@endif