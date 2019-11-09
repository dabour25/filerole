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
                        {{ DB::table('function_new')->where('id',39)->value('description') }}
                    @else
                        {{ DB::table('function_new')->where('id',39)->value('description_en') }}
                    @endif
                  </p>
                  <a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle"></i></a>
                </div>
                <div role="tabpanel">
                    <div class="panel panel-white panel-message">
                        <div class="panel-body ">
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
                                                            <input type="text" name="search" value="@lang('strings.search')" id="search-list">
                                                        </div>
                                                        <ul class="list-group">
                                                            @if(App\User::where(['org_id' => Auth::user()->org_id, 'is_active' => 1])->count() < 1)
                                                            <p class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>No users found</p>
                                                            @else
                                                                @foreach(App\User::where(['org_id' => Auth::user()->org_id, 'is_active' => 1])->get() as $value)
                                                                    @if($value->id != Auth::user()->id)
                                                                    <li class="user-list" data-id="{{ $value->id }}">
                                                                        <a href="{{ url('admin/inbox/users/message/'. $value->id) }}" data-load="admin/inbox/users/messages/{{ $value->id }}" data-id="{{ $value->id }}">
                                                                            <div class="user-avatar">
                                                                                <img src="{{ $value->photo ? asset($value->photo->file) : asset('images/profile-placeholder.png') }}" alt="user avatar">
                                                                            </div>
                                                                            <div class="countunseen">{{ App\UsersMessages::where(['to_id' => Auth::user()->id, 'from_id' => $value->id,'seen' => 0])->count() == 0 ? '' : App\UsersMessages::where(['to_id' => Auth::user()->id, 'from_id' => $value->id,'seen' => 0])->count() }}</div>
                                                                            <div class="user-name">{{ $value->name }}</div>
                                                                            <div class="user-last-message">{{ App\UsersMessages::where(['to_id' => Auth::user()->id, 'from_id' => $value->id])->orderBy('id', 'desc')->value('message') }}</div>
                                                                            <div class="clear"></div>
                                                                        </a>
                                                                    </li>
                                                                    @endif
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
                                                                    $user = App\User::findOrFail($id);
                                                                @endphp
                                                            <h3 class="pull-left">
                                                                
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left mobilemsgclose"><polyline points="15 18 9 12 15 6"></polyline></svg> <a href='#' data-load='' >{{ $user->name }}</a>
                                                                                                                                        <div class="user-avatar">
                                                                                <img src="{{ $user->photo ? asset($user->photo->file) : asset('images/profile-placeholder.png') }}" alt="user message">
                                                                            </div>
                                                            </h3>
                                                            {{--<div class="pull-right" id="delete-conversation"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></div>--}}
                                                            <div class="clear"></div>
                                                            @else
                                                            <h3 class="pull-left">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-left mobilemsgclose"><polyline points="15 18 9 12 15 6"></polyline></svg> <a style='color: #fff;' class='user-link'></a>
                                                                                                                                            <div class="user-avatar">
                                                                                <img src="{{ $user->photo ? asset($user->photo->file) : asset('images/profile-placeholder.png') }}" alt="user message">
                                                                            </div>
                                                                </h3>
                                                            <div class="clear"></div>
                                                            @endif
                                                        </div>
                                                        <button id="load-more-messages" title="Load more messages"><i class="fa fa-angle-up"></i></button>

                                                        <div class="pt_msg_joint">
                                                            <div class="user-messages user-setting-panel pt_msg_area">
                                                                @if(!empty($messages))
                                                                <div class="messages" data-id="0">

                                                                    {{--@foreach($messages as $m)--}}
                                                                        {{--<div class="message to-user pull-right" data-id="{{ $m->id }}">--}}
                                                                            {{--<div class="user-message">{{ $m->message }}</div>--}}
                                                                            {{--<div class="clear"></div>--}}
                                                                        {{--</div>--}}
                                                                        {{--<div class="clear"></div>--}}
                                                                    {{--@endforeach--}}

                                                                    @foreach(App\UsersMessages::where(['from_id' => $id, 'to_id' => Auth::user()->id])->Orwhere(['from_id' => Auth::user()->id, 'to_id' => $id])->get() as $m_r)
                                                                        @php $user = App\User::findOrFail($id); @endphp

                                                                        @if($m_r->to_id == $id && $m_r->from_id == Auth::user()->id)
                                                                        <div class="message to-user pull-right" data-id="{{ $m_r->id }}">
                                                                            <div class="user-message">{{ $m_r->message }}</div>
                                                                            <div class="clear"></div>
                                                                        </div>
                                                                        <div class="clear"></div>
                                                                        @endif
                                                                        @if($m_r->from_id == $id && $m_r->to_id == Auth::user()->id)
                                                                        <div class="message to-user incming_msg pull-left" data-id="{{ $m_r->id }}">
                                                                            <div class="user-avatar">
                                                                                <img src="{{ $user->photo ? asset($user->photo->file) : asset('images/profile-placeholder.png') }}" alt="user message">
                                                                            </div>
                                                                            <div class="user-message">{{ $m_r->message }}</div>
                                                                            <div class="clear"></div>
                                                                        </div>
                                                                        <div class="clear"></div>
                                                                        @endif
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
                                                                <form method="POST" id="new-message-form">
                                                                    {{ csrf_field() }}
                                                                    <textarea name="new-message" id="new-message" cols="30" rows="2" placeholder="@lang('strings.write_message')" ></textarea>
                                                                    <button class="btn btn-primary2" type="submit" id="send-button">@lang('strings.send')<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M2,21L23,12L2,3V10L17,12L2,14V21Z" /></svg></button>
                                                                    @if(!empty($id))
                                                                    <input type="hidden" id="user-id" name="id" value="{{ $id }}">
                                                                    @endif
                                                                    <input type="hidden" id="user-avatar" value="">
                                                                </form>
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
    </div>
