@php
use App\Notification as notifyModel;
use App\NotificationsUser as activityModel;
use App\loginHistory as logActivity;

@endphp
<style>
  .modal-backdrop {
    z-index: 1 !important;
    opacity: 0 !important;
  }

  .messagess a {
    text-decoration: none;
  }
</style>
<!-- notification -->

<div id="modelnawaf" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body NotifyModal">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">إغلاق</button>
      </div>
    </div>

  </div>
</div>

<div class="notification" id="nfnav">
  <div class="title-nf">
      <input type="hidden" id="userId" value="{{Auth::user()->id}}">
      <input type="hidden" id="orgId" value="{{ Auth::user()->org_id }}">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation">
        <a href="#message-clients" aria-controls="profile" role="tab" data-toggle="tab">
          @lang('strings.customers_messages')</a>
      </li>
      {{-- <li role="presentation" class="active">
               <a href="#message-users" aria-controls="home" role="tab" data-toggle="tab">@lang('strings.user_messages')</a>
             </li> --}}
    </ul>
  </div>

  <div class="nf-content">
    <div class="tab-content">
      <div role="tabpanel" class="tab-pane" id="message-clients">
        <!-- time date for notification -->
        <div class="time-d">
          <p class="time-date-nf datenf-2"> {{ date('h:i') }} </p>
          <p class="time-date-nf datenf-1"> {{ date('Y-m-d') }} </p>
        </div>
        <div class="trach">
          <a href="#" onclick="showSearch()" id="whenSS">
            <i class="fas fa-inbox"></i>
          </a>
          <a href="#" onclick="hideSearch()" id="whenHS">
            <i class="fas fa-arrow-circle-left"></i>
          </a>
        </div>
        <p class="all-nf-s"> {{ __('strings.all_nf') }} </p>
        <!-- messages -->
        <div class="messagess" id="messagesSearch">
          <div class="seenMessages">
            @php
            $notifiyHidden = DB::table("notifications")->where('org_id',Auth::user()->org_id)
            ->select(
            "id",
            "content"
            ,"content_en"
            ,"content_type"
            ,"created_at"
            );
            $reservationHidden = DB::table("reservations")->where('org_id',Auth::user()->org_id)
            ->select(
            "id"
            ,"cust_id"
            ,"org_id"
            ,"confirm"
            ,"reservation_date"
            );

            $msgsHidden = DB::table("users_messages")->where('org_id',Auth::user()->org_id)->where('to_id',Auth::user()->id)
            ->select(
            "id"
            ,"from_id"
            ,"message"
            ,"to_id"
            ,"created_at"
            );
             $front_messages=DB::table("front_messages")->where('org_id',Auth::user()->org_id)
            ->select(
            "id"
            ,"name"
            ,"message"
            ,"open"
          ,"created_at"
            );
          
            $loginHistoryHidden = DB::table("login_history")->where('org_id',Auth::user()->org_id)
            ->select(
            "id"
            ,"user_id"
            ,"org_id"
            ,"status"
            ,"created_at"
            )
            ->unionAll($notifiyHidden)->unionAll($reservationHidden)->unionAll($msgsHidden)->unionAll($front_messages)

            ->orderBy('created_at','desc')->get();
           
            @endphp
            @if (count($loginHistoryHidden) > 0)
            @foreach($loginHistoryHidden as $value)
            @if (Auth::user()->id != $value->user_id )
            @if ($value->status == 'login')
            @php
            $userlogin = App\User::find($value->user_id);
            $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','login')->first();
            @endphp
            @if ($activityUser)
            <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
              <h3>
                {{ app()->getLocale() == 'ar' ? "تسجيل دخول" : "Login" }}
                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
              </h3>
              {{-- <p class="sub-messages"></p> --}}
              @if ($userlogin)
              <p class="desk-messages">{{ app()->getLocale() == 'ar' ? " المستخدم $userlogin->name  سجل دخول " : "$userlogin->name_en Logged in " }}</p>
              @endif
            </div>
            </a>
            @endif

            @endif


            @if ($value->status == 'logout')
            @php
            $userlogout = App\User::find($value->user_id);
            $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','logout')->first();
            @endphp
            @if ($activityUser)
            <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
              <h3>
                {{ app()->getLocale() == 'ar' ? "تسجيل خروج" : "Logout" }}
                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
              </h3>
              {{-- <p class="sub-messages"></p> --}}
              @if ($userlogout)
              <p class="desk-messages">{{ app()->getLocale() == 'ar' ? " المستخدم $userlogout->name سجل خروج " : "$userlogout->name_en Logged out " }}</p>
              @endif
            </div>
            </a>
            @endif

            @endif
          @endif

            @if ($value->status == 'n')
            @php
            $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','reservation')->first();
            $cust = App\User::where('id',$value->cust_id)->where('org_id',$value->org_id)->first();
            @endphp

            @if ($activityUser)
            <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
              <h3>
                {{ app()->getLocale() == 'ar' ? "حجز جديد" : "New reservation" }}
                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
              </h3>
              {{-- <p class="sub-messages"></p> --}}
              <p class="desk-messages">{{ app()->getLocale() == 'ar' ?   "تم اضافة حجز جديد للعميل $cust->name" : "New reservation added for $cust->name_en"}}</p>
            </div>
            </a>
            @endif
            @endif
            @if ($value->status == Auth::user()->id)
            @php
            $userMsg = App\User::find($value->user_id);
            $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','message')->first();
            @endphp
            @if ($activityUser)
            <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
              <h3>
                {{ app()->getLocale() == 'ar' ? "رسالة جديدة" : "New message" }}
                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
              </h3>
              {{-- <p class="sub-messages"></p> --}}
              @if ($userMsg)
              <p class="desk-messages">{{ app()->getLocale() == 'ar' ?   "لديك رسالة جديدة من  $userMsg->name"  : "You have a new message from $userMsg->name_en"}}</p>
              @endif
            </div>
            </a>
            @endif
            @endif
            @if ($value->status =='0' || $value->status =='1' )
            @php
          
            $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','front_message')->first();
            @endphp
            @if ($activityUser)
            <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
              <h3>
                {{ app()->getLocale() == 'ar' ? "رسالة جديدة" : "New message" }}
                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
              </h3>
              {{-- <p class="sub-messages"></p> --}}
            
              <p class="desk-messages">{{ app()->getLocale() == 'ar' ?   "لديك رسالة عميل جديدة من  $value->user_id"  : "You have a new front message from $value->user_id"}}</p>
          
            </div>
            </a>
           @endif
            @endif
            @if ($value->status == 'offer')
            @php
            $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','offer')->first();
            @endphp
            @if ($activityUser)

            <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
              <h3>
                {{ app()->getLocale() == 'ar' ? "انتهاء عرض" : "Offer ended" }}
                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
              </h3>
              {{-- <p class="sub-messages"></p> --}}
              <p class="desk-messages">{{ app()->getLocale() == 'ar' ?   "$value->user_id"  : "$value->org_id"}}</p>
            </div>
            </a>
            @endif
            @endif
            @if ($value->status == 'transaction')
            @php
            $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','transaction')->first();
            @endphp
            @if ($activityUser)
            <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
              <h3>
                {{ app()->getLocale() == 'ar' ? "حد الطلب" : "transaction" }}
                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
              </h3>
              {{-- <p class="sub-messages"></p> --}}
              <p class="desk-messages">{{ app()->getLocale() == 'ar' ?   "$value->user_id"  : "$value->org_id"}}</p>
            </div>
            </a>
            @endif
            @endif
            @endforeach
            @endif


          </div>
        </div>

        <!-- messages -->
        <div class="clearfix"></div>
        {{-- a.nabil --}}
        <div class="messages" id="hidemessage">
          @php
          $notifiy = DB::table("notifications")->where('org_id',Auth::user()->org_id)
          ->select(
          "id",
          "content"
          ,"content_en"
          ,"content_type"
          ,"created_at"
          );
          $reservation = DB::table("reservations")->where('org_id',Auth::user()->org_id)
          ->select(
          "id"
          ,"cust_id"
          ,"org_id"
          ,"confirm"
          ,"created_at"
          );

          $msgs = DB::table("users_messages")->where('org_id',Auth::user()->org_id)->where('to_id',Auth::user()->id)
          ->select(
          "id"
          ,"from_id"
          ,"message"
          ,"to_id"
          ,"created_at"
          );
           $front_messages=DB::table("front_messages")->where('org_id',Auth::user()->org_id)
            ->select(
            "id"
            ,"name"
            ,"message"
            ,"open"
          ,"created_at"
            );
          $loginHistory = DB::table("login_history")->where('org_id',Auth::user()->org_id)->where('user_id','!=',Auth::user()->id)
          ->select(
          "id"
          ,"user_id"
          ,"org_id"
          ,"status"
          ,"created_at"
          )
          ->unionAll($notifiy)->unionAll($reservation)->unionAll($msgs)->unionAll($front_messages)

          ->orderBy('created_at','desc')->get();
            $allNotifications = count($loginHistory);
            $allNotifyACtivity  = activityModel::where('user_id',Auth::user()->id)->count();
            
          @endphp
          @if ($allNotifyACtivity < $allNotifications)
          @if (count($loginHistory) > 0)


          @foreach($loginHistory as $value)

          @if (Auth::user()->id != $value->user_id )
            @if ($value->status == 'login')
              @php
              $userlogin = App\User::find($value->user_id);
              $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','login')->first();
              @endphp
              @if (!$activityUser)
              <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
                <h3>
                  <button type="button" class="notifySeen" data-id="{{ $value->id }}" data-type="login" name="button">X</button>
                  {{ app()->getLocale() == 'ar' ? "تسجيل دخول" : "Login" }}
                  <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                  <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
                </h3>
                {{-- <p class="sub-messages"></p> --}}
                @if ($userlogin)
                <p class="desk-messages">{{ app()->getLocale() == 'ar' ? " المستخدم  $userlogin->name  سجل دخول": "$userlogin->name_en Logged in " }}</p>
                @endif
            </div>
            </a>
            @endif

          @endif
          @if ($value->status == 'logout')

            @php
            $userlogout = App\User::find($value->user_id);
            $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','logout')->first();

            @endphp

            @if (!$activityUser)
            <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
              <h3>
                <button type="button" class="notifySeen" data-id="{{ $value->id }}" data-type="logout" name="button">X</button>

                {{ app()->getLocale() == 'ar' ? "تسجيل خروج" : "Logout" }}
                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
              </h3>
              {{-- <p class="sub-messages"></p> --}}
              @if ($userlogout)

              <p class="desk-messages">{{ app()->getLocale() == 'ar' ? " المستخدم  $userlogout->name    سجل خروج" : "$userlogout->name_en Logged out " }}</p>
              @endif
            </div>
            </a>
            @endif

          @endif
        @endif

          @if ($value->status == 'n')
          @php
          $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','reservation')->first();
          $cust = App\Customers::where('id',$value->user_id)->where('org_id',Auth::user()->org_id)->first();
          @endphp

          @if (!$activityUser)
          <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
            <h3>
              <button type="button" class="notifySeen" data-id="{{ $value->id }}" data-type="reservation" name="button">X</button>
  
              {{ app()->getLocale() == 'ar' ? "حجز جديد" : "New reservation" }}
              <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
              <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
            </h3>
            {{-- <p class="sub-messages"></p> --}}
            <p class="desk-messages">{{ app()->getLocale() == 'ar' ?   "تمت اضافة حجز جديد للعميل $cust->name" : "New reservation added for $cust->name_en"}}</p>
          </div>
          </a>
          @endif
          @endif
          @if ($value->status == Auth::user()->id)
          @php
          $userMsg = App\User::find($value->user_id);
          $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','message')->first();
          @endphp
          @if (!$activityUser)
          <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
            <h3>
              <button type="button" class="notifySeen" data-id="{{ $value->id }}" data-type="message" name="button">X</button>

              {{ app()->getLocale() == 'ar' ? "رسالة جديدة" : "New message" }}
              <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
              <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
            </h3>
            {{-- <p class="sub-messages"></p> --}}
            @if ($userMsg)
            <p class="desk-messages">{{ app()->getLocale() == 'ar' ?   "لديك رسالة جديدة من  $userMsg->name"  : "You have a new message from $userMsg->name_en"}}</p>
            @endif
          </div>
          </a>
          @endif

          @endif
            @if ($value->status == '0' || $value->status == '1' )
     
            @php
           
            $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','front_message')->first();
            @endphp
            @if (!$activityUser)
            <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
              <h3>
                  <button type="button" class="notifySeen" data-id="{{ $value->id }}" data-type="front_message" name="button">X</button>
                {{ app()->getLocale() == 'ar' ? "رسالة جديدة" : "New message" }}
                <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
                <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
              </h3>
              {{-- <p class="sub-messages"></p> --}}
            
              <p class="desk-messages">{{ app()->getLocale() == 'ar' ?   "لديك رسالة عميل جديدة من  $value->user_id"  : "You have a new  front message from $value->user_id"}}</p>
          
            </div>
            </a>
            @endif

            @endif
          @if ($value->status == 'offer')
          @php
          $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','offer')->first();
          @endphp
          @if (!$activityUser)

          <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
            <h3>
              <button type="button" class="notifySeen" data-id="{{ $value->id }}" data-type="offer" name="button">X</button>

              {{ app()->getLocale() == 'ar' ? "انتهاء عرض" : "Offer ended" }}
              <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
              <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
            </h3>
            {{-- <p class="sub-messages"></p> --}}
            <p class="desk-messages">{{ app()->getLocale() == 'ar' ?   "$value->user_id"  : "$value->org_id"}}</p>
          </div>
          </a>
          @endif

          @endif
          @if ($value->status == 'transaction')
          @php
          $activityUser = App\NotificationsUser::where('user_id',Auth::user()->id)->where('notification_id',$value->id)->where('type','transaction')->first();
          @endphp
          @if (!$activityUser)
          <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
            <h3>
              <button type="button" class="notifySeen" data-id="{{ $value->id }}" data-type="transaction" name="button">X</button>

              {{ app()->getLocale() == 'ar' ? "حد الطلب" : "transaction" }}
              <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
              <p class="time-messages"> <i class="fas fa-clock"></i> {{ $value->created_at }}</p>
            </h3>
            {{-- <p class="sub-messages"></p> --}}
            <p class="desk-messages">{{ app()->getLocale() == 'ar' ?   "$value->user_id"  : "$value->org_id"}}</p>
          </div>
          </a>
          @endif
          @endif
          @endforeach
          @endif
      
        
        
        @elseif ($allNotifyACtivity == 0 && $allNotifications == 0)
        <p class="pforNF">لا توجد إشعارات</p>
        @elseif ($allNotifications == 0)
        <p class="pforNF">لا توجد إشعارات</p>
        @else
        <p class="pforNF">لا توجد إشعارات</p>
        @endif
        </div>
      </div>
      {{-- a.nabil --}}
    </div>
  </div>
