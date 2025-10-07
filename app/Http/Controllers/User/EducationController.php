<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EducationalQualification;
use App\Models\EducationDegree;
use App\Models\EducationGroup;
use App\Models\EducationLevel;
use Illuminate\Http\Request;

class EducationController extends Controller {
    public function index(Request $request) {
        $pageTitle  = "Education History";
        $user       = authUser();
        $levels     = EducationLevel::active()->with('educationDegrees')->orderByDesc('id')->get();
        $groups     = EducationGroup::active()->orderByDesc('id')->get();
        $educations = EducationalQualification::where('user_id', $user->id)->with('educationGroup', 'educationDegree')->get();
        return view('Template::user.education.index', compact('pageTitle', 'educations', 'levels', 'groups'));
    }

    public function store(Request $request, $id = 0) {
        $request->validate([
            'education_level_id'  => 'required',
            'education_degree_id' => 'required',
            'education_group_id'  => 'required',
            'institute'           => 'required|string|max:255',
            'scale'               => 'required|integer|gt:0',
            'duration'            => 'required|string|max:40',
            'passing_year'        => 'required|date_format:Y',
            'cgpa_or_marks'       => [
                'required',
                'numeric',
                'gt:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($value > $request->input('scale')) {
                        $fail('The ' . keyToTitle($attribute) . ' must not be greater than to the scale.');
                    }
                },
            ],
        ]);

        $user = authUser();
        if ($id) {
            $education = EducationalQualification::where('user_id', $user->id)->findOrFail($id);
            $message   = "Education qualification updated successfully";
        } else {
            $education          = new EducationalQualification();
            $education->user_id = $user->id;
            $message            = "Education qualification added successfully";
        }

        if (!EducationLevel::where('id', $request->education_level_id)->exists()) {
            $newEducationLevel       = new EducationLevel();
            $newEducationLevel->name = $request->education_level_id;
            $newEducationLevel->save();

            $educationLevelId = $newEducationLevel->id;
        } else {
            $educationLevelId = $request->education_level_id;
        }

        if (!EducationDegree::where('id', $request->education_degree_id)->exists()) {
            $newEducationDegree                     = new EducationDegree();
            $newEducationDegree->education_level_id = $educationLevelId;
            $newEducationDegree->name               = $request->education_degree_id;
            $newEducationDegree->save();

            $educationDegreeId = $newEducationDegree->id;
        } else {
            $educationDegreeId = $request->education_degree_id;
        }

        if (!EducationGroup::where('id', $request->education_group_id)->exists()) {
            $newEducationGroup       = new EducationGroup();
            $newEducationGroup->name = $request->education_group_id;
            $newEducationGroup->save();

            $educationGroupId = $newEducationGroup->id;
        } else {
            $educationGroupId = $request->education_group_id;
        }

        $education->education_level_id  = $educationLevelId;
        $education->education_degree_id = $educationDegreeId;
        $education->education_group_id  = $educationGroupId;
        $education->institute           = $request->institute;
        $education->cgpa_or_marks       = $request->cgpa_or_marks;
        $education->scale               = $request->scale;
        $education->duration            = $request->duration;
        $education->passing_year        = $request->passing_year;
        $education->save();

        $profileUpdatePercentList = $user->profile_update_percent_list;
        if (@$profileUpdatePercentList['education']) {
            $user->profile_update_percent += $profileUpdatePercentList['education'];
            unset($profileUpdatePercentList['education']);
            $user->profile_update_percent_list = $profileUpdatePercentList;
        }
        $user->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function delete($id) {
        $user      = authUser();
        $education = EducationalQualification::where('user_id', $user->id)->findOrFail($id);
        $education->delete();

        if (EducationalQualification::where('user_id', $user->id)->count() <= 0) {
            $profileUpdatePercentList              = $user->profile_update_percent_list;
            $profileUpdatePercentList['education'] = gs('resume_percentage')['education'];
            $user->profile_update_percent -= gs('resume_percentage')['education'];
            $user->profile_update_percent_list = $profileUpdatePercentList;
            $user->save();
        }

        $notify[] = ['success', 'Education qualification deleted successfully'];
        return back()->withNotify($notify);
    }
}
