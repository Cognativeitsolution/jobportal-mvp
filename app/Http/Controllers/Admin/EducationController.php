<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationDegree;
use App\Models\EducationGroup;
use App\Models\EducationLevel;
use Illuminate\Http\Request;

class EducationController extends Controller {
    public function index() {
        $levels    = EducationLevel::searchable(['name'])->orderByDesc('id')->paginate(getPaginate());
        $pageTitle = "Manage Education Of Level";
        return view('admin.education.level', compact('pageTitle', 'levels'));
    }

    public function save(Request $request, $id = 0) {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        if ($id) {
            $education = EducationLevel::findOrFail($id);
            $message   = "Education level updated successfully";
        } else {
            $education = new EducationLevel();
            $message   = "Education level added successfully";
        }
        $education->name = $request->name;
        $education->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function changeLevelsStatus($id) {
        return EducationLevel::changeStatus($id);
    }

    public function degree() {
        $allDegrees = EducationDegree::searchable(['name', 'educationLevel:name'])->with('educationLevel')->orderByDesc('id')->paginate(getPaginate());
        $levels     = EducationLevel::active()->orderByDesc('id')->get();
        $pageTitle  = "Manage Education Degree";
        return view('admin.education.degree', compact('pageTitle', 'allDegrees', 'levels'));
    }

    public function degreeSave(Request $request, $id = 0) {
        $request->validate([
            'name'               => 'required|max:255',
            'education_level_id' => 'required|exists:education_levels,id',
        ]);

        if ($id) {
            $education = EducationDegree::findOrFail($id);
            $message   = "Education degree updated successfully";
        } else {
            $education = new EducationDegree();
            $message   = "Education degree added successfully";
        }
        $education->education_level_id = $request->education_level_id;
        $education->name               = $request->name;
        $education->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function changeDegreeStatus($id) {
        return EducationDegree::changeStatus($id);
    }

    public function group() {
        $groups    = EducationGroup::searchable(['name'])->orderByDesc('id')->paginate(getPaginate());
        $pageTitle = "Manage Education Group";
        return view('admin.education.group', compact('pageTitle', 'groups'));
    }

    public function groupStore(Request $request, $id = null) {
        $request->validate([
            'name' => 'required|max:255',
        ]);

        if ($id) {
            $educationGroup = EducationGroup::findOrFail($id);
            $message        = "Education group updated successfully";
        } else {
            $educationGroup = new EducationGroup();
            $message        = "Education group added successfully";
        }
        $educationGroup->name = $request->name;
        $educationGroup->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function changeGroupStatus($id) {
        return EducationGroup::changeStatus($id);
    }
}
