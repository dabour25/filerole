<?php

namespace App\Exports;

use App\User;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SalariesExport implements FromView
{
  private $employees;
  private $flag;
  public function __construct($employees,$flag)
  {

      $this->employees  = $employees;
      $this->flag=$flag;


  }
  public function view(): View
  {
    $employees=$this->employees;
    $flag=$this->flag;

      return view('exports.salaries', compact('employees','flag'));
  }
}
