<?php

namespace App\Http\Controllers\Employer;

use App\Constants\Status;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobApply;
use App\Models\JobKeyword;
use App\Models\Keyword;
use App\Models\Location;
use App\Models\Role;
use App\Models\SalaryPeriod;
use App\Models\Shift;
use App\Models\Skill;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Type;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JobController extends Controller {
    public function index() {
        $pageTitle = "Jobs List";
        $employer  = authUser('employer');
        $jobs      = Job::where('employer_id', $employer->id)->searchable(['title'])->filter(['status'])->with('category', 'shift', 'type', 'favoriteItems')->withCount('jobApplication as total_apply')->withCount('favoriteItems as total_favorite')->latest()->paginate(getPaginate());
        return view('Template::employer.job.index', compact('employer', 'pageTitle', 'jobs'));
    }

    public function create($step = 0, $slug = null, $jobId = 0) {
        $employer     = authUser('employer');
        $subscription = Subscription::where('employer_id', $employer->id)->approved()->first();
        if ((gs('free_job_post') && $employer->free_job_post_limit > 0) || $subscription || gs('job_post_payment')) {
            $pageTitle     = "Create Job";
            $cities        = Location::city()->active()->orderBy('name')->with('address')->get();
            $types         = Type::active()->get();
            $shifts        = Shift::active()->get();
            $skills        = Skill::active()->get();
            $categories    = Category::active()->get();
            $experiences   = Experience::active()->get();
            $salaryPeriods = SalaryPeriod::active()->get();
            $keywords      = Keyword::get();
            $roles         = Role::active()->get();

            $job              = null;
            $selectedKeywords = null;

            if ($jobId) {
                $job              = Job::where('id', $jobId)->where('employer_id', $employer->id)->firstOrFail();
                $step             = $job->step;
                $selectedKeywords = $job->jobKeywords()->pluck('keyword')->toArray();
            }

            return view('Template::employer.job.form', compact('pageTitle', 'cities', 'types', 'shifts', 'skills', 'categories', 'experiences', 'salaryPeriods', 'keywords', 'roles', 'subscription', 'step', 'job', 'selectedKeywords'));
        } else {
            $notify[] = ['error', 'You have to subscribe to a plan first'];
            return to_route('employer.plan.index')->withNotify($notify);
        }
    }

    public function edit($id) {
        $employer         = authUser('employer');
        $job              = Job::where('id', $id)->where('employer_id', $employer->id)->firstOrFail();
        $step             = $job->step;
        $pageTitle        = "Edit Job";
        $cities           = Location::city()->active()->orderBy('name')->with('address')->get();
        $types            = Type::active()->get();
        $shifts           = Shift::active()->get();
        $skills           = Skill::active()->get();
        $categories       = Category::active()->get();
        $experiences      = Experience::active()->get();
        $salaryPeriods    = SalaryPeriod::active()->get();
        $locations        = Location::where('parent_id', $job->city_id)->get();
        $keywords         = Keyword::get();
        $roles            = Role::active()->get();
        $selectedKeywords = $job->jobKeywords()->pluck('keyword')->toArray();

        return view('Template::employer.job.form', compact('job', 'pageTitle', 'cities', 'types', 'shifts', 'skills', 'categories', 'experiences', 'salaryPeriods', 'locations', 'keywords', 'selectedKeywords', 'roles', 'step'));
    }

    public function basic(Request $request, $id = 0, $edit = false) {
        $request->validate([
            'title'             => 'required|max:255',
            'category_id'       => 'required|exists:categories,id',
            'role_id'           => 'required|exists:roles,id',
            'type_id'           => 'required|exists:types,id',
            'job_location_type' => 'required|in:' . Status::ONSITE . ',' . Status::REMOTE . ',' . Status::FIELD . ',' . Status::HYBRID,
            'city_id'           => 'required|exists:locations,id',
            'location_id'       => 'required|exists:locations,id',
        ]);

        $employer = authUser('employer');

        if ($id) {
            $job = Job::where('id', $id)->where('employer_id', $employer->id)->firstOrFail();
        } else {
            $job = new Job();

            $subscription = Subscription::where('employer_id', $employer->id)->whereHas('employer', function ($employer) {
                $employer->where('job_post_count', '>', 0);
            })->whereDate('expired_date', '>', now()->format('Y-m-d'))->approved()->first();

            if (gs('free_job_post') && $employer->free_job_post_limit > 0) {
                $job->amount = 0;
                $employer->free_job_post_limit -= 1;
                $employer->save();
                $notify[] = self::postJobs($job, $employer, isFree: true);

            } else if ($subscription || (!$subscription && $employer->balance >= gs('fee_per_job_post') && gs('job_post_payment'))) {
                $job->amount = gs('fee_per_job_post');
                if ($subscription) {
                    $employer->job_post_count -= 1;
                    $employer->save();
                    $job->amount = 0;
                }
                $notify[] = self::postJobs($job, $employer, balance: !$subscription ? true : false);
            } else {
                if (gs('job_post_payment') && $employer->balance < gs('fee_per_job_post')) {
                    $job->redirect_payment = Status::YES;
                    $job->amount           = gs('fee_per_job_post');
                } else {
                    $notify[] = ['error', 'You have to subscribe to a plan first'];
                    return to_route('employer.plan.index')->withNotify($notify);
                }
            }
        }

        $job->employer_id       = $employer->id;
        $job->title             = $request->title;
        $job->category_id       = $request->category_id;
        $job->role_id           = $request->role_id;
        $job->type_id           = $request->type_id;
        $job->city_id           = $request->city_id;
        $job->location_id       = $request->location_id;
        $job->job_location_type = $request->job_location_type;
        $job->slug              = slug($request->title . '-' . time());
        $job->step              = Status::JOB_STEP_INFORMATION;
        $job->save();

        return to_route('employer.job.create', ['step' => Status::JOB_STEP_INFORMATION, 'slug' => $job->slug, 'jobId' => $job->id, 'edit' => $edit]);
    }

    public function information(Request $request, $id, $edit = false) {
        $request->validate([
            'job_experience_id' => 'required|exists:experiences,id',
            'gender'            => 'required|in:' . Status::ANY_GENDER . ',' . Status::MALE . ',' . Status::FEMALE . ',' . Status::OTHERS . ',' . 0,
            'deadline'          => 'required|date|after_or_equal:today',
            'shift_id'          => 'required|exists:shifts,id',
            'vacancy'           => 'required|integer|gt:0',
            'salary_period'     => 'required|exists:salary_periods,id',
            'min_age'           => 'nullable|integer|gte:0',
            'max_age'           => 'nullable|integer|gt:min_age',
            'salary_type'       => 'required|in:' . Status::NEGOTIATION . ',' . Status::RANGE,
            'salary_from'       => 'nullable|required_if:salary_type,' . Status::RANGE . '|numeric|gte:0',
            'salary_to'         => 'nullable|required_if:salary_type,' . Status::RANGE . '|numeric|gte:salary_from',
            'skills'            => 'required|array',
            'skills.*'          => 'required',
        ], [
            'salary_from.required_if' => 'Minimum salary is required when salary type is Range',
            'salary_to.required_if'   => 'maximum salary to is required when salary type is Range',
            'salary_to.gte'           => 'Minimum salary must be less than maximum salary',
        ]);

        $employer               = authUser('employer');
        $job                    = Job::where('id', $id)->where('employer_id', $employer->id)->firstOrFail();
        $job->job_experience_id = $request->job_experience_id;
        $job->gender            = $request->gender;
        $job->deadline          = Carbon::parse($request->deadline);
        $job->shift_id          = $request->shift_id;
        $job->vacancy           = $request->vacancy;
        $job->salary_period     = $request->salary_period;
        $job->min_age           = $request->min_age;
        $job->max_age           = $request->max_age;
        $job->salary_type       = $request->salary_type;
        $job->salary_from       = $request->salary_from ?? 0;
        $job->salary_to         = $request->salary_to ?? 0;

        foreach ($request->skills as $value) {
            if (!Skill::where('name', $value)->exists()) {
                $skill         = new Skill();
                $skill->name   = $value;
                $skill->status = Status::ENABLE;
                $skill->save();
            }
        }

        $job->skills = $request->skills;
        $job->step   = Status::JOB_STEP_DETAILS;
        $job->save();
        return to_route('employer.job.create', ['step' => Status::JOB_STEP_INFORMATION, 'slug' => $job->slug, 'jobId' => $job->id, 'edit' => $edit]);
    }

    public function details(Request $request, $id, $edit = false) {
        $request->validate([
            'description'       => 'required|string',
            'short_description' => 'required|string|max:255',
            'keywords'          => 'required|array',
            'keywords.*'        => 'required|string|max:255',
        ]);

        $employer               = authUser('employer');
        $job                    = Job::where('id', $id)->where('employer_id', $employer->id)->firstOrFail();
        $job->description       = $request->description;
        $job->short_description = $request->short_description;
        $job->status            = Status::JOB_PENDING;
        $job->save();

        $jobKeywords     = $job->jobKeywords()->pluck('keyword')->toArray();
        $removedKeywords = array_diff($jobKeywords, $request->keywords);
        foreach ($removedKeywords as $keyword) {
            $job->jobKeywords()->detach(Keyword::where('keyword', $keyword)->first()->id);
        }

        foreach ($request->keywords as $keywordName) {
            $keyword = Keyword::where('keyword', $keywordName)->first();
            if (!$keyword) {
                $newKeyword          = new Keyword();
                $newKeyword->keyword = $keywordName;
                $newKeyword->save();

                $job->jobKeywords()->attach($newKeyword->id);
            } else {
                if (!JobKeyword::where('job_id', $job->id)->where('keyword_id', $keyword->id)->exists()) {
                    $job->jobKeywords()->attach($keyword->id);
                }
            }
        }

        if ($edit) {
            $notify[] = ['success', 'Job updated successfully'];
        } else {
            if ($job->redirect_payment) {
                $notify[] = ['error', 'You have to pay ' . showAmount(gs('fee_per_job_post')) . ' to create this job'];
                session()->put('job_id', $job->id);
                return to_route('employer.deposit.index')->withNotify($notify);
            }
            $notify[] = ['success', 'Job created successfully'];
        }

        return to_route('employer.job.index')->withNotify($notify);
    }

    public function store(Request $request, $id = 0) {
        $this->validation($request);
        $employer = authUser('employer');

        if ($id) {
            $notify[] = self::postJobs($request, $employer, $id);
        } else {

            $subscription = Subscription::where('employer_id', $employer->id)->whereHas('employer', function ($employer) {
                $employer->where('job_post_count', '>', 0);
            })->whereDate('expired_date', '>', now()->format('Y-m-d'))->approved()->first();

            if (gs('free_job_post') && $employer->free_job_post_limit > 0) {
                $employer->free_job_post_limit -= 1;
                $employer->save();
                $notify[] = self::postJobs($request, $employer, isFree: true);
            } else if ($subscription || (!$subscription && $employer->balance >= gs('fee_per_job_post') && gs('job_post_payment'))) {
                if ($subscription) {
                    $employer->job_post_count -= 1;
                    $employer->save();
                }
                $notify[] = self::postJobs($request, $employer, balance: !$subscription ? true : false);
            } else {
                if (gs('job_post_payment')) {
                    if ($employer->balance < gs('fee_per_job_post')) {
                        $notify[] = ['error', 'You have to pay ' . showAmount(gs('fee_per_job_post')) . ' to create this job'];
                        session()->put('JOB_DATA', $request->all());
                        return to_route('employer.deposit.index')->withNotify($notify);
                    }
                } else {
                    $notify[] = ['error', 'You have to subscribe to a plan first'];
                    return to_route('employer.plan.index')->withNotify($notify);
                }
            }
        }
        return to_route('employer.job.index')->withNotify($notify);
    }

    public static function postJobs($job, $employer, $balance = false, $isFree = false) {
        $subscription = Subscription::where('employer_id', $employer->id)->whereDate('expired_date', '>', now()->format('Y-m-d'))->approved()->first();
        if ($balance) {

            $employer->balance -= gs('fee_per_job_post');
            $employer->save();

            $transaction               = new Transaction();
            $transaction->user_id      = 0;
            $transaction->employer_id  = $employer->id;
            $transaction->amount       = gs('fee_per_job_post');
            $transaction->post_balance = $employer->balance;
            $transaction->charge       = 0;
            $transaction->trx_type     = '-';
            $transaction->details      = 'Create a new job';
            $transaction->trx          = getTrx();
            $transaction->remark       = 'job_post';
            $transaction->save();
        }

        if (!$balance && $employer->job_post_count <= 0) {
            if ($subscription) {
                $subscription->status = Status::SUBSCRIPTION_EXPIRED;
                $subscription->save();

                $employer->subscription_status = Status::SUBSCRIPTION_EXPIRED;
                $employer->save();

                notify($employer, 'JOB_LIMIT_OVER', [
                    'plan_name'    => @$subscription->plan->name,
                    'order_number' => @$subscription->order_number,
                ]);
            }
        }
        $message = "Job created successfully";
        if ($isFree) {
            $job->is_free = Status::YES;
        }
        return ['success', $message];
    }

    public function allApplicants($id, $userId = 0) {
        return $this->applicantView($id, userId: $userId);
    }

    public function selectedApplicants($id) {
        return $this->applicantView($id, 'received');
    }

    public function draftApplicants($id) {
        return $this->applicantView($id, 'draft');
    }

    private function applicantView($id, $scope = null, $userId = 0) {
        $pageTitle   = "Applicants List";
        $employer    = authUser('employer');
        $job         = Job::where('employer_id', $employer->id)->findOrFail($id);
        $appliedJobs = JobApply::where('job_id', $job->id);
        if ($scope) {
            $appliedJobs = $appliedJobs->$scope();
        }
        $appliedJobs              = $appliedJobs->with('user')->orderbyDesc('id')->orderBy('status')->get();
        $data['total_applicants'] = JobApply::totalApplicants($job->id);
        $data['total_pending']    = JobApply::totalPending($job->id);
        $data['total_approved']   = JobApply::totalReceived($job->id);
        $data['total_rejected']   = JobApply::totalRejected($job->id);
        $data['total_draft']      = JobApply::totalDraft($job->id);
        $userAppliedJob           = null;
        if ($userId) {
            $userAppliedJob = $appliedJobs->where('user_id', $userId)->first();
        }
        return view('Template::employer.job.applied', compact('pageTitle', 'appliedJobs', 'job', 'data', 'scope', 'userAppliedJob'));
    }

    public function applicationApprove($id) {
        $employer = authUser('employer');
        $jobApply = JobApply::pending()->orWhere('status', Status::JOB_APPLY_DRAFT)->checkEmployerJobs($employer->id)->whereHas('job', function ($query) {
            $query->approved();
        })->findOrFail($id);

        $jobApply->status = Status::JOB_APPLY_APPROVED;
        $jobApply->save();

        $user = $jobApply->user;
        $user->total_email += 1;
        $user->save();

        notify($user, 'JOB_APPLICATION_RECEIVED', [
            'company_name' => @$jobApply->job->employer->company_name,
            'job_title'    => $jobApply->job->title,
        ]);

        $notify[] = ['success', 'Job application received successfully'];
        return back()->withNotify($notify);
    }

    public function applicationDraft($id) {
        $employer = authUser('employer');
        $jobApply = JobApply::pending()->checkEmployerJobs($employer->id)->whereHas('job', function ($query) {
            $query->approved();
        })->findOrFail($id);

        $jobApply->status = Status::JOB_APPLY_DRAFT;
        $jobApply->save();

        $notify[] = ['success', 'Job application moved to draft successfully'];
        return back()->withNotify($notify);
    }

    public function jobPreview($id) {
        $pageTitle = 'Job Preview';
        $employer  = authUser('employer');
        abort_if(!$employer, 404);
        $job     = Job::where('employer_id', $employer->id)->withCount('jobApplication')->findOrFail($id);
        $preview = true;
        return view('Template::job_details', compact('pageTitle', 'job', 'preview'));
    }

    private function validation($request) {
        $request->validate([
            'title'             => 'required|max:255',
            'category_id'       => 'required|exists:categories,id',
            'type_id'           => 'required|exists:types,id',
            'city_id'           => 'required|exists:locations,id',
            'location_id'       => 'required|exists:locations,id',
            'shift_id'          => 'required|exists:shifts,id',
            'role_id'           => 'required|exists:roles,id',
            'vacancy'           => 'required|integer|gt:0',
            'job_experience_id' => 'required|exists:experiences,id',
            'gender'            => 'required|in:' . Status::ANY_GENDER . ',' . Status::MALE . ',' . Status::FEMALE . ',' . Status::OTHERS . ',' . 0,
            'salary_type'       => 'required|in:' . Status::NEGOTIATION . ',' . Status::RANGE,
            'salary_period'     => 'required|exists:salary_periods,id',
            'deadline'          => 'required|date|after_or_equal:today',
            'min_age'           => 'nullable|integer|gte:0',
            'max_age'           => 'nullable|integer|gt:min_age',
            'description'       => 'required|string',
            'salary_from'       => 'nullable|required_if:salary_type,' . Status::RANGE . '|numeric|gte:0',
            'salary_to'         => 'nullable|required_if:salary_type,' . Status::RANGE . '|numeric|gte:salary_from',
            'job_location_type' => 'required|in:' . Status::ONSITE . ',' . Status::REMOTE . ',' . Status::FIELD . ',' . Status::HYBRID,
            'skills'            => 'required|array',
            'skills.*'          => 'required',
            'short_description' => 'required|string|max:255',
            'keywords'          => 'required|array',
            'keywords.*'        => 'required|string|max:255',
        ], [
            'salary_from.required_if' => 'Minimum salary is required when salary type is Range',
            'salary_to.required_if'   => 'maximum salary to is required when salary type is Range',
            'salary_to.gte'           => 'Minimum salary must be less than maximum salary',
        ]);
    }

    public function exportJobApplicant($id, $scope = null) {
        $csvData = fopen('php://temp', 'r+');
        fputcsv($csvData, ['Serial', 'Applicant Name', 'Email', 'Mobile', 'Expected Salary']);
        $jobApplications = JobApply::where('job_id', $id);
        if ($scope) {
            $jobApplications = $jobApplications->$scope();
        }
        $jobApplications = $jobApplications->with('user')->get();
        foreach ($jobApplications as $key => $jobApplication) {
            fputcsv($csvData, [
                ($key + 1),
                $jobApplication->user->fullname,
                $jobApplication->user->email,
                $jobApplication->user->mobile,
                showAmount($jobApplication->expected_salary),
            ]);
        }
        rewind($csvData);
        return response()->streamDownload(function () use ($csvData) {
            rewind($csvData);
            fpassthru($csvData);
        }, 'job_applications.csv', ['Content-Type' => 'text/csv']);
    }

    public function applicantDetails($id, $applicationId) {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return response()->json(['error' => 'User not found']);
        }
        $userAppliedJob = JobApply::where('user_id', $user->id)->where('id', $applicationId)->first();
        if (!$userAppliedJob) {
            return response()->json(['error' => 'Application not found']);
        }
        $view = view('Template::partials.applicant_profile', compact('user', 'userAppliedJob'))->render();
        return response()->json(['view' => $view]);
    }
}
