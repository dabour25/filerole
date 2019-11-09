@extends('front.index_layout')

@section('content')

<style>
        td.details-control {
            background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
            cursor: pointer;
        }

        tr.shown td.details-control {
            background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
        }
    </style>
   <div id="page_header" class="page-subheader page-subheader-bg">

        <!-- Sub-Header content wrapper -->
        <div class="ph-content-wrap d-flex">
            <div class="container align-self-center">
                <div class="row">

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="subheader-titles">
                            <h2 class="subheader-maintitle">
                             @lang('strings.inovices_resrvition')
                            </h2>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <ul class="breadcrumbs fixclear">
                            <li><a href="/">@lang('strings.Home')</a></li>
                            <li> @lang('strings.inovices_resrvition') </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
@if(session()->has('message'))
		    <div class="alert alert-success">
		        {{ session()->get('message') }}
		    </div>
		@endif
        <!-- Sub-Header bottom mask style 6 -->
        <div class="kl-bottommask kl-bottommask--mask6">
            <svg width="2700px" height="57px" class="svgmask" viewBox="0 0 2700 57" version="1.1" xmlns="https://www.w3.org/2000/svg" xmlns:xlink="https://www.w3.org/1999/xlink">
                <defs>
                    <filter x="-50%" y="-50%" width="200%" height="200%" filterUnits="objectBoundingBox" id="filter-mask6">
                        <feOffset dx="0" dy="-2" in="SourceAlpha" result="shadowOffsetOuter1"></feOffset>
                        <feGaussianBlur stdDeviation="2" in="shadowOffsetOuter1" result="shadowBlurOuter1"></feGaussianBlur>
                        <feColorMatrix values="0 0 0 0 0   0 0 0 0 0   0 0 0 0 0  0 0 0 0.5 0" in="shadowBlurOuter1" type="matrix" result="shadowMatrixOuter1"></feColorMatrix>
                        <feMerge>
                            <feMergeNode in="shadowMatrixOuter1"></feMergeNode>
                            <feMergeNode in="SourceGraphic"></feMergeNode>
                        </feMerge>
                    </filter>
                </defs>
                <g transform="translate(-1.000000, 10.000000)">
                    <path d="M0.455078125,18.5 L1,47 L392,47 L1577,35 L392,17 L0.455078125,18.5 Z" fill="#000000"></path>
                    <path d="M2701,0.313493752 L2701,47.2349598 L2312,47 L391,47 L2312,0 L2701,0.313493752 Z" fill="#fbfbfb" class="bmask-bgfill" filter="url(#filter-mask6)"></path>
                    <path d="M2702,3 L2702,19 L2312,19 L1127,33 L2312,3 L2702,3 Z" fill="#cd2122" class="bmask-customfill"></path>
                </g>
            </svg>
        </div>

    </div>

    <div class="latest_product latest_product_inner categorys_product_page res_front">
        <div class="container">



            <div class="tab-content">
                     <table id="xtreme-table" class="display table table-striped table-bordered" style="width:100%">
                         <thead><tr>
                             
                             <th>#</th>
                                <th>@lang('strings.reservation_no')</th>
                                <th>@lang('strings.reservation_captain')</th>
                                <th>@lang('strings.reservation_comment')</th>
                                <th>@lang('strings.reservation_date')</th>
                                <th>@lang('strings.reservation_confirm')</th>
                         </tr>
                         </thead>
                         <tbody>
                         @foreach($reservations as $reservation)

                             <tr>
                                 <td class=" details-control"></td>
                               <td>{{ $reservation['id'] }}</td>
                               <td>{{ app()->getLocale() == 'ar' ?App\User::where('id', $reservation->captain_id)->value('name') : App\User::where('id', $reservation->captain_id)->value('name_en') }}</td>

                               <td>{{ $reservation['comment'] }}</td>
                               <td>{{ $reservation['reservation_date'] }}</td>

                               <td>
                                   <!--<Esraa  11-feb-2019 -->
                                    @if($reservation['confirm']=='y')
                                 <span class="label label-success"
                                    style="font-size:13px;color:green;">@lang('strings.confirmed2')</span>
                                    @elseif($reservation['confirm']=='c')
                                     <span class="label label-default"
                                    style="font-size:13px;background-color: #2a2a2a;border:
                                    none;color:red;" >@lang('strings.canceled')</span>
                                     @else
                                    <span class="label label-danger"
                                    style="font-size:13px;color:red;">@lang('strings.uncertain')</span>
                                      @endif
                               <!-- Esraa 11-feb-2019 -->


                               </td>
                             </tr>
                         @endforeach
                         </tbody>

                     </table>
                     {{ $reservations->links() }}
                     <ul class="nav nav-pills" role="tablist">
                         <!-- Mostafa Reservation -->
                         <li role="presentation" class="add-service"><a href="{{ url('reservation') }}"><i class="icon-calendar"></i> @lang('strings.reservation_add')  </a></li>

                         <!-- End Mostafa Reservation -->

                     </ul>





            </div>

        </div>
    </div> <!-- // latest product -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap4.min.js"></script>
