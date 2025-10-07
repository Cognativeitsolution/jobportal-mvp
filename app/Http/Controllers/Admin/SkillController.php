<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use App\Traits\Crud;

class SkillController extends Controller {
    protected $title        = 'Manage Skill';
    protected $model        = Skill::class;
    protected $view         = 'admin.skill.';
    protected $searchable   = ['name'];
    protected $operationFor = 'Skill';

    use Crud;

    public function validation($request, $id = 0) {
        return $request->validate([
            'name' => 'required|string|max:255|unique:skills,name,' . $id,
        ]);
    }
}
