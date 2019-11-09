var lang = $('meta[name="lang"]').attr('content');
if(window.location.pathname==='/admin/reciet' || window.location.pathname==='/admin/addNewServiceRequest' || window.location.pathname==='/admin/show_reciet'){
      var url1="/admin/getservices";
     }
     else{
         var url1="/admin/getitems";
     }

  $(document).ready(function() {
       
     $(".datepicker_salary").datepicker( {
    format: "mm-yyyy",
    viewMode: "months", 
    minViewMode: "months"
});
       
    //clac total
    function calcTotal(thisBtn) {
      var total = 0,reg_1 = 0,reg = 0;
      var total1 = 0;

    console.log($('.finalTotalPrice').text());

        $(".fPrice span").each(function() {
          reg += parseFloat($(this).text());
           //return
        });

        $(".fprice_1 span").each(function() {
          reg_1 += parseFloat($(this).text()); //ex
        });
        console.log(reg_1);
        if (thisBtn.parents('tr').find('.reg_flagg select').val()  == -1) {
          total =  reg_1  - reg  ; //ex
        }
        else if (thisBtn.parents('tr').find('.reg_flagg select').val()  == 1) {
          total =   reg_1 -  reg ; //Return
        }
        $('.finalTotalPrice').text(total.toFixed(2));


    }
    //end calc total

    $("input[name$='delev']").click(function() {
        var test = $(this).val();

        $("div.desc").hide();
        $("#delev" + test).show();
    });
    $('#main-wrapper').on('click','#addRow',function(){
        
        var j=0;
        var counter;
       counter= parseInt(localStorage.getItem('counter'));
      
       
if (lang == 'ar'){
    var data ='<tr>\n'+
              '<td class="reg_flagg">\n'+
  '<span class=" " style="display:none;"></span>\n'+
  '<select name="reqFlag[]" form="newRequests" class="reg_flag_select form-control">\n'+
 '<option value="-1">صرف</option>\n'+
  '<option value="1">ايداع</option>\n'+
  '</select>\n'+
  '</td>\n'+
  '<td>\n'+
  '<select name="cat_id[]" form="newRequests" class="cat_id_select form-control" id="cat-'+counter+'" required>\n'+
  '<option class="btnTest" style="display:none"></option>\n'+
  '</select>\n'+
  '</td>\n'+
  '<td>\n'+
  '<input class="form-control qnyNum" name="qny[]" form="newRequests" type="number" disabled required>\n'+
  '</td>\n'+
  '<td>\n'+
  '<span class="cat_price"></span>\n'+
  '<input class="cat_price_input"  form="newRequests" type="hidden" name="cat_price[]">\n'+
  '<input class="tax_val" type="hidden"  form="newRequests" name="tax_val[]" required>\n'+
  '<input class="taxId" name="taxId[]" type="hidden"   form="newRequests" required>\n'+
  '</td>\n'+
  '<td>\n'+
  '<span class="tax"></span>\n'+
  '</td>\n'+
  '<td class="fprice_1">\n'+
  '<span class="total"></span>\n'+
  '</td>\n'+
  '<td>\n'+
  '<button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>\n'+
  '</td>\n'+
  '</tr>';
}
else{
      var data ='<tr>\n'+
  '<td class="reg_flagg">\n'+
  '<span class=" " style="display:none;"></span>\n'+
  '<select name="reqFlag[]" form="newRequests" class="reg_flag_select form-control">\n'+
  '<option value="-1">Exchange</option>\n'+
  '<option value="1">Return</option>\n'+
  '</select>\n'+
  '</td>\n'+
  '<td>\n'+
  '<select name="cat_id[]" form="newRequests" class="cat_id_select form-control" id="cat'+counter+'" required>\n'+
  '<option class="btnTest" style="display:none"></option>\n'+
  '</select>\n'+
  '</td>\n'+
  '<td>\n'+
  '<input class="form-control qnyNum" name="qny[]" form="newRequests" type="number" disabled required>\n'+
  '</td>\n'+
  '<td>\n'+
  '<span class="cat_price"></span>\n'+
  '<input class="cat_price_input"  form="newRequests" type="hidden" name="cat_price[]">\n'+
  '<input class="tax_val" type="hidden"  form="newRequests" name="tax_val[]" required>\n'+
  '<input class="taxId" name="taxId[]" type="hidden"   form="newRequests" required>\n'+
  '</td>\n'+
  '<td>\n'+
  '<span class="tax"></span>\n'+
  '</td>\n'+
  '<td class="fprice_1">\n'+
  '<span class="total"></span>\n'+
  '</td>\n'+
  '<td>\n'+
  '<button type="button" id="deltr" style="color: red;"   class="btn btn-defult btn-close-regust2"><i class="fas fa-times"></i></button>\n'+
  '</td>\n'+
  '</tr>';
}
  $('#xtreme-table tbody').append(data);

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }

    });
    $.ajax({
  url: url1,
  type: "GET",
  success: function (services){
    console.log(services);
   counter--;
    console.log(counter);
   
      $.each(services, function(key, value) {
   $('#cat-'+ counter).append('<option value="'+ key +'">'+ value +'</option>');

        });
  }
  });
 counter++;
  localStorage.setItem("counter", counter);
  

     });
     if(window.location.pathname==='/admin/reciet'){
         localStorage.setItem("counter", 0);
         $('#addRow').click();
     }
     

     $('#delete_req').on('show.bs.modal', function (event) {
       var button = $(event.relatedTarget) // Button that triggered the modal
       var id = button.data('id') // Extract info from data-* attributes
       var cust = button.data('cust') // Extract info from data-* attributes
       var req = button.data('req') // Extract info from data-* attributes
       // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
       // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
       var modal = $(this)
       modal.find('.modal-body #trans_id').val(id)
       modal.find('.modal-body #cust_id').val(cust)
       modal.find('.modal-body #req_id').val(req)

     });

     $("#xtreme-table").on('click', '.btn-close-regust2', function () {
       var minus = 0,plus = 0;
       if ($(this).parents('tr').find('.reg_flagg select').val()  == -1) {
         minus = $('.finalTotalPrice').text()  -  $(this).parents('tr').find('.fPrice').text()  ;
         $('.finalTotalPrice').text(minus);
       }
       else if ($(this).parents('tr').find('.reg_flagg select').val()  == 1) {
         plus = $('.finalTotalPrice').text()  +  $(this).parents('tr').find('.fprice_1').text()  ;
         $('.finalTotalPrice').text(plus);
       }
       $(this).parents('tr').remove();
     });
     $('#xtreme-table').on('change', '.cat_id_select' , function () {
       var url = "/admin/getServiceDetails";

       var selected = $(this);
       // alert($('#menu_id').val());
       // Start Ajax
       $.ajaxSetup({
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }

       });
       $.ajax({
         url: url,
         dataType: 'json',
         data: {
           cat_id: $(this).find('option:selected').val(),
           flag_req: $(this).parents('tr').find('.reg_flagg option:selected').val(),

         },
         type: 'POST',

         beforeSend: function() {


           selected.parents('tr').find('.qnyNum').attr('disabled',true);
           selected.parents('tr').find('.tax').empty();
           selected.parents('tr').find('.cat_price').empty();
           selected.parents('tr').find('.qnyNum').empty();
           // selected.parents('tr').find('.id_hidden').empty();
           selected.parents('tr').find('.total').empty();
           selected.parents('tr').find('.taxId').empty();
           selected.parents('tr').find('.tax_val').empty();
           // selected.parents('tr').find('.invoice_no').empty();
           // selected.parents('tr').find('.invoice_date').empty();

         },
         success: function(msg) {
           if (msg.data == 'successGetPice') {
             // selected.find('option').val(msg.catId).attr('selected',true);
             selected.parents('tr').find('.tax_val').val(msg.catTax);
             selected.parents('tr').find('.tax').text(msg.catTax);
             selected.parents('tr').find('.cat_price_input').val(msg.catPrice);
             selected.parents('tr').find('.cat_price').text(msg.catPrice);
             selected.parents('tr').find('.qnyNum').attr('disabled',false);
             // selected.parents('tr').find('.id_hidden').val(msg.catId);
             selected.parents('tr').find('.qnyNum').val(1);
             selected.parents('tr').find('.total').text(msg.catPrice * selected.parents('tr').find('.qnyNum').val());
             selected.parents('tr').find('.taxId').val(msg.taxId);
             calcTotal(selected);
             var flag_req = 0

             if (selected.parents('tr').find('.reg_flag_select option:selected').val() == 1) {
                 selected.parents('tr').find('.qnyNum').attr('min',0);
                 selected.parents('tr').find('.qnyNum').val(1);

                 selected.parents('tr').find('.qnyNum').attr('max',msg.flag);
             }
             // flag
           ;
             // selected.parents('tr').find('.invoice_no').val(msg.invoice_date);
             // selected.parents('tr').find('.invoice_date').val(msg.invoice_date);

           }else{
             selected.parents('tr').find('.qnyNum').empty();
             if (lang=='ar'){
                 selected.parents('tr').find('.reg_flag_select').html(
               ` <option value="-1">صرف</option>
                <option value="1">ايداع</option>`
             );
             }
             else{
                 selected.parents('tr').find('.reg_flag_select').html(
               ` <option value="-1">Exchange</option>
                <option value="1">Return</option>`
             );
             }
             

               selected.parents('td').html(
                 `
                 <select name="cat_id[]" form="newRequests" class="cat_id_select form-control" required>
                 <option class="btnTest" style="display:none"></option>
                 </select>
                 `);
                 $.ajaxSetup({
                   headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   }

                 });
                 $.ajax({
               url: url1,
               type: "GET",
               success: function (services){
                 console.log(services);
                 $('select[name="cat_id[]"]').empty();
                   $.each(services, function(key, value) {

                     $('select[name="cat_id[]"]').append('<option value="'+ key +'">'+ value +'</option>');

                     });
               }
               });
               alert('هذا المنتج ليس له سعر');
           }

           }
         });
       return false;

     });
     $('#confirm_Req').on('show.bs.modal', function (event) {
     var button = $(event.relatedTarget) // Button that triggered the modal
     var recipient = button.data('cust') // Extract info from data-* attributes
     var req = button.data('req') // Extract info from data-* attributes
         var payType = button.data('type') // Extract info from data-* attributes
     // console.log()

     // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
     // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
     var modal = $(this)
     modal.find('.modal-body .confirmCustId').val(recipient)
     modal.find('.modal-body .req_id_confrim').val(req)
     modal.find('.modal-body .payType').val(payType)
   });

   var allPrice  = 0;
   var allPrice2  = 0;

   $('#xtreme-table').on('change', '.reg_flagg select' , function () {
     if ($(this).parents('tr').find('.reg_flagg select').val() == -1) {
       var total = $(this).parents('tr').find('.fPrice').addClass('fprice_1') ;
       var total = $(this).parents('tr').find('.fPrice').removeClass('fPrice') ;
         $(this).parents('tr').find('.qnyNum').val(null);
         $(this).parents('tr').find('.cat_id_select').html(
           `
           <option class="btnTest" style="display:none"></option>`);
           $.ajaxSetup({
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }

           });
           $.ajax({
         url: url1,
         type: "GET",
         success: function (services){
           console.log(services);
           $('select[name="cat_id[]"]').empty();
             $.each(services, function(key, value) {

               $('select[name="cat_id[]"]').append('<option value="'+ key +'">'+ value +'</option>');

               });
         }
         });

     }else{
       var total = $(this).parents('tr').find('.fprice_1').addClass('fPrice') ;
       var total = $(this).parents('tr').find('.fprice_1').removeClass('fprice_1') ;
       var url = "/admin/getServiceReturn";
       var selected = $(this);
       // alert($('#menu_id').val());
       // Start Ajax
       $.ajaxSetup({
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
       });
       $.ajax({
         url:  url,
         dataType: 'json',
         data: {
           reg_flag: selected.find('option:selected').val(),
           req_id: $('#request_id_span input').val(),
         },
         type: 'POST',

         beforeSend: function() {
           selected.parents('tr').find('.qnyNum').val(null);
           selected.parents('tr').find('.tax').empty();
           selected.parents('tr').find('.cat_price').empty();
           selected.parents('tr').find('.qnyNum').empty();
           selected.parents('tr').find('.total').empty();
           selected.parents('tr').find('.taxId').empty();
           selected.parents('tr').find('.tax_val').empty();

         },
         success: function(msg) {

           if (msg.returnMsg == 'successGitCats') {
             // console.log(msg.data);
             var data2 = `<option class="btnTest" style="display:none"></option>`;

             for(p in msg.data) {
                data2 += `
                 <option value="`+ msg.data[p][0].id +`" >`+ msg.data[p][0].name +`</option>
                 `;
               selected.parents('tr').find('.cat_id_select').html(data2);
             }
           }

           }
         });
       return false;
     }

     calcTotal($(this));
   });
   $('#xtreme-table').on('change', '.qnyNum' , function () {
     var total = $(this).val() * $(this).parents('tr').find('.cat_price').text() ;
     $(this).parents('tr').find('.total').text(total.toFixed(2));
     calcTotal($(this));
   });
