<?php

namespace App\Exports;

use App\KPIEmp;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithTitle;
use Illuminate\Contracts\View\View;
use Auth;

class KPIAverageExport implements FromView, WithTitle
{
    protected $year;
    protected $month;
    protected $employee;

    public function __construct($employee, $year, $month)
    {
        $this->employee = $employee;
        $this->year = $year;
        $this->month = $month;
    }

    /**
     * @return Builder
     */
    public function view(): View
    {

        if(!empty($this->employee)){
            return view('exports.kpi_average_reports', [
                'list' => KPIEmp::where(['emp_id' => $this->employee,'kpi_year' => $this->year, 'kpi_month' => $this->month, 'org_id' => Auth::user()->org_id])->groupBy('emp_id')->get()
            ]);
        }else{
            return view('exports.kpi_average_reports', [
                'list' => KPIEmp::where(['kpi_year' => $this->year, 'kpi_month' => $this->month, 'org_id' => Auth::user()->org_id])->groupBy('emp_id')->get()
            ]);
        }

    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Month ' . $this->month . '-' . $this->year;
    }
}
