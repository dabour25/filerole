$(document).ready(function() {
    
    
    
    
    
    
    
    
    
    
    
    
    $('form').submit(function() {
        jQuery('#modal_view_password .modal-body').html('<div style="text-align:center;"><img src="/lg.azure-round-loader.gif"/></div>');

        jQuery('#modal_view_password').modal('show', {
            backdrop: 'true'
        });

    })

    $(".datepicker").datepicker({
        defaultDate: null,
        rtl: true,
        viewMode: 'years',
        format: 'mm-yyyy',
        minViewMode: "months"


      });
            reservation_date=new Date();
      $(".datepicker_reservation").datepicker({

        date:reservation_date,
          startDate:reservation_date,
          rtl: true,
          viewMode: 'years',
          format: 'yyyy-mm-dd',
          // minViewMode: "months"


        }).on('changeDate', function(e) {
          var date2 = $('.datepicker_reservation').datepicker('getDate', '+1d');
           date2.setDate(date2.getDate()+1);

           var msecsInADay = 8640000;
           var endDate = new Date( date2.getTime() + msecsInADay);
           $('.datepicker_reservation2').datepicker('setStartDate',endDate);
         $('.datepicker_reservation2').datepicker('setDate',endDate);


           });


           $('.datepicker_reservation2').datepicker({

              format: 'yyyy-mm-dd',
           });
           
           
           
    
           
      

});




if (lang == 'ar') {
function create_valid() {
    if (document.getElementById('search_name').value == "0") {
        alert("من فضلك اختار الموظف");
        return false;
    }
    if (document.getElementById('loan_dt').value == '') {
        alert("من فصلك اختار التاريخ");
        return false;
    }

    if (document.getElementById('receive_dt').value == '') {
      alert("من فصلك اختار التاريخ");
        return false;
    } else return true;
}

function search_valid() {
    if (document.getElementById('search_name').value == "0") {
        alert("من فضلك اختار الموظف");
        return false;
    } else return true;
}


function create_valid1() {
    if (document.getElementById('search_name').value == "0") {
          alert("من فضلك اختار الموظف");
        return false;
    }
    if (document.getElementById('loan_dt').value == '') {
        alert("من فصلك اختار التاريخ");
        return false;
    } else return true;
}

function show_valid_save() {
   if(document.getElementById('search_name').value == "0"){
    alert('من فضلك اختار الموظف ');
    return false;
       }

   if(document.getElementById('emp_val').value == ''){
   alert('من فضللك ادخال القيمة');
      return false;
    }
   if(document.getElementById('val_date').value == ''){
    alert('برجاء ادخال التاريخ');
     return false;
    }
    if(document.getElementById('amount_type').value == ''){
     alert('يجب اضافة استحقاق/استقطاع اولا');
      return false;
     }
    else return true;
}
function show_valid_search() {
  if(document.getElementById('search_name').value == "0"){
  alert('من فضلك اختار الموظف ');
   return false;
  }
 if(document.getElementById('val_date').value == ''){
  alert('من فضلك ادخال التاريخ');
   return false;
  }
  else return true;
}


}else{
  function create_valid() {
      if (document.getElementById('search_name').value == "0") {
          alert("Please Choose The Employee");
          return false;
      }
      if (document.getElementById('loan_dt').value == '') {
          alert("Please Choose The Date");
          return false;
      }

      if (document.getElementById('receive_dt').value == '') {
              alert("Please Choose The Date");
          return false;
      } else return true;
  }

  function search_valid() {
      if (document.getElementById('search_name').value == "0") {
          alert("Please Choose The Employee");
          return false;
      } else return true;
  }


  function create_valid1() {
      if (document.getElementById('search_name').value == "0") {
          alert("Please Choose The Employee");
          return false;
      }
      if (document.getElementById('loan_dt').value == '') {
          alert("Please Choose The Date");
          return false;
      } else return true;

}

function show_valid_save() {
   if(document.getElementById('search_name').value == "0"){
      alert("Please Choose The Employee");
    return false;
       }

   if(document.getElementById('emp_val').value == ''){
   alert('Please Enter The value_en');
      return false;
    }
   if(document.getElementById('val_date').value == ''){
    alert("Please Choose The Date");
     return false;
    }
    if(document.getElementById('amount_type').value == ''){
     alert('You Must Add Allow Or dedcted first');
      return false;
     }
    else return true;
}

function show_valid_search() {
  if(document.getElementById('search_name').value == "0"){
  alert("Please Choose The Employee");
   return false;
  }
 if(document.getElementById('val_date').value == ''){
  alert("Please Choose The Date");
   return false;
  }
  else return true;
}



}




function change_type(){
var type_code=document.getElementById('type').value;

if(type_code==0){

document.getElementById('Deduction-select').style.display = "none";
 document.getElementById('Benefits-select').style.display = "block";
}else{

document.getElementById('Deduction-select').style.display = "block";
document.getElementById('Benefits-select').style.display = "none";
}
}

function show_add(){
document.getElementById('add').style.display = "block";
document.getElementById('add').value = '';
}