//   document.getElementById('serachExternalReqForm').addEventListener('keypress', function(event) {
//       if (event.keyCode == 13) {
//           $("#serachExternalReqForm").submit()
//       }
// });
$(document).ready(function() {

          $('#close_reguest').on('show.bs.modal', function (event) {
          var button = $(event.relatedTarget) // Button that triggered the modal
          var req = button.data('req') // Extract info from data-* attributes
          var cust_id = button.data('cust') // Extract info from data-* attributes
          var total = button.data('total') // Extract info from data-* attributes
          var emp = button.data('emp') // Extract info from data-* attributes
          var status = button.data('status') // Extract info from data-* attributes
          // console.log()
          if (status == 'yx') {
            $('#bankSelect').hide();
            $('#selectId').attr('disabled',true);
            $('#selectId').attr('name','online_bank');
          }else{
            $('#bankSelect').show();
            $('#selectId').attr('disabled',false);
            $('#selectId').attr('name','bank_id');

          }
          // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
          // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
          var modal = $(this)
          modal.find('.modal-body #req_id_Confirm').val(req)
          modal.find('.modal-body #cust_id').val(cust_id)
          modal.find('.modal-body #total').val(total)
          modal.find('.modal-body #emp').val(emp)
      });
});
$('#due_date').on('change', function (event) {
  var tt = document.getElementById('delivery_date').value;

 var date = new Date(tt);

 var newdate = new Date(date);

 newdate.setDate(newdate.getDate() + parseInt(document.getElementById('due_date').value));

 var dd = newdate.getDate();
 var mm = newdate.getMonth()+1;
 var y = newdate.getFullYear();

 var someFormattedDate = mm + '/' + dd + '/' + y;
 document.getElementById('end_date').value = someFormattedDate;
  document.getElementById('end_date1').value = someFormattedDate;
});
    });
