@if(Session::has('section_created'))
    <div class="alert alert-success">{{session('section_created')}}</div>
@endif

@if(Session::has('section_deleted'))
    <div class="alert alert-success">{{session('section_deleted')}}</div>
@endif

@if(Session::has('section_updated'))
    <div class="alert alert-success">{{session('section_updated')}}</div>
@endif