function show_input(){
if(document.getElementById('input_details').style.display=='block'){
document.getElementById('input_details').style.display='none';
}else
document.getElementById('input_details').style.display='block'
}



 function modal_show(id){

  $('input[name="location_id"]').val($('#modal_button'+id).data('id'));
  $('input[name="name"]').val($('#modal_button'+id).data('name'));
  $('input[name="name_en"]').val($('#modal_button'+id).data('name_en'));
  $('input[name="description"]').val($('#modal_button'+id).data('description'));
  $('input[name="description_en"]').val($('#modal_button'+id).data('description_en'));
  $('input[name="longitude"]').val($('#modal_button'+id).data('longitude'));
  $('input[name="latitude"]').val($('#modal_button'+id).data('latitude'));
  $('select[name="destination_id"]').val($('#modal_button'+id).data('destination_id'));
  $('select[name="active"]').val($('#modal_button'+id).data('active'));
 }
 function get_des(id){

$('select[name="destination_id"]').val(id);
$('input[name="name"]').val('');
$('input[name="name_en"]').val('');
$('input[name="description"]').val('');
$('input[name="description_en"]').val('');
$('input[name="longitude"]').val('');
$('input[name="latitude"]').val('');
$('select[name="active"]').val(1);
$('input[name="id"]').val('');

 }


function add_des(){
$('input[name="name"]').val('');
$('input[name="name_en"]').val('');
$('input[name="description"]').val('');
$('input[name="description_en"]').val('');
$('input[name="longitude"]').val('');
$('input[name="latitude"]').val('');
$('select[name="active"]').val(1);
$('select[name="infrontpage"]').val(1);
 }


 function modal_show_data(id){

         $('#details').val($('#modal_button'+id).data('details'));
        $('#details_information').val($('#modal_button'+id).data('details'));
         $('input[name="id"]').val($('#modal_button'+id).data('id'));
         $('input[name="type"]').val($('#modal_button'+id).data('type'));
         $('input[name="tab"]').val($('#modal_button'+id).data('tab'));
         $('#details_en').val($('#modal_button'+id).data('details_en'));
         $('#details_en_information').val($('#modal_button'+id).data('details_en'));
         $('select[name="policy_type_id"]').val($('#modal_button'+id).data('policy_type_id'));


        }

      function  modal_add_policy(){
         document.getElementById('information_checkcard').style.display='none';
        $('input[name="type_add"]').val($('#policy_add').data('type'));
        $('input[name="pre_tab"]').val($('#policy_add').data('tab'));

  }
  function  modal_add_information(){
     document.getElementById('information_checkcard').style.display='block';
    $('input[name="type_add"]').val($('#information_add').data('type'));
    $('input[name="pre_tab"]').val($('#information_add').data('tab'));


}


 function show_details(){
     var type_room = document.getElementById('unit_type').value;
     if(type_room=='شقة'  ||  type_room =='فيلا'){
       document.getElementById('flat_details').style.display='block';
     }

    else {
      document.getElementById('flat_details').style.display='none';
    }
 }

  function show_data(){
        $("#addroomType").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('id');
            $.get( "get_room_types/"+id, function( data ) {
                $(".modal-body").html(data.html);
                $('input[name="name"]').val(data['name']);
                $('input[name="name_en"]').val(data['name_en']);
                $('input[name="destination"]').val(data['destination']);
                $('input[name="description_en"]').val(data['description_en']);
                $('input[name="no_rooms"]').val(data['no_rooms']);
                $('input[name="no_kitchen"]').val(data['no_kitchen']);
                $('input[name="id"]').val(data['id']);
                $('input[name="no_bathrooms"]').val(data['no_bathrooms']);
                $('input[name="area"]').val(data['area']);
                $('select[name=kind]').val(data['kind']);
                $('select[name=unit_type]').val(data['unit_type']);
                $('select[name=max_people]').val(data['max_people']);
                $('select[name=max_adult]').val(data['max_adult']);
                $('select[name=max_kids]').val(data['max_kids']);
                $('select[name=active]').val(data['active']);
                if(data['unit_type'] =='شقة' || data['unit_type'] =='فيلا' ){
                  document.getElementById('flat_details').style.display='block';
                }else{
                  document.getElementById('flat_details').style.display='none';

                }
            });

        });



    }



                  function add_data(){
                   $('input[name="name"]').val('');
                   $('input[name="name_en"]').val('');
                   $('input[name="destination"]').val('');
                   $('input[name="description_en"]').val('');
                   $('input[name="no_rooms"]').val('');
                   $('input[name="no_kitchen"]').val('');
                   $('input[name="no_bathrooms"]').val('');
                   $('input[name="area"]').val('');
                   $('select[name=kind]').val('للايجار');
                   $('select[name=unit_type]').val('غرفة');
                   $('select[name=max_people]').val('');
                   $('select[name=max_adult]').val('');
                   $('select[name=max_kids]').val('');
                   $('select[name=active]').val(1);
       }




function book_cancel_data(id){
 $('input[name="id"]').val($('#modal_button'+id).data('id'));
 $('input[name="name"]').val($('#modal_button'+id).data('name'));
 $('input[name="name_en"]').val($('#modal_button'+id).data('name_en'));
 $('input[name="description"]').val($('#modal_button'+id).data('description'));
 $('input[name="rank"]').val($('#modal_button'+id).data('rank'));
 $('select[name="property_id"]').val($('#modal_button'+id).data('hotel'));
}
function clear_old_data(){

$('select[name="property_id"]').val('');
$('input[name="name"]').val('');
$('input[name="name_en"]').val('');
$('input[name="description"]').val('');
$('input[name="id"]').val('');
$('input[name="rank"]').val('');
}