function showmod() {
  var cat_id=[];
  $('select[name="cat_id[]"]').each(function(){
        cat_id.push(this.value);

    });
    var qny=[];
    $('input[name="qny[]"]').each(function(){
          qny.push(this.value);

      });
      var reqFlag=[];
      $('select[name="reqFlag[]"]').each(function(){
            reqFlag.push(this.value);

        });
        var taxId=[];
        $('input[name="taxId[]"]').each(function(){
              taxId.push(this.value);

          });
          var tax_val=[];
          $('input[name="tax_val[]"]').each(function(){
                tax_val.push(this.value);

            });
            var cat_price=[];
            $('input[name="cat_price[]"]').each(function(){
                  cat_price.push(this.value);

              });

    console.log(cat_id);
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });
  $.ajax({
url: "/admin/getpaymentdata",
type: "GET",
data: {
"cust_id": $('input[name="cust_id"]').val(),
"customer_req_head":$('input[name="customer_req_head"]').val(),
"cat_id":cat_id,
"qny":qny,
"reqFlag":reqFlag,
"cat_price":cat_price,
"taxId":taxId,
"tax_val":tax_val,
},
success: function (data){
$('input[name="invoice_no"]').val(data.invoice_no);
$('input[name="invoice_no1"]').val(data.invoice_no);
$('input[name="paid"]').val(data.paid_amount);
$('input[name="paid1"]').val(data.paid_amount);
$('input[name="customer_id"]').val(data.cust_id);
$('input[name="customer_head"]').val(data.customer_head);


$.each(data.payment_method, function(key, value) {
  $('select[name="payment_method"]').append('<option value="'+ key +'">'+ value +'</option>');
  });
$(".modal1").show();


}
});
}

function closemod() {
    $(".modal1").hide();
}
function closemod2() {
    $(".modal2").hide();
}

function pay_method() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });
  $.ajax({
url: "/admin/payServiceamount",
type: "post",
data: {
"cust_id": $('input[name="cust_id"]').val(),
"customer_req_head":$('input[name="customer_req_head"]').val(),
"amount":$('input[name="amount"]').val(),
"payment_method":$('select[name="payment_method"]').val(),
"payment_type":$('select[name="payment_type"]').val(),
"customer_head":$('input[name="customer_head"]').val(),
"customer_id":$('input[name="customer_id"]').val(),
"invoice_no":$('input[name="invoice_no"]').val(),
"total_amount":$('.finalTotalPrice').text()
},
success: function (data){


closemod();
$('.alert_new').empty();

if(lang=="ar"){
    $('.alert_new').append('<a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle">تم الدفع بنجاح</i> </a>');

$('.invoice_button').append('<a href="/admin/invoice_reciet/'+data.customer_head+'" class="btn btn-primary btn-xs"><i class="fa fa-print">الفاتورة</i></a>');
}

else{
    $('.alert_new').append('<a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle">payment has done successfully</i> </a>');
    $('.invoice_button').append('<a href="/admin/invoice_reciet/'+data.customer_head+'" class="btn btn-primary btn-xs"><i class="fa fa-print">Invoice</i></a>');
}
  
}
});

};
function deliver_method() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });
  $.ajax({
url: "/admin/deliverservice",
type: "post",
data: {
"cust_id": $('input[name="cust_id"]').val(),
"customer_req_head":$('input[name="customer_req_head"]').val(),
"customer_head":$('input[name="customer_head3"]').val(),
"customer_id":$('input[name="customer_id3"]').val(),
"invoice_no":$('input[name="invoice_no3"]').val(),
"delivered_name":$('input[name="delivered_name"]').val(),
"total_amount":$('.finalTotalPrice').text()
},
success: function (data){


closemod2();
$('.alert_new').empty();
$('.alert_new').append('<a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle">تم التسليم بنجاح</i> </a>')


}
});

};

function deliver() {
  var cat_id=[];
  $('select[name="cat_id[]"]').each(function(){
        cat_id.push(this.value);

    });
    var qny=[];
    $('input[name="qny[]"]').each(function(){
          qny.push(this.value);

      });
      var reqFlag=[];
      $('select[name="reqFlag[]"]').each(function(){
            reqFlag.push(this.value);

        });
        var taxId=[];
        $('input[name="taxId[]"]').each(function(){
              taxId.push(this.value);

          });
          var tax_val=[];
          $('input[name="tax_val[]"]').each(function(){
                tax_val.push(this.value);

            });
            var cat_price=[];
            $('input[name="cat_price[]"]').each(function(){
                  cat_price.push(this.value);

              });

    console.log(cat_id);
    console.log($('input[name="customer_req_head"]').val());
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });
  $.ajax({
url: "/admin/getdeliverydata",
type: "GET",
data: {
"cust_id": $('input[name="cust_id"]').val(),
"customer_req_head":$('input[name="customer_req_head"]').val(),
"cat_id":cat_id,
"qny":qny,
"reqFlag":reqFlag,
"cat_price":cat_price,
"taxId":taxId,
"tax_val":tax_val,
"total_amount":$('.finalTotalPrice').text()
},
success: function (data){
if(data.msg!='notpaid'){
$('input[name="invoice_no3"]').val(data.invoice_no);
$('input[name="invoice_no4"]').val(data.invoice_no);
$('input[name="customer_id3"]').val(data.cust_id);
$('input[name="customer_head3"]').val(data.customer_head);
$(".modal2").show();
}

else {
    $('.alert_new').empty();
$('.alert_new').append('<a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle">لايمكن التسليم قبل دفع المبلغ كاملا </i> </a>')
}


}
});
}

