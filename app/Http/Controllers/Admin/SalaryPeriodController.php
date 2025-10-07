<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryPeriod;
use App\Traits\Crud;

class SalaryPeriodController extends Controller
{
    protected $title        = 'Manage Salary Period';
    protected $model        = SalaryPeriod::class;
    protected $view         = 'admin.salary_period.';
    protected $searchable   = ['name'];
    protected $operationFor = 'Salary Period';

    use Crud;

    public function validation($request, $id = 0)
    {
        return $request->validate([
            'name' => 'required|string|max:255|unique:salary_periods,name,' . $id,
        ]);
    }
}