</div>
<script src="//js.pusher.com/3.1/pusher.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script>

$(document).ready(function() {
  $("#nfnav").on("click", ".notifySeen", function() {
    $(this).attr('disabled', 'disabled');
    var gg = $(this);
    var id = $(this).data('id');
    var type = $(this).data('type');
    var url = "{{ Route('editNotify') }}";
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: url,
      dataType: 'json',
      data: {
        id: id,
        type: type,
      },
      type: 'POST',

      beforeSend: function() {

      },
      success: function(msg) {
        if (msg.data == 'successNotifiy') {
          gg.parents('.item-messages').fadeOut();
          $(".seenMessages").load(location.href + " .seenMessages");
        }
      }
    });
    return false;


  });
});
</script>
<script>
  $('.chat-nf').scrollTop($('.chat-nf')[0].scrollHeight);
  var form = $('form#notification_send_message');

  form.ajaxForm({
    url: '{{ url('
    admin / notification / send_message ') }}',
    data: form.serialize(),
    beforeSubmit: function(formData, jqForm, options) {
      $('.all-messages').append('<div class="userCH"><br><p> ' + $('.notification_message').val() + ' </p>');
      $('.notification_message').val('');
      $('.chat-nf').scrollTop($('.chat-nf')[0].scrollHeight);
    },
    success: function(data) {

    }
  });

  function openMessage(id) {
    var user, user2 = '';
    $.get("{{ url('admin/notification/user_message/') }}/" + id, function(data) {
      $('.userCH').remove();
      $('.meCH').remove();
      if (data.messages.length != 0) {
        $.each(data.messages, function(key, value) {
          user += '<div class="userCH">\n' +
            '           <br> <p> ' + value.message + ' </p> \n' +
            '</div>';
        });
        $('.all-messages').append(user);
      }
      if (data.reply.length != 0) {
        $.each(data.reply, function(key, value) {
          user2 += '<div class="meCH">\n' +
            '           <br><p> ' + value.message + ' </p> \n' +
            '</div>';
        });
        $('.all-messages').append(user2);
      }
    });
    $('.chatuser-' + id).show();
  };

  function backallM2(id) {
    $('.chatuser-' + id).hide();
  };
