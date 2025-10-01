<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\EmploymentHistory;
use App\Models\Type;
use Illuminate\Http\Request;

class EmploymentController extends Controller {
    public function index() {
        $pageTitle   = "Employment history";
        $employments = EmploymentHistory::where('user_id', auth()->id())->orderByDesc('id')->get();
        $types       = Type::active()->orderByDesc('id')->get();
        return view('Template::user.employment.index', compact('pageTitle', 'employments', 'types'));
    }

    public function save(Request $request, $id = 0) {
        $request->validate([
            'company_name'     => 'required|string|max:255',
            'designation'      => 'required|string|max:255',
            'department'       => 'required|string|max:255',
            'currently_work'   => 'required|in:' . Status::YES . ',' . Status::NO,
            'start_date'       => 'required|date',
            'end_date'         => 'nullable|required_if:currently_work,' . Status::NO . '|date|after:start_date',
            'type'             => 'required|integer|exists:types,id',
            'responsibilities' => 'required',
        ], [
            'end_date.required_if' => 'The end date field is required',
        ]);

        $user = authUser();
        if ($id) {
            $employment = EmploymentHistory::where('user_id', $user->id)->findOrFail($id);
            $message    = "Employment updated successfully";
        } else {
            $employment          = new EmploymentHistory();
            $employment->user_id = $user->id;
            $message             = "Employment added successfully";
        }

        $employment->company_name     = $request->company_name;
        $employment->designation      = $request->designation;
        $employment->department       = $request->department;
        $employment->start_date       = $request->start_date;
        $employment->end_date         = $request->end_date;
        $employment->currently_work   = $request->currently_work;
        $employment->type_id          = $request->type;
        $employment->responsibilities = $request->responsibilities;
        $employment->save();

        $profileUpdatePercentList = $user->profile_update_percent_list;
        if (@$profileUpdatePercentList['company_job_title']) {
            $user->profile_update_percent += $profileUpdatePercentList['company_job_title'];
            unset($profileUpdatePercentList['company_job_title']);
            $user->profile_update_percent_list = $profileUpdatePercentList;
        }
        $user->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function delete($id) {
        $user       = authUser();
        $employment = EmploymentHistory::where('user_id', $user->id)->findOrFail($id);
        $employment->delete();

        if (EmploymentHistory::where('user_id', $user->id)->count() <= 0) {
            $profileUpdatePercentList                      = $user->profile_update_percent_list;
            $profileUpdatePercentList['company_job_title'] = gs('resume_percentage')['company_job_title'];
            $user->profile_update_percent -= gs('resume_percentage')['company_job_title'];
            $user->profile_update_percent_list = $profileUpdatePercentList;
            $user->save();
        }

        $notify[] = ['success', 'Employment history deleted successfully'];
        return back()->withNotify($notify);
    }
}
