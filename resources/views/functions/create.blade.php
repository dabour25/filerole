@extends('layouts.admin', ['title' => 'اضافة صلاحيه'])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>اضافة صلاحيه</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">الرئيسية</a></li>-->
    <!--            <li><a href="{{ route('functions.index') }}">الصلاحيات</a></li>-->
    <!--            <li class="active">اضافة صلاحيه</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-white">
                    <div class="panel-heading clearfix">
                        <div class="col-md-12">
                            <h4 class="panel-title">اضافة صلاحيه</h4>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="{{route('functions.store')}}" enctype="multipart/form-data">

                            {{csrf_field()}}
                            <input type="hidden" class="form-control" name="user_id" value="{{  Auth::user()->id }}">

                            <div class="col-md-6 form-group{{$errors->has('role_id') ? ' has-error' : ''}}"> <strong class="text-danger">*</strong>
                                <label class="control-label" for="role_id">الصلاحية</label>
                                <select class="form-control" name="role_id">
                                    <option value="0">اختر</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role_id'))
                                    <span class="help-block">
                                        <strong class="text-danger">{{ $errors->first('role_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <table id="" class="display table" style="width: 100%; cellspacing: 0;">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم الشاشة</th>
                                    <th>الصلاحية للمستخدم</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($functions as $role)
                                    <tr>
                                        <td>{{ $role->id }}</td>
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <input type="radio" id="enable_gst" name="function_{{ $role->id }}[]" value="1">&nbsp;نعم
                                            &nbsp;&nbsp;
                                            {{--<input type="radio" id="enable_gst" name="function_{{ $role->id }}[]" value="0">&nbsp;لا--}}
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <br>
                            <div class="col-md-12 form-group text-right">
                                <button type="submit" class="btn btn-primary btn-lg">اضافة</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection