var lang = $('meta[name="lang"]').attr('content');

var auth= $('meta[name="auth"]').attr('content');
$(document).ready(function(){

 $('#myTab a').click(function(e) {
              e.preventDefault();
              $(this).tab('show');
});

// store the currently selected tab in the hash value
      $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
             var id = $(e.target).attr("href").substr(1);
             window.location.hash = id;
});

// on load of the page: switch to the currently selected tab
var hash = window.location.hash;
$('#myTab a[href="' + hash + '"]').tab('show');

    $('.clear-cart').click();
  var input = document.querySelector("#phone_number");
  window.intlTelInput(input);
  $('#serach').keyup(function(){
         var query = $(this).val();
         if(query != '')
         {
          var _token = $('input[name="_token"]').val();
          $.ajax({
           url:"{{ route('autocomplete.fetch') }}",
           method:"POST",
           data:{query:query, _token:_token},
           success:function(data){
            $('#categorysList').fadeIn();
             $('#categorysList').html(data);
           }
          });
         }
     });

     $(document).on('click', 'li', function(){
         $('#serach').val($(this).text());

         $('#categorysList').fadeOut();
     });




 var x = document.getElementById("demo");
 function getLocation() {
   if (navigator.geolocation) {
     navigator.geolocation.getCurrentPosition(showPosition);
   } else {
     console.log('Geolocation is not supported by this browser');
   }
 }

 function showPosition(position) {
   console.log(position.coords);
 }

 function scrollup() {
     window.scrollTo(100, document.body.scrollHeight);
 };

 function scrolldowncheck() {
     window.scrollTo(100, document.body.scrollHeight);
 }
 if(lang=="ar"){
 $("#registerForm").validate({
     errorClass: "has-error",
     validClass: "has-success",
     rules: {

         "name": {
             required: true,
             maxlength: 255
         },

         "email": {
             required: true,
             email: true,
             remote: {
                 url: "checkCustomer",
                 type: "get",
                 data: {
                     "email": function() {
                         return $("#email").val();
                 }
               },
                 beforeSend: function() {
                     $('#subok').hide();
                     $('#subcancel').hide();
                     $('#subdomain_loading').show();
                 }, complete: function(response) {

                     if ($("#email").hasClass('has-success')) {

                         $('#email_error').html('');
                     }

                 }
             }
           },
         "phone_number": {
             required: true,
             number: true,
             remote: {
                 url: "checkCustomer",
                 type: "get",
                 data: {
                     "phone_number": function() {
                         return $("#phone_number").val();
                 }
               },
                 beforeSend: function() {
                     $('#subok').hide();
                     $('#subcancel').hide();
                     $('#subdomain_loading').show();
                 }, complete: function(response) {



                                                     if ($("#phone_number").hasClass('has-success')) {

                                                     $('#error-msg').empty();
                                                     $('#phoneok').show();
                                                     $('#phonecancel').hide();
                                                     $('#phone_error').html('');

                                                     } else {


                                                       }



                 }
             }
           },

         "password": {
             required: true,
             minlength: 6
         },
         "confirm_passowrd": {
             required: true,
             equalTo: "#password"
         }
     },

     messages: {


         "name": {
             required:"الاسم مطلوب",
             maxlength : "الاسم كبير"
         },
         "address": {
             required:"العنوان مطلوب",
             maxlength : "العنوان كبير"
         },
         "phone_number": {
             required:"التليفون مطلوب",
             remote:"{{admin('strings.valid_phone')}}"

         },
         "email":{
         required  : "البريد الا لكترونى مطلوب",
         remote:"هذا الاميل موجود بالفعل"
       },

         "password": {
             required :"كلمة السر مطلوبة",
             minlength : "كلمة السر كبيرة"
         },
         "confirm_passowrd": "تاكيد كلمة السر مطلوبة",


     }, errorPlacement: function(error, element) {
          if (element.attr('id') == 'email') {
             $('#email_error').html('<div class="error-message">' + error.html() + '</div>');
             error.remove();
         }
          else if (element.attr('id') == 'name') {
           $('#name_error').html('<div class="error-message">' + error.html() + '</div>');
                 error.remove();
         } else if (element.attr('id') == 'password') {
             $('#password_error').html('<div class="error-message">' + error.html() + '</div>');
             error.remove();
         } else if (element.attr('id') == 'confirm_passowrd') {
             $('#passwd_error').html('<div class="error-message">' + error.html() + '</div>');
             error.remove();
         }else if (element.attr('id') == 'phone_number') {
             $('#phone_number_error').html('<div class="error-message">' + error.html() + '</div>');
             error.remove();
         } else if (element.attr('id') == 'address') {
             $('#address_error').html('<div class="error-message">' + error.html() + '</div>');
             error.remove();
         }
         else {
            element.next().remove();
            error.insertAfter("#" + element.attr('id'));
        }





     }, success: function(label, element) {
         label.addClass("has-success");
         var myid = label.attr('for');

         if (myid == 'name') {

             $('#name_error').html('');

         } else if (myid == 'email') {

             $('#email_error').html('');

         }else if (myid == 'password') {

             $('#password_error').html('');

         }else if (myid == 'confirm_passowrd') {

             $('#passwd_error').html('');

         }else if (myid == 'phone_number') {

             $('#phone_number_error').html('');

         }else if (myid == 'address') {

             $('#address_error').html('');

         }

     }
 });
}
else{
    $("#registerForm").validate({
     errorClass: "has-error",
     validClass: "has-success",
     rules: {

         "name": {
             required: true,
             maxlength: 255
         },

         "email": {
             required: true,
             email: true,
             remote: {
                 url: "checkCustomer",
                 type: "get",
                 data: {
                     "email": function() {
                         return $("#email").val();
                 }
               },
                 beforeSend: function() {
                     $('#subok').hide();
                     $('#subcancel').hide();
                     $('#subdomain_loading').show();
                 }, complete: function(response) {

                     if ($("#email").hasClass('has-success')) {

                         $('#email_error').html('');
                     }

                 }
             }
           },
         "phone_number": {
             required: true,
             number: true,
             remote: {
                 url: "checkCustomer",
                 type: "get",
                 data: {
                     "phone_number": function() {
                         return $("#phone_number").val();
                 }
               },
                 beforeSend: function() {
                     $('#subok').hide();
                     $('#subcancel').hide();
                     $('#subdomain_loading').show();
                 }, complete: function(response) {



                                                     if ($("#phone_number").hasClass('has-success')) {

                                                     $('#error-msg').empty();
                                                     $('#phoneok').show();
                                                     $('#phonecancel').hide();
                                                     $('#phone_error').html('');

                                                     } else {


                                                       }



                 }
             }
           },

         "password": {
             required: true,
             minlength: 6
         },
         "confirm_passowrd": {
             required: true,
             equalTo: "#password"
         }
     },

     messages: {


         "name": {
             required:"required name",
             maxlength : "maximum name"
         },
         "address": {
             required:"required address",
             maxlength : "maximum address"
         },
         "phone_number": {
             required:"required phone numer",
             remote:"admin('strings.valid_phone')"

         },
         "email":{
         required  : "required email",
         remote:"email already exits"
       },

         "password": {
             required :"required password",
             minlength : "minimum password "
         },
         "confirm_passowrd": "password don't matches",


     }, errorPlacement: function(error, element) {
          if (element.attr('id') == 'email') {
             $('#email_error').html('<div class="error-message">' + error.html() + '</div>');
             error.remove();
         }
          else if (element.attr('id') == 'name') {
           $('#name_error').html('<div class="error-message">' + error.html() + '</div>');
                 error.remove();
         } else if (element.attr('id') == 'password') {
             $('#password_error').html('<div class="error-message">' + error.html() + '</div>');
             error.remove();
         } else if (element.attr('id') == 'confirm_passowrd') {
             $('#passwd_error').html('<div class="error-message">' + error.html() + '</div>');
             error.remove();
         }else if (element.attr('id') == 'phone_number') {
             $('#phone_number_error').html('<div class="error-message">' + error.html() + '</div>');
             error.remove();
         } else if (element.attr('id') == 'address') {
             $('#address_error').html('<div class="error-message">' + error.html() + '</div>');
             error.remove();
         }
         else {
            element.next().remove();
            error.insertAfter("#" + element.attr('id'));
        }





     }, success: function(label, element) {
         label.addClass("has-success");
         var myid = label.attr('for');

         if (myid == 'name') {

             $('#name_error').html('');

         } else if (myid == 'email') {

             $('#email_error').html('');

         }else if (myid == 'password') {

             $('#password_error').html('');

         }else if (myid == 'confirm_passowrd') {

             $('#passwd_error').html('');

         }else if (myid == 'phone_number') {

             $('#phone_number_error').html('');

         }else if (myid == 'address') {

             $('#address_error').html('');

         }

     }
 });
}
 var input = document.querySelector("#phone_number"),
     errorMsg = document.querySelector("#error-msg"),
     validMsg = document.querySelector("#valid-msg");

 // here, the index maps to the error code returned from getValidationError - see readme
 var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];

 // initialise plugin
 var iti = window.intlTelInput(input, {
     initialCountry: "auto",
     geoIpLookup: function (callback) {
         $.get('https://ipinfo.io', function () {
         }, "jsonp").always(function (resp) {
             var countryCode = (resp && resp.country) ? resp.country : "";
             callback(countryCode);
         });
     },
     utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.0/js/utils.js"
 });

 var reset = function () {
     input.classList.remove("error");

     errorMsg.innerHTML = "";
     $('#valid-msg').empty();


 };

 // on blur: validate
 input.addEventListener('blur', function () {
     reset();
     if (input.value.trim()) {
         if (iti.isValidNumber()) {
             validMsg.classList.remove("hide");
         } else {
             input.classList.add("error");
             var errorCode = iti.getValidationError();
             errorMsg.innerHTML = errorMap[errorCode];
             errorMsg.classList.remove("hide");
         }
     }
 });

 // on keyup / change flag: reset
 input.addEventListener('change', reset);
 input.addEventListener('keyup', reset);

 $("#changpasswordForm").validate({
 		errorClass: "has-error",
 		validClass: "has-success",
 		rules: {

 				"old_password": {
 						required: true,
 						remote: {
 								url: "passwordCheck",
 								type: "get",
 								data: {
 										"old_password": function() {
 												return $("#old_password").val();
 								}
 							},
 								beforeSend: function() {
 										$('#subok').hide();
 										$('#subcancel').hide();
 										$('#subdomain_loading').show();
 								}, complete: function(response) {

 										if ($("#old_password").hasClass('has-success')) {

 												$('#old_password_error').html('');
 										}

 								}
 						}
 					},
 				"password_new": {
 						required: true,
 						minlength: 6
 				},
 				"confirmed_password": {
 						required: true,
 						equalTo: "#confirmed_password"
 				}
 		},

 		messages: {

 				"old_password":{
 				required  : "{{trans('strings.password_required')}}",
 				remote:"{{trans('strings.old_password_validate')}}"
 			},

 				"password_new": {
 						required :"{{trans('strings.password_required')}}",
 						minlength : "{{trans('strings.password_minlength')}}"
 				},
 				"confirmed_password": "{{trans('strings.password_confirmation_validation')}}",


 		}, errorPlacement: function(error, element) {
 				 if (element.attr('id') == 'old_password') {
 						$('#old_password_error').html('<div class="error-message">' + error.html() + '</div>');
 						error.remove();
 				}
 				else if (element.attr('id') == 'password_new') {
 						$('#password_new_error').html('<div class="error-message">' + error.html() + '</div>');
 						error.remove();
 				} else if (element.attr('id') == 'confirmed_password') {
 						$('#password_new_error').html('<div class="error-message">' + error.html() + '</div>');
 						error.remove();
 				}
 				else {
 					 element.next().remove();
 					 error.insertAfter("#" + element.attr('id'));
 			 }





 		}, success: function(label, element) {
 				label.addClass("has-success");
 				var myid = label.attr('for');

 				if (myid == 'old_password') {

 						$('#old_password_error').html('');

 				} else if (myid == 'password_new') {

 						$('#confirmed_password_error').html('');

 				}else if (myid == 'confirm_passowrd') {

 						$('#confirmed_password_error').html('');

 				}

 		}
 });
 });
 
  function login_customer(e) {
       
      if(auth==0)
      e.preventDefault();
        $('#loginclick').click();

     }
 
          

 /////hossam