function showpaymodal(id) {

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });
  $.ajax({
url: "/admin/getreportpaymentdata",
type: "GET",
data: {

"customer_req_head":id,

},
success: function (data){
$('input[name="invoice_no"]').val(data.invoice_no);
$('input[name="invoice_no1"]').val(data.invoice_no);
$('input[name="paid"]').val(data.paid_amount);
$('input[name="paid1"]').val(data.paid_amount);
$('input[name="customer_id"]').val(data.cust_id);
$('input[name="customer_head"]').val(data.customer_head);


$.each(data.payment_method, function(key, value) {
  $('select[name="payment_method"]').append('<option value="'+ key +'">'+ value +'</option>');
  });
$(".modal1").show();


}
});
}
function pay_methodreport() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });
  $.ajax({
url: "/admin/payreportServiceamount",
type: "post",
data: {
"cust_id": $('input[name="cust_id"]').val(),
"customer_req_head":$('input[name="customer_req_head"]').val(),
"amount":$('input[name="amount"]').val(),
"payment_method":$('select[name="payment_method"]').val(),
"payment_type":$('select[name="payment_type"]').val(),
"customer_head":$('input[name="customer_head"]').val(),
"customer_id":$('input[name="customer_id"]').val(),
"invoice_no":$('input[name="invoice_no"]').val(),
"total_amount":$('.finalTotalPrice').text()
},
success: function (data){


$(".modal1").hide();
$('.alert_new').empty();
$('.alert_new').append('<a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle">تم الدفع بنجاح</i> </a>')


}
});

};
function showdelivermodal(id) {

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });
  $.ajax({
url: "/admin/getreportdeliverydata",
type: "GET",
data: {

"customer_req_head":id,

},
success: function (data){
if(data.msg!='notpaid'){
$('input[name="invoice_no3"]').val(data.invoice_no);
$('input[name="invoice_no3"]').val(data.invoice_no);
$('input[name="customer_id3"]').val(data.cust_id);
$('input[name="customer_head3"]').val(data.customer_head);
$(".modal2").show();
}

else {
    $('.alert_new').empty();
$('.alert_new').append('<a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle">لايمكن التسليم قبل دفع المبلغ كاملا </i> </a>')
}


}
});
}
function deliver_method() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }

  });
  $.ajax({
url: "/admin/deliverreportservice",
type: "post",
data: {
"cust_id": $('input[name="cust_id"]').val(),
"customer_req_head":$('input[name="customer_req_head"]').val(),
"customer_head":$('input[name="customer_head3"]').val(),
"customer_id":$('input[name="customer_id3"]').val(),
"invoice_no":$('input[name="invoice_no3"]').val(),
"delivered_name":$('input[name="delivered_name"]').val(),
"total_amount":$('.finalTotalPrice').text()
},
success: function (data){


closemod2();
$('.alert_new').empty();
$('.alert_new').append('<a href="#" onclick="close_alert()" class="close_alert"> <i class="fas fa-times-circle">تم التسليم بنجاح</i> </a>')


}
});

};
  $('.gateway-row .ActiveButton').on('click', function(e) {

                accordion_switch = $(this).parents('.gateway-row').find('a.accordion-switch');
                accordion_switch.removeClass('Collapse');
                accordion_switch.addClass('Expand');
                accordion_switch.html('&#8211;');

                $(this).parents('.gateways-list').find('.DetailsBlock').show();
                e.stopPropagation();
            });
              $('.gateway-row .Default').on('click', function(e) {
                $(this).parents('.gateway-row').find('.ActiveButton').click();
                $(this).parents('.gateway-row').find('.ActiveButton input').prop('checked', true);

                e.stopPropagation();
            });
              $('.gateway-row .InActiveButton').on('click', function(e) {
                if ($(this).parents('.gateway-row').find('.Default input').is(":checked")) {
                    return false;
                }
                accordion_switch = $(this).parents('.gateway-row').find('a.accordion-switch');
                accordion_switch.removeClass('Expand');
                accordion_switch.addClass('Collapse');
                accordion_switch.html('+');

                $(this).parents('.gateways-list').find('.DetailsBlock').hide();
                e.stopPropagation();
            });
            $('.rounded-item').on('click', function() {
                $(this).find('a.accordion-switch').click();
            });
              $('.gateway-row a.accordion-switch').on('click', function() {
                if ($(this).hasClass('Expand')) {
                    $(this).removeClass('Expand');
                    $(this).addClass('Collapse');
                    $(this).html('+');
                    $(this).parents('.gateways-list').find('.DetailsBlock').hide();
                } else if ($(this).hasClass('Collapse')) {
                    $(this).removeClass('Collapse');
                    $(this).addClass('Expand');
                    $(this).html('&#8211;');
                    $(this).parents('.gateways-list').find('.DetailsBlock').show();
                }
                return false;
            });
              $('.is-default').change(function() {
                if (this.checked) {
                    var id = this.id;
                    $('.is-default:not(#' + id + ')').attr('checked', false);
                }
            });
                function confirm_reservation(id){
    $.get("/admin/reservations/" + id + "/confirm" , function (data) {
        if(data.msg=='missed'){
            if(lang=='ar'){
                $('#message').append('<div class="alert alert-danger">لايمكنك تاكيد الحجز لانه تعدي وقت الحجز</div>');
            }
            else{
                $('#message').append('<div class="alert alert-danger">you cant confirm the reservation because time is over</div>');
            }
        }
            else if(data.msg=='nopermisson'){
                if(lang=='ar'){
                $('#message').append('<div class="alert alert-danger">لا تملك الصلاحية للتاكيد</div>');
            }
            else{
                $('#message').append('<div class="alert alert-danger">you dont have permission</div>');
            }
            }
            else if(data.msg=='pre_confirmed'){
                 if(lang=='ar'){
                $('#message').append('<div class="alert alert-danger">لايمكنك تاكيد الحجز لانه محجوز بالفعل في نفس الوقت</div>');
            }
            else{
                $('#message').append('<div class="alert alert-danger">you cant confirm the reservation because it is already reserved at the same time</div>');
            }
            }
            else{
                 if(lang=='ar'){
                $('#message').append('<div class="alert alert-success">تم تاكيد الحجز</div>');  
                location.reload();
            }
            
            else{
                
                $('#message').append('<div class="alert alert-success">Reservation is confirmed</div>');
                location.reload();
            }
            
            
        }
      
    });
  }
  
  function calcResrvationtotal(thisBtn) {
  var total = 0,reg_1 = 0,reg = 0;
  var total1 = $('input[name="total_amount1"]').val();


    $(".fprice_1 span").each(function() {

                if(Number.isNaN(parseFloat($(this).text()))){

                }
                else{
                  reg_1 += parseFloat($(this).text());
                }




    });
    $(".fprice_2 span").each(function() {
            
                if(Number.isNaN(parseFloat($(this).text()))){

                }
                else{
                  reg_1 += parseFloat($(this).text());
                }




    });

    total=parseFloat(total1)+reg_1;
    $('input[name="total_amount"]').val(total.toFixed(2));


}

function check_availability(){

  var book_id=$('input[name="change_date_book_id"]').val();
  var from_date=$('input[name="date_from"]').val();
  var to_date=$('input[name="date_to"]').val();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: '/admin/check_new_date',
    dataType: 'json',
    data:{
      id: book_id,
      from_date: from_date,
      to_date:to_date
    },
    type: 'POST',
    success: function(data) {
      if(data.data=="not_available"){
        $('#old_date_from').text(data.old_date_from);
        $('#old_date_to').text(data.old_date_to);
        $('#old_price').text(data.old_price);
        $('#new_date_from').text(data.new_date_from);
        $('#new_date_to').text(data.new_date_to);
        $('#new_price').text(data.new_price);


          close_change_date_modal();
          var modal2 = document.getElementById('DatesNotAvailableModal');
          modal2.style.display = "block";
      }
      else if(data.data=="cancel_policy"){
        var modal2 = document.getElementById('ChangeDatesModal2');
        modal2.style.display = "none";
        var modal2 = document.getElementById('DatesCancelPolicy');
        modal2.style.display = "block";
      }
      else{
        $('#available_old_date_from').text(data.old_date_from);
        $('#available_old_date_to').text(data.old_date_to);
        $('#available_old_price').text(data.old_price);
        $('#available_new_date_from').text(data.new_date_from);
        $('#available_new_date_to').text(data.new_date_to);
        $('#available_new_price').text(data.new_price);
        $('input[name="available_book_id"]').val(data.book_id);
        $('input[name="available_new_date_from"]').val(data.date_from);
        $('input[name="available_new_date_to"]').val(data.date_to);
        $('input[name="available_new_price"]').val(data.new_price);
        $('input[name="available_nights"]').val(data.new_nights);


        close_change_date_modal();
        var modal2 = document.getElementById('DatesAvailableModal');
        modal2.style.display = "block";
       }
     }
    });

}

