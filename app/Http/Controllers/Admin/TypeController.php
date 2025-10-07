<?php

namespace App\Http\Controllers\Admin;

use App\Models\Type;
use App\Traits\Crud;
use App\Http\Controllers\Controller;

class TypeController extends Controller
{
    protected $title        = 'Manage Type';
    protected $model        = Type::class;
    protected $view         = 'admin.type.';
    protected $searchable   = ['name'];
    protected $operationFor = 'Type';

    use Crud;

    public function validation($request, $id = 0)
    {
        return $request->validate([
            'name' => 'required|string|max:255|unique:types,name,' . $id,
        ]);
    }
}
