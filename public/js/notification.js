var lang = $('meta[name="lang"]').attr('content');

$(document).ready(function() {
  $("#nfnav").on("click", ".notifySeen", function() {
    $(this).attr('disabled', 'disabled');
    var gg = $(this);
    var id = $(this).data('id');
    var type = $(this).data('type');
    var url = "/admin/editNotify";
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
  $('#modelnawaf').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var modal = $(this)
      modal.find('.NotifyModal').html(button.find('.item-messages').html())

    });
});
/*var form = $('form#notification_send_message');

form.ajaxForm({
  url: '/admin/notification/send_message' ,
  data: form.serialize(),
  beforeSubmit: function(formData, jqForm, options) {
    $('.all-messages').append('<div class="userCH"><br><p> ' + $('.notification_message').val() + ' </p>');
    $('.notification_message').val('');
  },
  success: function(data) {

  }
});*/

function openMessage(id) {
  var user, user2 = '';
  $.get("/admin/notification/user_message/" + id, function(data) {
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

/*var form = $('form#notification_send_message');

form.ajaxForm({
  url: '/admin/notification/send_message',
  data: form.serialize(),
  beforeSubmit: function(formData, jqForm, options) {
    $('.all-messages').append('<div class="userCH"><br><p> ' + $('.notification_message').val() + ' </p>');
    $('.notification_message').val('');
  },
  success: function(data) {

  }
});*/

function openMessage(id) {
  var user, user2 = '';
  $.get("/admin/notification/user_message/" + id, function(data) {
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

var notificationsWrapper = $('.notification');
var notifications = notificationsWrapper.find('#hidemessage');

var pusher = new Pusher('0ed63140cfc3c3df68a3', {
  encrypted: true
});
var channel = pusher.subscribe('Notifications');
let audio = new Audio("/sounds/nf_sound.mp3");

channel.bind('App\\Events\\Notifications', function(data) {
  var newNotificationHtml = '';
  var existingNotifications = notifications.html();
  /* check user id with auth id to display notify  and check if type login */
  if (data.user['id'] != $('#userId').val() && data.notify['org_id'] ==$('#orgId').val()  && data.type == 'login') {
      $('.badge').css('display','block');
      audio.play();
    /* check lang ar or en to show notfiy with lang */
    if (lang == 'ar') {
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
  if (data.user['id'] !=$('#userId').val() && data.notify['org_id'] ==$('#orgId').val()  && data.type == 'logout') {
       $('.badge').css('display','block');
      audio.play();
    /* check lang to show notify with lang chosen */
    if (lang == 'ar') {
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

  if (data.user['org_id']  == $('#orgId').val() && data.type == 'reservations') {
       $('.badge').css('display','block');
      audio.play();

    if (lang == 'ar') {
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
  if (data.notify['to_id'] == $('#userId').val() && data.user['org_id'] ==$('#orgId').val()  && data.type == 'newmsg') {
       $('.badge').css('display','block');
      audio.play();
    if (lang == 'ar') {
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
  if (data.user ==$('#orgId').val()  && data.type == 'offer') {
       $('.badge').css('display','block');
      audio.play();
    if (lang== 'ar') {
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
  if (data.user ==$('#orgId').val()  && data.type == 'transaction') {
       $('.badge').css('display','block');
      audio.play();
    if (lang == 'ar') {
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
