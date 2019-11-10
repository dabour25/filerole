@extends('layouts.admin', ['title' => __('strings.Role_edit') ])

@section('content')
    <!--<div class="page-title">-->
    <!--    <h3> {{ __('strings.Role_add') }} </h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li><a href="{{ route('roles.index') }}">{{ __('strings.Roles') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Role_add') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->
    <div id="main-wrapper">
        <div class="row">
            <form method="post" action="{{route('roles.update', $role->id)}}" enctype="multipart/form-data">
            @csrf
            {{ method_field('PATCH') }} 
            <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">
            <div class="col-md-6 form-group{{$errors->has('name') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                <label class="control-label" for="name">{{ __('strings.Arabic_name') }}</label>
                <input type="text" class="form-control" name="name" value="{{$role->name}}">
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-6 form-group{{$errors->has('name_en') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                <label class="control-label" for="name_en">{{ __('strings.English_name') }}</label>
                <input type="text" class="form-control" name="name_en" value="{{$role->name_en}}">
                @if ($errors->has('name_en'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('name_en') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12 form-group">
                <div class="check_all">
                    <div class="title_check_menu">
                        <h3>إعدادات القائمة</h3>
                        <p>
                            <button type="button" class="checkall checkall_check"> تحديد الكل </button>
                            <button type="button" class="checkall checkall_uncheck"> الغاء الكل </button>
                        </p>
                    </div>
                    <ul class="Newnav">
                    @foreach( $parent_auths as $par)                 
                    <li class="dropdown mega-dropdown">
                        <input type="checkbox" onclick="checkallin({{$par->id}})" class="checkhour" id="par{{$par->id}}" name="acs[]" value="{{$par->id}}" {{App\functions_role::where('role_id' ,$role->id)->where('org_id',Auth::user()->org_id)->where('functions_id',$par->function_id)->count()>0 ? 'checked'  : ''  }}>
                        <a href="javascript:;" class="dropdown-toggle" tabindex="-1" aria-expanded="false" class="dropdown-toggle">
                            <p id="partext{{$par->id}}" class="partext">
                                {{app()->getLocale() == 'ar' ? $par->funcname : $par->funcname_en }}
                                <i class="fas fa-chevron-down"></i>
                            </p>
                        </a>                       
                        <ul class="dropdown-menu dropdown-menuNew mega-dropdown-menu">
                            @foreach( $par->childs()->where('org_id', Auth::user()->org_id)->where('funcparent_id','>',0)->orderBy('porder')->get()   as $auth)
                            <li class="check_menu">
                                <label class="containerss">
                                {{app()->getLocale() == 'ar' ? $auth->funcname : $auth->funcname_en }}
                                <input type="checkbox" name="acs[]" type="checkbox" value="{{$auth->id}}" class="checkhour checkchild{{$par->id}}" onclick="checktiny({{$par->id}},{{$auth->id}})" {{ App\functions_role::where('role_id' ,$role->id)->where('org_id',Auth::user()->org_id)->where('functions_id',$auth->function_id)->count()>0 ? 'checked'  : ''  }} id="child{{$auth->id}}">
                                <span class="checkmark"></span>
                                </label>
                                <div class="innercon">
                                @foreach($auth->childs()->where('org_id',Auth::user()->org_id)->orderby('porder')->get() as $child)
                                    <label class="containerss"> 
                                    {{app()->getLocale() == 'ar' ? $child->funcname : $child->funcname_en }}
                                    <input type="checkbox" name="acs[]" type="checkbox" value="{{$child->id}}" class="checkhour checkchild{{$par->id}} tinycheck{{$auth->id}}" id="tiny{{$child->id}}" onclick="checkselected({{$par->id}},{{$auth->id}})" {{ App\functions_role::where('role_id' ,$role->id)->where('org_id',Auth::user()->org_id)->where('functions_id',$child->function_id)->count()>0 ? 'checked'  : ''  }}> 
                                    <span class="checkmark"></span>
                                    </label>
                                @endforeach
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-md-12 form-group{{$errors->has('description') ? ' has-error' : ''}}">
                <label class="control-label" for="description">{{ __('strings.Description') }}</label>
                <textarea type="text" class="form-control textall"
                          name="description">{{$role->description}}</textarea>
                @if ($errors->has('description'))
                    <span class="help-block">
                        <strong class="text-danger">{{ $errors->first('description') }}</strong>
                    </span>
                @endif
            </div>
            <div class="col-md-12 form-group text-right">
                <button type="submit" class="btn btn-primary btn-lg"> <i class="fas fa-save"></i> {{ __('strings.Save') }}</button>
            </div>
        </form>
    </div>
</div>
<!--Detect Colors -->
<script type="text/javascript">
    $( document ).ready(function() {
        @foreach( $parent_auths as $par)
        checkcolor({{$par->id}});
        @endforeach
    });
</script>

@stop
