var __jsDateFormat = 'yy/mm/dd';
var jsDateFormat='yy/mm/dd';
var lang = $('meta[name="lang"]').attr('content');

date=new Date();
var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
$datePickerDiv = $('#dateDiv').datepicker({
onSelect: function()
{
$('#AddAppointment').val($.datepicker.formatDate(__jsDateFormat, $(this).datepicker('getDate')));
$('#AddAppointment').change();
},


     dateFormat: jsDateFormat,
    startDate: date,
});

    $('.next').on('click',function()
    {
        if(!($(this).hasClass('btn-disabled')))
        {
            return false;
        }
        $(this).siblings('.next-error').remove();
        error = $(this).data('error');
        $error = $(`<div class="clear"></div><div class='next-error alert-danger'>${error}</div>`);
        $error.insertAfter(this);
    })
    $('#serviceNext').on('click', function ()
    {
        if($(this).hasClass('btn-disabled'))
        {
            return false;
        }
        $('.staff-item ').first().click();
    });






staffs = {"1":"\u0641\u0646\u064a","2":"\u0641\u0646\u06492"};
bookingData = null;
clientId = "";
default_currency= $('meta[name="currency"]').attr('content');
no_staff_text = "يبدو ان $staff لا يعمل هذا اليوم من فضلك اختر موظف أو موعد اخر";
getTimeUrl = "/admin/reservations/captins_time";
addClientUrl = "/owner/clients/add";
var appoitnmentData = {
    staff: {},
    services: {},
    date: {
        date: null,
        start_time: null,
        end_time: null,
        duration: 0
    },
    client: {id: clientId},
}

function enableBtn(btn)
{
    btn.siblings('.next-error').remove();
    btn.removeClass('btn-disabled');
}

function disableBtn(btn)
{
    btn.addClass('btn-disabled');
}

function checkFinishBtn() {
    if(
        appoitnmentData.staff.staff_id != null &&
        appoitnmentData.staff.staff_name != null &&
        appoitnmentData.date.duration > 0 &&
        appoitnmentData.client.id != null && appoitnmentData.client.id != ''
    ){
        
        enableFinishBtn();
    }else{
            disableFinishBtn();
    }

}

function isEmpty(obj) {
    for (var key in obj) {
        if (obj.hasOwnProperty(key))
            return false;
    }
    return true;
}
var addService = function (service, service_name)
{
    appoitnmentData.services[service_name] = service;
    appoitnmentData.date.duration = service.duration + appoitnmentData.date.duration;
    $('.service-items').append('<tr><td class="service-title"><span>' + service_name + '</span></td><td class="td16">' + service.price + default_currency+ '</td><td class="td16">' + service.duration + ' M</td><td><i class="fa selected-service service-' + service.id + ' fa-times"></i></td></tr>');


    enableBtn($('#serviceNext'));
    checkFinishBtn();
}
var removeService = function (service_name)
{
    deletedService = appoitnmentData.services[service_name];
    appoitnmentData.date.duration -= deletedService.duration;
    $('.service-' + deletedService.id).parents('tr').remove();
    delete appoitnmentData.services[service_name];
    if (isEmpty(appoitnmentData.services))
    {
        disableBtn($('#serviceNext'));
    }
    checkFinishBtn();
}
time_post_data = {staff_name: null, staff_id: null, services: {}, date: null};
$(document).ready(function () {

    $(document).on('click', '.fa-times', function ()
    {
        if ($(this).hasClass('selected-service'))
        {
            text = $(this).parents('tr').find('.service-title').text();
            service_name = text;
            service_id = appoitnmentData.services[service_name].id;
            $('.service-input-' + service_id).attr('checked', false);
            removeService(service_name);

        } else if ($(this).hasClass('selected-staff'))
        {
            $(this).children('input').attr('checked', false).end().toggleClass('active');
            disableBtn(staffNext);
            setSelectedStaff('');

        }
        $(this).parent('tr').remove();
        checkFinishBtn();
    });


});

function add_selected(sel)
{
    service = {}
    service_name = $(sel).siblings('label').text();
    service.id = $(sel).val();
    service.duration = $(sel).data('duration');

    service.price = $(sel).data('price');

    if ($(sel).not(':checked').length)
    {
        //give each service item id and remove it in this condition ya 7ag belal
        removeService(service_name);
        $('.fa-times.service-' + service.id).parent().remove();
    } else
    {

        addService(service, service_name);

    }
    checkFinishBtn()

}

