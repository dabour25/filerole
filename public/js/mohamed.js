var lang = $('meta[name="lang"]').attr('content');
var url=$('meta[name="base_url"]').attr('content');
if(lang=='ar'){

    /*  rooms/num-> index   */
    function format_(d) {
        var table1;
        var programs = '';
        if (d != []) {
            $.each(d, function (key, item) {

                programs += '<tr>';
                programs += '<td style="width: 195px; display: none;" >' + item.id + '</td>';
                programs += '<td>' + item.cat_num + '</td>';
                if (item.building != null) {
                    programs += '<td>' + item.building + ' </td>';

                } else {
                    programs += '<td>  </td>';
                }
                if (item.floor_num == 0) {
                    programs += '<td>الارضي</td>';
                } else if (item.floor_num == 1) {
                    programs += '<td>الاول</td>';
                } else if (item.floor_num == 2) {
                    programs += '<td>الثاني</td>';
                } else if (item.floor_num == 3) {
                    programs += '<td>الثالث</td>';
                } else if (item.floor_num == 4) {
                    programs += '<td>الرابع</td>';
                } else if (item.floor_num == 5) {
                    programs += '<td>الخامس</td>';
                } else if (item.floor_num == 6) {
                    programs += '<td>السادس</td>';
                } else if (item.floor_num == 7) {
                    programs += '<td>السابع</td>';
                } else if (item.floor_num == 8) {
                    programs += '<td>الثامن</td>';
                } else if (item.floor_num == 9) {
                    programs += '<td>التاسع</td>';
                } else if (item.floor_num == 10) {
                    programs += '<td>العاشر</td>';
                } else {
                    programs += '<td>  </td>';
                }
                programs += '<td>' + item.room_status + '</td>';
                programs += '<td>' + item.clean_status + '</td>';
                programs += '<td> \n' +

                    '<a href="'+ url +'/admin/rooms/number/updated' + '/' + item.id + '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="تعديل" data-original-title="تعديل"> <i class="fa fa-pencil"></i></a>' +
                '<a onclick="return myFunctionarabic();" href="'+ url +'/admin/rooms/number/del' + '/' + item.id + '"' + 'class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="حذف" data-original-title="حذف"> <i class="fa fa-trash-o"></i></a>' +

                '</td>';
                programs += '</tr>';
            });
        }

        table1 = '<table class="table">\n' +
            '\t\t\t\t\t\t\t<thead>\n' +
            '\t\t\t\t\t\t\t\t<tr>\n' +
            '\t\t\t\t\t\t\t\t\t<th style="display: none;">#</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>رقم الغرفه</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>اسم المبنى</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>الطابق/الدور</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>الحاله</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>حاله النظافه</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>الاعدادات</th>\n' +
        '\t\t\t\t\t\t\t\t</tr>\n' +
        '\t\t\t\t\t\t\t</thead>\n' +
        '\t\t\t\t\t\t\t<tbody>\n' +
        programs +
        '\t\t\t\t\t\t\t</tbody>\n' +
        '\t\t\t\t\t\t</table>';


        return table1
    }

    $(document).ready(function () {
        var table = $('#xtreme-table').DataTable();
        $.fn.dataTable.ext.errMode = 'none';
        $('#xtreme-table tbody').on('click', 'td.details-control_', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                $.get(url+'/admin/rooms/number/get-cate-num/' + row.data()[1], function (data) {
                    row.child(format_(data)).show();
                });
                tr.addClass('shown');
            }
        });
    });

    function myFunctionarabic() {
        if(!confirm("هل تريد حذف هذه الغرف"))
            event.preventDefault();
    }

    /*  rooms-> index   */
    function formatroom(d) {
        var table1;
        var programs = '';
        if (d != []) {
            $.each(d, function (key, item) {

                programs += '<tr>';
                programs += '<td style="width: 195px; display:none;">' + item.id + '</td>';
                programs += '<td>' + item.name + '</td>';
                programs += '<td>' + item.name_en + '</td>';
                programs += '<td>' + item.type.name + '</td>';
                if(item.photo!=null ){
                    programs += '<td><a target="_blank" href="'+url+item.photo.file +'" ><img src="'+url+item.photo.file +'" width="40" height="40"></a></td>';
                }
                else{
                    programs +='<td><img src="'+url+'/images/profile-placeholder.png" width="40" height="40"></td>';
                }

                programs += '<td> <a href="'+url+'/admin/rooms/photos'+'/'+ item.id +'" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="show_rooms_photo" data-original-title="show_rooms_photo"> <i class="fa fa-image"></i></a>';
                programs += '<td>'+
                    '  <a href="'+url+'/admin/rooms/create/prices'+'/'+ item.id +'" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="show_prices_and_eating" data-original-title="show_prices_and_eating"> <i class="fas fa-allergies"></i></a>' +
                '</td>';
                programs += '<td> \n' +

                    '<a href="'+url+'/admin/rooms/updated'+'/'+ item.id +'" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="تعديل" data-original-title="تعديل"> <i class="fa fa-pencil"></i></a>' +
                '<a onclick="return removeRoomNumAr();" href="'+url+'/admin/rooms/deleted'+'/' + item.id + '" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="حذف" data-original-title="حذف"> <i class="fa fa-trash-o"></i></a>' +

                '</td>';
                programs += '</tr>';
            });
        }

        table1 = '<table class="table">\n' +
            '\t\t\t\t\t\t\t<thead>\n' +
            '\t\t\t\t\t\t\t\t<tr>\n' +
            '\t\t\t\t\t\t\t\t\t<th style="display: none;">#</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>الاسم بالعربي</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>الاسم بالانجليزى</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>نوع الغرفه</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>صوره الغرفه</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>عرض جميع صور الغرفه</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>اسعار الاطفال والوجبات</th>\n' +
        '\t\t\t\t\t\t\t\t\t<th>الاعدادات</th>\n' +
        '\t\t\t\t\t\t\t\t</tr>\n' +
        '\t\t\t\t\t\t\t</thead>\n' +
        '\t\t\t\t\t\t\t<tbody>\n' +
        programs +
        '\t\t\t\t\t\t\t</tbody>\n' +
        '\t\t\t\t\t\t</table>';


        return table1
    }


    $(document).ready(function () {
        var table = $('#xtreme-table').DataTable();
        $.fn.dataTable.ext.errMode = 'none';
        $('#xtreme-table tbody').on('click', 'td.details-control_room', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                $.get(url+'/admin/rooms/get/rooms/' + row.data()[1], function (data) {
                    row.child(formatroom(data)).show();
                });
                tr.addClass('shown');
            }
        });
    });

    function removeRoomNumAr() {
        if(!confirm("هل تريد حذف الغرفه"))
            event.preventDefault();
    }





}else{

    /*  rooms/num-> index   */
    function format_(d) {
        var table1;
        var programs = '';
        if (d != []) {
            $.each(d, function (key, item) {

                programs += '<tr>';
                programs += '<td style="width: 195px; display: none;" >' + item.id + '</td>';
                programs += '<td>' + item.cat_num + '</td>';
                if (item.building != null) {
                    programs += '<td>' + item.building + ' </td>';

                } else {
                    programs += '<td>  </td>';
                }
                if (item.floor_num == 0) {
                    programs += '<td>Ground floor</td>';
                } else if (item.floor_num == 1) {
                    programs += '<td>First round</td>';
                } else if (item.floor_num == 2) {
                    programs += '<td>second floor</td>';
                } else if (item.floor_num == 3) {
                    programs += '<td>Third round</td>';
                } else if (item.floor_num == 4) {
                    programs += '<td>Fourth Floor</td>';
                } else if (item.floor_num == 5) {
                    programs += '<td>fifth floor</td>';
                } else if (item.floor_num == 6) {
                    programs += '<td>sixth floor</td>';
                } else if (item.floor_num == 7) {
                    programs += '<td>seventh floor</td>';
                } else if (item.floor_num == 8) {
                    programs += '<td>eighth floor</td>';
                } else if (item.floor_num == 9) {
                    programs += '<td>Ninth floor</td>';
                } else if (item.floor_num == 10) {
                    programs += '<td>Tenth floor</td>';
                } else {
                    programs += '<td>  </td>';
                }
                programs += '<td>' + item.room_status + '</td>';
                programs += '<td>' + item.clean_status + '</td>';
                programs += '<td> \n' +

                    '<a href="'+ url +'/admin/rooms/number/updated' + '/' + item.id + '" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="updated" data-original-title="updated"> <i class="fa fa-pencil"></i></a>' +
                    '<a onclick="return myFunctionen();" href="'+ url +'/admin/rooms/number/del' + '/' + item.id + '"' + 'class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="deleted" data-original-title="deleted"> <i class="fa fa-trash-o"></i></a>' +

                    '</td>';
                programs += '</tr>';
            });
        }

        table1 = '<table class="table">\n' +
            '\t\t\t\t\t\t\t<thead>\n' +
            '\t\t\t\t\t\t\t\t<tr>\n' +
            '\t\t\t\t\t\t\t\t\t<th style="display: none;">#</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>room number</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>building</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>Floor number</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>room status</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>clean status</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>Settings</th>\n' +
            '\t\t\t\t\t\t\t\t</tr>\n' +
            '\t\t\t\t\t\t\t</thead>\n' +
            '\t\t\t\t\t\t\t<tbody>\n' +
            programs +
            '\t\t\t\t\t\t\t</tbody>\n' +
            '\t\t\t\t\t\t</table>';


        return table1
    }

    $(document).ready(function () {
        var table = $('#xtreme-table').DataTable();
        $.fn.dataTable.ext.errMode = 'none';
        $('#xtreme-table tbody').on('click', 'td.details-control_', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                $.get(url+'/admin/rooms/number/get-cate-num/' + row.data()[1], function (data) {
                    row.child(format_(data)).show();
                });
                tr.addClass('shown');
            }
        });
    });

    function myFunctionen() {
        if(!confirm("Sure you want to delete this room"))
            event.preventDefault();
    }

    /*  rooms-> index   */
    function formatroom(d) {
        var table1;
        var programs = '';
        if (d != []) {
            $.each(d, function (key, item) {

                programs += '<tr>';
                programs += '<td style="width: 195px; display:none;">' + item.id + '</td>';
                programs += '<td>' + item.name + '</td>';
                programs += '<td>' + item.name_en + '</td>';
                programs += '<td>' + item.type.name + '</td>';
                if(item.photo!=null ){
                    programs += '<td><a target="_blank" href="'+url+item.photo.file +'" ><img src="'+url+item.photo.file +'" width="40" height="40"></a></td>';
                }
                else{
                    programs +='<td><img src="'+url+'/images/profile-placeholder.png" width="40" height="40"></td>';
                }

                programs += '<td> <a href="'+url+'/admin/rooms/photos'+'/'+ item.id +'" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="show_rooms_photo" data-original-title="show_rooms_photo"> <i class="fa fa-image"></i></a>';
                programs += '<td>'+
                    '  <a href="'+url+'/admin/rooms/create/prices'+'/'+ item.id +'" class="btn btn-info btn-xs" data-toggle="tooltip" data-placement="bottom" title="show_prices_and_eating" data-original-title="show_prices_and_eating"> <i class="fas fa-allergies"></i></a>' +
                    '</td>';
                programs += '<td> \n' +

                    '<a href="'+url+'/admin/rooms/updated'+'/'+ item.id +'" class="btn btn-primary btn-xs" data-toggle="tooltip" data-placement="bottom" title="updated" data-original-title="updated"> <i class="fa fa-pencil"></i></a>' +
                    '<a onclick="return removeRoomNumen();" href="'+url+'/admin/rooms/deleted'+'/' + item.id + '" class="btn btn-danger btn-xs" data-toggle="tooltip" data-placement="bottom" title="Remove" data-original-title="Remove"> <i class="fa fa-trash-o"></i></a>' +

                    '</td>';
                programs += '</tr>';
            });
        }

        table1 = '<table class="table">\n' +
            '\t\t\t\t\t\t\t<thead>\n' +
            '\t\t\t\t\t\t\t\t<tr>\n' +
            '\t\t\t\t\t\t\t\t\t<th style="display: none;">#</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>name arbic</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>اname english</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>Room Type</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>Room Photo</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>View all room images</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>Prices of children and meals</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>Settings</th>\n' +
            '\t\t\t\t\t\t\t\t</tr>\n' +
            '\t\t\t\t\t\t\t</thead>\n' +
            '\t\t\t\t\t\t\t<tbody>\n' +
            programs +
            '\t\t\t\t\t\t\t</tbody>\n' +
            '\t\t\t\t\t\t</table>';


        return table1
    }


    $(document).ready(function () {
        var table = $('#xtreme-table').DataTable();
        $.fn.dataTable.ext.errMode = 'none';
        $('#xtreme-table tbody').on('click', 'td.details-control_room', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                $.get(url+'/admin/rooms/get/rooms/' + row.data()[1], function (data) {
                    row.child(formatroom(data)).show();
                });
                tr.addClass('shown');
            }
        });
    });

    function removeRoomNumen() {
        if(!confirm("Sure you want to delete this room"))
            event.preventDefault();
    }

}

