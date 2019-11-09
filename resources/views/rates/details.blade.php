<style>
    td.details-control {
        background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
        cursor: pointer;
    }

    tr.shown td.details-control {
        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
    }
</style>
<div id="main-wrapper">
    <div class="row">
        <table id="xtreme-table" class="display table" style="width: 100%; cellspacing: 0;">
            <thead>
                <tr>
                    <th></th>
                    <th style="display:none ">#</th>
                    <th>{{ __('strings.date') }}</th>
                    <th>@lang('strings.room_name')</th>
                    <th>{{ __('strings.hotel_room_price') }}</th>
                    <th>{{ __('strings.tax') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($list as $value)
                    <tr>
                        <td class="details-control"></td>
                        
                        <td style="display:none ">{{ empty($value->cat_id) ? $id : $value->cat_id }}</td>
                        <td>{{ $value->date }}</td>
                        <td>{{ App\Category::where('id', $value->cat_id)->value('name')  }}</td>
                        <td>{{ Decimalplace($value->final_price) }}</td>
                        <td>{{ Decimalplace(abs($value->final_price - $value->price)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<script>
    function format(d) {
        var table1;
        var programs = '';
        if (d != []) {
            $.each(d, function (key, item) {
                programs += '<tr>';
                programs += '<td>' + item.name + '</td>';
                programs += '<td>' + item.price + '</td>';
            });
        }
        table1 = '<table class="table">\n' +
            '\t\t\t\t\t\t\t<thead>\n' +
            '\t\t\t\t\t\t\t\t<tr>\n' +
            '\t\t\t\t\t\t\t\t\t<th>@lang('strings.name')</th>\n' +
            '\t\t\t\t\t\t\t\t\t<th>@lang('strings.price')</th>\n' +
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

        $('#xtreme-table tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                $.get("{{ url('admin/rates/get-fees/') }}/" + row.data()[1], function (data) {
                    row.child(format(data)).show();
                });
                tr.addClass('shown');
            }
        });
    });
</script>