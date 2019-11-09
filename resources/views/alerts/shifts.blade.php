@if(Session::has('shift_created'))
    <div class="alert alert-success">{{session('shift_created')}}</div>
@endif

@if(Session::has('shift_deleted'))
    <div class="alert alert-success">{{session('shift_deleted')}}</div>
@endif

@if(Session::has('shift_updated'))
    <div class="alert alert-success">{{session('shift_updated')}}</div>
@endif
