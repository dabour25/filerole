@if(Session::has('created'))
    <div class="alert alert-success" style="background:green !important;color:#fff !important">{{session('created')}}</div>
@endif

@if(Session::has('deleted'))
    <div class="alert alert-success" style="background:green !important;color:#fff !important">{{session('deleted')}}</div>
@endif

@if(Session::has('updated'))
    <div class="alert alert-success" style="background:green !important;color:#fff !important">{{session('updated')}}</div>
@endif

@if(Session::has('danger'))
    <div class="alert alert-danger" style="background:red !important;color:#fff !important">{{session('danger')}}</div>
@endif