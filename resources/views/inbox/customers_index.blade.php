@extends('layouts.admin', ['title' => __('strings.inbox') ])

@section('content')
   

    <div id="main-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="alert_new">
                  <span class="alertIcon">
                      <i class="fas fa-exclamation-circle"></i>
                   </span>
                  <p>
                    @if (app()->getLocale() == 'ar')
                        {{ DB::table('function_new')->where('id',40)->value('description') }}
                    @else
                        {{ DB::table('function_new')->where('id',40)->value('description_en') }}
                    @endif
                  </p>
                  <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i></a>
                </div>
                <div role="tabpanel">
                    <div class="panel panel-white">
                        <div class="panel-body">
                            @include('alerts.index')
                            <!-- Content  -->
                            <div id="container_content">
                                <div class="">
                                    <div class="ma_pc_inner">
                                        <div class="">
                                            <div class="row chatcontainer">
                                                <div class="col-md-4">
                                                    <div class="messages-sidebar">
                                                        <div class="search-box">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search" id="search-icon"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                                            <input type="text" name="search" value="ابحث" id="search-list">
                                                        </div>
                                                        <ul class="list-group">
                                                            @if(App\FrontMessages::where([ 'url' => explode('/',url()->current())[2]])->count() < 1)
                                                            <p class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>No users found</p>
                                                            @else
                                                                @foreach(App\FrontMessages::where([ 'url' => explode('/',url()->current())[2]])->orderBy('date', 'desc')->get() as $value)
                                                                    <li class="user-list" data-id="{{ $value->id }}">
                                                                        <a href="{{ url('admin/inbox/customers/message/'. $value->id) }}" data-load="admin/inbox/customers/messages/{{ $value->id }}" data-id="{{ $value->id }}">
                                                                            <div class="countunseen">{{ $value->open == 1 ? '' : 1 }}</div>
                                                                            <div class="user-name">{{ $value->name }} - {{ $value->email }}</div>
                                                                            <!--<div class="user-last-message">{{ $value->subject }}</div>-->
                                                                            <div class="clear"></div>
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-8">
                                                    <ul class="pt_msg_main">
                                                        <div class="settings-header pt_msg_header">
                                                            @if(!empty($id))
                                                                @php
                                                                    $user = App\FrontMessages::findOrFail($id);
                                                                @endphp
                                                            <h3 class="pull-left"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left mobilemsgclose"><polyline points="15 18 9 12 15 6"></polyline></svg> <a href='#' data-load='' >{{ $user->name }}</a></h3>
                                                            <h3 class="pull-right"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left mobilemsgclose"><polyline points="15 18 9 12 15 6"></polyline></svg> <a href='#' data-load='' >{{ $user->subject }}</a></h3>

                                                                {{--<div class="pull-right" id="delete-conversation"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></div>--}}
                                                            <div class="clear"></div>
                                                            @else
                                                            <h3 class="pull-left"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left mobilemsgclose"><polyline points="15 18 9 12 15 6"></polyline></svg> <a style='color: #fff;' class='user-link'></a></h3>
                                                            <div class="clear"></div>
                                                            @endif
                                                        </div>
                                                        <button id="load-more-messages" title="Load more messages"><i class="fa fa-angle-up"></i></button>

                                                        <div class="pt_msg_joint">
                                                            <div class="user-messages user-setting-panel pt_msg_area">

                                                                @if(!empty($messages) && count($messages) != 0)
                                                                <div class="messages" data-id="0">
                                                                    @foreach($messages as $m)
                                                                    <div class="message to-user pull-right" data-id="{{ $m->id }}">
                                                                        <div class="user-message">{{ $m->message }}</div>
                                                                        <div class="clear"></div>
                                                                    </div>
                                                                    <div class="clear"></div>
                                                                        @foreach(App\FrontMessagesReplay::where('parent_id', $m->id)->orderBy('created_at', 'ASC')->get() as $v)
                                                                        <div class="message to-user pull-left" data-id="{{ $v->id }}">
                                                                            <div class="user-message">{{ $v->message }}</div>
                                                                            <div class="clear"></div>
                                                                        </div>
                                                                        <div class="clear"></div>
                                                                        @endforeach
                                                                    @endforeach
                                                                </div>
                                                                @else
                                                                <div class="messages"></div>
                                                                {{--<div class="empty_state">--}}
                                                                    {{--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>--}}
                                                                    {{--<p>No messages were found, please choose a channel to chat.</p>--}}
                                                                {{--</div>--}}
                                                                @endif
                                                            </div>
                                                            <div class="user-send-message">
                                                                @if(Request::is('admin/inbox/customers/*'))
                                                                    <form method="POST" id="new-message-form" action="{{ url('admin/inbox/customers/messages/new') }}">
                                                                        {{ csrf_field() }}
                                                                            <textarea name="new-message" id="new-message" cols="30" rows="2" placeholder="@lang('strings.write_message')" ></textarea>
                                                                            <button class="btn btn-primary2" type="submit" id="send-button">@lang('strings.send') <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M2,21L23,12L2,3V10L17,12L2,14V21Z" /></svg></button>
                                                                        @if(!empty($id))
                                                                            <input type="hidden" id="user-id" name="id" value="{{ $id }}">
                                                                        @endif
                                                                            <input type="hidden" id="user-avatar" value="">
                                                                    </form>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
    <script>
        $('.user-messages').scrollTop($('.user-messages')[0].scrollHeight);
        var form = $('form#new-message-form');

        $('#search-list').on('keyup', function(event) {
            $('#search-icon').toggleClass('fa-search fa-spinner fa-spin');
            $.post('{{ url('admin/inbox/customers/messages/search') }}', {keyword: $(this).val()}, function(data, textStatus, xhr) {
                $('#search-icon').toggleClass('fa-spinner fa-spin fa-search ');
                if (data.status == 200) {
                    $('.messages-sidebar .list-group').html(data.users);
                }
            });
        });

        $('#new-message').on('keyup', function(event) {
            if (event.keyCode == 13 && !event.shiftKey) {
                if ($(this).val().length > 1) {
                    form.submit();
                } else {
                    $('#new-message').val('');
                }
            }
        });

        form.ajaxForm({
            url: '{{ url('admin/inbox/customers/messages/new') }}',
            data: form.serialize(),
            beforeSubmit: function(formData, jqForm, options) {
                if ($('.messages').length == 0) {
                    $('.user-messages').html('<div class="messages"></div>');
                }
                $('.messages').append('<div class="data_message" data-id="0"><div class="message to-user incming_msg pull-left" data-id=""><div class="user-message"> Thank you for your reply!</div><div class="clear"></div></div><div class="clear"></div></div>');
                $('#new-message').val('');
                $('.user-messages').scrollTop($('.user-messages')[0].scrollHeight);
            },
            success: function(data) {

            }
        });
        
        $(document).ready(function() {
          if(!Modernizr.input.placeholder){
            $("#search-list").each(function(){
              if($(this).val()=="" &amp;&amp; $(this).attr("placeholder")!=""){
                $(this).val($(this).attr("placeholder"));
                $(this).focus(function(){
                  if($(this).val()==$(this).attr("placeholder")) $(this).val("");
                });
                $(this).blur(function(){
                  if($(this).val()=="") $(this).val($(this).attr("placeholder"));
                });
              }
            });
          }
        });

    </script>
@endsection
@section('scripts')

@endsection