function submit_change_date(){
  var book_id=$('input[name="available_book_id"]').val();
  var from_date=$('input[name="available_new_date_from"]').val();
  var to_date=$('input[name="available_new_date_to"]').val();
  var price=$('input[name="available_new_price"]').val();
    var nights=$('input[name="available_nights"]').val();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: '/admin/change_booking_date',
    dataType: 'json',
    data:{
      id: book_id,
      from_date: from_date,
      to_date:to_date,
      price:price,
      nights:nights
    },
    type: 'POST',
    success: function(data) {
      var modal2 = document.getElementById('DatesAvailableModal');
      modal2.style.display = "none";
      var modal2 = document.getElementById('DatesChangedModal');
      modal2.style.display = "block";
     }
    });

}


function  edit_dates_modal(nights,id){

            reservation_date=new Date();
        $(".datepicker_reservation_change").datepicker({

          date:reservation_date,
            startDate:reservation_date,
            rtl: true,
            viewMode: 'years',
            format: 'yyyy-mm-dd',
          }).on('changeDate', function(e) {
            var date2 = $('.datepicker_reservation_change').datepicker('getDate', '+1d');
             date2.setDate(date2.getDate()+nights);

             var msecsInADay = 8640000;
             var endDate = new Date( date2.getTime() + msecsInADay);
             $('.datepicker_reservation2_change').datepicker('setStartDate',endDate);
           $('.datepicker_reservation2_change').datepicker('setDate',endDate);
             });
             $('.datepicker_reservation2_change').datepicker({

                format: 'yyyy-mm-dd',
             });

$('input[name="change_date_book_id"]').val(id);
  var modal2 = document.getElementById('ChangeDatesModal2');
  modal2.style.display = "block";

 }
 function close_change_date_modal(){
   var modal2 = document.getElementById('ChangeDatesModal2');
   modal2.style.display = "none";
 }
   function close_dates_not_available(){
     var modal2 = document.getElementById('DatesNotAvailableModal');
     modal2.style.display = "none";
   }

   function try_new_dates(){

     var modal2 = document.getElementById('DatesNotAvailableModal');
     modal2.style.display = "none";
     var modal2 = document.getElementById('DatesAvailableModal');
     modal2.style.display = "none";
     var modal2 = document.getElementById('ChangeDatesModal2');
     modal2.style.display = "block";
   }

   function close_dates_available(){
     var modal2 = document.getElementById('DatesAvailableModal');
     modal2.style.display = "none";
   }

function dates_changed_successfully(){
var modal2 = document.getElementById('DatesChangedModal');
modal2.style.display = "none";
}

function dates_cancel_policy(){
var modal2 = document.getElementById('DatesCancelPolicy');
modal2.style.display = "none";
}

function add_rooms_modal(book_id){
$('input[name="add_room_book_id"]').val(book_id);
var modal2 = document.getElementById('AddRoomForm');
modal2.style.display = "block";
}
function close_add_room_form(){
var modal2 = document.getElementById('AddRoomForm');
modal2.style.display = "none";
}

function get_rooms_to_add(){
var book_id=$('input[name="add_room_book_id"]').val();
var people=$('input[name="guests"]').val();
$.ajaxSetup({
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});

$.ajax({
  url: '/admin/get_available_rooms',
  dataType: 'json',
  data:{
    id: book_id,
    people:people
  },
  type: 'POST',
  success: function(data) {
    if(data.data=="no_rooms"){
      var modal2 = document.getElementById('AddRoomForm');
      modal2.style.display = "none";
      var modal2 = document.getElementById('NoRoomAvailable');
      modal2.style.display = "block";
    }
    else{
var rooms_available='';
$("#xtreme-table2 tbody").empty();
console.log(data);
       $.each(data.rooms, function (key) {

         $.each(data.rooms[key].meal_plans,function(key2){

           rooms_available+='<tr>';
           rooms_available+='<td>'+data.rooms[key].meal_plans[key2].room_name+'</td>';
           rooms_available+='<td>'+data.rooms[key].meal_plans[key2].name+'</td>';
           rooms_available+='<td>'+data.rooms[key].meal_plans[key2].price+'</td>';
           rooms_available+='<td>'+data.rooms[key].meal_plans[key2].total_price+'</td>';
           if(lang=='ar'){
             rooms_available+='<td><button type="button" class="btn btn-primary" onclick="select_room_to_booking('+data.rooms[key].meal_plans[key2].cat_id+','+data.rooms[key].meal_plans[key2].catsub_id+','+data.rooms[key].meal_plans[key2].price+','+data.rooms[key].meal_plans[key2].tax_id+','+data.rooms[key].meal_plans[key2].tax_val+','+data.rooms[key].meal_plans[key2].total_price+')">اختر</button></td>';
           }
           else{
             rooms_available+='<td><button type="button" class="btn btn-primary" onclick="select_room_to_booking('+data.rooms[key].meal_plans[key2].cat_id+','+data.rooms[key].meal_plans[key2].catsub_id+','+data.rooms[key].meal_plans[key2].price+','+data.rooms[key].meal_plans[key2].tax_id+','+data.rooms[key].meal_plans[key2].tax_val+','+data.rooms[key].meal_plans[key2].total_price+')">select</button></td>';
           }



           rooms_available+='</tr>';



         });
       });
   $('input[name="select_room_book_id"]').val(book_id);
  $("#xtreme-table2 tbody").append(rooms_available);


      var modal2 = document.getElementById('AddRoomForm');
      modal2.style.display = "none";
      var modal2 = document.getElementById('SelectRoomAvailable');
      modal2.style.display = "block";
     }
   }
  });
}

function close_no_room_available(){
var modal2 = document.getElementById('NoRoomAvailable');
modal2.style.display = "none";
}

function close_select_room_available(){
var modal2 = document.getElementById('SelectRoomAvailable');
modal2.style.display = "none";
}

