@extends('layouts.admin', ['title' => 'edit menu' ])
@section('styles')
<style media="screen">
  .btnMenuStyle {
    padding: 5px;
    margin 0;
  }
  @if (app()->getLocale() == 'ar')
  .changeMenuStyle {
    float: left !important;
  }
  .editmenuDataForm{
    text-align: right;
  }
  .menu_edit_footer{
    padding-right:40px;
  }
  .btn-group.pull-right{
    float:left !important;
  }

    .HintAlertBox {
      background: #fff;
      position: relative;
      /* padding:20px; */
      border: 2px solid #34a0d5;
    }
    .HintAlertBox .alertIcon {
      font-size: 50px;
      color: #34a0d5;
    }
    .divAlert {
      padding: 20px 0;
    }

    .HintAlertBox .exsitBtn {
      background: #34a0d5;
      border: none;
      position: absolute;
      left: 0;
      top: 0;
      z-index: 999;
    }
  @else
  .btn-group.pull-right{
    float:right !important;
  }


    .HintAlertBox {
      background: #fff;
      position: relative;
      /* padding:20px; */
      border: 2px solid #34a0d5;
    }
    .HintAlertBox .alertIcon {
      font-size: 50px;
      color: #34a0d5;
    }
    .divAlert {
      padding: 20px 0;
    }

    .HintAlertBox .exsitBtn {
      background: #34a0d5;
      border: none;
      position: absolute;
      right: 0;
      top: 0;
      z-index: 999;
    }

  @endif




  .menuLabel{
    padding:15px;
  }
  .content-dash .panel .panel-body{
    background: transparent;
  }

  .clickable{
    padding : 5px !important;
    margin:0 !important ;
  }

  .btnEdit{
    height:35px;
    padding-top: 7px !important;
  }
  .editmenuHeader{
    padding-right:50px;
  }

  .sortableListsClosed{
    padding-right:50px;
  }
  /* .sortableListsClosed i {
    margin-right: 10px;
  } */
</style>
@endsection
@section('content')

<div id="main-wrapper" class="main-wrapper-index">
        <div class="alert_new">
        <span class="alertIcon">
            <i class="fas fa-exclamation-circle"></i>
         </span>
         <p>
             @if (app()->getLocale() == 'ar')
            {{ DB::table('function_new')->where('id',102)->value('description') }}
            @else
            {{ DB::table('function_new')->where('id',102)->value('description_en') }}
            @endif
         </p>
         <a href="#" onclick="close_alert()" class="close_alert">  <i class="fas fa-times-circle"></i> </a>

    </div>
  <div class="content-dash">

    <div class="">

    <div class="panel-body panel-body-edit" id="cont">



      <div class="new_edit_menu">
          <h1>إدارة التطبيقات </h1>
          <form class="" id="menuMangerEditor" action="{{ Route('menuMangerEdit') }}" method="post">
            @csrf
            <div class="row">
                <div class="col-md-6 col-xs-12">
                    <div class="item_edit_menu active_edit">
                      <h3 class="all_edit_title"><i class="fas fa-check"></i> مفعل</h3>
                      <div class="active_links" id="active_links">
                        @foreach ($menus as $menu)
                          @if ($menu->appear == 1)
                            <p>
                              <i class="fas fa-users"></i> {{ app()->getLocale() == 'ar' ? $menu->funcname : $menu->funcname_en }}
                              <label class="switch">
                                  <input  class="menuCheckBox" name="checkBoxMenu[]"   type="checkbox" id="checkbox_4"  {{ $menu->appear == 1 ?  'checked' : '' }} >
                                  <input  class="menuUnCheckedId" name="id[]" value="{{ $menu->id }}"  type="hidden" >
                                  <span class="slider round"></span>
                              </label>
                            </p>
                          @endif
                        @endforeach
                      </div>
                    </div>
                </div>
                <div class="col-md-6 col-xs-12">
                    <div class="item_edit_menu not_active_edit">
                      <h3 class="all_edit_title"><i class="fas fa-bars"></i> متاح (غير مفعل) </h3>
                      <div class="active_links unactive_links" id="unactive_links">
                        @foreach ($menus as $menu)
                          @if ($menu->appear == 0)
                            <p>
                              <i class="fas fa-users"></i> {{ app()->getLocale() == 'ar' ? $menu->funcname : $menu->funcname_en }}
                              <label class="switch">
                                  <input  class="UnCheck" name="unCheckBoxMenu[]"   type="checkbox" id="checkbox_4" >
                                  <input  class="menuUnCheckedId" name="UnCheckedId[]" value="{{ $menu->id }}"  type="hidden" >
                                  <span class="slider round"></span>
                              </label>
                            </p>
                          @endif
                        @endforeach
                      </div>
                    </div>
                </div>
            </div>
          </form>
      </div>

      <div class="menu_edit_footer">
        <button type="submuit"   form="menuMangerEditor" class="btn btn-primary"> <i class="fas fa-save"></i>  {{ __('strings.editMenu_saveChanges') }}</button>
        {{-- <button type="button" id="default_menu" class="btn btn-primary"> <i class="fas fa-undo-alt"></i> {{ __('strings.editMenu_default') }}</button> --}}
      </div>

      <div class="alert-infto ">
        <span class="menu_msg"></span>
        <span class="menu_icon"></span>
      </div>

    </div>


        {{-- <button id="btnReload" type="button" class="btn btn-default">
        <i class="glyphicon glyphicon-triangle-right"></i> Load Data</button> --}}
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
$( document ).ready(function() {
      $('#active_links').on('change' , '.menuCheckBox',function(){
        $(this).parents('p');
        $(this).parents('p').find('.menuCheckedId').addClass("menuUnCheckedId");
        $(this).parents('p').find('.menuUnCheckedId').attr("name",'UnCheckedId[]');
        $(this).attr("name",'unCheckBoxMenu[]');
        $(this).parents('p').find('.menuCheckedId').removeClass("menuCheckedId");
        $(this).addClass('UnCheck');
        $(this).removeClass('menuCheckBox');
        $('#unactive_links').append($(this).parents('p'));
    });
    $('#unactive_links').on('change' , '.UnCheck',function(){
        $(this).parents('p');

        $(this).parents('p').find('.menuUnCheckedId').addClass("menuCheckedId");
        $(this).attr("name",'checkBoxMenu[]');
        $(this).parents('p').find('.menuCheckedId').attr("name",'id[]');
        $(this).parents('p').find('.menuUnCheckedId').removeClass("menuUnCheckedId");
        $(this).addClass('menuCheckBox');
        $(this).removeClass('UnCheck');
        $('#active_links').append($(this).parents('p'));
    });
  });
</script>
<script>
    $(document).ready(function(){
      $(".dropdown").click(function(){
        $('.dropdown-menu').slideUp();
        $(this).find('.dropdown-menu').slideToggle();
      });
    });
</script>
<script>
function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
  ev.target.appendChild(document.getElementById(data));
}
</script>
@endsection
