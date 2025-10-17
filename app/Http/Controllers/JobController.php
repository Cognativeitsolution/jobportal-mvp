<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Experience;
use App\Models\Job;
use App\Models\JobApply;
use App\Models\Keyword;
use App\Models\Location;
use App\Models\Role;
use App\Models\Shift;
use App\Models\Type;
use App\Models\Visitor;
use Illuminate\Http\Request;

class JobController extends Controller
{
    private function dataQuery($data, $query)
    {
        if (@$data['category_id']) {
            $query = $query->where('category_id', $data['category_id']);
        }
        if (@$data['keyword']) {
            $query = $query->where(function ($cate) use ($data) {
                $cate->where('title', 'LIKE', '%' . @$data['keyword'] . '%')->orWhereHas('jobKeywords', function ($q) use ($data) {
                    $q->where('keyword', 'LIKE', '%' . @$data['keyword'] . '%');
                });
            });
        }
        if (@$data['city_id']) {
            $query = $query->where('city_id', @$data['city_id']);
        }
        if (@$data['type_id']) {
            $query = $query->where('type_id', @$data['type_id']);
        }
        if (@$data['role_id']) {
            $query = $query->where('role_id', @$data['role_id']);
        }
        return $query;
    }

    private function filterQuery($query)
    {
        if (request('sort_by')) {
            $query = $query->orderBy('id', request('sort_by'));
        } else {
            $query = $query->orderByDesc('id');
        }
        if (request('keyword')) {
            $query = $query->whereHas('jobKeywords', function ($q) {
                $q->where('keyword', 'LIKE', '%' . request('keyword') . '%');
            });
        }
        if (request('min_age') || request('max_age')) {
            $minAge = request('min_age');
            $maxAge = request('max_age');

            $query = $query->where(function ($q) use ($minAge, $maxAge) {
                $q->whereBetween('min_age', [$minAge, $maxAge])
                    ->whereBetween('max_age', [$minAge, $maxAge]);
            });
        }
        if (request('type_id')) {
            $query = $query->whereIn('type_id', request('type_id'));
        }
        if (request('job_location_type')) {
            $query = $query->whereIn('job_location_type', request('job_location_type'));
        }
        if (request('city_id')) {
            $query = $query->where('city_id', request('city_id'));
        } else {
            $countryCode =  null;

            if ($countryCode) {
                $cityIds = Location::whereHas('country', function ($q) use ($countryCode) {
                    $q->where('iso_code', $countryCode);
                })->pluck('id')->toArray();

                if (!empty($cityIds)) {
                    $query = $query->whereIn('city_id', $cityIds);
                }
            }
        }
        if (request('category_id')) {
            $query = $query->whereIn('category_id', request('category_id'));
        }
        if (request('role_id')) {
            $query = $query->whereIn('role_id', request('role_id'));
        }
        if (request('job_experience_id')) {
            $query = $query->whereIn('job_experience_id', request('job_experience_id'));
        }
        if (request('shift_id')) {
            $query = $query->whereIn('shift_id', request('shift_id'));
        }
        $query = $query->searchable(['title']);
        return $query;
    }