<script>
function time_from_id(id){
      if(id==1){
      return "12:00 AM";
    }
    else if(id==2){
      return "12:30 AM";
    }
    else if(id==3){
      return "01:00 AM";
    }
    else if(id==4){
      return "01:30 AM";
    }
    else if(id==5){
      return "02:00 AM";
    }
    else if(id==6){
      return "02:30 AM";
    }
    else if(id==7){
      return "03:00 AM";
    }
    else if(id==8){
      return "03:30 AM";
    }
    else if(id==9){
      return "04:00 AM";
    }
    else if(id==10){
      return "04:30 AM";
    }
    else if(id==11){
      return "05:00 AM";
    }
    else if(id==12){
      return "05:30 AM";
    }
    else if(id==13){
      return "06:00 AM";
    }
    else if(id==14){
      return "06:30 AM";
    }
    else if(id==15){
      return "07:00 AM";
    }
    else if(id==16){
      return "07:30 AM";
    }
    else if(id==17){
      return "08:00 AM";
    }
    else if(id==18){
      return "08:30 AM";
    }
    else if(id==19){
      return "09:00 AM";
    }
    else if(id==20){
      return "09:30 AM";
    }
    else if(id==21){
      return "10:00 AM";
    }
    else if(id==22){
      return "10:30 AM";
    }
    else if(id==23){
      return "11:00 AM";
    }
    else if(id==24){
      return "11:30 AM";
    }
    else if(id==25){
      return "1:00 PM";
    }
    else if(id==26){
      return "1:30 PM";
    }
    else if(id==27){
      return "2:00 PM";
    }
    else if(id==28){
      return "2:30 PM";
    }
    else if(id==29){
      return "3:00 PM";
    }
    else if(id==30){
      return "3:30 PM";
    }
    else if(id==31){
      return "4:00 PM";
    }
    else if(id==32){
      return "4:30 PM";
    }
    else if(id==33){
      return "5:00 PM";
    }
    else if(id==34){
      return "5:30 PM";
    }
    else if(id==35){
      return "6:00 PM";
    }
    else if(id==36){
      return "6:30 PM";
    }
    else if(id==37){
      return "7:00 PM";
    }
    else if(id==38){
      return "7:30 PM";
    }
    else if(id==39){
      return "8:00 PM";
    }
    else if(id==40){
      return "8:30 PM";
    }
    else if(id==41){
      return "9:00 PM";
    }
    else if(id==42){
      return "9:30 PM";
    }
    else if(id==43){
      return "10:00 PM";
    }
    else if(id==44){
      return "10:30 PM";
    }
    else if(id==45){
      return "11:00 PM";
    }
    else if(id==46){
      return "11:30 pm";
    }
    else if(id==47){
      return "12:00 PM";
    }
    else if(id==48){
      return "12:30 PM";
    }
    else{
      return 0;
    }
}


      function format(d) {
            var table1;
            var details ='';
            if (d != []) {
                customer='<div class="panel panel-white">\n'+
                          '<div class="panel-heading clearfix">\n'+
                          '<h4 class="panel-title">@lang('strings.details')</h4>\n' +
                          '</div>\n' +
                          '<div class="panel-body">\n' +
                          '<div class="row">\n' +
                          '<div class="col-md-12">\n' +
                        '<div class="col-md-6">\n'+
                        '<h3 class="head-bar theme-color-a">\n'+
						'<span class="details-info">{{__('strings.services')}}</span>\n'+
					    '</h3>\n'+
                        '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="view-table">\n'+
										'<tbody>';
						$.each(d.reservation_details, function(key, value) {
                        details+='<tr>';
                       details+='<td width="160">';
                       details+='<strong>';
                       details+=value.name;
                       details+='</strong>';
                       details+='</td><td>';
                       details+=value.required_time;
                       details+='M</td>';
                       details+='</tr>';
                    });
                    remaining='<tr>\n'+
                               '<td width="160">\n'+
                               '<strong>{{__('strings.total_time')}}</strong>\n'+
                               '</td>\n'+
                               '<td>'+d.total+'M</td>\n'+
						       '</tr>\n'+
                               '<tr>\n'+
                               '<td><i class="fa fa-calendar icon-sum"></i></td>\n'+
                               '<td>'+d.reservation.reservation_date+'</td>\n'+
                               '</tr>\n'+
                               '<tr>\n'+
                               '<td><i class="fa fa-clock-o icon-sum"></i></td>\n'+
                               '<td>'+time_from_id(d.start_time)+'</td>\n'+
								'</tr>\n'+
									'</tbody>\n'+
									'</table>\n'+
                                    '</div>\n'+
                                    '</div>\n'+
                                    '</div>';
                                   
                                    table1=customer+details+remaining;

            return table1;
        }
      }

        $(document).ready(function () {
            var table = $('#xtreme-table').DataTable();
            $.fn.dataTable.ext.errMode = 'none';
            $('#xtreme-table tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                console.log(row.data()[1]);

                if (row.child.isShown()) {
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    $.get("{{ url('reservations/get-details') }}/" + row.data()[1], function (data) {
                        
                        row.child(format(data)).show();
                    });
                    tr.addClass('shown');
                }
            });
        });
</script>


@endsection
