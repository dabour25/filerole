@foreach($list as $value)
@php
    $user = App\User::findOrFail($value->emp_id);
@endphp
<table>
    <thead>
        <tr>
            <th>@lang('strings.Employee')</th>
            <th>{{ app()->getLocale() == 'ar' ? $user->name : $user->name_en }}</th>
        </tr>
        <tr>
            <th>@lang('strings.Item_name')</th>
            <th>@lang('strings.weight')</th>
            <th>@lang('strings.Average_value')</th>
        </tr>
    </thead>
    <tbody>
        @foreach(App\KPIEmp::where(['kpi_year' => $value->kpi_year, 'kpi_month' => $value->kpi_month,'emp_id' => $value->emp_id, 'user_id' => Auth::user()->id])->get() as $v)
        @php
            $type = App\KPITypes::findOrFail($v->kpi_id);

            if($count = App\KPIEmp::where(['kpi_id' => $v->kpi_id, 'kpi_year' => $value->kpi_year, 'kpi_month' => $value->kpi_month, 'emp_id' => $value->emp_id])->whereNotNull('kpi_val') ->count()){

            }
        @endphp
        <tr>
            <td>{{ app()->getLocale() == 'ar' ? $type->name : $type->name_en }}</td>
            <td>{{ $type->weight }}</td>
            <td>{{ $count != 0 ? round(App\KPIEmp::where(['kpi_id' => $v->kpi_id, 'emp_id' => $value->emp_id])->whereNotNull('kpi_val') ->sum('kpi_val') / $count, 2) : 0 }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endforeach