</script>

<script>
  $('.chat-nf').scrollTop($('.chat-nf')[0].scrollHeight);
  var form = $('form#notification_send_message');

  form.ajaxForm({
    url: '{{ url('
    admin / notification / send_message ') }}',
    data: form.serialize(),
    beforeSubmit: function(formData, jqForm, options) {
      $('.all-messages').append('<div class="userCH"><br><p> ' + $('.notification_message').val() + ' </p>');
      $('.notification_message').val('');
      $('.chat-nf').scrollTop($('.chat-nf')[0].scrollHeight);
    },
    success: function(data) {

    }
  });

  function openMessage(id) {
    var user, user2 = '';
    $.get("{{ url('admin/notification/user_message/') }}/" + id, function(data) {
      $('.userCH').remove();
      $('.meCH').remove();
      if (data.messages.length != 0) {
        $.each(data.messages, function(key, value) {
          user += '<div class="userCH">\n' +
            '           <br> <p> ' + value.message + ' </p> \n' +
            '</div>';
        });
        $('.all-messages').append(user);
      }
      if (data.reply.length != 0) {
        $.each(data.reply, function(key, value) {
          user2 += '<div class="meCH">\n' +
            '           <br><p> ' + value.message + ' </p> \n' +
            '</div>';
        });
        $('.all-messages').append(user2);
      }
    });
    $('.chatuser-' + id).show();
  };

  function backallM2(id) {
    $('.chatuser-' + id).hide();
  };