$selectedStaff = $('#selected-staff');
staffNext = $('#staffNext');

var weekdays = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];


setSelectedStaff = function (staff_name, staff_id = null) {
    if (staff_name == '')
    {
        deletedStaffId = appoitnmentData['staff']['staff_id'];
        $('.staff-item-' + deletedStaffId).removeClass('active').find('input').attr('checked', false);
        delete appoitnmentData['staff']['staff_name'];
        delete appoitnmentData['staff']['staff_id'];
        $selectedStaff.html('');
    } else {
        appoitnmentData.staff.staff_name = staff_name;
        appoitnmentData.staff.staff_id = staff_id;
        $.ajax({
            url: '/admin/get_staff_work_days/'+staff_id,
            dataType: 'JSON',
            success: function(availableWeekdays)
            {

              $('#dateDiv').datepicker({

        beforeShowDay: function (date) {
          if (availableWeekdays.indexOf(weekdays[date.getDay()]) != -1)
          return true;
          else
          return false;



   },

   dateFormat: jsDateFormat,

   startDate: date,
              }).on('changeDate', function(e) {
                $('#AddAppointment').val($.datepicker.formatDate(__jsDateFormat, e.date));
              if (date = $.datepicker.formatDate(__jsDateFormat, e.date))
              {
                  appoitnmentData.date.date = $.datepicker.formatDate(__jsDateFormat, e.date);
                  appoitnmentData.staff.staff_id = $('.staff_id:checked').val();
                  duration = appoitnmentData.date.duration;
                  ajax_data = {
                      staff_id: appoitnmentData.staff.staff_id,
                      date: appoitnmentData.date.date,
                      duration: duration,
                      ignored_appointments: [appoitnmentData.appointment_id]
                  };

                  //current window is time window
                  staff_id = $('.staff_id:checked').val();


                  $.ajax({
                      method: 'get',
                      dataType: 'JSON',
                      data: ajax_data,
                      url: getTimeUrl,
                      success: function (time_slots) {

                          timeSlotsHtml = '';
                          if (isEmpty(time_slots)) {
                              timeSlotsHtml += `<div class="alert alert-warning" role="alert">
                                      <h3>  <b>Not Working </b></h3>
                                      <p>
                            ` + no_staff_text.replace("$staff", appoitnmentData.staff.staff_name) + `
                                      </p>
                                   </div>`;
                          } else {

                              $.each(time_slots, function (key, value) {
                                  disabled_class = '';
                                  disabled = false;
                                  checked = '';

                                  timeString = getTimeString(value);
                                  timeSlotsHtml += `<li class="staff-time">
                                        <input  class='start-time' type="checkbox" name="start_time" value="${key}"> <span>${timeString}</span>
                                  </li>`;
                                  disabled_class = ''
                              });

                          }
                          $('#times').html(timeSlotsHtml);
                          if(!correctEndDate())
                          {
                              unSelectTime();
                          }
                      },
                      error: function (jqXHR, textStatus, errorThrown)
                      {
                          console.log(jqXHR);
                      }
                  })

              }


});


$('#dateDiv').datepicker( 'setDate', today );
if (date = $.datepicker.formatDate(__jsDateFormat,date))
{
    appoitnmentData.date.date = date;
    appoitnmentData.staff.staff_id = $('.staff_id:checked').val();
    duration = appoitnmentData.date.duration;
    ajax_data = {
        staff_id: appoitnmentData.staff.staff_id,
        date: appoitnmentData.date.date,
        duration: duration,
        ignored_appointments: [appoitnmentData.appointment_id]
    };

    //current window is time window
    staff_id = $('.staff_id:checked').val();


    $.ajax({
        method: 'get',
        dataType: 'JSON',
        data: ajax_data,
        url: getTimeUrl,
        success: function (time_slots) {

            timeSlotsHtml = '';
            if (isEmpty(time_slots)) {
                timeSlotsHtml += `<div class="alert alert-warning" role="alert">
                        <h3>  <b>Not Working </b></h3>
                        <p>
              ` + no_staff_text.replace("$staff", appoitnmentData.staff.staff_name) + `
                        </p>
                     </div>`;
            } else {

                $.each(time_slots, function (key, value) {
                    disabled_class = '';
                    disabled = false;
                    checked = '';

                    timeString = getTimeString(value);
                    timeSlotsHtml += `<li class="staff-time">
                          <input  class='start-time' type="checkbox" name="start_time" value="${key}"> <span>${timeString}</span>
                    </li>`;
                    disabled_class = ''
                });

            }
            $('#times').html(timeSlotsHtml);
            if(!correctEndDate())
            {
                unSelectTime();
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log(jqXHR);
        }
    })

}


            }

        });

        staffHtml = `
						<tr data-id="` + appoitnmentData.staff.staff_id + `">
                                        <td  class="selected-staff-item" width="60%">
                                            <span><i class="fa fa-user summary-icon"></i>` + appoitnmentData.staff.staff_name + `</span>
                                        </td>
                                        <td class="td16">&nbsp;
                                        </td>
                                        <td class="td16">&nbsp;
                                        </td>
                                        <td>
                                            <i class="selected-staff fa fa-times"></i>
                                        </td>
                                    </tr>
						`;
        $selectedStaff.html(staffHtml);
    }
    checkFinishBtn();

}

$('.staff-item').on('click', function ()
{
    if ($(this).children('input').attr('checked') == 'checked')
    {

        $(this).children('input').attr('checked', false).end().toggleClass('active');
        disableBtn(staffNext);
        setSelectedStaff('');
    } else {
        enableBtn(staffNext);
        $(this).children('input').attr('checked', 'checked').end().toggleClass('active');
        setSelectedStaff($(this).children('label').text(), $(this).children('input').val());
    }

    $(this).siblings('.staff-item').each(function ()
    {
        $(this).children('input').attr('checked', false);
        $(this).removeClass('active');
    })
    checkFinishBtn();

});

/********* Date Section *********/


function correctEndDate()
{
    return (appoitnmentData.date.start_time != null && addMinutesToTime(appoitnmentData.date.duration, appoitnmentData.date.start_time) == appoitnmentData.date.end_time);
}



function getTimeString(time)
{
    timeParts = time.split(':');
    hours = parseInt(timeParts[0]);
    if(hours >= 12)
    {
        timeSuffix = 'PM';
        if(hours > 12)
        {
            hours = hours - 12;
        }
    }else if(hours < 12)
    {
        timeSuffix = 'AM';
        if(hours == 0)
        {
            hours = 12;
        }
    }

    if(hours < 10){
        hours = '0'+hours.toString();
    }

    timeParts[0] = hours;
    timeParts[1]+= ' ' + timeSuffix;
    time = timeParts.join(':');
    return time;
}
$date = $('#date');
$startTime = $('#start-time');
$endTime = $('#end-time');

function addMinutesToTime(minutes, time)
{
    minutes = parseInt(minutes);
    minutesToadd = minutes % 60;
    hoursToAdd = Math.floor(minutes / 60);
    speratedTime = time.split(':');

    timeMinutes = parseInt(speratedTime[1])?parseInt(speratedTime[1]):0;

    timeHours = parseInt(speratedTime[0]);
    resultMinutes = timeMinutes + minutesToadd;
    if (resultMinutes >= 60) {
        hoursToAdd++;
        resultMinutes = resultMinutes % 60;
    }
    resultHours = timeHours + hoursToAdd;
    if(resultHours < 10)
    {
        resultHours = '0' + resultHours;
    }
    if(resultMinutes < 10)
    {
        resultMinutes = '0' + resultMinutes ;
    }
    result = [resultHours, resultMinutes].join(':');
    return result;
}
$timeNext = $('#timeNext');



selectTime = function ($this)
{
    if ($this.hasClass('time-disabled'))
    {
        return;
    }
    $this.addClass('active-time');
    $('.staff-time').removeClass('active-time').children('input').attr('checked', false);
    $this.addClass('active-time');
    $this.children('input').attr('checked', 'checked');
    start_time = $this.children('span').text();
    setTime(start_time);

}

function setTime(start_time)
{
    if(start_time != '00:00')
    start_time = start_time.replace('00:00', '');
    appoitnmentData.date.start_time = start_time;

    appoitnmentData.date.end_time = addMinutesToTime(appoitnmentData.date.duration, start_time);
    html = `<tr>
                                        <td class="staff-item" width="60%">
											<i class="fa fa-calendar summary-icon icon-sum"></i>` + appoitnmentData.date.date + `
                                        </td>
                                        <td  class="td16 value-color">
												` + appoitnmentData.date.start_time + `
                                        </td>
                                        <td  class="td16 value-color">
											` + getTimeString(appoitnmentData.date.end_time) + `
                                        </td>
                                        <td >
                                            <i class="fa fa-times"></i>
                                        </td>
                                    </tr>
						`;
    $date.html(html);
    $date.show();
    enableBtn($timeNext);
}

unSelectTime = function ()
{
    appoitnmentData.date.start_time = null;
    appoitnmentData.date.end_time = null;
    $('.staff-time.active-time').removeClass('active-time').children('input').removeAttr('checked');
    $date.text('');
    disableBtn($timeNext);
}

$selectedDate = $('#selected-date');
$('body').on('click', '.staff-time', function ()
{
    if ($(this).children('input').is(':checked')) {
        unSelectTime();
    } else {

        selectTime($(this));
    }
    checkFinishBtn();
});

function initSelectedDate() {
    if(
        !appoitnmentData.date.date ||
        (typeof appoitnmentData.date.start_time != null &&
            !correctEndDate()
    )
    )
    {
        $('#AddAppointment').val($.datepicker.formatDate(__jsDateFormat, $datePickerDiv.datepicker('getDate')));
        $('#AddAppointment').change();
    }
}


/********* Edit Section ********/

function fillData(bookingData)
{
    for (i = 0; i < bookingData.InvoiceItem.length; i++)
    {
        //set selected services
        invoiceItem = bookingData.InvoiceItem[i];
        $('.service-input-' + invoiceItem.product_id).click();
    }

    appoitnmentData.appointment_id = bookingData.FollowUpReminder.id;

    //set selected staff
    selectedStaff = bookingData.ItemStaff;
    $('.staff_id[value="' + selectedStaff.staff_id + '"]').click();

    //set selected time and date
    startDateTime = bookingData.FollowUpReminder.date.split(' ');
    startTime = startDateTime[1];
    startDate = startDateTime[0];
    appoitnmentData.date.date = startDate;
    $('#AddAppointment').val(startDate);
    var dateParts = startDate.split("-");
    var jsDate = new Date(dateParts[0], dateParts[1] - 1, dateParts[2].substr(0, 2));
    startDate = $.datepicker.formatDate(jsDateFormat, jsDate);
    $('#dateDiv').datepicker('setDate', startDate);
    $('#dateDiv').datepicker('refresh');
    appoitnmentData.date.date = startDate;
    $('#AddAppointment').change();
    setTime(startTime);
    $('#client_selectpicker').change();

}
$(function ()
{
    if (typeof bookingData != 'undefined' && bookingData != null) {
        fillData(bookingData);
    }
})



var formDataToApiJson = function (selector)
{
    formData = {};
    serializedFormData = $(selector).serializeArray();
    $.each(serializedFormData, function () {
        inputName = this.name.replace('data', '');

        var matches = inputName.match(/\[([^\]]*)\]/g);
        if (matches != null && matches != "null")
        {
            if(matches.length == 2)
            {
                modelName = matches[0].substring(1, matches[0].length - 1);
                fieldName = matches[1].substring(1, matches[1].length - 1);
                if (!formData[modelName])
                {
                    formData[modelName] = {};
                }

                if (formData[modelName][fieldName]) {
                    if (!formData[modelName][fieldName].push) {
                        formData[modelName][fieldName] = [formData[this.name]];
                    }
                    formData[modelName][fieldName].push(this.value || '');
                } else {
                    formData[modelName][fieldName] = this.value || '';
                }
            }else if(matches.length == 3)
            {
                modelName = matches[0].substring(1, matches[0].length - 1);
                number = matches[1].substring(1, matches[1].length - 1);
                fieldName = matches[2].substring(1, matches[2].length - 1);
                if (!formData[modelName])
                {
                    formData[modelName] = {};
                }

                if(!formData[modelName][number])
                {
                    formData[modelName][number] = {};
                }

                if (formData[modelName][number][fieldName]) {
                    if (!formData[modelName][number][fieldName].push) {
                        formData[modelName][number][fieldName] = [formData[this.name]];
                    }
                    formData[modelName][number][fieldName].push(this.value || '');
                } else {
                    formData[modelName][number][fieldName] = this.value || '';
                }
            }

        }

    });
    return formData;
}


