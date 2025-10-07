<?php

namespace App\Http\Controllers;

use App\Models\User;

class CandidateController extends Controller
{
    public function candidateProfile($id = 0)
    {
        $pageTitle = 'Profile';
        if ($id && auth()->guard('employer')->check()) {
            $user = User::findOrFail($id);
        } else {
            $user = authUser();
        }
        return view('Template::profile_view', compact('pageTitle', 'user'));
    }

    public function resumeDownload($id = 0)
    {
        if ($id && auth()->guard('employer')->check()) {
            $user = User::findOrFail($id);
            $user->resume_download += 1;
            $user->save();
        } else {
            $user = authUser();
        }
        if ($user->resume) {
            return response()->download(getFilePath('resume') . '/' . $user->resume);
        }
        abort(404);
    }
}
