@extends('layouts.admin', ['title' => __('strings.news')])

@section('content')

    <!--<div class="page-title">-->
    <!--    <h3>@lang('strings.news')</h3>-->
    <!--    <div class="page-breadcrumb">-->
    <!--        <ol class="breadcrumb">-->
    <!--            <li><a href="{{ route('home') }}">@lang('strings.Home')</a></li>-->
    <!--            <li class="active">@lang('strings.news')</li>-->
    <!--        </ol>-->
    <!--    </div>-->
    <!--</div>-->

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
             <div class="alert_new">
                          <span class="alertIcon">
                              <i class="fas fa-exclamation-circle"></i>
                           </span>
                          <p>
                              @if (app()->getLocale() == 'ar')
            {{ DB::table('function_new')->where('id',99)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',99)->value('description_en') }}
            @endif
                          </p>
                          <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i>
                          </a>
                      </div>

                <a class="btn btn-primary btn-lg btn-add" href="news/savenew"><i class="fa fa-plus"></i>&nbsp;&nbsp;@lang('strings.add_news') </a>
                
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">@lang('strings.news')</h4>
                </div>


                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">

                            <thead>
                            <tr>
                                <th> @lang('strings.news_title')</th>
                                <th style=" width:415px;">@lang('strings.news_desc')</th>
                                <th>@lang('strings.news_date')</th>
                                <th>@lang('strings.Status')</th>


                                <th>@lang('strings.Settings')</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($news as $new)
                                <tr>
                                    <td>{{  app()->getLocale() == 'ar' ?  $new->news_title   : $new->news_title_en   }} </td>
                                    <td>{{  app()->getLocale() == 'ar' ?  strip_tags(htmlspecialchars_decode($new->news_desc))  :   strip_tags(htmlspecialchars_decode($new->news_desc_en))  }} </td>
                                    <td> {{$new->news_date}} </td>
                                    <td>
                                        @if($new->active)
                                            <span class="label label-success"
                                                  style="font-size:12px;">@lang('strings.Active')</span>
                                        @else
                                            <span class="label label-danger" style="font-size:12px;">@lang('strings.Deactivate')</span>
                                        @endif
                                    </td>


                                    <td>
                                        <a href="news/{{ $new->id }}/edit" class="btn btn-primary btn-xs"> <i
                                                    class="fa fa-pencil" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="تعديل "></i></a>
                                        <a href="news/{{ $new->id }}/delete" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="حذف"> <i
                                                    class="fa fa-trash-o"></i></a>


                                    </td>

                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </form>


@stop
  
  
