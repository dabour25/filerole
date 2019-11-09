@extends('layouts.admin', ['title' => app()->getLocale() == 'ar' ? ActivityLabel('item_service')->value : ActivityLabel('item_service')->value_en ])

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@endsection

@section('content')
    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">

                @include('alerts.index')
                @if($type == null)
                    <style>
                        .btn-primary:hover {
                            background:#2c9d6f !important;
                        }
                    </style>
    

    
    <!-- Function Description -->                 
    <div class="alert_new">
        <span class="alertIcon">
            <i class="fas fa-exclamation-circle"></i>
         </span>
         <p>
             @if (app()->getLocale() == 'ar')
            {{ DB::table('function_new')->where('id',26)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',26)->value('description_en') }}
            @endif
         </p>
         <a href="#" onclick="close_alert()" class="close_alert">  <i class="fas fa-times-circle"></i> </a>
         
    </div>
                    <div class="btn-group m-l-xs">
                        <button type="button" class="btn btn-primary btn-lg btn-add" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-plus"></i> @lang('strings.add') </button>

                        <ul class="dropdown-menu pull-right">
                            @if(App\Settings::where(['key' => 'sold_item_type', 'org_id' => Auth::user()->org_id])->value('value') == 1)
                            <li>
                                <a href="{{ url('admin/categories/1/create') }}"> <i class="fas fa-plus"></i> {{ app()->getLocale() == 'ar' ? ActivityLabel('items')->value : ActivityLabel('items')->value_en }}</a>
                            </li>
                            @endif
                            @if(App\Settings::where(['key' => 'sold_item_type', 'org_id' => Auth::user()->org_id])->value('value') == 2)
                            <li>
                                <a href="{{ url('admin/categories/2/create') }}"> <i class="fas fa-plus"></i> {{ app()->getLocale() == 'ar' ? ActivityLabel('services')->value : ActivityLabel('services')->value_en }}</a>
                            </li>
                            @endif
                            @if(App\Settings::where(['key' => 'sold_item_type', 'org_id' => Auth::user()->org_id])->value('value') == 0)
                                <li>
                                    <a href="{{ url('admin/categories/1/create') }}"> <i class="fas fa-plus"></i> {{ app()->getLocale() == 'ar' ? ActivityLabel('items')->value : ActivityLabel('items')->value_en }}</a>
                                </li>
                                <li>
                                    <a href="{{ url('admin/categories/2/create') }}"> <i class="fas fa-plus"></i> {{ app()->getLocale() == 'ar' ? ActivityLabel('services')->value : ActivityLabel('services')->value_en }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                @else
                    <a class="btn btn-primary btn-lg btn-add" href="{{ $type == 1 ? url('admin/categories/1/create') : url('admin/categories/2/create') }}">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp; {{ $type == 1 ? __('strings.Categories_add') : __('strings.Categories_add_service') }}
                    </a>
                @endif

                <div role="tabpanel" class="taps-set">
                    <div class="row">
                        <div class="col-12">
                            <!-- Tab panes -->
                            <div class="jus_tap" style="">
                                <div role="tabpanel">
                                    <form action="{{ url('admin/categories/search') }}" method="POST">
                                        {{csrf_field()}}
                                        <input name="type" value="{{ $type }}" type="hidden">
                                        <h3 class="title-tap">@lang('strings.search')</h3>
                                        <div class="col-md-4 form-group">
                                            <label class="control-label" for="categories_type">{{ __('strings.Categories_type') }}</label>
                                            <select class="form-control js-select" name="categories_type" id="categories_types">
                                                <option value="0"> @lang('strings.all_categories_type') </option>
                                                @php
                                                    if($type == null){
                                                        $CategoriesType = App\CategoriesType::whereBetween('type', [1,2])->where(['org_id' => Auth::user()->org_id])->get();
                                                    }else{
                                                        $CategoriesType = App\CategoriesType::where(['type' => $type, 'org_id' => Auth::user()->org_id])->get();
                                                    }
                                                @endphp
                                                @foreach($CategoriesType as $v)
                                                    <option {{ old('categories_type') == $v->id ? 'selected' : '' }} value="{{ $v->id }}">{{   app()->getLocale() == 'ar' ? $v->name : $v->name_en }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label class="control-label" for="categories_type">@lang('strings.keyword_title')</label>
                                            <input type="text" class="form-control" name="keyword" placeholder="@lang('strings.keyword')">

                                        </div>
                                        <div class="col-md-4 form-group text-right">
                                            <button type="submit" class="btn btn-primary btn-lg"> <i class="fa fa-search"></i> {{ __('strings.search') }} </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-12">
                            <!-- Tab panes -->
                            <div class="tab-content tap-up">
                                <div role="tabpanel">
                                    <h3 class="title-tap">@if($type == null) @lang('strings.categories_and_services') @else {{  $type == 1 ? __('strings.categories') : __('strings.services') }} @endif</h3>
                                    <table id="" class="xtreme-table display table"
                                           style="width: 100%; cellspacing: 0;">
                                        <thead>
                                            <tr>
                                                <th>{{ __('strings.Barcode') }}</th>
                                                <th>{{ __('strings.Photo') }}</th>
                                                <th>{{ __('strings.Arabic_name') }}</th>
                                                <th>{{ __('strings.English_name') }}</th>
                                                <th>{{ __('strings.Status') }}</th>
                                                <th>{{ __('strings.Settings') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($list as $category)
                                            <tr>
                                                <td>{{ $category->barcode }}</td>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
                                                <td>
                                                    <img src="{{ $category->photo_id !== null ? asset(str_replace(' ', '%20', $category->photo->file)) : asset('images/profile-placeholder.png') }}" width="40" height="40">
                                                </td>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $category->name_en }}</td>
                                                <td>
                                                    @if($category->active)
                                                        <span class="label label-success"
                                                              style="font-size:12px;">{{ __('strings.Active') }}</span>
                                                    @else
                                                        <span class="label label-danger"
                                                              style="font-size:12px;">{{ __('strings.Deactivate') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($type == null)
                                                        <a href="{{ url('admin/categories/'.$category->type.'/'.$category->id.'/edit') }}" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تعديل">
                                                            <i class="fa fa-pencil"></i>
                                                        </a>
                                                    @else
                                                    <a href="{{ url('admin/categories/'.$type.'/'.$category->id.'/edit') }}"
                                                       class="btn btn-primary btn-xs" data-toggle="tooltip"
                                                       data-placement="bottom" title=""
                                                       data-original-title="تعديل"><i
                                                                class="fa fa-pencil"></i></a>
                                                    @endif
                                                {{--<a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#{{ $category->id }}"><i class="fa fa-trash-o"></i></a>--}}
                                                <!-- Category Delete Modal -->
                                                    <div id="{{ $category->id }}" class="modal fade"
                                                         role="dialog" data-keyboard="false"
                                                         data-backdrop="static">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close"
                                                                            data-dismiss="modal">&times;
                                                                    </button>
                                                                    <h4 class="modal-title">{{ __('strings.confirm') }}</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>{{ __('strings.delete_category_message') }}</p>
                                                                </div>
                                                                <form method="post"
                                                                      action="{{ route('categories.destroy', $category->id) }}">
                                                                    <div class="modal-footer">
                                                                        {{csrf_field()}}
                                                                        {{ method_field('DELETE') }}
                                                                        <button type="submit"
                                                                                class="btn btn-danger">{{ __('strings.delete_btn') }}</button>
                                                                        <button type="button"
                                                                                class="btn btn-primary"
                                                                                data-dismiss="modal">{{ __('strings.no') }}</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{ $list->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script>
        $(".js-select").select2();
    </script>
@endsection