</script>



<script type="text/javascript">
  var notificationsWrapper = $('.notification');
  var notifications = notificationsWrapper.find('#hidemessage');
  
  var pusher = new Pusher('0ed63140cfc3c3df68a3', {
    encrypted: true
  });
  /* Subscribe to the channel we specified in our Laravel Event */
    var channel = pusher.subscribe('Notifications');
    let audio = new Audio("{{ asset('sounds/nf_sound.mp3') }}");


  /* Bind a function to a Event (the full Laravel class) */
  channel.bind('App\\Events\\Notifications', function(data) {
    var newNotificationHtml = '';
    var existingNotifications = notifications.html();
    /* check user id with auth id to display notify  and check if type login */
    if (data.user['id'] != {{ Auth::user()->id }} && data.notify['org_id'] == {{ Auth::user()->org_id }} && data.type == 'login') {
        $('.badge').css('display','block');
        audio.play();
      /* check lang ar or en to show notfiy with lang */
      if ("{{ app()->getLocale() }}" == 'ar') {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3> تسجيل دخول
            <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="login" name="button">X</button>        
            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock"></i> ` + data.notify['created_at'] + `</p>
          </h3>
          <p class="sub-messages"> المستخدم  `+ data.user['name'] +` قام بتسجيل الدخول </p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;


      } else {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3>   Login
                    <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="login" name="button">X</button>
            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock"></i> ` + data.notify['created_at'] + `</p>
          </h3>
          <p class="sub-messages"> ` + data.user['name_en'] + ` logged in  </p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      }

    }

    /* check if type logout display notify and check user id with auth id */
    if (data.user['id'] != {{ Auth::user()->id }} && data.notify['org_id'] == "{{ Auth::user()->org_id }}" && data.type == 'logout') {
         $('.badge').css('display','block');
        audio.play();
      /* check lang to show notify with lang chosen */
      if ("{{ app()->getLocale() }}" == 'ar') {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3> تسجيل خروج
                    <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="logout" name="button">X</button>
            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock"></i> ` + data.notify['created_at'] + `</p>
          </h3>
          <p class="sub-messages"> المستخدم  ` + data.user['name']  +` سجل خروج </p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      } else {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3> Logout
          <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="logout" name="button">X</button>

            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock">` + data.notify['created_at'] + `</i> </p>
          </h3>
          <p class="sub-messages"> ` + data.user['name_en'] + ` logged out  </p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      }
    }

    /* check if type equal reservations to show new order reservation notify */
   
    if (data.user['org_id']  == {{ Auth::user()->org_id }} && data.type == 'reservations') {
         $('.badge').css('display','block');
        audio.play();
   
      if ("{{ app()->getLocale() }}" == 'ar') {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3>  حجز جديد
          <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="reservation" name="button">X</button>

            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock"></i> ` + data.notify['created_at'] + `</p>
          </h3>
          <p class="sub-messages"> تمت اضاف جديد للعميل `+data.user['name']+`</p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      } else {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3> new Reservation
          <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="reservation" name="button">X</button>

            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock">` + data.notify['created_at'] + `</i> </p>
          </h3>
          <p class="sub-messages">  New reservation added for `+data.user['name_en']+` </p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      }
    }


    /* check if type equal newMsg and to_id(user) equal Auth::id to show msg for  user */
    if (data.notify['to_id'] == {{Auth::user()->id}} && data.user['org_id'] == "{{ Auth::user()->org_id }}" && data.type == 'newmsg') {
         $('.badge').css('display','block');
        audio.play();
      if ("{{ app()->getLocale() }}" == 'ar') {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3>  رسالة جديدة
          <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="message" name="button">X</button>
            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock"></i> ` + data.notify['created_at'] + `</p>
          </h3>
          <p class="sub-messages">لديك رسالة  من ` + data.user['name'] + `</p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      } else {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3> New message
          <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="message" name="button">X</button>

            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock">` + data.notify['created_at'] + `</i> </p>
          </h3>
          <p class="sub-messages"> You have a New message  from ` + data.user['name_en'] + ` </p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      }
    }

    /* check if type equal offer Ended and org_id equal user org_id; */
    if (data.user == {{ Auth::user()->org_id }} && data.type == 'offer') {
         $('.badge').css('display','block');
        audio.play();
      if ("{{ app()->getLocale() }}" == 'ar') {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3>  انتهاء عرض
          <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="offer" name="button">X</button>

            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock"></i> ` + data.notify['created_at'] + `</p>
          </h3>
          <p class="sub-messages"> ` + data.notify['content'] + `</p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      } else {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3> Offer ended
            <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="offer" name="button">X</button>
            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock">` + data.notify['created_at'] + `</i> </p>
          </h3>
          <p class="sub-messages">  ` + data.notify['content_en'] + `   </p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      }
    }

    /* check if type equal offer Ended and org_id equal user org_id; */
    if (data.user == {{ Auth::user()->org_id }} && data.type == 'transaction') {
         $('.badge').css('display','block');
        audio.play();
      if ("{{ app()->getLocale() }}" == 'ar') {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3>  حد الطلب
          <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="transaction" name="button">X</button>

            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock"></i> ` + data.notify['created_at'] + `</p>
          </h3>
          <p class="sub-messages"> ` + data.notify['content'] + `</p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      } else {
        var newNotificationHtml = `
        <a type="button" class="NotifyBtnClass" data-toggle="modal" data-target="#modelnawaf"><div class="item-messages" id="afterSee">
          <h3> Offer ended
            <button type="button" class="notifySeen" data-id="` + data.notify['id'] + `" data-type="transaction" name="button">X</button>
            <p id="iconseeDone"> <i class="fas fa-check"></i> </p>
            <p class="time-messages"> <i class="fas fa-clock">` + data.notify['created_at'] + `</i> </p>
          </h3>
          <p class="sub-messages">  ` + data.notify['content_en'] + `   </p>
          <p class="desk-messages"> </p>
        </div>
        </a>
        `;
      }
    }

    notifications.html(newNotificationHtml + existingNotifications);
    
  });
  
    $(document).ready(function(){
      $('#modelnawaf').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget)
          var modal = $(this)
          modal.find('.NotifyModal').html(button.find('.item-messages').html())
      
        });
    });
    

</script>
