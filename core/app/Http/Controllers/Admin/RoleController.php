<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Traits\Crud;
use App\Rules\FileTypeValidate;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    protected $title        = 'All Roles';
    protected $model        = Role::class;
    protected $view         = 'admin.role.';
    protected $searchable   = ['name'];
    protected $operationFor = 'Role';

    use Crud;

    public function __construct()
    {
        $this->hasImage = true;
    }

    public function validation($request, $id = 0)
    {
        $isRequired = $id ? 'nullable' : 'required';
        return $request->validate([
            'name'        => 'required|string|max:255|unique:roles,name,' . $id,
            'image'       => [$isRequired, 'image', new FileTypeValidate(['jpg', 'jpeg', 'png'])]
        ]);
    }
}
