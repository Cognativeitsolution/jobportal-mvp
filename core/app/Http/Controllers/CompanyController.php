<?php

namespace App\Http\Controllers;

use App\Constants\Status;
use App\Models\Employer;
use App\Models\Industry;
use App\Models\Job;
use App\Models\Page;
use Illuminate\Http\Request;

class CompanyController extends Controller {
    public function companyList() {
        $query = Employer::active()->whereHasActiveIndustry();
        $data  = session()->has('REQUEST_DATA') ? session()->get('REQUEST_DATA') : [];
        if ($data) {
            if (@$data['industry_id']) {
                $query = $query->where('industry_id', $data['industry_id']);
            }
            if (@$data['city']) {
                $query = $query->where('city', 'LIKE', '%' . $data['city'] . '%');
            }
        }

        if (request('filter')) {
            if (request('sort_by')) {
                $query = $query->orderBy('id', request('sort_by'));
            } else {
                $query = $query->orderByDesc('id');
            }
            if (request('city')) {
                $query = $query->where('city', 'LIKE', '%' . request('city') . '%');
            }
            if (request('country_name')) {
                $query = $query->where('country_name', 'LIKE', '%' . request('country_name') . '%');
            }
            if (request('industry_id')) {
                $query = $query->whereIn('industry_id', request('industry_id'));
            }
        } else {
            $pageTitle  = "Companies";
            $cities     = Employer::active()->where('city', '!=', null)->distinct()->pluck('city')->toArray();
            $countries  = Employer::active()->where('country_name', '!=', null)->distinct()->pluck('country_name')->toArray();
            $industries = Industry::active()
                ->whereHas('employers')
                ->withCount(['employers' => function ($query) {
                    $query->active();
                }])
                ->orderByDesc('employers_count')
                ->get();
        }

        $query          = $query->searchable(['company_name'])->filter(['industry_id', 'country_name'])->orderByDesc('id');
        $employers      = clone $query;
        $totalEmployers = clone $query;
        $totalEmployers = $totalEmployers->count();

        if (($totalEmployers <= getPaginate()) && request('page') > 1) {
            $request   = request();
            $page      = $request->merge(['page' => 1]);
            $employers = $employers->paginate(getPaginate() * $request->get('page'));
        } else {
            $employers = $employers->paginate(getPaginate());
        }

        $sections = Page::where('tempname', activeTemplate())->where('slug', 'companies')->first();
        if (request('filter')) {
            $view = view('Template::partials.frontend.company_list_card', compact('employers'))->render();
            return response()->json([
                'view'           => $view,
                'totalEmployers' => $totalEmployers,
            ]);
        } else {
            return view('Template::employer', compact('pageTitle', 'employers', 'industries', 'totalEmployers', 'cities', 'countries', 'sections'));
        }
    }

    public function companyIndustryTypeList($industryId) {
        $data = [];
        if ($industryId) {
            $data['industry_id'] = $industryId;
        }
        session()->put('REQUEST_DATA', $data);
        return to_route('company.list');
    }

    public function companyLocationList($city) {
        $data = [];
        if ($city) {
            $data['city'] = $city;
        }
        session()->put('REQUEST_DATA', $data);
        return to_route('company.list');
    }

    public function companyProfile($slug) {
        $pageTitle = "Company Profile";
        $employer  = Employer::where('slug', $slug)->active()->firstOrFail();
        $jobs      = Job::approved()
            ->where('employer_id', $employer->id)
            ->with('favoriteItems', function ($favoriteItems) {
                $favoriteItems->where('user_id', auth()->id());
            })
            ->orderByDesc('id')
            ->get();
        return view('Template::employer_profile', compact('pageTitle', 'employer', 'jobs'));
    }

    public function featuredCompanies($id = null) {
        $featuredCompanies = Employer::active();
        if ($id) {
            $featuredCompanies = $featuredCompanies->where('industry_id', $id);
        }
        $featuredCompanies = $featuredCompanies->where('is_featured', Status::YES)->orderByDesc('id')->get();
        return view('Template::partials.frontend.featured_companies', compact('featuredCompanies', 'id'));
    }

    public function companyJobs($slug) {
        session()->put('JOB_STATUS', true);
        return to_route('company.profile', $slug);
    }

    public function contactWithCompany(Request $request, $id) {
        $request->validate([
            'name'    => 'required',
            'email'   => 'required|email',
            'message' => 'required',
        ]);

        $employer = Employer::findOrFail($id);

        notify($employer, 'CONTACT_WITH_COMPANY', [
            'name'    => $request->name,
            'email'   => $request->email,
            'message' => $request->message,
        ], ['email'], false);

        $notify[] = ['success', 'Contact mail has been submitted'];
        return back()->withNotify($notify);
    }
}
