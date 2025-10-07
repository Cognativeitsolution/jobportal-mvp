<?php

namespace App\Http\Controllers\Admin;

use App\Traits\Crud;
use App\Models\Experience;
use App\Http\Controllers\Controller;

class ExperienceController extends Controller
{
    protected $title        = 'Manage Experience';
    protected $model        = Experience::class;
    protected $view         = 'admin.experience.';
    protected $searchable   = ['name'];
    protected $operationFor = 'Experience';

    use Crud;

    public function validation($request, $id = 0)
    {
        return $request->validate([
            'name' => 'required|max:255|unique:experiences,name,' . $id
        ]);
    }
}
