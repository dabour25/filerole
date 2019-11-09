@extends('layouts.admin', ['title' => __('strings.Functions_edit'). App\Role::findOrFail($function->id)->name])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>{{ __('strings.Functions_edit') }}</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">{{ __('strings.Home') }}</a></li>-->
    <!--            <li><a href="{{ route('functions.index') }}">{{ __('strings.Functions') }}</a></li>-->
    <!--            <li class="active">{{ __('strings.Functions_edit') }}</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">{{ __('strings.Functions_edit') }}  {{ app()->getLocale() == 'ar' ? App\Role::findOrFail($function->id)->name : App\Role::findOrFail($function->id)->name_en }}  </h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-12">
                            <form method="post" action="{{route('functions.update', $function->id)}}" enctype="multipart/form-data" id="edit_users">

                                {{csrf_field()}}
                                {{ method_field('PATCH') }}
                                <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">
                                <input type="hidden" class="form-control" name="role_id" value="{{  $function->id }}">
                                <input type="hidden" class="form-control" name="org_id" value="{{  Auth::user()->org_id }}">

                                <table id="" class="display table" style="width: 100%; cellspacing: 0;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('strings.Functions_name') }}</th>
                                        <th>{{ __('strings.User') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach(App\Functions::all() /*where('technical_name', '!=', '')->get()*/ as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>{{ app()->getLocale() == 'ar' ? $value->name : $value->name_en }}</td>
                                            <td>

                                                <input type="radio" id="enable_gst" name="function_{{ $value->id }}" value="1" @if(App\UsersType::where(['function_id' => $value->id, 'role_id' => $function->id, 'org_id' => Auth::user()->org_id])->exists() && App\UsersType::where(['function_id' => $value->id, 'role_id' => $function->id, 'org_id' => Auth::user()->org_id])->value('active') == 1) checked @endif>&nbsp;{{ __('strings.Yes') }}
                                                <input type="radio" id="enable_gst" name="function_{{ $value->id }}" value="0" @if(!App\UsersType::where(['function_id' => $value->id, 'role_id' => $function->id, 'org_id' => Auth::user()->org_id])->exists() || App\UsersType::where(['function_id' => $value->id, 'role_id' => $function->id, 'org_id' => Auth::user()->org_id ])->value('active') == 0) checked @endif>&nbsp; {{ __('strings.No') }}

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <br>
                                <div class="col-md-12 form-group text-right">
                                    <button type="submit" class="btn btn-primary btn-lg">{{ __('strings.Save') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
