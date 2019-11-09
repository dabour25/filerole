@if($flag==0)
<table>
  <thead>
    <tr>
      <th>@lang('strings.employee_id')</th>
      <th>@lang('strings.employee_name')</th>
      <th>@lang('strings.total_earnings')</th>
      <th>@lang('strings.total_deductions')</th>
      <th>@lang('strings.net')</th>
    </tr>
  </thead>
  <tbody>
    @foreach($employees as $employee)
    <tr>
      <td>{{$employee->emp_id}}</td>
      <td>{{ app()->getLocale() == 'ar' ? $employee->employee_name_ar  : $employee->employee_name_en }}</td>
      <td>{{abs(round($employee->total_earnings, 2))}}</td>
      <td>{{abs(round($employee->total_deductions, 2))}}</td>
      <td>{{abs(round($employee->net_salary, 2))}} </td>
    </tr>
   @endforeach
 </tbody>
</table>
@else
  <table>
    <thead>
      <tr>
        <th>@lang('strings.employee_id')</th>
        <th>@lang('strings.employee_name')</th>
        <th>@lang('strings.total_earnings')</th>
        <th>@lang('strings.total_deductions')</th>
        <th>@lang('strings.net')</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{$employees->emp_id}}</td>
        <td>{{ app()->getLocale() == 'ar' ? $employees->employee_name_ar  : $employees->employee_name_en }}</td>
        <td>{{abs(round($employees->total_earnings, 2))}}</td>
        <td>{{abs(round($employees->total_deductions, 2))}}</td>
        <td>{{abs(round($employees->net_salary, 2))}} </td>
      </tr>
    </tbody>
  </table>
@endif