$finishBtn = $('#finish');
$('#client_selectpicker').on('change', function ()
{
    
  alert('hello');
    client_id = $(this).val();
    alert(client_id);
   
    if (client_id)
    {
        
        appoitnmentData.client.id = client_id;
    }
    checkFinishBtn();
});
function change_customer(){
    client_id = $('#client_selectpicker').val();
  
   
    if (client_id)
    {
        
        appoitnmentData.client.id = client_id;
    }
    checkFinishBtn();
    
}

function disableFinishBtn()
{
    // $finishBtn.attr('disabled', 'disabled');

    $finishBtn.addClass('btn-disabled');
}

function enableFinishBtn()
{
    // $finishBtn.attr('disabled', false);
    $finishBtn.removeClass('btn-disabled');
}

function open_modal_register()
{
    $('#ModalSnippetRegist').modal('show');
}
$finishBtn.on('click', function()
{
    
    if(!$finishBtn.hasClass('btn-disabled'))
    {
        $('#msform').submit();
    }
})


function fillBookingData()
{
    $('.service-input:not(:checked)').attr('disabled',true);
    $endTime = '<input id="InvoiceEndTime" name="end_time" value="' + appoitnmentData.date.end_time + '" type="hidden"/>'
    $('#msform').append($endTime);
    $startTime = '<input id="InvoiceStartTime" name="start_time" value="' + appoitnmentData.date.start_time + '" type="hidden"/>'
    $('#msform').append($startTime);
    // $date = '<input id="InvoiceDate" name="data[Invoice][date]" value="' + appoitnmentData.date.date + '" type="hidden"/>'
    // $('#msform').append($date);
}