    public function jobs()
    {
        $query = Job::approved()->withCount('jobApplication')->whereHasActiveCategory()->whereHasActiveRole();
        $data  = session()->has('REQUEST_DATA') ? session()->get('REQUEST_DATA') : [];

        if ($data) {
            $query = $this->dataQuery($data, $query);
        }
        if (request('filter')) {
            $query = $this->filterQuery($query);
        } else {
            $pageTitle      = "All Jobs";
            $cities         = Location::city()->active()->get();
            $jobTypes       = Type::active()->whereHasJob()->withJobCount()->orderByDesc('job_count')->get();
            $categories     = Category::active()->whereHasJobs()->withJobCount()->orderbyDesc('job_count')->get();
            $roles          = Role::active()->whereHasJobs()->withJobCount()->orderbyDesc('jobs_count')->get();
            $jobExperiences = Experience::active()->whereHasJob()->withJobCount()->orderByDesc('job_count')->get();
            $jobShifts      = Shift::active()->whereHasJob()->withJobCount()->orderByDesc('job_count')->get();
            $minAge         = Job::approved()->min('min_age');
            $maxAge         = Job::approved()->max('max_age');
            $keywords       = Keyword::whereHasJobs()->get();
            $url            = route('job');
        }

        $query = $query->with(['employer', 'location', 'city', 'favoriteItems' => function ($favoriteItems) {
            $favoriteItems->where('user_id', auth()->id());
        }]);
        if (!request('city_id')) {

            $countryCode =  null;

            if ($countryCode) {
                $cityIds = Location::whereHas('country', function ($q) use ($countryCode) {
                    $q->where('iso_code', $countryCode);
                })->pluck('id')->toArray();

                if (!empty($cityIds)) {
                    $query = $query->whereIn('city_id', $cityIds);
                }
            }
        }

        $jobs      = clone $query;
        $totalJobs = clone $query;
        $totalJobs = $totalJobs->count();

        //         array:3 [▼ // app\Http\Controllers\JobController.php:157
        //   "city_id" => "3"
        //   "keyword" => "AI Pro Resume"
        //   "type_id" => "1"
        // ]

        $search = $data['keyword'] ?? request('keyword');

        if (($totalJobs <= getPaginate(18)) && request('page') > 1) {
            $request = request();
            $page    = $request->merge(['page' => 1]);
            $jobs    = $jobs->orderByDesc('id')->paginate(getPaginate(18) * $request->get('page'));
            collect($request->all())->except('page');
        } else {
            $jobs = $jobs->orderByDesc('id')->paginate(getPaginate(18));
        }

        if (request(key: 'filter')) {
            $viewTemplate = request('view');
            $view         = view('Template::partials.frontend.' . $viewTemplate, compact('jobs'))->render();
            return response()->json([
                'view'      => $view,
                'totalJobs' => $totalJobs,
                'page'      => @$page,
                'search'    => $search,
            ]);
        } else {
            return view('Template::job', compact('pageTitle', 'jobs', 'jobTypes', 'jobShifts', 'jobExperiences', 'categories', 'cities', 'minAge', 'maxAge', 'keywords', 'totalJobs', 'roles', 'url', 'search'));
        }
    }

    public function featuredJobsList()
    {
        $query = Job::approved()->featured()->whereHasActiveCategory()->withCount('jobApplication');
        if (request('filter')) {
            $query = $this->filterQuery($query);
        } else {
            $pageTitle      = "All Featured Jobs";
            $cities         = Location::city()->active()->get();
            $jobTypes       = Type::active()->whereHasFeaturedJob()->withFeaturedJobCount()->orderByDesc('job_count')->get();
            $categories     = Category::active()->whereHasFeaturedJobs()->withFeaturedJobCount()->orderbyDesc('job_count')->get();
            $roles          = Role::active()->whereHasFeaturedJobs()->withFeaturedJobCount()->orderbyDesc('jobs_count')->get();
            $jobExperiences = Experience::active()->whereHasFeaturedJob()->withFeaturedJobCount()->orderByDesc('job_count')->get();
            $jobShifts      = Shift::active()->whereHasFeaturedJob()->withFeaturedJobCount()->orderByDesc('job_count')->get();
            $minAge         = Job::approved()->min('min_age');
            $maxAge         = Job::approved()->max('max_age');
            $keywords       = Keyword::whereHasFeaturedJobs()->get();
            $url            = route('featured.jobs.list');
        }

        $query = $query->with(['employer', 'location', 'city', 'favoriteItems' => function ($favoriteItems) {
            $favoriteItems->where('user_id', auth()->id());
        }]);

        $jobs      = clone $query;
        $totalJobs = clone $query;
        $totalJobs = $totalJobs->count();

        if (($totalJobs <= getPaginate(18)) && request('page') > 1) {
            $request = request();
            $page    = $request->merge(['page' => 1]);
            $jobs    = $jobs->orderByDesc('id')->paginate(getPaginate(18) * $request->get('page'));
            collect($request->all())->except('page');
        } else {
            $jobs = $jobs->orderByDesc('id')->paginate(getPaginate(18));
        }

        if (request('filter')) {
            $viewTemplate = request('view');
            $view         = view('Template::partials.frontend.' . $viewTemplate, compact('jobs'))->render();
            return response()->json([
                'view'      => $view,
                'totalJobs' => $totalJobs,
                'page'      => @$page,
            ]);
        } else {
            return view('Template::job', compact('pageTitle', 'jobs', 'jobTypes', 'jobShifts', 'jobExperiences', 'categories', 'cities', 'minAge', 'maxAge', 'keywords', 'totalJobs', 'roles', 'url'));
        }
    }

