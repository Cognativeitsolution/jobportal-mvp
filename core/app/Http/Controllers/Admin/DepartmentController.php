<?php

namespace App\Http\Controllers\Admin;

use App\Traits\Crud;
use App\Models\Department;
use App\Http\Controllers\Controller;

class DepartmentController extends Controller
{
    protected $title        = 'Manage Department';
    protected $model        = Department::class;
    protected $view         = 'admin.department.';
    protected $searchable   = ['title'];
    protected $operationFor = 'Department';

    use Crud;

    public function validation($request, $id = 0)
    {
        return $request->validate([
            'title' => 'required|max:255|unique:departments,title,' . $id
        ]);
    }
}
