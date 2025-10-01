<?php

namespace App\Http\Controllers\User;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\EducationalQualification;
use App\Models\EducationGroup;
use App\Models\EducationLevel;
use App\Models\EmploymentHistory;
use App\Models\Industry;
use App\Models\Location;
use App\Models\Shift;
use App\Models\Skill;
use App\Models\Type;
use App\Models\UserCertification;
use App\Models\UserItSkill;
use App\Models\UserLanguage;
use App\Models\UserOnlineProfile;
use App\Models\UserPatent;
use App\Models\UserPresentation;
use App\Models\UserProject;
use App\Models\UserPublication;
use App\Models\UserSkill;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller {
    public function profileSetting() {
        $pageTitle      = "Profile Setting";
        $user           = authUser();
        $skills         = Skill::active()->get();
        $employments    = EmploymentHistory::where('user_id', $user->id)->orderByDesc('id')->get();
        $userEducations = EducationalQualification::where('user_id', $user->id)->with(['educationLevel', 'educationDegree', 'educationGroup'])->orderByDesc('id')->get();
        $levels         = EducationLevel::active()->with('educationDegrees')->orderByDesc('id')->get();
        $groups         = EducationGroup::active()->orderByDesc('id')->get();
        $industries     = Industry::active()->orderByDesc('id')->get();
        $departments    = Department::active()->orderByDesc('id')->get();
        $shifts         = Shift::active()->orderByDesc('id')->get();
        $cities         = Location::active()->city()->orderByDesc('id')->get();
        $types          = Type::active()->orderByDesc('id')->get();
        return view('Template::user.profile_setting', compact('pageTitle', 'user', 'skills', 'employments', 'levels', 'groups', 'userEducations', 'industries', 'departments', 'shifts', 'cities', 'types'));
    }

    public function basicDetailsUpdate(Request $request) {
        $workStatus     = [Status::WORK_STATUS_FRESHER, Status::WORK_STATUS_EXPERIENCE];
        $availableToJob = [Status::IMMEDIATE, Status::ONE_MONTH, Status::TWO_MONTH, Status::MORE_THEN_TWO_MONTH];
        $request->validate([
            'firstname'           => 'required|string|max:40',
            'lastname'            => 'required|string|max:40',
            'work_status'         => 'required|integer|in:' . implode(',', $workStatus),
            'available_to_job'    => 'required|integer|in:' . implode(',', $availableToJob),
            'year_of_experience'  => 'required_if:work_status,' . Status::WORK_STATUS_EXPERIENCE,
            'month_of_experience' => 'required_if:work_status,' . Status::WORK_STATUS_EXPERIENCE,
            'current_salary'      => 'required_if:work_status,' . Status::WORK_STATUS_EXPERIENCE,
            'designation'         => 'required_if:work_status,' . Status::WORK_STATUS_EXPERIENCE,
        ]);

        $user                      = authUser();
        $user->firstname           = $request->firstname;
        $user->lastname            = $request->lastname;
        $user->work_status         = $request->work_status;
        $user->available_to_job    = $request->available_to_job;
        $user->year_of_experience  = $request->work_status == Status::WORK_STATUS_FRESHER ? 0 : $request->year_of_experience;
        $user->month_of_experience = $request->work_status == Status::WORK_STATUS_FRESHER ? 0 : $request->month_of_experience;
        $user->current_salary      = $request->work_status == Status::WORK_STATUS_FRESHER ? 0 : $request->current_salary;
        $user->designation         = $request->work_status == Status::WORK_STATUS_FRESHER ? '' : $request->designation;
        $user->save();

        $notify[] = ['success', 'Basic details updated successfully'];
        return back()->withNotify($notify);
    }

    public function resumeHeadlineUpdate(Request $request) {
        $request->validate([
            'resume_headline' => 'required|string|max:255',
        ]);

        $user                     = authUser();
        $user->resume_headline    = $request->resume_headline;
        $profileUpdatePercentList = $user->profile_update_percent_list;
        if (@$profileUpdatePercentList['resume_headline']) {
            $user->profile_update_percent += $profileUpdatePercentList['resume_headline'];
            unset($profileUpdatePercentList['resume_headline']);
            $user->profile_update_percent_list = $profileUpdatePercentList;
        }
        $user->save();

        $notify[] = ['success', 'Resume headline updated successfully'];
        return back()->withNotify($notify);
    }

    public function skillUpdate(Request $request, $id = null) {
        $request->validate([
            'skill_id'  => 'required|integer|exists:skills,id',
            'expertise' => 'required|integer|gt:0|lte:100',
        ]);

        $user     = authUser();
        $isExists = UserSkill::where('user_id', $user->id)->where('skill_id', $request->skill_id)->exists();
        if ($id) {
            $userSkill = UserSkill::where('user_id', $user->id)->findOrFail($id);
            if ($isExists && $request->skill_id != $userSkill->skill_id) {
                $notify[] = ['error', 'You already added this skill.'];
                return back()->withNotify($notify);
            }
            $message = 'Skill updated successfully';
        } else {
            if ($isExists) {
                $notify[] = ['error', 'You already added this skill.'];
                return back()->withNotify($notify);
            }
            $userSkill          = new UserSkill();
            $userSkill->user_id = $user->id;
            $message            = 'Skill added successfully';
        }
        $userSkill->skill_id  = $request->skill_id;
        $userSkill->expertise = $request->expertise;
        $userSkill->save();

        $profileUpdatePercentList = $user->profile_update_percent_list;
        if (@$profileUpdatePercentList['skill']) {
            $user->profile_update_percent += $profileUpdatePercentList['skill'];
            unset($profileUpdatePercentList['skill']);
            $user->profile_update_percent_list = $profileUpdatePercentList;
        }
        $user->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function skillDelete($id) {
        $user      = authUser();
        $userSkill = UserSkill::where('user_id', $user->id)->findOrFail($id);
        $userSkill->delete();

        if (UserSkill::where('user_id', $user->id)->count() <= 0) {
            $profileUpdatePercentList          = $user->profile_update_percent_list;
            $profileUpdatePercentList['skill'] = gs('resume_percentage')['skill'];
            $user->profile_update_percent -= gs('resume_percentage')['skill'];
            $user->profile_update_percent_list = $profileUpdatePercentList;
            $user->save();
        }

        $notify[] = ['success', 'Skill deleted successfully'];
        return back()->withNotify($notify);
    }

    public function itSkillUpdate(Request $request, $id = null) {
        $request->validate([
            'name'      => 'required|string|max:255',
            'version'   => 'required|string',
            'last_used' => 'required|integer',
            'year'      => 'required|integer',
            'month'     => 'required|integer',
        ]);

        $user = authUser();

        if ($id) {
            $userItSkill = UserItSkill::where('user_id', $user->id)->findOrFail($id);
            $message     = 'IT skill updated successfully';
        } else {
            $userItSkill          = new UserItSkill();
            $userItSkill->user_id = $user->id;
            $message              = 'IT skill added successfully';
        }
        $userItSkill->name      = $request->name;
        $userItSkill->version   = $request->version;
        $userItSkill->last_used = $request->last_used;
        $userItSkill->year      = $request->year;
        $userItSkill->month     = $request->month;
        $userItSkill->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function itSkillDelete($id) {
        $user        = authUser();
        $userItSkill = UserItSkill::where('user_id', $user->id)->findOrFail($id);
        $userItSkill->delete();

        $notify[] = ['success', 'IT skill deleted successfully'];
        return back()->withNotify($notify);
    }

    public function projectStore(Request $request, $id = null) {
        $request->validate([
            'title'    => 'required|string|max:255',
            'details'  => 'required',
            'link'     => 'nullable|string|max:255',
            'duration' => 'required|integer|gt:0',
            'status'   => 'required|integer|in:' . Status::PROJECT_RUNNING . ',' . Status::PROJECT_COMPLETED,
        ]);

        $user = authUser();
        if ($id) {
            $project = UserProject::where('user_id', $user->id)->findOrFail($id);
            $message = 'Project updated successfully';
        } else {
            $project          = new UserProject();
            $project->user_id = $user->id;
            $message          = 'Project added successfully';
        }

        $project->title    = $request->title;
        $project->details  = $request->details;
        $project->link     = $request->link;
        $project->duration = $request->duration;
        $project->status   = $request->status;
        $project->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function projectDelete($id) {
        $user    = authUser();
        $project = UserProject::where('user_id', $user->id)->findOrFail($id);
        $project->delete();

        $notify[] = ['success', 'Project deleted successfully'];
        return back()->withNotify($notify);
    }

    public function summaryStore(Request $request) {
        $request->validate([
            'summary' => 'required|string',
        ]);

        $user                     = authUser();
        $user->summary            = $request->summary;
        $profileUpdatePercentList = $user->profile_update_percent_list;
        if (@$profileUpdatePercentList['summary']) {
            $user->profile_update_percent += $profileUpdatePercentList['summary'];
            unset($profileUpdatePercentList['summary']);
            $user->profile_update_percent_list = $profileUpdatePercentList;
        }
        $user->save();

        $notify[] = ['success', 'Summary updated successfully'];
        return back()->withNotify($notify);
    }

    public function onlineProfileStore(Request $request, $id = null) {
        $request->validate([
            'social_media_name' => 'required|string|max:40',
            'link'              => 'required|string|max:40',
        ]);

        $user = authUser();
        if ($id) {
            $userOnlineProfile = UserOnlineProfile::where('user_id', $user->id)->findOrFail($id);
            $message           = 'Online profile updated successfully';
        } else {
            $userOnlineProfile          = new UserOnlineProfile();
            $userOnlineProfile->user_id = $user->id;
            $message                    = 'Online profile added successfully';
        }
        $userOnlineProfile->social_media_name = $request->social_media_name;
        $userOnlineProfile->link              = $request->link;
        $userOnlineProfile->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function onlineProfileDelete($id) {
        $user              = authUser();
        $userOnlineProfile = UserOnlineProfile::where('user_id', $user->id)->findOrFail($id);
        $userOnlineProfile->delete();

        $notify[] = ['success', 'Online profile deleted successfully'];
        return back()->withNotify($notify);
    }

    public function publicationStore(Request $request, $id = null) {
        $request->validate([
            'title'               => 'required|string|max:255',
            'url'                 => 'required|url|max:255',
            'publication_details' => 'required|string',
            'published_date'      => 'required|date_format:Y-m-d',
        ]);

        $user = authUser();
        if ($id) {
            $publication = UserPublication::where('user_id', $user->id)->findOrFail($id);
            $message     = 'Publication updated successfully';
        } else {
            $publication          = new UserPublication();
            $publication->user_id = $user->id;
            $message              = 'Publication added successfully';
        }
        $publication->title               = $request->title;
        $publication->url                 = $request->url;
        $publication->publication_details = $request->publication_details;
        $publication->published_date      = $request->published_date;
        $publication->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function publicationDelete($id) {
        $user        = authUser();
        $publication = UserPublication::where('user_id', $user->id)->findOrFail($id);
        $publication->delete();

        $notify[] = ['success', 'Publication deleted successfully'];
        return back()->withNotify($notify);
    }

    public function presentationStore(Request $request, $id = null) {
        $request->validate([
            'title'       => 'required|string|max:255',
            'url'         => 'required|url|max:255',
            'description' => 'required|string',
        ]);

        $user = authUser();
        if ($id) {
            $presentation = UserPresentation::where('user_id', $user->id)->findOrFail($id);
            $message      = 'Presentation updated successfully';
        } else {
            $presentation          = new UserPresentation();
            $presentation->user_id = $user->id;
            $message               = 'Presentation added successfully';
        }
        $presentation->title       = $request->title;
        $presentation->url         = $request->url;
        $presentation->description = $request->description;
        $presentation->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function presentationDelete($id) {
        $user         = authUser();
        $presentation = UserPresentation::where('user_id', $user->id)->findOrFail($id);
        $presentation->delete();

        $notify[] = ['success', 'Presentation deleted successfully'];
        return back()->withNotify($notify);
    }

    public function patentStore(Request $request, $id = null) {
        $request->validate([
            'title'              => 'required|string|max:255',
            'url'                => 'required|url|max:255',
            'application_number' => 'required|string|max:40',
            'status'             => 'required|in:' . Status::PATENT_ISSUED . ',' . Status::PATENT_PENDING,
            'details'            => 'required|string',
            'issued_date'        => 'nullable|required_if:status,' . Status::PATENT_ISSUED,
        ]);

        $user = authUser();
        if ($id) {
            $patent  = UserPatent::where('user_id', $user->id)->findOrFail($id);
            $message = 'Patent updated successfully';
        } else {
            $patent          = new UserPatent();
            $patent->user_id = $user->id;
            $message         = 'Patent added successfully';
        }
        $patent->title              = $request->title;
        $patent->url                = $request->url;
        $patent->application_number = $request->application_number;
        $patent->status             = $request->status;
        $patent->details            = $request->details;
        $patent->issued_date        = $request->status == Status::PATENT_ISSUED ? $request->issued_date : null;
        $patent->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function patentDelete($id) {
        $user   = authUser();
        $patent = UserPatent::where('user_id', $user->id)->findOrFail($id);
        $patent->delete();

        $notify[] = ['success', 'Patent deleted successfully'];
        return back()->withNotify($notify);
    }

    public function careerProfileUpdate(Request $request) {
        $request->validate([
            'industry_id'      => 'nullable|integer|exists:industries,id',
            'department_id'    => 'nullable|integer|exists:departments,id',
            'desired_job_type' => 'nullable|integer|in:' . Status::PERMANENT . ',' . Status::CONTRACTUAL,
            'type_id'          => 'nullable|integer|exists:types,id',
            'shift_id'         => 'nullable|integer|exists:shifts,id',
            'location_id'      => 'nullable|integer|exists:locations,id',
            'expected_salary'  => 'nullable|numeric|gt:0',
        ]);
        $user                   = authUser();
        $user->industry_id      = $request->industry_id;
        $user->department_id    = $request->department_id;
        $user->desired_job_type = $request->desired_job_type;
        $user->type_id          = $request->type_id;
        $user->shift_id         = $request->shift_id;
        $user->location_id      = $request->location_id;
        $user->expected_salary  = $request->expected_salary;

        $profileUpdatePercentList = $user->profile_update_percent_list;
        if (@$profileUpdatePercentList['preferred_location'] && $request->location_id) {
            $user->profile_update_percent += $profileUpdatePercentList['preferred_location'];
            unset($profileUpdatePercentList['preferred_location']);
        }
        if (@$profileUpdatePercentList['department'] && $request->department_id) {
            $user->profile_update_percent += $profileUpdatePercentList['department'];
            unset($profileUpdatePercentList['department']);
        }
        if (@$profileUpdatePercentList['industry_type'] && $request->industry_id) {
            $user->profile_update_percent += $profileUpdatePercentList['industry_type'];
            unset($profileUpdatePercentList['industry_type']);
        }
        $user->profile_update_percent_list = $profileUpdatePercentList;
        $user->save();

        $notify[] = ['success', 'Career profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function permanentAddressUpdate(Request $request) {
        $request->validate([
            'address' => 'required|string|max:255',
            'state'   => 'required|string|max:40',
            'city'    => 'required|string|max:40',
            'zip'     => 'required|string|max:40',
            'country' => 'required|string|max:40',
        ]);

        $user = authUser();
        $data = [
            'address' => $request->address,
            'state'   => $request->state,
            'city'    => $request->city,
            'zip'     => $request->zip,
            'country' => $request->country,
        ];
        $user->permanent_address = $data;
        $user->save();

        $notify[] = ['success', 'Permanent address updated successfully'];
        return back()->withNotify($notify);
    }

    public function presentAddressUpdate(Request $request) {
        $request->validate([
            'address' => 'required|string|max:255',
            'state'   => 'required|string|max:255',
            'city'    => 'required|string|max:255',
            'zip'     => 'required|string|max:40',
        ]);

        $user          = authUser();
        $user->address = $request->address;
        $user->state   = $request->state;
        $user->city    = $request->city;
        $user->zip     = $request->zip;
        $user->save();

        $notify[] = ['success', 'Present address updated successfully'];
        return back()->withNotify($notify);
    }

    public function languageStore(Request $request, $id = null) {
        $request->validate([
            'name'        => 'required|string|max:40',
            'proficiency' => 'required|integer|in:' . Status::LANGUAGE_BEGINNER . ',' . Status::LANGUAGE_PROFICIENT . ',' . Status::LANGUAGE_EXPERT,
        ]);

        $user     = authUser();
        $isExists = UserLanguage::where('user_id', $user->id)->where('name', $request->name)->exists();
        if ($id) {
            $language = UserLanguage::where('user_id', $user->id)->findOrFail($id);
            if ($isExists && $language->name != $request->name) {
                $notify[] = ['error', 'You already added this language'];
                return back()->withNotify($notify);
            }
            $message = 'Language updated successfully';
        } else {
            if ($isExists) {
                $notify[] = ['error', 'You already added this language'];
                return back()->withNotify($notify);
            }
            $language          = new UserLanguage();
            $language->user_id = $user->id;
            $message           = 'Language added successfully';
        }
        $language->name        = $request->name;
        $language->proficiency = $request->proficiency;
        $language->is_read     = $request->is_read ? Status::YES : Status::NO;
        $language->is_write    = $request->is_write ? Status::YES : Status::NO;
        $language->is_speak    = $request->is_speak ? Status::YES : Status::NO;
        $language->save();

        $profileUpdatePercentList = $user->profile_update_percent_list;
        if (@$profileUpdatePercentList['language']) {
            $user->profile_update_percent += $profileUpdatePercentList['language'];
            unset($profileUpdatePercentList['language']);
            $user->profile_update_percent_list = $profileUpdatePercentList;
        }
        $user->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function languageDelete($id) {
        $user     = authUser();
        $language = UserLanguage::where('user_id', $user->id)->findOrFail($id);
        $language->delete();

        if (UserLanguage::where('user_id', $user->id)->count() <= 0) {
            $profileUpdatePercentList             = $user->profile_update_percent_list;
            $profileUpdatePercentList['language'] = gs('resume_percentage')['language'];
            $user->profile_update_percent -= gs('resume_percentage')['language'];
            $user->profile_update_percent_list = $profileUpdatePercentList;
            $user->save();
        }

        $notify[] = ['success', 'Language deleted successfully'];
        return back()->withNotify($notify);
    }

    public function certificationStore(Request $request, $id = null) {
        $request->validate([
            'name'      => 'required|string|max:255',
            'institute' => 'required|string|max:255',
            'location'  => 'required|string|max:255',
            'duration'  => 'required|integer|gt:0',
        ]);

        $user = authUser();
        if ($id) {
            $certification = UserCertification::where('user_id', $user->id)->findOrFail($id);
            $message       = 'Certification updated successfully';
        } else {
            $certification          = new UserCertification();
            $certification->user_id = $user->id;
            $message                = 'Certification added successfully';
        }
        $certification->name      = $request->name;
        $certification->institute = $request->institute;
        $certification->location  = $request->location;
        $certification->duration  = $request->duration;
        $certification->save();

        $notify[] = ['success', $message];
        return back()->withNotify($notify);
    }

    public function certificationDelete($id) {
        $user          = authUser();
        $certification = UserCertification::where('user_id', $user->id)->findOrFail($id);
        $certification->delete();

        $notify[] = ['success', 'Certification deleted successfully'];
        return back()->withNotify($notify);
    }

    public function personalDetailsUpdate(Request $request) {
        $bloodGroup = ['A +', 'A -', 'B +', 'B -', 'O +', 'O -', 'AB +', 'AB -'];
        $request->validate([
            'gender'         => 'required|in:' . Status::MALE . ',' . Status::FEMALE . ',' . Status::OTHERS,
            'married_status' => 'required|in:' . Status::SINGLE . ',' . Status::MARRIED . ',' . Status::DIVORCED . ',' . Status::SEPARATED,
            'career_break'   => 'required|in:' . Status::YES . ',' . Status::NO,
            'birth_date'     => 'required|date_format:Y-m-d|before:today',
            'national_id'    => 'nullable|string|max:255',
            'blood_group'    => 'required|string|in:' . implode(',', $bloodGroup),
        ]);

        $user                 = authUser();
        $user->gender         = $request->gender;
        $user->married_status = $request->married_status;
        $user->career_break   = $request->career_break;
        $user->birth_date     = $request->birth_date;
        $user->blood_group    = $request->blood_group;
        $user->national_id    = $request->national_id;

        $profileUpdatePercentList = $user->profile_update_percent_list;
        if (@$profileUpdatePercentList['personal_detail']) {
            $user->profile_update_percent += $profileUpdatePercentList['personal_detail'];
            unset($profileUpdatePercentList['personal_detail']);
        }
        $user->profile_update_percent_list = $profileUpdatePercentList;
        $user->save();

        $notify[] = ['success', 'Personal details updated successfully'];
        return back()->withNotify($notify);
    }

    public function resumeUpdate(Request $request) {
        $request->validate([
            'resume' => ['required', new FileTypeValidate(['pdf', 'docx', 'doc', 'rtf']), 'max:2048'],
        ], [
            'resume.max' => 'The resume must not exceed 2 MB.',
        ]);
        $user = authUser();
        if ($request->hasFile('resume')) {
            try {
                $originalFileName = $request->resume->getClientOriginalName();
                $user->resume     = fileUploader($request->resume, getFilePath('resume'), old: $user->resume, filename: $originalFileName);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload language image'];
                return back()->withNotify($notify);
            }
        }
        $profileUpdatePercentList = $user->profile_update_percent_list;
        if (@$profileUpdatePercentList['resume']) {
            $user->profile_update_percent += $profileUpdatePercentList['resume'];
            unset($profileUpdatePercentList['resume']);
        }
        $user->profile_update_percent_list = $profileUpdatePercentList;
        $user->save();

        $notify[] = ['success', 'Resume update successfully'];
        return back()->withNotify($notify);
    }

    public function resumeDownload() {
        $user = authUser();
        if ($user->resume) {
            if (!file_exists(getFilePath('resume') . '/' . $user->resume)) {
                $notify[] = ['error', 'Resume download failed'];
                return back()->withNotify($notify);
            }
            return response()->download(getFilePath('resume') . '/' . $user->resume);
        }
        abort(404);
    }

    public function resumeDelete() {
        $user = authUser();
        if (!file_exists(getFilePath('resume') . '/' . $user->resume)) {
            $notify[] = ['error', 'Resume delete failed'];
            return back()->withNotify($notify);
        }
        unlink(getFilePath('resume') . '/' . $user->resume);
        $user->resume                       = null;
        $profileUpdatePercentList           = $user->profile_update_percent_list;
        $profileUpdatePercentList['resume'] = gs('resume_percentage')['resume'];
        $user->profile_update_percent -= gs('resume_percentage')['resume'];
        $user->profile_update_percent_list = $profileUpdatePercentList;
        $user->save();

        $notify[] = ['success', 'Resume deleted successfully'];
        return back()->withNotify($notify);
    }

    public function imageStore(Request $request) {
        $request->validate([
            'image' => ['required', 'image', new FileTypeValidate(['jpg', 'png', 'jpeg'])],
        ]);

        $user = authUser();
        if ($request->hasFile('image')) {
            try {
                $user->image = fileUploader($request->image, getFilePath('userProfile'), getFileSize('userProfile'), $user->image);
            } catch (\Exception $exp) {
                $notify[] = ['error', 'Couldn\'t upload image'];
                return back()->withNotify($notify);
            }
        }
        $profileUpdatePercentList = $user->profile_update_percent_list;
        if (@$profileUpdatePercentList['photo_upload']) {
            $user->profile_update_percent += $profileUpdatePercentList['photo_upload'];
            unset($profileUpdatePercentList['photo_upload']);
            $user->profile_update_percent_list = $profileUpdatePercentList;
        }
        $user->save();

        $notify[] = ['success', 'Profile image uploaded successfully'];
        return back()->withNotify($notify);
    }

    public function submitProfile(Request $request) {
        $request->validate([
            'firstname'       => 'required|string',
            'lastname'        => 'required|string',
            'designation'     => 'required|string',
            'gender'          => 'required|in:1,2',
            'married_status'  => 'required|in:1,2,3,4',
            'birth_date'      => 'required|date_format:Y-m-d|before:today',
            'national_id'     => 'required',
            'career_summary'  => 'required',
            'social_links'    => 'nullable|array',
            'social_links.*.' => 'nullable|url',
            'skill'           => 'nullable|array',
            'skill.*.'        => 'nullable|exists:skills,id',
            'language'        => 'nullable|array',
        ], [
            'firstname.required' => 'First name field is required',
            'lastname.required'  => 'Last name field is required',
            'birth_date.before'  => 'The birthday date must be a past date',
        ]);

        $user = authUser();

        $carrierSummary           = $request->career_summary;
        $user->firstname          = $request->firstname;
        $user->lastname           = $request->lastname;
        $user->designation        = $request->designation;
        $user->gender             = $request->gender;
        $user->married_status     = $request->married_status;
        $user->address            = $request->address;
        $user->city               = $request->city;
        $user->state              = $request->state;
        $user->zip                = $request->zip;
        $user->skill              = $request->skill ?? null;
        $user->social_links       = $request->social_links ?? null;
        $user->language           = $request->language ?? null;
        $user->national_id        = $request->national_id;
        $user->birth_date         = $request->birth_date;
        $user->career_information = $carrierSummary;
        $user->save();
        $notify[] = ['success', 'Profile updated successfully'];
        return back()->withNotify($notify);
    }

    public function changePassword() {
        $pageTitle = 'Change Password';
        return view('Template::user.password', compact('pageTitle'));
    }

    public function submitPassword(Request $request) {
        $passwordValidation = Password::min(6);
        if (gs('secure_password')) {
            $passwordValidation = $passwordValidation->mixedCase()->numbers()->symbols()->uncompromised();
        }

        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', $passwordValidation],
        ]);

        $user = authUser();
        if (Hash::check($request->current_password, $user->password)) {
            $password       = Hash::make($request->password);
            $user->password = $password;
            $user->save();
            $notify[] = ['success', 'Password changed successfully'];
            return back()->withNotify($notify);
        } else {
            $notify[] = ['error', 'The password doesn\'t match!'];
            return back()->withNotify($notify);
        }
    }

    public function updateImage(Request $request) {
        $imageSize      = getFileSize('user');
        $imagePath      = getFilePath('user');
        $validationSize = explode('x', $imageSize);

        $validator = Validator::make($request->all(), [
            'profile_image' => ['required', new FileTypeValidate(['jpg', 'jpeg', 'png']), "dimensions:width=$validationSize[0],height=$validationSize[1]"],
        ], [
            'profile_image.dimensions' => "Image size must be $imageSize" . "px",
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all(),
            ]);
        }
        $user = authUser();
        try {
            $user->image = fileUploader($request->profile_image, $imagePath, $imageSize, $user->image);
            $user->save();
            return response()->json([
                'success'    => true,
                'message'    => 'Profile image updated successfully',
                'image_name' => $user->image,
            ]);
        } catch (\Exception $exp) {
            return response()->json([
                'success' => false,
                'message' => "Couldn\'t upload your image",
            ]);
        }
    }
}
