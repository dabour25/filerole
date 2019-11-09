@if(Session::has('customer_created'))
    <div class="alert alert-success">{{session('customer_created')}}</div>
@endif

@if(Session::has('customer_deleted'))
    <div class="alert alert-success">{{session('customer_deleted')}}</div>
@endif

@if(Session::has('customer_updated'))
    <div class="alert alert-success">{{session('customer_updated')}}</div>
@endif

@if(Session::has('danger'))
    <div class="alert alert-danger">{{session('danger')}}</div>
@endif