    public function jobFilter(Request $request)
    {
        $data = [];
        if ($request->city_id) {
            $data['city_id'] = $request->city_id;
        }
        if ($request->keyword) {
            $data['keyword'] = $request->keyword;
        }
        if ($request->type_id) {
            $data['type_id'] = $request->type_id;
        }
        session()->put('REQUEST_DATA', $data);
        return to_route('job');
    }

    public function jobCategory($id = 0)
    {
        $data = [];
        if ($id) {
            $data['category_id'] = $id;
        }
        session()->put('REQUEST_DATA', $data);
        return to_route('job');
    }

    public function jobRole($id)
    {
        $data            = [];
        $data['role_id'] = $id;
        session()->put('REQUEST_DATA', $data);
        return to_route('job');
    }

    public function jobKeyword($keyword)
    {
        $data            = [];
        $data['keyword'] = $keyword;
        session()->put('REQUEST_DATA', $data);
        return to_route('job');
    }

    public function jobDetails($id)
    {
        $pageTitle = "Job Detail";
        $user      = authUser();
        $job       = Job::approved()
            ->with(['jobKeywords', 'favoriteItems' => function ($favoriteItems) {
                $favoriteItems->where('user_id', auth()->id());
            }])
            ->withCount('jobApplication')
            ->findOrFail($id);
        $job->visitor += 1;
        $job->save();

        $visitor = Visitor::where('date', today())->where('job_id', $id)->first();
        if (!$visitor) {
            $visitor         = new Visitor();
            $visitor->job_id = $id;
            $visitor->date   = today();
        }
        $visitor->count += 1;
        $visitor->save();

        $applied     = JobApply::where('job_id', $job->id)->where('user_id', @$user->id)->exists();
        $relatedJobs = Job::approved()
            ->where('role_id', $job->role_id)
            ->with(['employer', 'favoriteItems' => function ($favoriteItems) {
                $favoriteItems->where('user_id', auth()->id());
            }])
            ->where('id', '!=', $id)
            ->orderBy('id', 'DESC')
            ->take(5)
            ->get();

        return view('Template::job_details', compact('pageTitle', 'applied', 'job', 'relatedJobs'));
    }

    public function categoryHotJobs($id = null)
    {
        $jobs = Job::active()->approved();
        if ($id) {
            $jobs = $jobs->where('category_id', $id);
        }
        $jobs = $jobs->withCount('jobApplication')
            ->with(['employer', 'location', 'city', 'favoriteItems' => function ($favoriteItems) {
                $favoriteItems->where('user_id', auth()->id());
            }])
            ->orderByDesc('visitor')
            ->orderByDesc('job_application_count')
            ->take(8)->get();
        return view('Template::partials.frontend.category_hot_jobs', compact('jobs', 'id'));
    }

    public function featuredJobs($id = null)
    {
        $jobs = Job::featured()->approved();
        if ($id) {
            $jobs = $jobs->where('category_id', $id);
        }

        $jobs = $jobs->with(['employer', 'location', 'city', 'favoriteItems' => function ($favoriteItems) {
            $favoriteItems->where('user_id', auth()->id());
        }])->orderByDesc('id')->take(6)->get();
        return view('Template::partials.frontend.featured_jobs', compact('jobs', 'id'));
    }
}
