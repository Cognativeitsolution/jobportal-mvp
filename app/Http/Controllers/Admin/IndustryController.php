<?php

namespace App\Http\Controllers\Admin;

use App\Traits\Crud;
use App\Models\Industry;
use App\Http\Controllers\Controller;

class IndustryController extends Controller
{
    protected $title        = 'Manage Industry';
    protected $model        = Industry::class;
    protected $view         = 'admin.industry.';
    protected $searchable   = ['name'];
    protected $operationFor = 'Industry';

    use Crud;

    public function validation($request, $id = 0)
    {
        return $request->validate([
            'name' => 'required|max:40|unique:industries,name,' . $id,
        ]);
    }
}
