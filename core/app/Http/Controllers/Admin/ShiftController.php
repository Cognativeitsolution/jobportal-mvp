<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Traits\Crud;

class ShiftController extends Controller
{
    protected $title        = 'Manage Shift';
    protected $model        = Shift::class;
    protected $view         = 'admin.shift.';
    protected $searchable   = ['name'];
    protected $operationFor = 'Shift';

    use Crud;

    public function validation($request, $id = 0)
    {
        return $request->validate([
            'name' => 'required|string|max:255|unique:shifts,name,' . $id,
        ]);
    }
}