$('#msform').on('submit', function ()
{
    fillBookingData();
});


/********* client Payment Section *********/
function convertInvoice(bookingId) {

    $.get('/api2/bookings/convert/'+bookingId, function (data) {
        if(data.id)
        {
            appoitnmentData.converted_invoice_id = data.id;
            $('#paymentIframe').attr('src','/client/invoices/pay/'+data.id +'?box=1')
            $('#paymentIframe').show();
        }else{
            showSnackbar(__('Could Not Convert Booking To Invoice Please Try Again Or Contact Support'));
        }
    })
}

function saveInvoice() {
    fillBookingData();
    formData = formDataToApiJson('#msform');
    $.ajax({
        url: '/api2/bookings/',
        method: 'POST',
        dataType: 'JSON',
        contentType: 'application/json',
        data: JSON.stringify(formData),
        success: function (data) {
            if(bookingId = data.id)
            {
                appoitnmentData.booking_id = bookingId;
                convertInvoice(bookingId);
            }else{
                showSnackbar(__('Could Not Save Invoice Please Try Again Or Contact Support'));
            }
        },
        error: function (jqXHR) {
            showSnackbar(__('Could Not Save Invoice Please Try Again Or Contact Support'));
        }
    })

}

function deleteInvoice() {
    $('.service-input:not(:checked)').removeAttr('disabled');
    $('#InvoiceEndTime').remove();
    $('#InvoiceStartTime').remove();
    $('#InvoiceDate').remove();
    if(appoitnmentData.converted_invoice_id)
    {
        $.ajax({
            url: '/api2/client/bookings/'+appoitnmentData.booking_id,
            type: 'DELETE',
            contentType: 'application/json',
            success: function (result) {
                if(result.code == 200)
                {

                }else{
                    showSnackbar(__('Could Not Save Invoice Please Try Again Or Contact Support'));
                }
            },
            error: function (jqXHR) {
                showSnackbar(__('Could Not Delete Invoice'));
            }
        })

    }

}
function customer_modal(){
    
    var modal2 = document.getElementById('myModal3');
    modal2.style.display = "block";
}
function close_modal(){
    var modal2 = document.getElementById('myModal3');
    modal2.style.display = "none";
}
 