function select_room_to_booking(cat_id,catsub_id,price,tax_id,tax_val,total_price){

var book_id=$('input[name="select_room_book_id"]').val();
$('input[name="confirm_book_id"]').val(book_id);
$('input[name="confirm_cat_id"]').val(cat_id);
$('input[name="confirm_catsub_id"]').val(catsub_id);
$('input[name="confirm_price"]').val(price);
$('input[name="confirm_tax_id"]').val(tax_id);
$('input[name="confirm_tax_val"]').val(tax_val);
$('input[name="confirm_total_price"]').val(total_price);
$('#confirm_current_reservation').text(total_price-price);
$('#confirm_additional_room').text(price);
$('#confirm_additional_room').text(price);
$('#confirm_total_room').text(total_price);
close_select_room_available();
var modal2 = document.getElementById('SelectRoomConfirmation');
modal2.style.display = "block";




}

function close_room_confirmation(){
  var modal2 = document.getElementById('SelectRoomConfirmation');
  modal2.style.display = "none";
}
function confirmation_return_back(){
  close_room_confirmation();
  var modal2 = document.getElementById('SelectRoomAvailable');
  modal2.style.display = "block";

}

function confirm_add_room(){

  var book_id = $('input[name="confirm_book_id"]').val();
  var cat_id  = $('input[name="confirm_cat_id"]').val();
  var catsub_id= $('input[name="confirm_catsub_id"]').val();
  var price = $('input[name="confirm_price"]').val();
  var tax_id =$('input[name="confirm_tax_id"]').val();
  var tax_val =  $('input[name="confirm_tax_val"]').val();
  var total_price = $('input[name="confirm_total_price"]').val();

  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: '/admin/add_room',
    dataType: 'json',
    data:{
      id: book_id,
      cat_id:cat_id,
      catsub_id:catsub_id,
      price:price,
      tax_id:tax_id,
      tax_val:tax_val,
      total_price:total_price
    },
    type: 'POST',
    success: function(data) {
       close_room_confirmation();
       location.reload();
     }
    });
}

function cancel_rooms_modal(book_id){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: '/admin/get_booked_rooms',
    dataType: 'json',
    data:{
      id: book_id,
    },
    type: 'POST',
    success: function(data) {


  var booked_rooms='';
  $("#xtreme-table2 tbody").empty();
  console.log(data);
         $.each(data.rooms, function (key) {

             booked_rooms+='<tr>';
             booked_rooms+='<td>'+data.rooms[key].name+'</td>';
             booked_rooms+='<td>'+data.rooms[key].meal_plan+'</td>';
             booked_rooms+='<td>'+data.rooms[key].tax_val+'</td>';
             booked_rooms+='<td>'+data.rooms[key].cat_final_price+'</td>';
             booked_rooms+='<td>'+data.rooms[key].policy+'</td>';
             if(lang=='ar'){
               booked_rooms+='<td><button type="button" class="btn btn-danger" onclick="cancel_room('+data.rooms[key].cat_id+','+data.rooms[key].catsub_id+','+data.rooms[key].charge+')">الغاء</button></td>';
             }
             else{
               booked_rooms+='<td><button type="button" class="btn btn-primary" onclick="cancel_room('+data.rooms[key].cat_id+','+data.rooms[key].catsub_id+','+data.rooms[key].charge+')">cancel</button></td>';
             }



             booked_rooms+='</tr>';



         });
     $('input[name="cancel_room_book_id"]').val(book_id);
     $("#xtreme-table3 tbody").append(booked_rooms);

        var modal2 = document.getElementById('CancelRoomSelect');
        modal2.style.display = "block";

     }
    });
}
function close_cancel_room(){
  var modal2 = document.getElementById('CancelRoomSelect');
  modal2.style.display = "none";
}

function cancel_room(cat_id,catsub_id,charge){

  var book_id=$('input[name="cancel_room_book_id"]').val();

  if(charge==0){
    if(lang=="ar"){
      $('#charge_hint').text('رسوم الالغاء لهذة الغرفة مجانا');
    }
    else{
      $('#charge_hint').text('this room is free of cancel charge');
    }

  }
  else{
    if(lang=="ar"){
      $('#charge_hint').text('رسوم الالغاء لهذة الغرفة'+charge);
    }
    else{
      $('#charge_hint').text('this room cancel charge is'+charge);
    }
  }
  $('input[name="confirm_cancel_room_book_id"]').val(book_id);
  $('input[name="confirm_cancel_room_cat_id"]').val(cat_id);
  $('input[name="confirm_cancel_room_catsub_id"]').val(catsub_id);
  $('input[name="confirm_cancel_room_charge"]').val(charge);


  close_cancel_room();
  var modal2 = document.getElementById('ConfirmCancelRoom');
  modal2.style.display = "block";

}

function confirm_cancel_room(){
  var book_id=$('input[name="confirm_cancel_room_book_id"]').val();
  var cat_id=$('input[name="confirm_cancel_room_cat_id"]').val();
  var catsub_id=$('input[name="confirm_cancel_room_catsub_id"]').val();
  var charge=$('input[name="confirm_cancel_room_charge"]').val();
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: '/admin/cancel_room',
    dataType: 'json',
    data:{
      id: book_id,
      cat_id:cat_id,
      catsub_id:catsub_id,
      charge:charge

    },
    type: 'POST',
    success: function(data) {
    close_cancel_room();
    location.reload();

     }
    });

}
function modal_show(id){
  console.log($('#modal_button').data());
  $('input[name="location_id"]').val($('#modal_button'+id).data('id'));
  $('input[name="name"]').val($('#modal_button'+id).data('name'));
  $('input[name="name_en"]').val($('#modal_button'+id).data('name_en'));

  $('input[name="description"]').val($('#modal_button'+id).data('description'));
  $('input[name="longitude"]').val($('#modal_button'+id).data('longitude'));
  $('input[name="latitude"]').val($('#modal_button'+id).data('latitude'));
  $('select[name="destination_id"]').val($('#modal_button'+id).data('destination_id'));
  $('select[name="active"]').val($('#modal_button'+id).data('active'));
 }










