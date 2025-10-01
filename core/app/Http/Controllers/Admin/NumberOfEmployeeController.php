<?php

namespace App\Http\Controllers\Admin;

use App\Traits\Crud;
use App\Models\NumberOfEmployees;
use App\Http\Controllers\Controller;

class NumberOfEmployeeController extends Controller
{
    protected $title        = 'Manage Number Of Employees';
    protected $model        = NumberOfEmployees::class;
    protected $view         = 'admin.number_employees.';
    protected $searchable   = ['name'];
    protected $operationFor = 'Number Of Employees';

    use Crud;

    public function validation($request, $id = 0)
    {
        return $request->validate([
            'employees' => 'required|string|max:255|unique:number_of_employees,employees,' . $id
        ]);
    }
}