@endsection
@section('scripts')
<script>
        var messagesInterval = 2000;
        function fetchMessages() {
            @if(!empty($id))
            $.post('{{ url('admin/inbox/messages/fetch') }}?id={{ $id }}', function (data, textStatus, xhr) {
                if (data.status == 200) {
                    if (data.message.length > 0) {
                        $('.messages').empty();
                        $('.messages').append(data.message);
                        $('.user-messages').scrollTop($('.user-messages')[0].scrollHeight);
                    }
                    if ($('#search-list').val() == 0) {
                        $('.messages-sidebar .list-group').html(data.users);
                    }
                }
                setTimeout(function () {
                    fetchMessages();
                }, messagesInterval);
            });
            @else
            $.post('{{ url('admin/inbox/messages/fetch') }}', function (data, textStatus, xhr) {
                if (data.status == 200) {
                    if ($('#search-list').val() == 0) {
                        $('.messages-sidebar .list-group').html(data.users);
                    }
                }
                setTimeout(function () {
                    fetchMessages();
                }, messagesInterval);
            });
            @endif
        }
        $(function() {
            setTimeout(function () {
                fetchMessages();
            }, messagesInterval);
        });

        $('.user-messages').scrollTop($('.user-messages')[0].scrollHeight);
        var form = $('form#new-message-form');

        $('#search-list').on('keyup', function(event) {
            $('#search-icon').toggleClass('fa-search fa-spinner fa-spin');
            $.post('{{ url('admin/inbox/users/messages/search') }}', {keyword: $(this).val()}, function(data, textStatus, xhr) {
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
            url: '{{ url('admin/inbox/users/messages/new') }}',
            data: form.serialize(),
            beforeSubmit: function(formData, jqForm, options) {
                if ($('.messages').length == 0) {
                    $('.user-messages').html('<div class="messages"></div>');
                }
                if($('#new-message').val() != ''){
                    $('.messages').append('<div class="data_message" data-id="0"><div class="message to-user pull-right" data-id=""><div class="user-message">' + $('#new-message').val() + '</div><div class="clear"></div></div><div class="clear"></div></div>');
                }
                $('#new-message').val('');
                $('.user-messages').scrollTop($('.user-messages')[0].scrollHeight);
            },
            success: function(data) {
                $('.user-list[data-id="' + data.message_id + '"].user-last-message').html(data.message);
            }
        });
        
        $(document).ready(function(){
            var Input = document.getElementById("search-list");
            var default_value = Input.val();
        
            $(Input).focus(function() {
                if($(this).val() == default_value)
                {
                     $(this).val("");
                }
            }).blur(function(){
                if($(this).val().length == 0)
                {
                    $(this).val(default_value);
                }
            });
        });

    </script>
@endsection