function add_ages(){

  var child_no=$('#child_no').val();
  $('#child_ages').empty();
  $('#child_ages2').empty();
  for(var i=0;i<child_no;i++){

    $('#child_ages').append('<select style="width:70px;" class="form-control" name="child_age[]"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option><option value="11">11</option><option value="12">12</option></select>');

  }

}

function reserve_room(){
    
$('#no_rooms').empty();
$('#total_price').empty();
$('#validation_error').empty();
$('tr>td:nth-child(4)').css("background-color", "white");
  var total=0;
  var cat_ids=[];
  var tax_ids=[];
  var tax_vals=[];
  var sub_ids=[];
  var child_ages=[];
  var total_price=0;
  var numbers=[];
  var prices=[];
  $('select[name="rooms_number[]"]').each(function(){

        total+=parseInt(this.value, 10);

        if(this.value!=0){
          total_price+=parseInt($(this).data('price'))*(this.value);
          cat_ids.push($(this).data('id'));
          tax_ids.push($(this).data('tax_id'));
          tax_vals.push($(this).data('tax_val'));
          numbers.push(this.value);
          sub_ids.push($(this).data('cat_sub_id'));
          prices.push($(this).data('price'));



        }

        });


        if(total==0){
          $('tr>td:nth-child(4)').css("background-color", "red");
          
          if(lang=="ar"){
              $('#validation_error').append('<p>لابد ان تختار واحدة علي الاقل</p>');
          }
          else{
              $('#validation_error').append('<p>you must select one at least</p>');
          }
        }
        else{

          
          if(lang=="ar"){
               $('#total_price').append('<p>السعر الاجمالي'+total_price+'</p>');
              
              $('#no_rooms').append('<p>عدد الغرف'+total+'</p>');
          }
          else{
              $('#no_rooms').append('<p>No of Rooms'+total+'</p>');
             $('#total_price').append('<p>Total price'+total_price+'</p>');
          }
          

          $('input[name="cat_id[]"]').val(cat_ids);
          $('input[name="tax_ids[]"]').val(tax_ids);
          $('input[name="sub_ids[]"]').val(sub_ids);
          $('input[name="tax_vals[]"]').val(tax_vals);
          $('input[name="total_value"]').val(total_price);
          $('input[name="numbers[]"]').val(numbers);
          $('input[name="prices[]"]').val(prices);
          $('select[name="child_age[]"]').each(function(){
            console.log($(this).val());
            child_ages.push($(this).val());

          });

          $('input[name="child_ages1[]"]').val($('select[name="child_age[]"]').val());
          $('input[name="child_ages1[]"]').val(child_ages);


          var modal2 = document.getElementById('Modal2');
          modal2.style.display = "block";
        }
}

function close_modal2(){
  var modal2 = document.getElementById('Modal2');
  modal2.style.display = "none";
}

function check_no_rooms(){

}

function choose_hotel(id){
$('input[name="hotel_id"]').val(id);
$('#search_form').submit();


}

function confirmation__cancel_room_return_back(){
  var modal2 = document.getElementById('ConfirmCancelRoom');
  modal2.style.display = "none";
  var modal2 = document.getElementById('CancelRoomSelect');
  modal2.style.display = "block";

}

function close_confirm_cancel_room(){
  var modal2 = document.getElementById('ConfirmCancelRoom');
  modal2.style.display = "none";
}

function payandconfirm(id){
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: '/admin/get_invoice_for_booking',
    dataType: 'json',
    data:{
        book_id:id

    },
    type: 'POST',
    success: function(data) {
            $('input[name="invoice_no1"]').val(data.invoice_no);
            $('input[name="invoice_no"]').val(data.invoice_no);
            $('input[name="pay_book_id"]').val(id);
            $('input[name="invoice_code"]').val(data.invoice_code);
            $('input[name="amount"]').val(data.amount_value);


     }
    });

  var modal2 = document.getElementById('PayandConfirm');
  modal2.style.display = "block";
}
function close_pay_and_confirm(){
  var modal2 = document.getElementById('PayandConfirm');
  modal2.style.display = "none";
}
function booking_confirmed(status){
  $('#booking_alerts').empty();
  if(status==1){
    if (lang=='ar'){
      $('#booking_alerts').append('<div class="alert alert-success" style="background:green !important;color:#fff !important">لقد تم تاكيد الحجز بنجاح</div>')
    }
    else{
      $('#booking_alerts').append('<div class="alert alert-success" style="background:green !important;color:#fff !important">booking has been confirmed</div>')
    }
  }
  else{
    if (lang=='ar'){
      $('#booking_alerts').append('<div class="alert alert-danger" style="background:red!important;color:#fff !important">يبدو ان احد الغرف محجوزة مسبقا</div>')
    }
    else{
      $('#booking_alerts').append('<div class="alert alert-danger" style="background:red !important;color:#fff !important">it seems that aroom previously confirmed</div>')
    }
  }

  location.reload();

}



function pay_confirm_booking(){
  var book_id=$('input[name="pay_book_id"]').val();
  var invoice_no=$('input[name="invoice_no"]').val();
  var invoice_code=$('input[name="invoice_code"]').val();
  var pay_method=$('select[name="payment_method"]').val();
  var amount=$('input[name="amount"]').val();


  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $.ajax({
    url: '/admin/pay_confirm_booking',
    dataType: 'json',
    data:{
        book_id:book_id,
        invoice_no:invoice_no,
        invoice_code:invoice_code,
        pay_method:pay_method,
        amount:amount

    },
    type: 'POST',
    success: function(data) {
          if(data.data=="succeede"){

setTimeout(booking_confirmed(1), 200000);

          }
          else{
            setTimeout(booking_confirmed(2), 200000);

          }



     }
    });
}




            
